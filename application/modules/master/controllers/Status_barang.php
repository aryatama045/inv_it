<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Status_barang extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_status_barang');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('status_barang/index',$this->data);
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

		$data           = $this->Model_status_barang->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_status_barang->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_status_barang->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['status_barang'];

				$btn 	= '';
				$btn 	.= '<a href="'.base_url('master/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
								<i class="fa fa-eye"></i> </a>
							</a>
							<a href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
								<i class="fa fa-edit"></i> </a>
							</a>';

				$btn 	.= ' <a class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
				$btn 	.= "remove('".$id."')";
				$btn 	.= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
						<i class="fa fa-trash"></i></a>';

				$output['data'][$key] = array(
					$id,
					$value['nama'],
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

		$this->form_validation->set_rules('status_barang' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_status_barang->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('master/status_barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/status_barang/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('status_barang/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('status_barang' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_status_barang->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['status_barang'].'" <br> Berhasil Di Update !!');
				redirect('master/status_barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/status_barang/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['type'] = $this->Model_global->getStatusBarang($id);

			if($this->data['type']['status_barang']){
				$this->render_template('status_barang/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/status_barang/edit/'.$id, 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_status_barang->saveDelete($id);

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
