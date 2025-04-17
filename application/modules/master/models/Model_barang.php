<?php

class Model_barang extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_barang';
	}

	function getKodeBarang($id = NULL)
	{

		$str_cat = strlen($id);

		$getKode = $this->db->query("SELECT RIGHT(kode_barang,$str_cat)+1 as gencode FROM mst_barang
		WHERE kode_kategori ='$id' ORDER BY kode_barang DESC LIMIT 1")->row_array();

		$code    = uppercase($id);
		if($getKode){
			$urut = $getKode['gencode'];
			for ($i=$str_cat; $i > strlen($getKode['gencode']) ; $i--) {
				$urut = $urut;
			}

			if(strlen($urut) < 3)
			{
				if(strlen($urut) < 2)
				{
					$urut =  "00".$urut;
				}else{
					$urut =  "0".$urut;
				}
			}else{
				$urut = $urut;
			}

			return $code.$urut;

		}else{
			return $code."001";
        }
	}

	// ---- Datatables Start
	function getDataStore($result,$search_kd_barang="", $search_name = "", $kategori = "", $merk = "", $type ="", $stock ="", $status ="", $lokasi ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
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

	function getBarangTransaksi($result,$search_kd_barang="", $search_name = "", $kategori = "", $merk = "", $type ="", $stock ="", $jenis ="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_barang');
        $this->db->order_by('kode_barang', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('kode_barang', $search_name);
                $this->db->or_like('nama_barang', $search_name);
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

		if($jenis == "OUT")
		{
			$this->db->where_in('status_barang', ['S', 'QTY', 'N'] );
			// $this->db->where_not_in('status_barang', ['R', 'H'] );
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
		$data 				= $_POST;
		// if($data['kategori'] != '0'){
			$kodeBarang 		= $this->getKodeBarang($data['kategori']);
		// }else{
			$kodeBarang 		= $data['kode_barang'];
		// }

		$cekStok 			= $this->db->query("SELECT * FROM stock
								WHERE kode_barang='$kodeBarang' ")->row_array();

		if($data['barang_stock'] == 'True'){
			$barang_stock	= 'True';
			$status_barang 	= 'QTY';
		}else{
			$barang_stock	= 'False';
			$status_barang 	= 'N';
		}

		$dataBarang = array(
			'kode_barang' 		=> $kodeBarang,
			'serial_number'		=> $data['serial_number'],
			'nama_barang' 		=> $data['nama_barang'],
			'keterangan'		=> $data['keterangan'],
			'keterangan_acct'	=> $data['keterangan_acct'],
			'kode_kategori'		=> $data['kategori'],
			'kode_merk'			=> $data['merk'],
			'kode_type'			=> $data['type'],
			'harga_beli'		=> $data['harga_beli'],
			'harga_asuransi'	=> $data['harga_asuransi'],
			'lokasi_terakhir'	=> 'HO_IT',
			'status_barang'		=> $status_barang,
			'barang_stock'		=> $barang_stock,
			'user_input'		=> $this->session->userdata('username'),
			'tanggal_input'		=> date('Y-m-d H:i:s'),
			'tanggal_pembelian'	=> date('Y-m-d H:i:s', strtotime($data['tanggal_pembelian'])),

		);

		if($data['barang_stock'] == 'True'){
			$addStock = array(
				'kode_barang'	=> $kodeBarang,
				'saldo_awal'	=> '0',
				'in'			=> '0',
				'out'			=> '0'
			);
			if(empty($cekStok)){
				$insert = $this->db->insert('stock', $addStock);
			}
		}

		$insert = $this->db->insert('mst_barang', $dataBarang);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit($id)
	{
		$data = $_POST;
		$this->db->where(['kode_barang' => $id]);
		$update = $this->db->update('mst_barang', $data);

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