<?php

class Model_tanda_terima extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'tanda_terima_h';

		$this->load->database();
		$this->db->reconnect();
	}

	public function getNomorTransaksi()
	{
		$docCode	 ='TT';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM tanda_terima_h
		WHERE nomor_transaksi LIKE '".$sno_doc."%' ORDER BY nomor_transaksi DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['gencode'];
			for ($i=4; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getNomorTransaksiManual()
	{
		$docCode	 ='TTM';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM tanda_terima_h
		WHERE nomor_transaksi LIKE '".$sno_doc."%' ORDER BY nomor_transaksi DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['gencode'];
			for ($i=4; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getDataStore($result, $search_name = "",$jenis="",$pengirim="",$penerima="",$tujuan="", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("a.* ");
        $this->db->from('tanda_terima_h a');
        $this->db->order_by('a.tanggal_input, a.nomor_transaksi', 'DESC');

        if($search_name !=""){
			$this->db->group_start();
			$this->db->like('a.nomor_transaksi',$search_name);
            $this->db->or_like('a.pengirim',$search_name);
			// $this->db->or_like('b.nama',$search_name);
			$this->db->group_end();
		}

		if($jenis !=""){
			$this->db->where('a.kode_dokumen',$jenis);
		}
		if($pengirim !=""){
			$this->db->where('a.pengirim',$pengirim);
		}
		if($penerima !=""){
			$this->db->where('a.penerima',$penerima);
		}
		if($tujuan !=""){
			$this->db->where('a.tujuan',$tujuan);
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

	public function getData($id, $type=null)
	{
		if($id){
			if($type == 'header'){

				$this->db->from('tanda_terima_h');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->row_array();

			}else if($type == 'detail'){

				$this->db->select('h.*, d.*, b.nama_barang, s.nama nama_status');
				$this->db->from('tanda_terima_d d');
				$this->db->join('tanda_terima_h h'		,'d.nomor_transaksi = h.nomor_transaksi','left');
				$this->db->join('mst_barang b'			,'d.kode_barang 	= b.kode_barang','left');
				$this->db->join('mst_status_barang s'	,'d.status_barang 	= s.status_barang','left');
				$this->db->where('h.nomor_transaksi', $id);
				$this->db->order_by('d.no_urut');
				$query= $this->db->get();
				// die(nl2br($this->db->last_query()));
				return $query->result_array();

			}else{

				$this->db->from('tanda_terima_d');
				$this->db->where('nomor_transaksi',$id);
				$this->db->or_where('kode_barang',$id);
				$query	= $this->db->get();
				return $query->result_array();

			}
		}else{
			return false;
		}
	}


	public function getDataDetail($nomor_transaksi){
		$this->db->select('h.*, d.*, b.nama_barang, s.nama nama_status');
		$this->db->from('tanda_terima_d d');
		$this->db->join('tanda_terima_h h'		,'d.nomor_transaksi = h.nomor_transaksi','left');
		$this->db->join('mst_barang b'			,'d.kode_barang 	= b.kode_barang','left');
		$this->db->join('mst_status_barang s'	,'d.status_barang 	= s.status_barang','left');
		$this->db->where('h.nomor_transaksi', $nomor_transaksi);
		$this->db->order_by('d.no_urut');
		$query= $this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->result_array();
	}

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;

		if($data['kd_dokumen'] == 'IN'){
			$tgl_pengiriman 	= '';
			$tgl_terima_it	 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
		}else{
			$tgl_pengiriman 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
			$tgl_terima_it	 	= '';
		}

		$log_detail = array();
		$count_d 	= count($data['urut']);

		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksi(),
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> $data['tujuan'],
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('name'),
			'manual'			=> "False",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_pengiriman'=> $tgl_pengiriman,
			'tgl_terima_it'		=> $tgl_terima_it,
		);

		for($x = 0; $x < $count_d ; $x++) {

			$getBarang = $this->Model_global->getBarang($data['kd_brg'][$x]);

			if($getBarang['barang_stock'] == 'True'){
				$status_barang = $getBarang['status_barang'];
			}else{
				$status_barang = $data['status'][$x];
			}

			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $data['urut'][$x],
				'kode_barang' 		=> $data['kd_brg'][$x],
				'qty'		 		=> $data['qty'][$x],
				'status_barang_old'	=> $getBarang['status_barang'],
				'status_barang'		=> $status_barang,
				'harga_asuransi'	=> $getBarang['harga_asuransi'],
				'keterangan_barang'	=> $data['ket'][$x],
			);
			array_push($log_detail, $detail);

			// Update Status Barang
				$kode_barang 	= $data['kd_brg'][$x];
				$where 		 	= array('kode_barang' => $kode_barang);
				$update_status 	= array(
									'status_barang' => $status_barang,
									'lokasi_terakhir' => $data['tujuan']
								);
				$this->db->where($where)->update('mst_barang', $update_status);
			// Update Status Barang
		}

		$insert 		= $this->db->insert('tanda_terima_h', $header);

		$insert_detail 	= $this->db->insert_batch('tanda_terima_d', $log_detail);

		return ($insert)?TRUE:FALSE;
	}

	function saveTambahManual()
	{
		$data = $_POST;

		if($data['kd_dokumen'] == 'IN'){
			$tgl_pengiriman 	= '';
			$tgl_terima_it	 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
		}else{
			$tgl_pengiriman 	= date('Y-m-d', strtotime($data['tanggal_pengiriman']));
			$tgl_terima_it	 	= '';
		}

		$log_detail = array();
		$count_d 	= count($data['keterangan']);

		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksiManual(),
			'kode_dokumen' 		=> $data['kd_dokumen'],
			'keterangan'		=> $data['keterangan_header'],
			'pengirim'			=> $data['pengirim'],
			'penerima'			=> $data['penerima'],
			'tujuan'			=> $data['tujuan'],
			'jumlah_detail'		=> $count_d,
			'user_input'		=> $this->session->userdata('name'),
			'manual'			=> "True",
			'tanggal'			=> date('Y-m-d'),
			'tanggal_input'		=> date('Y-m-d'),
			'tanggal_pengiriman'=> $tgl_pengiriman,
			'tgl_terima_it'		=> $tgl_terima_it,
		);

		for($x = 0; $x < $count_d ; $x++) {

			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $x+1,
				'kode_barang' 		=> '',
				'qty'		 		=> $data['qty'][$x],
				'status_barang_old'	=> '',
				'status_barang'		=> '',
				'harga_asuransi'	=> '',
				'keterangan_barang'	=> $data['keterangan'][$x],
			);
			array_push($log_detail, $detail);

		}

		$insert 		= $this->db->insert('tanda_terima_h', $header);

		$insert_detail 	= $this->db->insert_batch('tanda_terima_d', $log_detail);

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