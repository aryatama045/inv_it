<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function

		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		// Load Model
		$this->load->model('Model_role');

	}

	public function starter()
	{
        $this->data['modul'] = 'Settings';
        $this->data['page']   = $this->router->fetch_class();
	}


	public function index()
	{
		$this->starter();
		$this->render_template($this->data['page'].'/index',$this->data);
	}

	public function store()
	{
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_role->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_role->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_role->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['id'];

				$btn 	= '';
				$btn 	.= '<div class="btn-group">
							<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Opsi
							</button>
							<div class="dropdown-menu">
								<a href="'.base_url('settings/'.$cn.'/edit/'.$id).'" class="dropdown-item">
									<i data-acorn-icon="edit-square"></i> Edit</a>';

								$btn .= ' <a class="dropdown-item" onclick="';
								$btn .= "remove('".$id."')";
								$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
										<i data-acorn-icon="bin"></i> Delete</a>

							</div>
						</div>';

				$output['data'][$key] = array(
					capital(strtolower($value['name'])),
					capital(strtolower($value['sts'])),
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function tambah()
	{

		$this->form_validation->set_rules('name' ,'Role Name ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_role->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('settings/role', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('settings/role/tambah', 'refresh');
			}

		}else{
			$this->starter();
            // $this->data['ta']           = $this->Model_global->getTahunAjaran();
			$this->render_template('role/tambah',$this->data);
		}

	}

	public function edit($id)
	{

		$this->form_validation->set_rules('name' ,'Role Name ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_role->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Role Name  : "'.$_POST['name'].'" <br> Berhasil Di Update !!');
				redirect('settings/role', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('settings/role' , 'refresh');
			}

		}else{
			$this->starter();
            $this->data['role']  	= $this->Model_role->getDataRow($id);

			if($this->data['role']['id']){
				$this->render_template('role/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('settings/role' , 'refresh');
			}
		}
	}

	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_role->saveDelete($id);

			if($delete == true) {
				$response['success'] 	= true;
				$response['messages'] 	= " <strong>Kode '".$id."'</strong> Berhasil Di Remove";
			} else {
				$response['success'] 	= false;
				$response['messages'] 	= " <strong>Kode '".$id."'</strong> Gagal Di Remove";
			}
		}
		else {
			$response['success'] 	= false;
			$response['messages'] 	= "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}

?>
