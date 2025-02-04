<?php

class Model_stock extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->db->reconnect();
	}



	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

        $this->db->from('mst_barang');
        $this->db->order_by('kode_barang', 'ASC');

        if($search_name !="")
			$this->db->like('kode_barang',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}


}