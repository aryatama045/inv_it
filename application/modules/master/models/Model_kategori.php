<?php

class Model_kategori extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_kategori';
	}

	public function sortByGrade($a, $b) {
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}

	public function getKodeKategori()
	{
		$kode_kategori = $this->Model_global->getKategori();

		usort($kode_kategori, array($this,'sortByGrade'));

		$myLastKode = $kode_kategori[array_key_last($kode_kategori)];

		return $myLastKode;
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
		function saveTambah($data_kat)
		{

			$insert = $this->db->insert($this->table, $data_kat);

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



	/**
     * Cek apakah nama kategori sudah ada
     * 
     * @param string $name Nama kategori
     * @param int $exclude_id ID yang dikecualikan (untuk update)
     * @return boolean
     */
    public function check_name_exists($name) {
        $this->db->where('REPLACE(REPLACE(nama, "\\r", ""), "\\n", "") =', strtoupper(trim($name)));
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

	/**
     * 
     * @param string $code Kode kategori
     * @return boolean
     */
    public function check_code_exists($code) {
        $this->db->where('kode_kategori', $code);
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }


	 /**
     * Ambil semua kode kategori yang ada
     * 
     * @return array
     */
    public function get_all_codes() {
        $this->db->select('kode_kategori');
        $query = $this->db->get($this->table);
        return $query->result();
    }

	/**
     * Ambil semua kategori
     * 
     * @return array
     */
    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }


    /**
     * Validasi kode kategori untuk update
     * 
     * @param string $code Kode kategori
     * @param int $id ID kategori (untuk exclude)
     * @return boolean
     */
    public function validate_code($code, $id = null) {
        $this->db->where('kode_kategori', $code);
        // if ($id) {
        //     $this->db->where('id !=', $id);
        // }
        $query = $this->db->get($this->table);
        return $query->num_rows() == 0;
    }

    /**
     * Ambil kategori berdasarkan ID
     * 
     * @param int $id ID kategori
     * @return object
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }




}