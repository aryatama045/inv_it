<?php

class Model_install_ulang extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_install_ulang';

	}


    public function getNomorTransaksi()
	{
		$docCode	 ='INUL';
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

	// ---- Datatables Start
	public function getDataStore($result,$search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('kode_program', 'ASC');

        if($search_name !="")
		{
			$this->db->group_start();
				$this->db->like('kode_program', $search_name);
                $this->db->or_like('nama_program', $search_name);
			$this->db->group_end();
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
            $this->db->trans_start(); // Start transaction

            $error 		= [];
            $error_new 	= '';
            $data 		= $_POST;
			
            $datainsert = [
                'nama_program'	=> capital($data['nama_program']),
				'keterangan'    => capital($data['keterangan']),
				'is_os'			=> (!empty($data['is_os']))?$data['is_os']:0,
				'pic_input'    	=> $this->session->userdata('username'),
				'tgl_input'    	=> date('Y-m-d H:i:s'),
            ];

			$insert = $this->db->insert($this->table, $datainsert);
            $error = $this->db->error();
            $error_new .= cekError($error);

			$this->db->trans_complete(); // Complete transaction
            if ($this->db->trans_status() === FALSE) {
                return [
                    'status' 	=> 'FALSE',
                    'message' 	=> $error_new,
                ];
            } else {
                return [
                    'status' 	=> 'TRUE',
                    'message' 	=> 'Berhasil.',
                ];
            }

		}

		function saveEdit()
		{
			$data = $_POST;
			$this->db->where(['id_kategori' => $data['id_kategori']]);
			$update = $this->db->update($this->table, $data);

			return ($update)?TRUE:FALSE;
		}

		function saveDelete($id)
		{
			$this->db->where(['id_kategori' => $id]);
			$delete = $this->db->delete($this->table);

			return ($delete)?TRUE:FALSE;
		}
	// ---- Action END



}