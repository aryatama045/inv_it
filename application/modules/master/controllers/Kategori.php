<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_kategori');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('kategori/index',$this->data);
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

		$data           = $this->Model_kategori->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_kategori->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_kategori->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['kode_kategori'];

				// $btn 	= '';
				// $btn 	.= '<div class="btn-group">
				// 			<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				// 				Opsi
				// 			</button>
				// 			<div class="dropdown-menu">
				// 				<a href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="dropdown-item">
				// 					<i data-acorn-icon="edit-square"></i> Edit</a>';

				// 				$btn .= ' <a class="dropdown-item" onclick="';
				// 				$btn .= "remove('".$id."')";
				// 				$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
				// 						<i data-acorn-icon="bin"></i> Delete</a>

				// 			</div>
				// 		</div>';

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

		$this->form_validation->set_rules('kode_kategori' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_kategori->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('master/kategori', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/kategori/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('kategori/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('kode_kategori' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_kategori->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['kode_kategori'].'" <br> Berhasil Di Update !!');
				redirect('master/kategori', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/kategori/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['kategori'] = $this->Model_global->getKategori($id);

			if($this->data['kategori']['kode_kategori']){
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
			$delete = $this->Model_kategori->saveDelete($id);

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
