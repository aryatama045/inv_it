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
				'keterangan_barang'	=> $data['ket'][$x],
			);
			array_push($log_detail, $detail);
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