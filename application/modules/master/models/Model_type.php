<?php

class Model_type extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_type';
	}

	function sortByGrade($a, $b) {
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}

	public function getKodeTypes()
	{
		$kode = $this->Model_global->getType();

		usort($kode, array($this,'sortByGrade'));

		$myLastKode = $kode[array_key_last($kode)];

		$myLastKode = $myLastKode['kode_type']+1;

		return $myLastKode;
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('ABS(kode_type)', 'ASC');

        if($search_name !="")
			$this->db->like('kode_type',$search_name);
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
		$this->db->where(['kode_type' => $data['kode_type']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kode_type' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END

}