<?php

class Model_kategori extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_kategori';
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('kode_kategori', 'ASC');

        if($search_name !="")
			$this->db->like('kode_kategori',$search_name);
			$this->db->or_like('nama',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();
		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}
	}

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		$this->db->where(['kode_kategori' => $data['kode_kategori']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kode_kategori' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END

}