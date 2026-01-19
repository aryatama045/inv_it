<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install_ulang extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] 	= 'Master';
		$this->ctrl 	        = $this->router->fetch_class(); // Controller
		$this->func 	        = $this->router->fetch_method(); // Function
		$this->data['pagetitle']= capital($this->ctrl);
		$this->data['function'] = capital($this->func);

		$this->load->model('Model_install_ulang');

	}

	public function starter()
	{
		// $this->data['kode_install_ulang'] = $this->Model_install_ulang->getKodeInstallUlang();
	}


	public function index()
	{
		$this->starter();
		$this->render_template($this->ctrl.'/index',$this->data);
	}

	public function store()
	{
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= '';//$_REQUEST['order'][0]['column'];
		$order 			= '';//$_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   	= $this->input->post('search_name');
		$data           = $this->Model_install_ulang->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_install_ulang->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_install_ulang->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['kode_program'];
				$btn 	= '';
				// $btn 	.= '<a href="'.base_url('master/'.$this->ctrl.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
				// 				<i class="fa fa-eye"></i> </a>
				// 			</a>
				// 			<a href="'.base_url('master/'.$this->ctrl.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
				// 				<i class="fa fa-edit"></i> </a>
				// 			</a>';
				// $btn 	.= ' <a class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
				// $btn 	.= "remove('".$id."')";
				// $btn 	.= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
				// 			<i class="fa fa-trash"></i></a>';

				$output['data'][$key] = array(
					$key+$start+1,
					$value['nama_program'],
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

		$this->form_validation->set_rules('nama_program', 'Nama Program','required',
				array('required' => 'Nama Program Tidak Boleh Kosong !!',
		));

        if ($this->form_validation->run() == TRUE) {
			
			$create_form = $this->Model_install_ulang->saveTambah();

			if($create_form['status'] === 'FALSE') {
				$this->session->set_flashdata('error', $create_form['message'].' </br> Silahkan Cek kembali data yang di input !!');
				redirect('master/'.$this->ctrl.'/tambah', 'refresh');
			} else {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('master/'.$this->ctrl, 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template($this->ctrl.'/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('kode_install_ulang' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_install_ulang->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['kode_install_ulang'].'" <br> Berhasil Di Update !!');
				redirect('master/kategori', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/kategori/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['param'] = $this->Model_global->getInstall_ulang($id);

			if($this->data['param']['kode_install_ulang']){
				$this->render_template('kategori/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/kategori/edit/'.$id, 'refresh');
			}
		}
	}

	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_install_ulang->saveDelete($id);

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
