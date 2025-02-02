<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'transaksi';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_opname');
		$this->load->model('master/Model_barang');

	}

	public function starter()
	{
		$this->data['new_nomor_transaksi'] = $this->Model_opname->getNomorTransaksi();
	}

	public function index()
	{
		$this->starter();
		$this->render_template('opname/index',$this->data);
	}


	public function store()
	{
        $f 		= $this->router->fetch_method(); // Function
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_opname->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_opname->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_opname->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no=1;
			foreach ($data as $key => $value) {
				$id		= $value['nomor_transaksi'];

				$btn 	= '';
				$btn 	.= '
						<a href="'.base_url('transaksi/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
							<i class="fa fa-eye"></i> </a>
						</a>';
						
                $btn 	.= '<a hidden href="'.base_url('transaksi/'.$cn.'/print/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-info mb-1">
							<i class="fa fa-print"></i> </a>
                            </a>
                            <a hidden href="'.base_url('transaksi/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
                                <i class="fa fa-edit"></i> </a>
                            </a>';

				$btn .= ' <a hidden class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
				$btn .= "remove('".$id."')";
				$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
							<i class="fa fa-trash"></i></a></div>';


				$output['data'][$key] = array(
					$id,
					$value['user_input'],
					tanggal($value['tanggal_input']),
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
		$this->data['header'] = $this->Model_opname->getData($id, 'header');
		$this->data['detail'] = $this->Model_opname->getData($id);

		if($this->data['header']['nomor_transaksi']){
			$this->render_template('opname/detail',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
			redirect('transaksi/opname', 'refresh');
		}

	}

	public function tambah()
	{

		$this->form_validation->set_rules('kd_brg[]', 'Kode Barang','required',
				array(	'required' 	=> 'Kode Barang Tidak Boleh Kosong !!',
		));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_opname->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/opname', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/opname/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('opname/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('nama' ,'Nama' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_opname->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Nama : "'.$_POST['nama'].'" <br> Berhasil Di Update !!');
				redirect('master/barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/opname/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['barang'] = $this->Model_opname->getBarang($id);

			if($this->data['barang']['kode_barang']){
				$this->render_template('opname/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/opname/edit/'.$id, 'refresh');
			}
		}
	}

	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_opname->saveDelete($id);

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
