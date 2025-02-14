<?php

class Model_merk extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_merk';
	}

	function sortByGrade($a, $b) {
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}

	public function getKodeMerk()
	{
		$kode = $this->Model_global->getMerk();

		usort($kode, array($this,'sortByGrade'));

		$myLastKode = $kode[array_key_last($kode)];

		$myLastKode = $myLastKode['kode_merk']+1;

		return $myLastKode;
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('kode_merk', 'ASC');

        if($search_name !="")
			$this->db->like('kode_merk',$search_name);
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
		$this->db->where(['kode_merk' => $data['kode_merk']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kode_merk' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END

}