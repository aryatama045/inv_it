<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_optimizer
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        // image_lib untuk resize
        $this->CI->load->library('image_lib');
    }

    /**
     * Optimize image:
     * - Resize jika melewati max_width/height
     * - Re-encode untuk mengecilkan ukuran
     * - Opsi convert ke WebP
     */
    public function optimize($path, $options = array())
    {
        if (!file_exists($path)) {
            throw new Exception("File tidak ditemukan: {$path}");
        }

        $options = array_merge(array(
            'max_width'       => 1280,
            'max_height'      => 1280,
            'quality_jpeg'    => 80,
            'quality_png'     => 82,
            'convert_to_webp' => true,
            'quality_webp'    => 80,
            'only_if_smaller' => true,
        ), $options);

        $info = $this->getImageInfo($path);
        if (!$info) {
            throw new Exception("Format file tidak dikenali.");
        }

        $orig_mime = $info['mime'];
        $dir  = dirname($path);
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $name = pathinfo($path, PATHINFO_FILENAME);

        $working_path = $path; // mulai dari file upload
        $resized = false;

        // 1) Resize jika lebih besar dari batas
        if ($info['width'] > $options['max_width'] || $info['height'] > $options['max_height']) {
            $resized_path = $dir . DIRECTORY_SEPARATOR . $name . '_resized.' . $ext;

            $config = array();
            $config['image_library']  = 'gd2';
            $config['source_image']   = $working_path;
            $config['new_image']      = $resized_path;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = $options['max_width'];
            $config['height']         = $options['max_height'];

            // Quality untuk proses resize (CI menerima '75%' atau '75')
            // Kita set berdasarkan tipe untuk jaga kualitas
            if (strpos($orig_mime, 'jpeg') !== false || strpos($orig_mime, 'jpg') !== false) {
                $config['quality'] = (string) intval($options['quality_jpeg']); // CI3 juga menerima tanpa %
            } elseif (strpos($orig_mime, 'png') !== false) {
                $config['quality'] = (string) intval($options['quality_png']);
            } else {
                $config['quality'] = '85';
            }

            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($config);

            if (!$this->CI->image_lib->resize()) {
                throw new Exception("Gagal resize: " . $this->CI->image_lib->display_errors('', ''));
            }

            $working_path = $resized_path;
            $resized = true;
            // refresh info image
            $info = $this->getImageInfo($working_path) ?: $info;
        }

        // 2) Re-encode untuk buang metadata/kompresi lebih baik
        $reencoded_path = $dir . DIRECTORY_SEPARATOR . $name . '_optimized.' . $ext;

        $this->reencodeWithGD($working_path, $reencoded_path, $orig_mime, $options);
        $final_path = $reencoded_path;
        $final_mime = mime_content_type($final_path);

        // Jika reencode lebih besar dan only_if_smaller aktif, fallback ke working_path
        if ($options['only_if_smaller'] && file_exists($working_path)) {
            if (filesize($final_path) > filesize($working_path)) {
                // gunakan yang lebih kecil
                @unlink($final_path);
                $final_path = $working_path;
                $final_mime = mime_content_type($final_path);
            } else {
                // buang intermediary jika tidak dipakai
                if ($resized && $working_path !== $path && $working_path !== $final_path) {
                    @unlink($working_path);
                }
            }
        } else {
            if ($resized && $working_path !== $path && $working_path !== $final_path) {
                @unlink($working_path);
            }
        }

        // 3) Convert ke WebP (opsional) bila fungsi tersedia
        $webp_created = false;
        $webp_path = '';
        if ($options['convert_to_webp'] && function_exists('imagewebp')) {
            $webp_path = $dir . DIRECTORY_SEPARATOR . $name . '.webp';
            $this->convertToWebP($final_path, $webp_path, $options['quality_webp']);

            if (file_exists($webp_path)) {
                $webp_created = true;

                if ($options['only_if_smaller'] && file_exists($final_path)) {
                    // Jika WebP lebih kecil, bagus; kalau tidak, Anda bisa memilih untuk hapus WebP
                    if (filesize($webp_path) >= filesize($final_path)) {
                        // WebP tidak lebih kecil, hapus supaya tidak membingungkan
                        @unlink($webp_path);
                        $webp_created = false;
                        $webp_path = '';
                    }
                }
            }
        }

        return array(
            'final_path'   => $final_path,
            'final_mime'   => $final_mime,
            'webp_created' => $webp_created,
            'webp_path'    => $webp_path,
        );
    }

    protected function getImageInfo($path)
    {
        $data = @getimagesize($path);
        if (!$data) return null;
        return array(
            'width'  => $data[0],
            'height' => $data[1],
            'mime'   => $data['mime'],
        );
    }

    protected function reencodeWithGD($src_path, $dst_path, $orig_mime, $options)
    {
        // Deteksi tipe
        $mime = mime_content_type($src_path);
        $type = $this->mimeToType($mime);

        switch ($type) {
            case 'jpeg':
                $img = @imagecreatefromjpeg($src_path);
                if (!$img) throw new Exception("Gagal membuka JPEG.");
                // Progressive JPEG untuk kualitas visual
                imageinterlace($img, true);
                // Re-encode
                $quality = max(0, min(100, (int)$options['quality_jpeg']));
                imagejpeg($img, $dst_path, $quality);
                imagedestroy($img);
                break;

            case 'png':
                $img = @imagecreatefrompng($src_path);
                if (!$img) throw new Exception("Gagal membuka PNG.");
                // Jaga alpha
                imagealphablending($img, false);
                imagesavealpha($img, true);
                // Map quality 0-100 -> compression 0-9 (kecil lebih baik)
                $q = max(0, min(100, (int)$options['quality_png']));
                $compression = (int) round((100 - $q) * 9 / 100);
                imagepng($img, $dst_path, $compression, PNG_ALL_FILTERS);
                imagedestroy($img);
                break;

            case 'gif':
                $img = @imagecreatefromgif($src_path);
                if (!$img) throw new Exception("Gagal membuka GIF.");
                imagegif($img, $dst_path);
                imagedestroy($img);
                break;

            default:
                // Fallback: copy saja
                copy($src_path, $dst_path);
        }
    }

    protected function convertToWebP($src_path, $webp_path, $quality_webp = 80)
    {
        $mime = mime_content_type($src_path);
        $type = $this->mimeToType($mime);

        $quality = max(0, min(100, (int)$quality_webp));

        if (!function_exists('imagewebp')) {
            return false;
        }

        switch ($type) {
            case 'jpeg':
                $img = @imagecreatefromjpeg($src_path);
                if (!$img) return false;
                imageinterlace($img, false); // tidak relevan untuk webp
                $ok = imagewebp($img, $webp_path, $quality);
                imagedestroy($img);
                return $ok;

            case 'png':
                $img = @imagecreatefrompng($src_path);
                if (!$img) return false;
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                $ok = imagewebp($img, $webp_path, $quality);
                imagedestroy($img);
                return $ok;

            case 'gif':
                $img = @imagecreatefromgif($src_path);
                if (!$img) return false;
                // GIF ke WebP tidak selalu ideal, tapi tetap bisa
                $ok = imagewebp($img, $webp_path, $quality);
                imagedestroy($img);
                return $ok;

            default:
                return false;
        }
    }

    protected function mimeToType($mime)
    {
        $mime = strtolower((string)$mime);
        if (strpos($mime, 'jpeg') !== false || strpos($mime, 'jpg') !== false) return 'jpeg';
        if (strpos($mime, 'png') !== false) return 'png';
        if (strpos($mime, 'gif') !== false) return 'gif';
        return 'unknown';
    }
}