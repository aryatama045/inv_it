<?php

class Model_barang_laporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Model_global');
	}


	function getDataStore($result,$search_kd_barang="", $search_name = "", $kategori = "", $merk = "", $type ="", $stock ="", $status ="", $lokasi ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('b.*, k.nama as nama_kategori');
        $this->db->from('mst_barang b');
		$this->db->join('mst_kategori k','b.kode_kategori = k.kode_kategori', 'left');
        $this->db->order_by('b.kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('b.kode_barang', $search_name);
                $this->db->or_like('b.nama_barang', $search_name);
				$this->db->or_like('b.serial_number', $search_name);
			$this->db->group_end();
		}


		if($kategori !="")
		{
			$this->db->where('b.kode_kategori', $kategori);
		}

		if($merk !="")
		{
			$this->db->where('b.kode_merk', $merk);
		}

		if($type !="")
		{
			$this->db->where('kode_type', $type);
		}

		if($stock !="")
		{
			$this->db->where('b.barang_stock', $stock);
		}

		if($status !="")
		{
			$this->db->where('b.status_barang', $status);
		}

		if($lokasi !="")
		{
			$this->db->where('b.lokasi_terakhir', $lokasi);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else if($result == 'report'){
			$query=$this->db->get();
			// die($this->db->last_query());
			return $query->result_array();
		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}


	function getDataExport($search_name = "", $kategori = "", $merk = "", $type ="", $stock ="", $status ="", $lokasi ="")
	{

		$this->db->select('b.*, k.nama as nama_kategori');
        $this->db->from('mst_barang b');
		$this->db->join('mst_kategori k','b.kode_kategori = k.kode_kategori', 'left');
        $this->db->order_by('b.kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('b.kode_barang', $search_name);
                $this->db->or_like('b.nama_barang', $search_name);
				$this->db->or_like('b.serial_number', $search_name);
			$this->db->group_end();
		}

		if($kategori !="")
		{
			$this->db->where('b.kode_kategori', $kategori);
		}

		if($merk !="")
		{
			$this->db->where('b.kode_merk', $merk);
		}

		if($type !="")
		{
			$this->db->where('kode_type', $type);
		}

		if($stock !="")
		{
			$this->db->where('b.barang_stock', $stock);
		}

		if($status !="")
		{
			$this->db->where('b.status_barang', $status);
		}

		if($lokasi !="")
		{
			$this->db->where('b.lokasi_terakhir', $lokasi);
		}

		$query=$this->db->get();
		// die($this->db->last_query());
		return $query->result_array();

	}


	function exportExcel($data=null)
	{

		#--- Style ------------------------
			set_time_limit(3600);
			ini_set('memory_limit', '2048M');
			function align_center($obj,$row){
				$obj->getStyle($row)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			function align_middle($obj,$row){
				$obj->getStyle($row)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			}
			function align_left($obj,$row){
				$obj->getStyle($row)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
			function align_right($obj,$row){
				$obj->getStyle($row)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
			function style($obj,$row,$style){
				$obj->getStyle($row)->applyFromArray($style);
			}
			function merge($obj,$row){
				$obj->mergeCells($row);
			}
			function date_format_excel($obj,$column,$value){
				$dateTimeNow = date('Y-m-d', strtotime($value));			
				$obj->setCellValue($column, PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
				$obj->getStyle($column)->getNumberFormat()->setFormatCode(': dd-mmm-yyyy');
			}
		#--- Style ------------------------


		if($data==null){
			return false;
		}else{
			// Style -----------------------------
				$this->load->library('excel');

				$objPHPExcel = new PHPExcel();

				$objPHPExcel->getProperties()->setTitle("title")
								->setDescription("description");
				// Assign cell values
				$objPHPExcel->setActiveSheetIndex(0);
				$row = 1;
				// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':M'.$row);
				$sheet	 	= $objPHPExcel->getActiveSheet();
				$sheet_set 	= $objPHPExcel->setActiveSheetIndex(0);
				//Alignment


				$border['borders'] = array (
					'allborders'=> array(
						'style'=> PHPExcel_Style_Border::BORDER_THIN ,
					)
				);
				style($sheet,'A'.$row.':R'.$row,$border);

			// Style -----------------------------

			$styleArray = array(
				'font'  => array(
					'bold'  => true,
				)
			);
			style($sheet,'A1'.':R'.$row,$styleArray);

			// Header
				$sheet->setCellValue('A'.$row, 'No.');
				$sheet->setCellValue('B'.$row, 'Kode Barang');
				$sheet->setCellValue('C'.$row, 'Nama Barang');
				$sheet->setCellValue('D'.$row, 'Kategori');
				$sheet->setCellValue('E'.$row, 'Merk');
				$sheet->setCellValue('F'.$row, 'Type');
				$sheet->setCellValue('G'.$row, 'Tanggal Pembelian');
				$sheet->setCellValue('H'.$row, 'Harga Pembelian');
				$sheet->setCellValue('I'.$row, 'Keterangan Barang');
				$sheet->setCellValue('J'.$row, 'Keterangan Acct');
				$sheet->setCellValue('K'.$row, 'Status Barang');
				$sheet->setCellValue('L'.$row, 'Tanggal Terakhir');
				$sheet->setCellValue('M'.$row, 'Lokasi Terakhir');
				$sheet->setCellValue('N'.$row, 'Serial Number');
				$sheet->setCellValue('O'.$row, 'Qty Baik');
				$sheet->setCellValue('P'.$row, 'Qty Rusak');
				$sheet->setCellValue('Q'.$row, 'Barang Stock');
				$sheet->setCellValue('R'.$row, 'Tanggal Opname');
			// Header
			

			$styleArray = array(
				'font'  => array(
					'bold'  => true,
				)
			);
			style($sheet,'A2'.':R'.$row,$styleArray);

			// Detail
				foreach ($data['detail'] as $key => $value) {
					
					$row++;
					style($sheet,'A'.$row.':R'.$row,$border);
					align_center($sheet,'A'.$row);

					// Pengirim, Penerima, dan Tujuan
						if($value['lokasi_terakhir']){
							$getPerson = $this->Model_global->getPersonil($value['lokasi_terakhir']);

							if($getPerson){
								$LokasiAkhir = $getPerson['nip'].'-'.$getPerson['nama'];
							}else{
								$LokasiAkhir = '-';
							}

						}else{
							$LokasiAkhir = '-';
						}

						if($value['barang_stock'] == 'True'){
							$getstock = $this->Model_global->getStockBarang($value['kode_barang']);
							if($getstock != NULL){
								$stock = $getstock['saldo_awal'] + $getstock['in'] - $getstock['out'];
							}else{
								$stock = '0';
							}

							$getstockR = $this->Model_global->getStockRusak($value['kode_barang']);
							if($getstockR != NULL){
								$stockR = $getstockR['saldo_awal'] + $getstockR['in'] - $getstockR['out'];
							}else{
								$stockR = '0';
							}

							$Qty 		= $stock;
							$QtyR 		= $stockR;
							$Stock    	= 'Stock';
						}else{

							$getHistory = $this->Model_global->getMutasiBarang($value['kode_barang']);

							if($getHistory){
								$Qty 	= '0';
								$QtyR 	= '1';
							}else{
								$QtyR 	= '0';
								$Qty 	= '1';
							}

							$Stock    	= 'Tidak';
						}

						$Kategoris = $this->Model_global->getKategori($value['kode_kategori']);
						if($Kategoris == NULL){
							$Kategori = '-';
						}else{
							$Kategori = $value['kode_kategori'].'-'.trim($Kategoris['nama']);
						}

						$Merks     = $this->Model_global->getMerk($value['kode_merk']);
						if($Merks == NULL){
							$Merk = '-';
						}else{
							$Merk = $value['kode_merk'].'-'.trim($Merks['nama']);
						}

						$Types     = $this->Model_global->getType($value['kode_type']);
						if($Types == NULL){
							$Type = '-';
						}else{
							$Type = $value['kode_type'].'-'.trim($Types['nama']);
						}
					// Pengirim, Penerima, dan Tujuan

					$namaBarang		= uppercase(lowercase($value['nama_barang']));
					$Keterangan 	= ($value['keterangan'] == NULL)? '-' : trim($value['keterangan']);
					$KeteranganAcct = ($value['keterangan_acct'] == NULL)? '-' : trim($value['keterangan_acct']);
					$SerialNumber 	= ($value['serial_number'] == NULL)? '-' : trim($value['serial_number']);
					$TglBeli		= ($value['tanggal_pembelian'] == NULL || $value['tanggal_pembelian'] == '00-00-0000')? '00-00-0000' : date('d-m-Y', strtotime($value['tanggal_pembelian']));
					$TglAkhir		= ($value['tanggal_lokasi_akhir'] == NULL || $value['tanggal_lokasi_akhir'] == '00-00-0000' || $value['tanggal_lokasi_akhir'] == ' 00-00-0000')? '00-00-0000' : date('d-m-Y', strtotime($value['tanggal_lokasi_akhir']));

					$sheet->setCellValue('A'.$row, $key+1);
					$sheet->setCellValue('B'.$row, $value['kode_barang']);
					$sheet->setCellValue('C'.$row, $namaBarang);
					$sheet->setCellValue('D'.$row, $Kategori);
					$sheet->setCellValue('E'.$row, $Merk);
					$sheet->setCellValue('F'.$row, $Type);
					$sheet->setCellValue('G'.$row, $TglBeli);
					$sheet->setCellValue('H'.$row, nominal($value['harga_beli']));
					$sheet->setCellValue('I'.$row, $Keterangan);
					$sheet->setCellValue('J'.$row, $KeteranganAcct);
					$sheet->setCellValue('K'.$row, $value['status_barang']);
					$sheet->setCellValue('L'.$row, $TglAkhir);
					$sheet->setCellValue('M'.$row, $LokasiAkhir);
					$sheet->setCellValue('N'.$row, $SerialNumber);
					$sheet->setCellValue('O'.$row, $Qty);
					$sheet->setCellValue('P'.$row, $QtyR);
					$sheet->setCellValue('Q'.$row, $Stock);
					$sheet->setCellValue('R'.$row, $value['opname']);
				}
			// Detail
			
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			align_left($sheet,'A'.$row);
			foreach(range('A','R') as $columnID) {
				$sheet->getColumnDimension($columnID)
					->setAutoSize(true);
			}
			// Save it as an excel 2003 file
			$filename = "Export Report Barang - (".date('d-m-Y h:i:s').")";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit();
		}

	}



}