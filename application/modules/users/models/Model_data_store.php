<?php

class Model_data_store extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_personil';
	}


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("mst_personil.*");
        $this->db->from($this->table);
        $this->db->where('nip', 0);
        $this->db->where("IFNULL(kd_store,'')<>'' ");
        $this->db->order_by('nama', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
			$this->db->like('kd_store',$search_name);
            $this->db->or_like('nama',$search_name);
			$this->db->group_end();
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

	public function detail($id)
	{
		$this->db->select("mst_personil.*");
        $this->db->from('');
		$this->db->where('nip',$id);
		$query	= $this->db->get();
		return $query->row_array();
	}

	public function storeData($id=NULL)
	{
		if($id){
			$this->db->select("mst_personil.*");
			$this->db->from('mst_personil');
			$this->db->where('nip','0');
			$this->db->where('kd_store',$id);
			$query	= $this->db->get();
			return $query->row_array();
		}else{
			$this->db->select("mst_personil.*");
			$this->db->from('mst_personil');
			$this->db->where('nip','0');
			$this->db->order_by('nama', 'ASC');
			$query	= $this->db->get();
			return $query->result_array();
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