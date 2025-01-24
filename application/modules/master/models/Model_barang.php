<?php

class Model_barang extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_barang';
	}

	// ---- Datatables Start
	public function getDataStore($result,$search_kd_barang="", $search_name = "", $kategori = "", $merk = "", $type ="", $stok ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
                $this->db->like('nama_barang', $search_name);
			$this->db->group_end();
		}

		if($search_kd_barang !="")
		{
			$this->db->like('kode_barang', $search_kd_barang);
		}

		if($kategori !="")
		{
			$this->db->where('kode_kategori', $kategori);
		}

		if($merk !="")
		{
			$this->db->where('kode_merk', $merk);
		}

		if($type !="")
		{
			$this->db->where('kode_type', $type);
		}

		if($stok !="")
		{
			$this->db->where('barang_stock', $stok);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}
	// ---- Datatables END

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit($id)
	{
		$data = $_POST;
		$this->db->where(['id' => $id]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['id' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}