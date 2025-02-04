<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'laporan';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_stock');
		$this->load->model('master/Model_barang');

	}

	public function starter()
	{

	}

	public function index()
	{
		$this->starter();
		$this->render_template('stock/index',$this->data);
	}


	public function store()
	{
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		// $column 		= $_REQUEST['order'][0]['column'];
		// $order 			= $_REQUEST['order'][0]['dir'];
		$column 		= '';
		$order 			= '';

        $output['data']	= array();
		$search_name    = $this->input->post('search_name');

		$data           = $this->Model_stock->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_stock->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_stock->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$output['data'][$key] = array(
                    $value['kode_barang'],
					$value['opname'],
					$value['opname'],
					$value['opname'],
				);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}



} ?>
