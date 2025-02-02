<?php

class Model_opname extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'opname_h';

		$this->load->database();
		$this->db->reconnect();
	}

	public function getNomorTransaksi()
	{
		$docCode	 ='OP';
		$date		 = date('ym');
		$sno_doc 	 = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(nomor_transaksi,4)+1 as gencode FROM opname_h
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


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("opname_h.*");
        $this->db->from($this->table);
        $this->db->order_by('tanggal_input', 'DESC');

        if($search_name !="")
			$this->db->like('nomor_transaksi',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	public function getData($id, $detail=null)
	{
		if($id){
			if($detail == 'header'){
				$this->db->from('opname_h');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->row_array();
			}else{
				$this->db->from('opname_d');
				$this->db->where('nomor_transaksi',$id);
				$query	= $this->db->get();
				return $query->result_array();
			}
		}else{
			return false;
		}
	}



	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$header = array(
			'nomor_transaksi' 	=> $this->getNomorTransaksi(),
			'keterangan'		=> $data['keterangan_header'],
			'user_input'		=> $this->session->userdata('username'),
			'tanggal_input'		=> date('Y-m-d H:i:s'),
		);

		$log_detail = array();
		$count_d = count($data['urut']);

		for($x = 0; $x < $count_d ; $x++) {
			$detail = array(
				'nomor_transaksi' 	=> $header['nomor_transaksi'],
				'no_urut' 			=> $data['urut'][$x],
				'kode_barang' 		=> $data['kd_brg'][$x],
				'qty'	 		    => $data['qty'][$x],
				'keterangan_barang'	=> $data['ket'][$x],
			);
			array_push($log_detail, $detail);

            // Update Barang Tanggal Opname
            $kode_barang = $data['kd_brg'][$x];
            $this->db->where('kode_barang', $kode_barang)
                    ->update('mst_barang', ['opname' => date('d-m-Y H:i:s')]);
		}

        // tesx($header, $log_detail);

		$insert 		= $this->db->insert('opname_h', $header);

		$insert_detail 	= $this->db->insert_batch('opname_d', $log_detail);

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