<?php

class Model_mutasi_rusak extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mutasi_rusak_h';

		$this->load->database();
		$this->db->reconnect();
	}

	public function getNomorTransaksi()
	{
		$docCode	 ='MR';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM mutasi_rusak_h
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

	public function getNomorTransaksiJual()
	{
		$docCode	 ='MRT';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM mutasi_rusak_h
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


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("mutasi_rusak_h.*");
        $this->db->from($this->table);
        $this->db->order_by('tanggal_input', 'DESC');

        if($search_name !="")
			$this->db->like('nomor_transaksi',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	public function getData($id, $detail=null)
	{
		if($id){
			if($detail == 'header'){
				$this->db->from('mutasi_rusak_h');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->row_array();
			}else{
				$this->db->from('mutasi_rusak_d');
				$this->db->where('nomor_transaksi',$id);
				$this->db->order_by('CAST(no_urut AS UNSIGNED)', 'ASC');
				$query	= $this->db->get();
				return $query->result_array();
			}
		}else{
			return false;
		}
	}

	public function detail($id)
	{
		$this->db->select("mst_personil.*");
        $this->db->from($this->table);
		$this->db->where('nip',$id);
		$query	= $this->db->get();
		return $query->row_array();
	}

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksi(),
			'keterangan'		=> $data['keterangan_header'],
			'user_input'		=> $this->session->userdata('username'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_proses'	=> date('Y-m-d H:i:s', strtotime($data['tanggal_pengiriman'])),
		);

		$log_detail = array();
		$count_d = count($data['urut']);

		for($x = 0; $x < $count_d ; $x++) {
			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $data['urut'][$x],
				'kode_barang' 		=> $data['kd_brg'][$x],
				'qty_in'	 		=> $data['qty'][$x],
				'status_barang_old' => $data['status'][$x],
				'keterangan_barang'	=> $data['ket'][$x],
			);
			array_push($log_detail, $detail);

			// Update Status Barang		
				$kode_barang 	= $data['kd_brg'][$x];
				$where 		 	= array('kode_barang' => $kode_barang);
				$item_barang = array(
					'tanggal_update'	=> date('Y-m-d'),
					'status_barang'		=> 'R',
					
				);
				$this->db->where($where)->update('mst_barang', $item_barang);
			// Update Status Barang
		}

		$insert 		= $this->db->insert('mutasi_rusak_h', $header);

		$insert_detail 	= $this->db->insert_batch('mutasi_rusak_d', $log_detail);

		return ($insert)?TRUE:FALSE;
	}

	function saveTambahJual()
	{
		$data = $_POST;

		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksiJual(),
			'keterangan'		=> $data['keterangan_header'],
			'user_input'		=> $this->session->userdata('username'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_proses'	=> date('Y-m-d H:i:s', strtotime($data['tanggal_pengiriman'])),
		);

		$log_detail = array();
		$log_item 	= array();
		$log_error 	= array();
		$count_d 	= count($this->input->post('upload_kode_barang'));


		//*	Check Kode Barang
		for($x = 0;  $x < $count_d ;  $x++) {

			$getBarang = $this->Model_global->getBarang($data['upload_kode_barang'][$x]);

			if(!$getBarang)
			{
				$item_kosong = array(
					'kode_barang'	=> $data['upload_kode_barang'][$x],
					'nama_barang'	=> $data['upload_nama_barang'][$x]
				);
				array_push($log_error, $item_kosong);
			}

		}

		if($log_error){

			$show_error = 'Ada Kode Barang yang Tidak Ada / Terdaftar <br>';
			foreach ($log_error as $key => $val) {
				$show_error .= 'Kode Barang : '.$val['kode_barang'].' - Nama Barang : '.$val['nama_barang'].'<br>';
			}

			$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !! <br>'. $show_error);
			redirect('transaksi/mutasi_rusak/tambah_jual', 'refresh');
		}
		//* End Check Kode Barang


		$no=0;
		for($x = 0;  $x < $count_d ;  $x++) {
			$no++;

			$getBarang = $this->Model_global->getBarang($data['upload_kode_barang'][$x]);

			

			if (isset($data['upload_ket_rusak'][$x])) {
				$keterangan = htmlentities($data['upload_ket_rusak'][$x], ENT_QUOTES);
				$detail = array(
					'nomor_transaksi' 	=> $header['nomor_transaksi'],
					'no_urut' 			=> $no,
					'kode_barang' 		=> $getBarang['kode_barang'],
					'qty_in'	 		=> '1',
					'status_barang_old' => 'RJ1',
					'keterangan_barang'	=> $keterangan,

				);
				// $this->db->insert('mutasi_rusak_d', $detail);
				array_push($log_detail, $detail);

				// Update Status Barang		
					$kode_barang 	= $data['upload_kode_barang'][$x];
					$where 		 	= array('kode_barang' => $kode_barang);
					$item_barang = array(
						'keterangan'		=> $header['nomor_transaksi'].'-'.$keterangan,
						'user_input'		=> $data['upload_pic'][$x],
						'tanggal_terjual'	=> date('Y-m-d', strtotime($data['tanggal_pengiriman'])),
						'status_terjual'	=> 'sudah',
						
					);
					$this->db->where($where)->update('mst_barang', $item_barang);
					array_push($log_item, $item_barang);
				// Update Status Barang
			} 
		}


		$insert 		= $this->db->insert('mutasi_rusak_h', $header);

		$insert_detail 	= $this->db->insert_batch('mutasi_rusak_d', $log_detail);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		$this->db->where(['nip' => $data['nip']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['nip' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}