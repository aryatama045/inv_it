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

		$this->db->select('*');
        $this->db->from('mst_barang');
        $this->db->order_by('kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('kode_barang', $search_name);
                $this->db->or_like('nama_barang', $search_name);
				$this->db->or_like('serial_number', $search_name);
			$this->db->group_end();
		}

		if($search_kd_barang !="")
		{
			$this->db->like('kode_barang', $search_kd_barang);
		}

		if($kategori !="")
		{
			$this->db->where('kode_kategori', $kategori);
		}

		if($merk !="")
		{
			$this->db->where('kode_merk', $merk);
		}

		if($type !="")
		{
			$this->db->where('kode_type', $type);
		}

		if($stock !="")
		{
			$this->db->where('barang_stock', $stock);
		}

		if($status !="")
		{
			$this->db->where('status_barang', $status);
		}

		if($lokasi !="")
		{
			$this->db->where('lokasi_terakhir', $lokasi);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else if($result == 'report'){
			$query=$this->db->get();
			return $query->result_array();
		}
		else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}


	function getDataTandaTerima($result,$search_kd_barang="", $search_name = "", $jenis = "", $merk = "", $type ="", $stock ="", $status ="", $lokasi ="", $tgl_awal ="", $tgl_akhir ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select(" h.*, d.no_urut, d.qty, b.kode_barang, b.nama_barang, d.keterangan_barang ket_detail,s.nama nama_status, d.status_barang");
        $this->db->from('tanda_terima_d d');
		$this->db->join('tanda_terima_h h'		,'d.nomor_transaksi = h.nomor_transaksi','left');
		$this->db->join('mst_barang b'			,'d.kode_barang 	= b.kode_barang','left');
		$this->db->join('mst_status_barang s'	,'d.status_barang 	= s.status_barang','left');

        $this->db->order_by('h.tanggal_input, h.nomor_transaksi', 'DESC', 'd.no_urut', 'ASC');

        if($search_name !=""){
			$this->db->group_start();
			$this->db->like('h.nomor_transaksi',$search_name);
            $this->db->or_like('h.pengirim',$search_name);
			$this->db->or_like('h.penerima',$search_name);
			$this->db->or_like('h.tujuan',$search_name);
			$this->db->or_like('d.kode_barang',$search_name);
			$this->db->or_like('b.nama_barang',$search_name);
			$this->db->group_end();
		}
		
		if($tgl_awal !=""){
			$tgl_awal = date('Y-m-d', strtotime($tgl_awal));
			$this->db->where('h.tanggal >=', $tgl_awal);
		}

		if($tgl_akhir !=""){
			$tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
			$this->db->where('h.tanggal <=', $tgl_akhir);
		}

		if($jenis !=""){
			$this->db->where('h.kode_dokumen',$jenis);
		}

		if($type !=""){
			$this->db->where('h.manual',$type);
			// $this->db->like('h.nomor_transaksi','TTM');
		}

		
		// if($pengirim !=""){
		// 	$this->db->where('a.pengirim',$pengirim);
		// }
		// if($penerima !=""){
		// 	$this->db->where('a.penerima',$penerima);
		// }
		// if($tujuan !=""){
		// 	$this->db->where('a.tujuan',$tujuan);
		// }

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


	function exportExcel($data=null)
	{
		function align_center($obj,$row){
			$obj->getStyle($row)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
		function date_format_excel($obj,$column,$value){
			$dateTimeNow = date('Y-m-d', strtotime($value));
			$obj->setCellValue($column, PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
			$obj->getStyle($column)->getNumberFormat()->setFormatCode(': dd-mmm-yyyy');
		}

		// tesx($data);

		if($data==null){
			return false;
		}else{
			$this->load->library('excel');

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("title")
							->setDescription("description");

			// Assign cell values
			$objPHPExcel->setActiveSheetIndex(0);
			$row = 1;
			$sheet = $objPHPExcel->getActiveSheet();

			$border['borders'] = array (
				'allborders'=> array(
					'style'=> PHPExcel_Style_Border::BORDER_THIN ,
				)
			);
			style($sheet,'A'.$row.':L'.$row,$border);
			$sheet->setCellValue('A'.$row, 'No.');
			$sheet->setCellValue('B'.$row, 'Kode Dokumen');
			$sheet->setCellValue('C'.$row, 'Nomor Transaksi');
			$sheet->setCellValue('D'.$row, 'Tanggal Input');
			$sheet->setCellValue('E'.$row, 'Pengirim');
			$sheet->setCellValue('F'.$row, 'Penerima');
			$sheet->setCellValue('G'.$row, 'Tujuan');
			$sheet->setCellValue('H'.$row, 'Kode Barang');
			$sheet->setCellValue('I'.$row, 'Nama Barang');
			$sheet->setCellValue('J'.$row, 'Qty');
			$sheet->setCellValue('K'.$row, 'Keterangan');
			$sheet->setCellValue('L'.$row, 'Status');
			

			$styleArray = array(
				'font'  => array(
					'bold'  => true,
				));
			style($sheet,'A1'.':L'.$row,$styleArray);

			foreach ($data['detail'] as $key => $value) {
				

				if($value['pengirim']){
					$getPengirim    = $this->Model_global->getPersonil($value['pengirim']);
					if($getPengirim){
						$pengirim       = $getPengirim['nip'].'-'.$getPengirim['nama'];
					}else{
						$pengirim       = '-';
					}
				}else{
					$pengirim       = '-';
				}

				if($value['penerima']){

					$getPenerima    = $this->Model_global->getPersonil($value['penerima']);
					if($getPenerima){
						$penerima       = $getPenerima['nip'].'-'.$getPenerima['nama'];
					}else{
						$penerima       = '-';
					}
				}else{
					$penerima       = '-';
				}

				if($value['tujuan']){
					$getTujuan    	= $this->Model_global->getPersonil($value['tujuan']);
					if($getTujuan){
						$tujuan       	= $getTujuan['nip'].'-'.$getTujuan['nama'];
					}else{
						$tujuan       	= '-';
					}
				}else{
					$tujuan       	= '-';
				}

				
				$row++;
				style($sheet,'A'.$row.':L'.$row,$border);
				$sheet->setCellValue('A'.$row, $key+1);
				$sheet->setCellValue('B'.$row, $value['kode_dokumen']);
				$sheet->setCellValue('C'.$row, $value['nomor_transaksi']);
				$sheet->setCellValue('D'.$row, date('d-m-Y',strtotime($value['tanggal'])));
				$sheet->setCellValue('E'.$row, $pengirim);
				$sheet->setCellValue('F'.$row, $penerima);
				$sheet->setCellValue('G'.$row, $tujuan);
				$sheet->setCellValue('H'.$row, $value['kode_barang']);
				$sheet->setCellValue('I'.$row, $value['nama_barang']);
				$sheet->setCellValue('J'.$row, $value['qty']);
				$sheet->setCellValue('K'.$row, $value['ket_detail']);
				$sheet->setCellValue('L'.$row, $value['status_barang']);
			}
			$row+=2;


			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			align_left($sheet,'A'.$row);
			foreach(range('A','L') as $columnID) {
				$sheet->getColumnDimension($columnID)
					->setAutoSize(true);
			}
			// Save it as an excel 2003 file
			$filename = "Export Report Tanda Terima - ( ".date('d-m-Y h:i:s')." )";
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

	}

}