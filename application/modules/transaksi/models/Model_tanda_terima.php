<?php

class Model_tanda_terima extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'tanda_terima_h';

		$this->load->database();
		$this->db->reconnect();
	}

	public function getNomorTransaksi()
	{
		$docCode	 ='TT';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM tanda_terima_h
		WHERE nomor_transaksi LIKE '".$sno_doc."%' ORDER BY nomor_transaksi DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['gencode'];
			for ($i=4; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getNomorTransaksiManual()
	{
		$docCode	 ='TTM';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM tanda_terima_h
		WHERE nomor_transaksi LIKE '".$sno_doc."%' ORDER BY nomor_transaksi DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['gencode'];
			for ($i=4; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getDataStore($result, $search_name = "",$jenis="",$pengirim="",$penerima="",$tujuan="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("a.* ");
        $this->db->from('tanda_terima_h a');
        $this->db->order_by('a.tanggal_input', 'DESC');

        if($search_name !=""){
			$this->db->group_start();
			$this->db->like('a.nomor_transaksi',$search_name);
            $this->db->or_like('a.pengirim',$search_name);
			// $this->db->or_like('b.nama',$search_name);
			$this->db->group_end();
		}

		if($jenis !=""){
			$this->db->where('a.kode_dokumen',$jenis);
		}
		if($pengirim !=""){
			$this->db->where('a.pengirim',$pengirim);
		}
		if($penerima !=""){
			$this->db->where('a.penerima',$penerima);
		}
		if($tujuan !=""){
			$this->db->where('a.tujuan',$tujuan);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			// die($this->db->last_query());
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	public function getData($id, $type=null)
	{
		if($id){
			if($type == 'header'){

				$this->db->from('tanda_terima_h');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->row_array();

			}else if($type == 'detail'){

				$this->db->select('h.*, d.*, b.nama_barang, s.nama nama_status');
				$this->db->from('tanda_terima_d d');
				$this->db->join('tanda_terima_h h'		,'d.nomor_transaksi = h.nomor_transaksi','left');
				$this->db->join('mst_barang b'			,'d.kode_barang 	= b.kode_barang','left');
				$this->db->join('mst_status_barang s'	,'d.status_barang 	= s.status_barang','left');
				$this->db->where('h.nomor_transaksi', $id);
				$this->db->order_by('d.no_urut');
				$query= $this->db->get();
				// die(nl2br($this->db->last_query()));
				return $query->result_array();

			}else{

				$this->db->from('tanda_terima_d');
				$this->db->where('nomor_transaksi',$id);
				$this->db->or_where('kode_barang',$id);
				$query	= $this->db->get();
				return $query->result_array();

			}
		}else{
			return false;
		}
	}


	public function getDataDetail($nomor_transaksi){
		$this->db->select('h.*, d.*, b.nama_barang, s.nama nama_status');
		$this->db->from('tanda_terima_d d');
		$this->db->join('tanda_terima_h h'		,'d.nomor_transaksi = h.nomor_transaksi','left');
		$this->db->join('mst_barang b'			,'d.kode_barang 	= b.kode_barang','left');
		$this->db->join('mst_status_barang s'	,'d.status_barang 	= s.status_barang','left');
		$this->db->where('h.nomor_transaksi', $nomor_transaksi);
		$this->db->order_by('d.no_urut');
		$query= $this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->result_array();
	}

	// ---- Action Start
	function saveTambah()
	{
		// Mulai transaction
		$this->db->trans_start();
		
		$data = $_POST;

		if($data['kd_dokumen'] == 'IN'){
			$tgl_pengiriman 	= '';
			$tgl_terima_it	 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
		}else{
			$tgl_pengiriman 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
			$tgl_terima_it	 	= '';
		}

		$log_detail = array();
		$count_d 	= count($data['urut']);

		// Generate nomor transaksi terlebih dahulu
		$nomor_transaksi = $this->getNomorTransaksi();
		
		$header = array(
			'nomor_transaksi' 	=> $nomor_transaksi,
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> $data['tujuan'],
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('name'),
			'manual'			=> "False",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_pengiriman'=> $tgl_pengiriman,
			'tgl_terima_it'		=> $tgl_terima_it,
		);

		for($x = 0; $x < $count_d ; $x++) {

			$getBarang = $this->Model_global->getBarang($data['kd_brg'][$x]);

			if($getBarang['barang_stock'] == 'True'){
				$status_barang = $getBarang['status_barang'];
			}else{
				$status_barang = $data['status'][$x];
			}

			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $data['urut'][$x],
				'kode_barang' 		=> $data['kd_brg'][$x],
				'qty'		 		=> $data['qty'][$x],
				'status_barang_old'	=> $getBarang['status_barang'],
				'status_barang'		=> $status_barang,
				'harga_asuransi'	=> $getBarang['harga_asuransi'],
				'keterangan_barang'	=> $data['ket'][$x],
			);
			array_push($log_detail, $detail);

			// Update Status Barang
				$kode_barang 	= $data['kd_brg'][$x];
				$where 		 	= array('kode_barang' => $kode_barang);
				$update_status 	= array(
									'status_barang' 			=> $status_barang,
									'lokasi_terakhir' 			=> $data['tujuan'],
									'tanggal_lokasi_akhir'		=> date('Y-m-d'),
								);
				$this->db->where($where)->update('mst_barang', $update_status);
			// Update Status Barang
		}

		// Insert header
		$insert 		= $this->db->insert('tanda_terima_h', $header);

		// Insert detail
		$insert_detail 	= $this->db->insert_batch('tanda_terima_d', $log_detail);

		// Upload foto jika ada (hanya untuk jenis dokumen IN)
		// if($data['kd_dokumen'] == 'IN') {
			$foto_file = $_FILES['foto'];
			$this->UploadImage($nomor_transaksi,$foto_file);
		// }

		// Complete transaction
		$this->db->trans_complete();

		// Check transaction status
		if ($this->db->trans_status() === FALSE) {
			// Rollback jika ada error
			$this->db->trans_rollback();
			return FALSE;
		} else {
			// Commit transaction
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function saveTambahManual()
	{
		$data = $_POST;

		if($data['kd_dokumen'] == 'IN'){
			$tgl_pengiriman 	= '';
			$tgl_terima_it	 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
		}else{
			$tgl_pengiriman 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
			$tgl_terima_it	 	= '';
		}

		$log_detail = array();
		$count_d 	= count($data['keterangan']);

		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksiManual(),
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> $data['tujuan'],
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('name'),
			'manual'			=> "True",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d H:i:s'),
			'tanggal_pengiriman'=> $tgl_pengiriman,
			'tgl_terima_it'		=> $tgl_terima_it,
		);

		for($x = 0; $x < $count_d ; $x++) {

			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $x+1,
				'kode_barang' 		=> '',
				'qty'		 		=> $data['qty'][$x],
				'status_barang_old'	=> '',
				'status_barang'		=> '',
				'harga_asuransi'	=> '',
				'keterangan_barang'	=> $data['keterangan'][$x],
			);
			array_push($log_detail, $detail);

		}

		$insert 		= $this->db->insert('tanda_terima_h', $header);

		$insert_detail 	= $this->db->insert_batch('tanda_terima_d', $log_detail);

		return ($insert)?TRUE:FALSE;
	}

	function saveFotoReference($row_poto)
	{
		if (!$row_poto) {
			return false;
		}

		$data = array(
			'foto' => $row_poto['foto'],
		);

		$this->db->where('nomor_transaksi', $row_poto['nomor_transaksi']);
		return $this->db->update($this->table, $data);
	}
	// ---- Action END



	private function UploadImage($nomor_transaksi, $images)
	{
		// Siapkan folder upload khusus per barang
		$upload_dir = FCPATH . 'upload' . DIRECTORY_SEPARATOR . 'tanda_terima' . DIRECTORY_SEPARATOR;
		if (!is_dir($upload_dir)) {
			@mkdir($upload_dir, 0755, true);
		}
		
		// Proses multi-upload (input name="foto[]")
		$errors = array();
		$saved_photos = array();


		if (!empty($images) && is_array($images['name'])) {
			$files = $images;
			$file_count = count($files['name']);

			for ($i = 0; $i < $file_count; $i++) {
				// Skip jika tidak ada file di index ini
				if (empty($files['name'][$i])) continue;

				// Susun ulang ke satu file pseudo "tmp_image" untuk CI Upload
				$_FILES['tmp_image'] = array(
					'name'     => $files['name'][$i],
					'type'     => $files['type'][$i],
					'tmp_name' => $files['tmp_name'][$i],
					'error'    => $files['error'][$i],
					'size'     => $files['size'][$i],
				);

				// Config upload per file
				$config = array(
					'upload_path'   => $upload_dir,
					'allowed_types' => 'jpg|jpeg|png',
					'encrypt_name'  => true,
					// 'max_size'    => 5120, // contoh: 5MB
				);

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('tmp_image')) {
					$errors[] = $this->upload->display_errors('', '');
					continue;
				}

				$data = $this->upload->data(); // info file yang ter-upload
				$source_path = $data['full_path'];

				// Optimasi
				$options = array(
					'max_width'       => 1280,
					'max_height'      => 1280,
					'quality_jpeg'    => 75,
					'quality_png'     => 82,
					'convert_to_webp' => false,
					'quality_webp'    => 78,
					'only_if_smaller' => true,
				);

				try {

					$result = $this->image_optimizer->optimize($source_path, $options);

					// Jika file hasil optimasi beda nama/beda path dari original dan Anda ingin hemat storage:
					// Hapus original jika berbeda
					if ($result['final_path'] !== $source_path && file_exists($source_path)) {
						@unlink($source_path);
					}

					// Simpan data foto ke DB (path relatif agar mudah dibangun sebagai URL)
					$final_path_normalized = str_replace('\\', '/', $result['final_path']);
					$fcpath_normalized = str_replace('\\', '/', FCPATH);
					$relative_final = str_replace($fcpath_normalized, '', $final_path_normalized);

					$saved_row = array(
						'nomor_transaksi' => $nomor_transaksi,
						'file_path' => $relative_final,
						'mime'      => $result['final_mime'],
						'size'      => @filesize($result['final_path']) ?: 0,
						'created_at'=> date('Y-m-d H:i:s'),
					);

					// Jika WebP dibuat dan lebih kecil, bisa juga disimpan kolom terpisah (opsional)
					if (!empty($result['webp_created']) && !empty($result['webp_path']) && file_exists($result['webp_path'])) {
						$saved_row['file_path_webp'] = str_replace(FCPATH, '', $result['webp_path']);
						$saved_row['size_webp']      = @filesize($result['webp_path']) ?: null;
					}

					$saved_photos[] = $saved_row;
				} catch (Exception $e) {
					// Hapus file upload jika gagal optimasi
					if (file_exists($source_path)) @unlink($source_path);
					$errors[] = $e->getMessage();
				}
			}
		}

		$row_poto = [
			'nomor_transaksi'   => $nomor_transaksi,
			'foto' => isset($saved_photos[0]['file_path']) ? $saved_photos[0]['file_path'] : null,
		];

		//Simpan foto-foto ke DB
		if (!empty($row_poto)) {
			$this->saveFotoReference($row_poto);
		}
	}


}