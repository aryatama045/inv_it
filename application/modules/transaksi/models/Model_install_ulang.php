<?php

class Model_install_ulang extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

    public function getNomorTransaksi()
	{
		$docCode	 ='INUL';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM trn_install_ulang_h
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

	public function getDataStore($result, $search_name = "",$tujuan="", $length = "", $start = "", $column = "", $order = "")
	{
		$this->db->select("a.* ");
        $this->db->from('trn_install_ulang_h a');
        $this->db->order_by('a.tanggal_dokumen, a.nomor_transaksi', 'DESC');

        if($search_name !=""){
			$this->db->group_start();
			$this->db->like('a.nomor_transaksi',$search_name);
            $this->db->or_like('a.pic_install',$search_name);
			$this->db->group_end();
		}

		if($tujuan !=""){
			$this->db->where('a.pc_tujuan',$tujuan);
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

				$this->db->from('trn_install_ulang_h');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->row_array();

			}else if($type == 'detail'){

				$this->db->select(' a.no_urut ,a.keterangan keterangan_detail,a.pic_check_checked, a.pic_install_checked,
									b.nomor_transaksi, b.pic_input, b.keterangan keterangan_header,
									b.tanggal_dokumen, b.tanggal_mulai,b.tanggal_check, b.tanggal_selesai,
									b.pic_install, b.pic_check, b.pic_approve,
									b.pc_tujuan, b.pc_ip, b.pc_os, b.pc_kode_barang,
									c.kode_program,c.nama_program, d.kode_barang, d.nama_barang
								');
				$this->db->from('trn_install_ulang_d a');
				$this->db->join('trn_install_ulang_h b'		,'a.nomor_transaksi = b.nomor_transaksi','left');
				$this->db->join('mst_install_ulang c'		,'a.kode_program = c.kode_program','left');
				$this->db->join('mst_barang d'		,'a.kode_barang = d.kode_barang','left');
				$this->db->where('b.nomor_transaksi', $id);
				$this->db->order_by('a.no_urut');
				$query= $this->db->get();
				// die(nl2br($this->db->last_query()));
				return $query->result_array();

			}else{

				$this->db->from('trn_install_ulang_d');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->result_array();

			}
		}else{
			return false;
		}
	}

	// ---- Action Start
	public function saveTambah()
	{
		$this->db->trans_start(); // Start transaction
		$error 		= [];
		$error_new 	= '';
		$data 		= $_POST;


		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksi(),
			'tanggal_dokumen'	=> date('Y-m-d'),
			'tanggal_mulai'		=> date('Y-m-d', strtotime($data['tanggal_mulai'])),
			'keterangan'		=> $data['keterangan_header'],
			'pc_os'				=> $data['pc_os'],
			'pc_ip'				=> $data['pc_ip'],
			'pc_tujuan'			=> $data['pc_tujuan'],
			'pic_install'		=> $data['pic_install'],
			'pic_check'			=> $data['pic_check'],
			'pic_approve'		=> '17110014',
			'pic_input'			=> $this->session->userdata('username'),
		);
		$this->db->insert('trn_install_ulang_h', $header);
		$error = $this->db->error();
		$error_new .= cekError($error);


		$log_detail = array();
		for($x = 0; $x < count($data['urut']); $x++) {

			$detail = array(
				'nomor_transaksi' 		=> $header['nomor_transaksi'],
				'no_urut' 				=> $data['urut'][$x],
				'kode_program' 			=> $data['kode_program'][$x],
				'kode_barang' 			=> $data['kode_barang'][$x],
				'keterangan'			=> $data['keterangan_detail'][$x],
				'pic_install_checked' 	=> '1',
			);
			array_push($log_detail, $detail);
		}
		$this->db->insert_batch('trn_install_ulang_d', $log_detail);
		$error = $this->db->error();
		$error_new .= cekError($error);


		$this->db->trans_complete(); // Complete transaction
		if ($this->db->trans_status() === FALSE) {
			return [
				'status' 	=> 'FALSE',
				'message' 	=> $error_new,
			];
		} else {
			return [
				'status' 	=> 'TRUE',
				'message' 	=> 'Transaksi berhasil.',
			];
		}
        
	}

	public function saveUpdate($id)
	{
		$this->db->trans_start(); // Start transaction
		$error 		= [];
		$error_new 	= '';
		$data 		= $_POST;

		// Get data lama dari database untuk compare
		$detail_lama = $this->getData($id, 'detail');
		$no_urut_lama = array_map(function($d) { return $d['no_urut']; }, $detail_lama);
		$no_urut_baru = isset($data['no_urut']) ? $data['no_urut'] : [];

		// Array untuk tracking operation
		$log_detail = array();

		// 1. UPDATE: Update row yang ada dengan data baru
		for($x = 0; $x < count($no_urut_baru); $x++) {
			$no_urut_current = $no_urut_baru[$x];

			// Check apakah row ini sudah ada di database (UPDATE) atau row baru (INSERT)
			if(in_array($no_urut_current, $no_urut_lama)) {
				// UPDATE existing row
				$detail = array(
					'kode_barang' 			=> $data['kode_barang'][$x],
					'keterangan'			=> $data['keterangan_detail'][$x],
					'pic_install_checked'	=> '1',
					'pic_check_checked'		=> '1',
				);
				$this->db->where([
					'nomor_transaksi' 	=> $id,
					'no_urut' 			=> $no_urut_current,
				]);
				$this->db->update('trn_install_ulang_d', $detail);
				$error = $this->db->error();
				$error_new .= cekError($error);

				array_push($log_detail, ['action' => 'UPDATE', 'no_urut' => $no_urut_current, 'detail' => $detail]);
			} else {
				// INSERT new row
				$detail = array(
					'nomor_transaksi'		=> $id,
					'no_urut'				=> $no_urut_current,
					'kode_program'			=> $data['kode_program'][$x],
					'kode_barang'			=> $data['kode_barang'][$x],
					'keterangan'			=> $data['keterangan_detail'][$x],
					'pic_install_checked'	=> '1',
					'pic_check_checked'		=> '1',
				);
				$this->db->insert('trn_install_ulang_d', $detail);
				$error = $this->db->error();
				$error_new .= cekError($error);

				array_push($log_detail, ['action' => 'INSERT', 'no_urut' => $no_urut_current, 'detail' => $detail]);
			}
		}

		// 2. DELETE: Hapus row yang ada di database tapi tidak ada di form baru
		foreach($no_urut_lama as $urut_lama) {
			if(!in_array($urut_lama, $no_urut_baru)) {
				// Row ini dihapus, DELETE dari database
				$this->db->where([
					'nomor_transaksi' 	=> $id,
					'no_urut'			=> $urut_lama,
				]);
				$this->db->delete('trn_install_ulang_d');
				$error = $this->db->error();
				$error_new .= cekError($error);

				array_push($log_detail, ['action' => 'DELETE', 'no_urut' => $urut_lama]);
			}
		}

		$this->db->trans_complete(); // Complete transaction
		if ($this->db->trans_status() === FALSE) {
			return [
				'status' 	=> 'FALSE',
				'message' 	=> $error_new,
			];
		} else {
			return [
				'status' 	=> 'TRUE',
				'message' 	=> 'Transaksi berhasil.',
			];
		}
	}

	public function saveCheck($id)
	{
		$this->db->trans_start(); // Start transaction
		$error 		= [];
		$error_new 	= '';
		$data 		= $_POST;

		$header = array(
			'tanggal_check'		=> date('Y-m-d'),
		);
		$this->db->where(['nomor_transaksi' => $id]);
		$this->db->update('trn_install_ulang_h', $header);
		$error = $this->db->error();
		$error_new .= cekError($error);

		// Dapatkan pic_check_checked yang sudah merupakan associative array (key = no_urut)
		$pic_check_map = [];
		if(isset($data['pic_check_checked']) && is_array($data['pic_check_checked'])) {
			$pic_check_map = $data['pic_check_checked'];
		}

		$log_detail = array();
		// Loop semua no_urut
		if(isset($data['no_urut']) && is_array($data['no_urut'])) {
			foreach($data['no_urut'] as $no_urut) {
				// Ambil value dari pic_check_map menggunakan no_urut sebagai key
				$pic_check_value = (isset($pic_check_map[$no_urut])) ? $pic_check_map[$no_urut] : 0;

				$detail = array(
					'pic_check_checked' 	=> $pic_check_value,
				);
				$this->db->where([
					'nomor_transaksi' 	=> $id,
					'no_urut' 			=> $no_urut,
				]);
				$this->db->update('trn_install_ulang_d', $detail);
				$error = $this->db->error();
				$error_new .= cekError($error);
				array_push($log_detail, $detail);
			}
		}

		$this->db->trans_complete(); // Complete transaction
		if ($this->db->trans_status() === FALSE) {
			return [
				'status' 	=> 'FALSE',
				'message' 	=> $error_new,
			];
		} else {
			return [
				'status' 	=> 'TRUE',
				'message' 	=> 'Transaksi berhasil.',
			];
		}
	}

	public function saveApprove($id)
	{
		$this->db->trans_start(); // Start transaction
		$error 		= [];
		$error_new 	= '';
		$data 		= $_POST;

		$header = array(
			'tanggal_selesai'		=> date('Y-m-d'),
		);
		$this->db->where(['nomor_transaksi' => $id]);
		$this->db->update('trn_install_ulang_h', $header);
		$error = $this->db->error();
		$error_new .= cekError($error);

		$this->db->trans_complete(); // Complete transaction
		if ($this->db->trans_status() === FALSE) {
			return [
				'status' 	=> 'FALSE',
				'message' 	=> $error_new,
			];
		} else {
			return [
				'status' 	=> 'TRUE',
				'message' 	=> 'Transaksi berhasil.',
			];
		}
	}
	// ---- Action END

	public function getBarangData($result, $search_kode = "", $search_nama = "", $length = "", $start = "")
	{
		$this->db->select("kode_barang, nama_barang");
        $this->db->from('mst_barang');
        $this->db->where('status_terjual', NULL);
        $this->db->order_by('kode_barang', 'ASC');

        if($search_kode != ""){
			$this->db->like('kode_barang', $search_kode);
		}

		if($search_nama != ""){
			$this->db->like('nama_barang', $search_nama);
		}

		if($result == 'numrows'){
			return $this->db->count_all_results();
		}

		if($length != "" && $start != ""){
			$this->db->limit($length, $start);
		}

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getProgramData($result, $search_kode = "", $search_nama = "", $length = "", $start = "")
	{
		$this->db->select("kode_program, nama_program");
        $this->db->from('mst_install_ulang');
        $this->db->where('is_os', '0');
        $this->db->order_by('kode_program', 'ASC');

        if($search_kode != ""){
			$this->db->like('kode_program', $search_kode);
		}

		if($search_nama != ""){
			$this->db->like('nama_program', $search_nama);
		}

		if($result == 'numrows'){
			return $this->db->count_all_results();
		}

		if($length != "" && $start != ""){
			$this->db->limit($length, $start);
		}

		$query = $this->db->get();
		return $query->result_array();
	}

}




