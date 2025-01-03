<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_barang');

	}

	public function starter()
	{

	}

	public function index()
	{
		$this->starter();
		$this->render_template('barang/index',$this->data);
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

		$data           = $this->Model_barang->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_barang->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_barang->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no=1;
			foreach ($data as $key => $value) {
				$id		= $value['kode_barang'];

				$btn 	= '';
				$btn 	.= '
						<a href="'.base_url('master/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
							<i class="fa fa-eye"></i> </a>
						</a>
						<a href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
							<i class="fa fa-edit"></i> </a>
						</a>';

						$btn .= ' <a class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
						$btn .= "remove('".$id."')";
						$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
								<i class="fa fa-trash"></i></a>

						</div>';


				$output['data'][$key] = array(
					$no++,
					$value['kode_barang'].'-'.$value['nama_barang'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	public function show($id)
	{

		$this->starter();
		$this->data['barang'] = $this->Model_barang->getBarang($id);

		if($this->data['barang']['kode_barang']){
			$this->render_template('barang/show',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
			redirect('master/barang', 'refresh');
		}

	}

	public function tambah()
	{

		$this->form_validation->set_rules('nama' ,'Nama' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_barang->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', 'Mata Kuliah Berhasil Disimpan !!');
				redirect('master/barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/barang/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('barang/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('nama' ,'Nama' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_barang->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Nama : "'.$_POST['nama'].'" <br> Berhasil Di Update !!');
				redirect('master/barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/barang/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['barang'] = $this->Model_barang->getBarang($id);

			if($this->data['barang']['kode_barang']){
				$this->render_template('barang/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/barang/edit/'.$id, 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_barang->saveDelete($id);

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
