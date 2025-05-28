<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Import PHPSpreadsheet classes
require_once APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Excel_export extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        // Load model jika diperlukan
        // $this->load->model('User_model');
    }

    /**
     * Export data users ke Excel
     */
    public function export_users()
    {
        try {
            // Ambil data dari database (contoh data dummy)
            $data = $this->get_sample_data();

            // Buat spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set properties dokumen
            $spreadsheet->getProperties()
                ->setCreator("Your App Name")
                ->setLastModifiedBy("Your App Name")
                ->setTitle("Data Users Export")
                ->setSubject("Export Data")
                ->setDescription("Export data users dari aplikasi")
                ->setKeywords("excel export users")
                ->setCategory("Report");

            // Set header kolom
            $headers = ['No', 'Nama', 'Email', 'Telepon', 'Alamat', 'Tanggal Daftar'];
            $column = 'A';
            
            foreach ($headers as $header) {
                $sheet->setCellValue($column . '1', $header);
                $column++;
            }

            // Style untuk header
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ];

            $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

            // Isi data
            $row = 2;
            $no = 1;
            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $item['nama']);
                $sheet->setCellValue('C' . $row, $item['email']);
                $sheet->setCellValue('D' . $row, $item['telepon']);
                $sheet->setCellValue('E' . $row, $item['alamat']);
                $sheet->setCellValue('F' . $row, $item['tanggal_daftar']);
                
                $row++;
                $no++;
            }

            // Style untuk data
            $dataStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ];

            $lastRow = $row - 1;
            $sheet->getStyle('A1:F' . $lastRow)->applyFromArray($dataStyle);

            // Auto size kolom
            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Set tinggi row header
            $sheet->getRowDimension('1')->setRowHeight(25);

            // Buat writer
            $writer = new Xlsx($spreadsheet);

            // Set nama file
            $filename = 'Data_Users_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            // Output file
            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            show_error('Error generating Excel file: ' . $e->getMessage());
        }
    }

    /**
     * Export dengan template yang lebih kompleks
     */
    public function export_advanced()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set judul laporan
            $sheet->setCellValue('A1', 'LAPORAN DATA PENGGUNA');
            $sheet->mergeCells('A1:F1');
            
            // Style judul
            $titleStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => '2F4F4F']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ];
            $sheet->getStyle('A1')->applyFromArray($titleStyle);
            $sheet->getRowDimension('1')->setRowHeight(30);

            // Info tanggal
            $sheet->setCellValue('A2', 'Tanggal Export: ' . date('d/m/Y H:i:s'));
            $sheet->mergeCells('A2:F2');
            $sheet->getStyle('A2')->getFont()->setItalic(true);

            // Kosongkan baris
            $sheet->setCellValue('A3', '');

            // Header tabel
            $headers = ['No', 'Nama Lengkap', 'Email', 'No. Telepon', 'Alamat', 'Tgl. Registrasi'];
            $startRow = 4;
            $column = 'A';
            
            foreach ($headers as $header) {
                $sheet->setCellValue($column . $startRow, $header);
                $column++;
            }

            // Style header tabel
            $headerTableStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '5B9BD5']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ];

            $sheet->getStyle('A4:F4')->applyFromArray($headerTableStyle);
            $sheet->getRowDimension('4')->setRowHeight(25);

            // Data
            $data = $this->get_sample_data();
            $row = 5;
            $no = 1;

            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $item['nama']);
                $sheet->setCellValue('C' . $row, $item['email']);
                $sheet->setCellValue('D' . $row, $item['telepon']);
                $sheet->setCellValue('E' . $row, $item['alamat']);
                $sheet->setCellValue('F' . $row, date('d/m/Y', strtotime($item['tanggal_daftar'])));

                // Style baris genap/ganjil
                if ($no % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()->setRGB('F2F2F2');
                }

                $row++;
                $no++;
            }

            // Border untuk semua data
            $lastRow = $row - 1;
            $sheet->getStyle('A4:F' . $lastRow)->getBorders()->getAllBorders()
                  ->setBorderStyle(Border::BORDER_THIN);

            // Total data
            $totalRow = $row + 1;
            $sheet->setCellValue('A' . $totalRow, 'Total Data: ' . ($no - 1) . ' pengguna');
            $sheet->mergeCells('A' . $totalRow . ':F' . $totalRow);
            $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);

            // Auto size kolom
            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Set nama sheet
            $sheet->setTitle('Data Pengguna');

            $writer = new Xlsx($spreadsheet);
            $filename = 'Laporan_Pengguna_' . date('Y-m-d_H-i-s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            show_error('Error generating advanced Excel file: ' . $e->getMessage());
        }
    }

    /**
     * Export multiple sheets
     */
    public function export_multiple_sheets()
    {
        try {
            $spreadsheet = new Spreadsheet();

            // Sheet 1 - Data Users
            $sheet1 = $spreadsheet->getActiveSheet();
            $sheet1->setTitle('Data Users');
            
            $this->create_users_sheet($sheet1);

            // Sheet 2 - Summary
            $sheet2 = $spreadsheet->createSheet();
            $sheet2->setTitle('Summary');
            
            $this->create_summary_sheet($sheet2);

            // Set active sheet ke sheet pertama
            $spreadsheet->setActiveSheetIndex(0);

            $writer = new Xlsx($spreadsheet);
            $filename = 'Multi_Sheet_Report_' . date('Y-m-d_H-i-s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            show_error('Error generating multiple sheets Excel: ' . $e->getMessage());
        }
    }

    /**
     * Buat sheet untuk data users
     */
    private function create_users_sheet($sheet)
    {
        $sheet->setCellValue('A1', 'DATA PENGGUNA');
        $sheet->mergeCells('A1:E1');
        
        $headers = ['No', 'Nama', 'Email', 'Telepon', 'Status'];
        $column = 'A';
        
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '2', $header);
            $column++;
        }

        $data = $this->get_sample_data();
        $row = 3;
        $no = 1;

        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item['nama']);
            $sheet->setCellValue('C' . $row, $item['email']);
            $sheet->setCellValue('D' . $row, $item['telepon']);
            $sheet->setCellValue('E' . $row, 'Aktif');
            
            $row++;
            $no++;
        }

        // Auto size
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Buat sheet untuk summary
     */
    private function create_summary_sheet($sheet)
    {
        $sheet->setCellValue('A1', 'SUMMARY REPORT');
        $sheet->mergeCells('A1:B1');
        
        $data = $this->get_sample_data();
        $total_users = count($data);
        
        $sheet->setCellValue('A3', 'Total Pengguna:');
        $sheet->setCellValue('B3', $total_users);
        
        $sheet->setCellValue('A4', 'Tanggal Export:');
        $sheet->setCellValue('B4', date('d/m/Y H:i:s'));
        
        $sheet->setCellValue('A5', 'Status Report:');
        $sheet->setCellValue('B5', 'Complete');

        // Auto size
        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Get sample data (ganti dengan query database sesungguhnya)
     */
    private function get_sample_data()
    {
        // Contoh data dummy - ganti dengan query dari database
        // $this->db->select('*');
        // $this->db->from('users');
        // return $this->db->get()->result_array();

        return [
            [
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'tanggal_daftar' => '2024-01-15'
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane@example.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'tanggal_daftar' => '2024-01-20'
            ],
            [
                'nama' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Thamrin No. 789, Surabaya',
                'tanggal_daftar' => '2024-01-25'
            ]
        ];
    }
}