<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_global extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->library('auth');
    }

    function getKategoriBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_kategori');
        $this->db->order_by('nama_kategory', 'ASC');
        if($id){
            $this->db->where('kode_kategory', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getMerkBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_merk');
        $this->db->order_by('nama', 'ASC');
        if($id){
            $this->db->where('kode_merk', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getTypeBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_type');
        $this->db->order_by('nama', 'ASC');
        if($id){
            $this->db->where('kode_type', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getStatusBarang($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_status_barang');
        $this->db->order_by('nama', 'ASC');
        if($id){
            $this->db->where('status_barang', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

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

    function getTahunAjaranAktif() {
        $this->db->select('*');
        $this->db->from('mst_ta');
        $this->db->where('aktif', '1');
        $this->db->order_by('kd_ta', 'ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->row_array();
    }

    function getTahunAjaran($kd_ta = NULL)
    {
        $this->db->select("*,
            CASE WHEN (smt)= '1' THEN '<b>GASAL</b>'
			WHEN (smt)='2' THEN '<b>GENAP</b>'
			ELSE 'Belum Ada Status' END smt_gage
        ");
		$this->db->from('mst_ta');
        $this->db->order_by('ta DESC, smt ASC');

        if($kd_ta){
            $this->db->where('kd_ta', $kd_ta);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getSemesterMahasiswaAktif($nim="",$ta="")
    {
        #--- Search
        $where_ta = '';
        if($ta){
            $where_ta = ',(SELECT kd_ta FROM mst_ta WHERE kd_ta = "'.$ta.'")ta_aktif
                        ,(SELECT smt FROM mst_ta WHERE kd_ta = "'.$ta.'")smt_aktif';
        }else{
            $where_ta = ",(SELECT kd_ta FROM mst_ta WHERE aktif = 1)ta_aktif
                        ,(SELECT smt FROM mst_ta WHERE aktif = 1)smt_aktif";
        }

        $where_nim = '';
        if($nim){
            $where_nim = 'WHERE a.nim = "'.$nim.'" ';
        }
        #--- End Search


        $sql = "SELECT *, (ta_aktif-kd_ta)+1 zem
                    FROM(
                        SELECT nim, nama_mhs,a.kd_prog,a.kd_ta, b.ta
                        $where_ta
                        FROM mst_mhs a
                        LEFT JOIN mst_ta b ON a.kd_ta=b.kd_ta
                    )a
                $where_nim
        ";
        $query = $this->db->query($sql);
        // die(nl2br($this->db->last_query()));

        if($nim){
            return $query->row_array();
        }else{
            return $query->result_array();
        }

    }

    function getCekKrs($kd_ta="",$nim="",$kode_matkul="")
    {
        $this->db->select('*');
		$this->db->from('trn_krs_paket');
        $this->db->where('kd_ta', $kd_ta);
        $this->db->where('nim', $nim);
        $this->db->where('kode_matkul', $kode_matkul);
        $query=$this->db->get();

        if($kd_ta != "" || $nim != "" || $kode_matkul != ""){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }

    function getMhsNik($nik)
    {
        $this->db->select('*');
		$this->db->from('mst_mhs');
        $this->db->where('nik', $nik);
		$query=$this->db->get();
		return $query->row_array();
    }

    function getMhsNim($nim)
    {
        $this->db->select('*');
		$this->db->from('mst_mhs');
        $this->db->where('nim', $nim);
		$query=$this->db->get();
		return $query->row_array();
    }

    function getDataUsername($username)
	{
		$this->db->select('*');
		$this->db->from('users');
        $this->db->where('username', $username);
		$query=$this->db->get();
		return $query->row_array();
	}

    function getDosen($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_dosen');
        if($id){
            $this->db->where('nip', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getProdi($kode_prog = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_prodi');

        if($kode_prog){
            $this->db->where('kd_prog', $kode_prog);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getMataKuliah($kode_matkul = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_matkul');
        $this->db->join('mst_prodi', 'mst_matkul.kd_prog = mst_prodi.kd_prog', 'left');
        $this->db->order_by('smt, nama_matkul ', 'ASC');
        if($kode_matkul){
            $this->db->where('kode_matkul', $kode_matkul);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getMatkulPersmt($smt = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_matkul');
        $this->db->join('mst_prodi', 'mst_matkul.kd_prog = mst_prodi.kd_prog', 'left');
        $this->db->order_by('smt, nama_matkul ', 'ASC');
        if($smt){
            $this->db->where('smt', $smt);
        }else{
            $this->db->group_by('smt', 'ASC');
        }

        $query=$this->db->get();
        return $query->result_array();
    }

    function getJenma($kd_jenma = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jenma');

        if($kd_jenma){
            $this->db->where('kd_jenma', $kd_jenma);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getBiaya($kd_biaya = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_biaya');
        $this->db->join('mst_jenma', 'mst_biaya.kd_jenma = mst_jenma.kd_jenma', 'left');
		$this->db->join('mst_ta', 'mst_biaya.kd_ta = mst_ta.kd_ta', 'left');

        if($kd_biaya){
            $this->db->where('kd_biaya', $kd_biaya);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getJenisBiaya($kd_jenis = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jenis_biaya');

        if($kd_jenis){
            $this->db->where('kd_jenis', $kd_jenis);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getPeriodeDaftar($kode = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_gel_daftar');
        $this->db->join('mst_ta', 'mst_gel_daftar.kd_ta = mst_ta.kd_ta', 'left');

        if($kode){
            $this->db->where('kode', $kode);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getJabatan($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jabatan');
        $this->db->order_by('nama', 'ASC');

        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getAgama($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_agama');
        $this->db->order_by('nama', 'ASC');
        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getKota($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_kota');
        $this->db->order_by('nm_kota', 'ASC');

        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function cek_gel_daftar()
    {
        $dates = date('Y-m-d');
        $sql = "SELECT * FROM ( SELECT *
                            FROM mst_gel_daftar
                            WHERE '$dates' >= DATE(tgl_awal) AND '$dates' <= DATE(tgl_akhir)
                            ORDER BY tgl_akhir ASC
                        )a
                WHERE (tgl_awal <='$dates' AND tgl_akhir >='$dates') ORDER BY tgl_awal ASC";
        $query=$this->db->query($sql);
        return $query->row_array();

    }

    function krs_khs($nim, $kd_ta)
    {
        $sql = "SELECT * FROM trn_krs_paket a
                    LEFT JOIN mst_matkul b ON a.kode_matkul = b.kode_matkul
                    LEFT JOIN trn_tugas_ajar c ON a.id_ajar=c.id
                    LEFT JOIN mst_dosen d ON c.nip = d.nip
                    WHERE nim=$nim AND a.kd_ta=$kd_ta
                ";
        $query= $this->db->query($sql);

        // die(nl2br($this->db->last_query()));
        return $query->result_array();
    }

}