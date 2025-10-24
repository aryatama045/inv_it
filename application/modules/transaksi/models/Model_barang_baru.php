<?php

class Model_barang_baru extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db->reconnect();

		$this->load->model('transaksi/Model_tanda_terima');
		$this->load->model('master/Model_barang');
	}

	public function getDataStore($result, $search_name = "",$jenis="",$pengirim="",$penerima="",$tujuan="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("a.* ");
        $this->db->from('tanda_terima_h a');
        $this->db->order_by('a.tanggal_input, a.nomor_transaksi', 'DESC');

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
		// Start transaction
		$this->db->trans_start();
		
		$error		= [];
		$error_new 	= '';
		$data		= $_POST;

		// Generate Item Barang sesuai Qty
		$log_item_brg 		= array();
		for ($x=0; $x < count($data['kode_kategori']); $x++) {

			// Simpan kode yang sudah di-generate untuk kategori ini
			if($data['barang_stock'][$x] == 'True'){
				$kode_barang = $data['kode_kategori'][$x].'001';
				$status_barang = 'QTY';
			}else{
				$kode_barang = $this->Model_barang->getKodeBarang($data['kode_kategori'][$x]);
				$status_barang = 'S';
			}
			
			// Master Barang Item
			$item_data = [
				'kode_barang' 		=> $kode_barang,
				'serial_number' 	=> isset($data['serial_number'][$x]) ? $data['serial_number'][$x] : '-',
				'nama_barang' 		=> $data['nama_barang'][$x],
				'keterangan'		=> $data['keterangan'][$x],
				'keterangan_acct'	=> $data['nomor_pembelian'][$x],
				'kode_kategori' 	=> $data['kode_kategori'][$x],
				'kode_merk'     	=> $data['kode_merk'][$x],
				'kode_type'     	=> $data['kode_type'][$x],
				'harga_beli'		=> $data['harga_beli'][$x],
				'harga_asuransi'	=> 0,
				'lokasi_terakhir'	=> 'HO_IT',
				'status_barang'		=> $status_barang,
				'barang_stock'		=> $data['barang_stock'][$x],
				'user_input'		=> $this->session->userdata('username'),
				'tanggal_input'		=> date('d-m-Y'),
				'tanggal_pembelian'	=> date('d-m-Y', strtotime($data['tanggal_beli'][$x])),
			];
			$this->db->insert('mst_barang', $item_data);
			$error = $this->db->error();
			$error_new .= cekError($error);
			array_push($log_item_brg,$item_data);

		}
		
		// Header Dokumen Tanda Terima IN
		$count_d 	= count($data['urut']);
		$header = array(
			'nomor_transaksi' 	=> $this->Model_tanda_terima->getNomorTransaksi(),
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> 'HO_IT',
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('username'),
			'manual'			=> "False",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_pengiriman'=> date('Y-m-d'),
			'tgl_terima_it'		=> date('Y-m-d', strtotime($data['tanggal_pengiriman'])),
		);
		$this->db->insert('tanda_terima_h', $header);
		$error 			= $this->db->error();
		$error_new 	   .= cekError($error);

		//// Detail Dokumen Tanda Terima IN
		$log_detail = array();
		foreach ($log_item_brg as $key => $val) {

			if($data['barang_stock'][$key] == 'True'){
				$status_barang = 'QTY';
			}else{
				$status_barang = 'S';
			}

			//// Detail Dokumen
			$detail = [
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $key+1,
				'kode_barang' 		=> $val['kode_barang'],
				'qty'		 		=> $data['qty_detail'][$key],
				'status_barang_old'	=> 'N',
				'status_barang'		=> $status_barang,
				'harga_asuransi'	=> '0',
				'keterangan_barang'	=> 'GENERATE BARANG BARU',
			];
			$this->db->insert('tanda_terima_d', $detail);
			$error 			= $this->db->error();
			$error_new 	   .= cekError($error);
			array_push($log_detail, $detail);
		}

		$this->db->trans_complete(); 	// Complete transaction
		if ($this->db->trans_status() === FALSE) { 	// Check transaction status
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


}