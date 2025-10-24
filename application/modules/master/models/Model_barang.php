<?php

class Model_barang extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_barang';

		$this->load->model('transaksi/Model_tanda_terima');
	}

	function getKodeBarang($id = NULL)
	{

		$str_cat = strlen($id);

		// $getKode = $this->db->query("SELECT RIGHT(kode_barang,$str_cat)+1 as gencode FROM mst_barang
		// WHERE kode_kategori ='$id' ORDER BY kode_barang DESC LIMIT 1")->row_array();

		$getKode = $this->db->query("SELECT CAST((SUBSTR(kode_barang,LENGTH(kode_kategori)+1,7)) AS SIGNED INTEGER)+1 as gencode FROM mst_barang
		WHERE kode_kategori ='$id' ORDER BY gencode DESC LIMIT 1")->row_array();
		 

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
		$this->db->where('status_terjual', NULL);
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
		$this->db->where('status_terjual', NULL);
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
			$this->db->group_start();
				$this->db->like('kode_barang', $search_kd_barang);
                $this->db->or_like('serial_number', $search_kd_barang);
			$this->db->group_end();
			// $this->db->like('kode_barang', $search_kd_barang);
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
			$this->db->where_in('status_barang', ['S', 'QTY', 'N', 'PG'] );
			// $this->db->where_not_in('status_barang', ['R', 'H'] );
		} else if($jenis == "IN") {

			$this->db->where_in('status_barang', ['U', 'QTY', 'N'] );

		} else if($jenis == "JUAL") {
			$this->db->where_in('status_barang', ['R', 'RJ1','RJ2', 'W', 'WJ2'] );
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

	function saveTambahBaru()
	{
		// Start transaction
		$this->db->trans_start();
		
		$error		= [];
		$error_new 	= '';
		$data		= $_POST;

		// Generate Item Barang sesuai Qty
		$log_item_brg 		= array();
		for ($x=0; $x < count($data['kode_kategori']); $x++) {

			// Simpan kode yang sudah di-generate untuk kategori ini
			if($data['barang_stock'][$x] == 'True'){
				$kode_barang = $data['kode_kategori'][$x].'001';
				$status_barang = 'QTY';
			}else{
				$kode_barang = $this->getKodeBarang($data['kode_kategori'][$x]);
				$status_barang = 'S';
			}
			
			// Master Barang Item
			$item_data = [
				'kode_barang' 		=> $data['kode_barang'][$x],
				'serial_number' 	=> isset($data['serial_number'][$x]) ? $data['serial_number'][$x] : '-',
				'nama_barang' 		=> $data['nama_barang'][$x],
				'keterangan'		=> $data['keterangan'][$x],
				'keterangan_acct'	=> $data['nomor_pembelian'][$x],
				'kode_kategori' 	=> $data['kode_kategori'][$x],
				'kode_merk'     	=> $data['kode_merk'][$x],
				'kode_type'     	=> $data['kode_type'][$x],
				'harga_beli'		=> $data['harga_beli'][$x],
				'harga_asuransi'	=> 0,
				'lokasi_terakhir'	=> 'HO_IT',
				'status_barang'		=> $status_barang,
				'barang_stock'		=> $data['barang_stock'][$x],
				'user_input'		=> $this->session->userdata('username'),
				'tanggal_input'		=> date('d-m-Y'),
				'tanggal_pembelian'	=> date('d-m-Y', strtotime($data['tanggal_beli'][$x])),
			];
			$this->db->insert('mst_barang', $item_data);
			$error = $this->db->error();
			$error_new .= cekError($error);
			array_push($log_item_brg,$item_data);

		}
		
		// Header Dokumen Tanda Terima IN
		$count_d 	= count($data['urut']);
		$header = array(
			'nomor_transaksi' 	=> $this->Model_tanda_terima->getNomorTransaksi(),
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> 'HO_IT',
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('username'),
			'manual'			=> "False",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_pengiriman'=> date('Y-m-d'),
			'tgl_terima_it'		=> date('Y-m-d', strtotime($data['tanggal_pengiriman'])),
		);
		$this->db->insert('tanda_terima_h', $header);
		$error 			= $this->db->error();
		$error_new 	   .= cekError($error);

		//// Detail Dokumen Tanda Terima IN
		$log_detail = array();
		foreach ($log_item_brg as $key => $val) {

			if($data['barang_stock'][$key] == 'True'){
				$status_barang = 'QTY';
			}else{
				$status_barang = 'S';
			}

			//// Detail Dokumen
			$detail = [
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $key+1,
				'kode_barang' 		=> $val['kode_barang'],
				'qty'		 		=> $data['qty_detail'][$key],
				'status_barang_old'	=> 'N',
				'status_barang'		=> $status_barang,
				'harga_asuransi'	=> '0',
				'keterangan_barang'	=> $val['keterangan'],
			];
			$this->db->insert('tanda_terima_d', $detail);
			$error 			= $this->db->error();
			$error_new 	   .= cekError($error);
			array_push($log_detail, $detail);
		}

		$this->db->trans_complete(); 	// Complete transaction
		if ($this->db->trans_status() === FALSE) { 	// Check transaction status
			return [
				'status' 	=> 'FALSE',
				'message' 	=> $error_new,
			];
		} else {
			return [
				'status' 	=> 'TRUE',
				'message' 	=> 'Transaksi berhasil.',
			];
		}

	}
	// ---- Action END


}