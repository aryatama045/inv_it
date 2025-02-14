<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_global extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->library('auth');
    }

    function getBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_barang');
        $this->db->order_by('nama_barang', 'ASC');
        if($id){
            $this->db->where('kode_barang', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getKategori($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_kategori');
        $this->db->order_by('kode_kategori, nama', 'ASC');
        if($id){
            $this->db->where('kode_kategori', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getMerk($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_merk');
        $this->db->order_by('kode_merk,nama', 'ASC');
        if($id){
            $this->db->where('kode_merk', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getType($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_type');
        $this->db->order_by('kode_type', 'DESC');
        if($id){
            $this->db->where('kode_type', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getStatusBarang($id = NULL, $jenis = NULL)
    {
        $this->db->select('mst_status_barang.*, CONCAT(status_barang,"-", nama) AS full_name', FALSE);
		$this->db->from('mst_status_barang');
        $this->db->order_by('status_barang, nama', 'ASC');
        if($id){
            $this->db->where('status_barang', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            if($jenis){
                $this->db->where_not_in('status_barang', ['R','H', 'BS','E','J','N','RJ1','RJ2','TOL','W','WJ2','QTY','S']);
                $query=$this->db->get();
                return $query->result_array();
            }else{
                $this->db->where_not_in('status_barang', ['R','H', 'BS','E','J','N','RJ1','RJ2','W','WJ2','QTY','U','TOL','TM','PG']);
                $query=$this->db->get();
                return $query->result_array();
            }
        }
    }

    function getStockBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('stock');
        $this->db->order_by('kode_barang', 'ASC');
        if($id){
            $this->db->where('kode_barang', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getDataPengiriman()
    {
        $sql = "SELECT * FROM(
                    SELECT nip id, nama_lengkap nama  FROM hrd_all.mst_biodata
                    UNION
                    SELECT kode_store id, nama_store nama FROM hrd_all.mst_store
                ) h";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }


    // -------
    function getPersonil($id = NULL)
    {
        $id = preg_replace('/\s+/', '', $id);
        $this->db->select('*');
		$this->db->from('mst_personil');
        // $this->db->where('aktif', 1);
        $this->db->order_by('nama', 'ASC');
        if($id){
            $cek_id = is_numeric($id);

            if($cek_id == TRUE){
                $this->db->where('nip', $id);
                $query=$this->db->get();
                return $query->row_array();
            }else{
                $this->db->where('kd_store', $id);
                $this->db->where('nip', 0);
                $query=$this->db->get();
                return $query->row_array();
            }

        }else{
            $query=$this->db->get();
            return $query->result_array();
        }

    }

    function getStore($id = NULL)
    {
        $id = preg_replace('/\s+/', '', $id);
        $this->db->select('*');
		$this->db->from('mst_personil');
        // $this->db->where('aktif', 1);
        $this->db->order_by('nama', 'ASC');
        if($id){
            $cek_id = is_numeric($id);

            if($cek_id == TRUE){
                $this->db->where('nip', $id);
                $query=$this->db->get();
                return $query->row_array();
            }else{
                $this->db->where('kd_store', $id);
                $this->db->where('nip', 0);
                $query=$this->db->get();
                return $query->row_array();
            }

        }else{
            $query=$this->db->get();
            return $query->result_array();
        }

    }
    // --------

    // END DATA MASTER GET

    function getMenuSetting()
    {
        $this->db->select('*');
        $this->db->from('permissions');
        $this->db->where('parent_id', '8');
        $this->db->order_by('sequence', 'ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

    function getRoles($id = NULL)
    {
        $this->db->select('roles.*');
		$this->db->from('roles');
        $this->db->order_by('id,name', 'ASC');
        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function showRecentTandaTerima()
	{
        $this->db->from('tanda_terima_h');
        $this->db->order_by('tanggal, nomor_transaksi', 'DESC');
        $this->db->limit('10');
        $query	= $this->db->get();
        return $query->result_array();
	}

    function getHistoryBarang($id = NULL)
    {
        $this->db->select('d.*, h.kode_dokumen, h.tanggal, st.nama status_new, sto.nama status_old
            ,h.pengirim, h.penerima, h.tujuan');
        $this->db->from('tanda_terima_d d');
        $this->db->join('tanda_terima_h h', 'd.nomor_transaksi = h.nomor_transaksi', 'left');
        $this->db->join('mst_status_barang st', 'd.status_barang = st.status_barang', 'left');
        $this->db->join('mst_status_barang sto', 'd.status_barang_old = sto.status_barang', 'left');
        $this->db->where('d.kode_barang',$id);
        $this->db->order_by('h.nomor_transaksi, h.tanggal', 'DESC');
        $query	= $this->db->get();
        return $query->result_array();
    }

    function getMutasiBarang($id = NULL)
    {
        $this->db->select('d.*,   h.tanggal_input,h.keterangan, sto.nama status_old ');
        $this->db->from('mutasi_rusak_d d');
        $this->db->join('mutasi_rusak_h h', 'd.nomor_transaksi = h.nomor_transaksi', 'left');
        $this->db->join('mst_status_barang sto', 'd.status_barang_old = sto.status_barang', 'left');
        $this->db->where('d.kode_barang',$id);
        $this->db->order_by('h.nomor_transaksi, h.tanggal_input', 'DESC');
        $query	= $this->db->get();
        return $query->result_array();
    }


}