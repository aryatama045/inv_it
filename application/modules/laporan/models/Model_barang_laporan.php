<?php

class Model_barang_laporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	function getDataStore($result,$search_kd_barang="", $search_name = "", $kategori = "", $merk = "", $type ="", $stock ="", $status ="", $lokasi ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_barang');
        $this->db->order_by('kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('kode_barang', $search_name);
                $this->db->or_like('nama_barang', $search_name);
				$this->db->or_like('serial_number', $search_name);
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

		if($stock !="")
		{
			$this->db->where('barang_stock', $stock);
		}

		if($status !="")
		{
			$this->db->where('status_barang', $status);
		}

		if($lokasi !="")
		{
			$this->db->where('lokasi_terakhir', $lokasi);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else if($result == 'report'){
			$query=$this->db->get();
			return $query->result_array();
		}
		else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}


}