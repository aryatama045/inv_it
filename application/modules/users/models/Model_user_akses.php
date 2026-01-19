<?php

class Model_user_akses extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'users';
	}


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("a.*, a.status aktif, b.nip, b.nama nama_karyawan, b.kd_store, c.name roles");
        $this->db->from('users a');
        $this->db->join('mst_personil b',    'a.username = b.nip', 'left');
        $this->db->join('roles c',           'a.roles_id = c.id', 'left');
        $this->db->order_by('a.name, a.username', 'ASC');

        if($search_name !="")
			$this->db->like('a.username',$search_name);
            $this->db->or_like('a.name',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	public function detail($id)
	{
        $this->db->from($this->table);
		$this->db->where('id',$id);
		$query	= $this->db->get();
		return $query->row_array();
	}

	// ---- Action Start
	function saveTambah()
	{
		$data 				= $_POST;
		$password 			= password_hash($data['nip'], PASSWORD_DEFAULT);

		$dataUsers = array(
			'name'			=> 'name',
			'username'		=> $data['nip'],
			'roles_id'		=> $data['roles'],
			'password'		=> $password ,
			'status'		=> $data['status'],
			'created_at'	=> date('Y-m-d H:i:s'),
		);
		$insert  = $this->db->insert('users', $dataUsers);

		$getUser = $this->db->where('username', $data['nip'])
							->from('users')
							->get()->row_array();

		$dataRoles = array(
			'user_id'	=> $getUser['id'],
			'role_id'	=> $data['roles'],
		);
		$insert  = $this->db->insert('roles_users', $dataRoles);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->db->where(['username' => $data['username']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['username' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}