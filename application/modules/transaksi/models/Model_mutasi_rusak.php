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


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("mutasi_rusak_h.*");
        $this->db->from($this->table);
        $this->db->order_by('tanggal_pengiriman', 'DESC');

        if($search_name !="")
			$this->db->like('nomor_transaksi',$search_name);
            $this->db->or_like('tujuan',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
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
			'kode_dokumen' 	=> $data['kd_dokumen'],
			'tujuan'		=> $data['tujuan']
		);

		$log_detail = array();
		$count_d = count($data['urut']);

		for($x = 0; $x < $count_d ; $x++) {
			$detail = array(
				'kode_dokumen' 	=> $data['kd_dokumen'],
				'kode_barang' 	=> $data['kd_brg'][$x],
				'qty'		 	=> $data['qty'][$x],
			);
			array_push($log_detail, $detail);
		}

		$insert 		= $this->db->insert('inv_web_it.mutasi_rusak_h', $header);

		$insert_detail 	= $this->db->insert('inv_web_it.mutasi_rusak_d', $detail);


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