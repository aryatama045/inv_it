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
		$this->load->model('Model_global');

	}

	public function starter()
	{}

	public function index()
	{
		$this->starter();
		$this->render_template('barang/index',$this->data);
	}

	public function show($id)
	{

		$this->starter();
		$this->data['barang'] = $this->Model_global->getBarang($id,'header');

		if($this->data['barang']['kode_barang']){
			$this->render_template('barang/show',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
			redirect('master/barang', 'refresh');
		}

	}

	public function tambah()
	{

		$this->form_validation->set_rules('nama_barang', 'Nama Barang','required',
				array(	'required' 	=> 'Nama Barang Tidak Boleh Kosong !!',
		));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_barang->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', 'Barang Berhasil Disimpan !!');
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



	// --- Get Data Ajax
	public function getKodeBarang()
	{

		$id = $_POST['id'];

		if($id == '0'){
			$getKodeBarang = '';
		}else{
			$getKodeBarang = $this->Model_barang->getKodeBarang($id);
		}

		$output['kode'] = $getKodeBarang;

		//"<input type='text' readonly value='". $getKodeBarang ."' name='kode_barang' class='form-control'>";

		echo json_encode($output);
	}

	public function store()
	{
		$cn 			= $this->router->fetch_class(); // Controller
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_kode_barang = '';
		$search_name   	= $this->input->post('search_name');
		$kategori   	= $this->input->post('kategori');
		$merk   		= $this->input->post('merk');
		$type   		= $this->input->post('type');
		$stock			= $this->input->post('stock');

		$data           = $this->Model_barang->getDataStore('result',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock,$length,$start,$column,$order);
		$data_jum       = $this->Model_barang->getDataStore('numrows',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_barang->getDataStore('numrows',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value)  {

				$id		= $value['kode_barang'];

				$btn 	= '';
				$btn 	.= '<a href="'.base_url('master/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon  btn-success mb-1">
								<i class="fa fa-eye"></i> </a>
							</a>
							<a hidden href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon  btn-warning mb-1">
								<i class="fa fa-edit"></i> </a>
							</a>';
				$btn 	.= '<a hidden class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
				$btn 	.= "remove('".$id."')";
				$btn 	.= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
						<i class="fa fa-trash"></i></a>';

				$StatusBarang = $this->Model_global->getStatusBarang($value['status_barang']);

				$output['data'][$key] = array(
					$key+$start+1,
					$value['kode_barang'],
					$value['nama_barang'],
					$StatusBarang['full_name'],
					$btn,
				);

				$key++;

			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function getBarangAjax()
	{
		$output['data']		= array();
		$draw           	= $_REQUEST['draw'];
		$length         	= $_REQUEST['length'];
		$start          	= $_REQUEST['start'];
		$column 			= '';
		$order 				= '';

		$search_kd_barang 	= $_REQUEST['columns'][0]['search']["value"];
		$search_name 		= $_REQUEST['columns'][1]['search']["value"];
		$stok				= $_REQUEST['columns'][2]['search']["value"];
		$jenis 				= $this->input->post('kode_dokumen');


		$kategori   		= $this->input->post('kategori');
		$merk   			= $this->input->post('merk');
		$type   			= $this->input->post('type');


		$data           	= $this->Model_barang->getBarangTransaksi('result',$search_kd_barang,$search_name,$kategori,$merk,$type,$stok,$jenis,$length,$start,$column,$order);
		$data_jum       	= $this->Model_barang->getBarangTransaksi('numrows',$search_kd_barang,$search_name,$kategori,$merk,$type,$stok,$jenis);

		$output			= array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" || $search_kd_barang != "" || $stok != "" || $jenis != "" ){
			$data_jum = $this->Model_barang->getBarangTransaksi('numrows',$search_kd_barang,$search_name,$kategori,$merk,$type,$stok,$jenis);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value)  {

				if($value['barang_stock'] == 'True'){
					$getstock = $this->Model_global->getStockBarang($value['kode_barang']);
					if($getstock != NULL){

						$stock = $getstock['saldo_awal'] + $getstock['in'] - $getstock['out'];
					}else{
						$stock = '0';
					}
				}else{
					$stock = '1';
				}

				$output['data'][$key] = array(
					$value['kode_barang'],
					$value['nama_barang'],
					$value['barang_stock'],
					$stock,
					$value['lokasi_terakhir'],
					$value['status_barang']
				);

				$key++;

			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	function sortByGrade($a, $b) {
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}


	// Import Excel
	public function import_excel(){
		$this->load->library(array('excel'));
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			$dataArray = $object->getWorksheetIterator();

			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$kode_kategori 		= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$kode_type 			= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$kode_merk 			= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$kode_barang		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$nama_barang		= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$tanggal_pembelian	= date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(5, $row)->getValue()));
					$harga_beli			= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$serial_number		= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$keterangan_acct	= $worksheet->getCellByColumnAndRow(8, $row)->getValue();


					if(strtotime($tanggal_pembelian) > 0){
						$tgl_pembelian = date('d-m-Y', strtotime($tanggal_pembelian));
					}else{
						$tgl_pembelian = '00-00-0000';
					}

					$cek_type = $this->db->like('nama',$kode_type)->get('mst_type')->row_array();
					if($cek_type == NULL){
						$get_type = $this->Model_global->getType();

						usort($get_type, array($this,'sortByGrade'));

						$myLast = $get_type[array_key_last($get_type)];

						$count_type = count($get_type);

						$data_kode_type = $myLast['kode_type']+1;

						$data_type = [
							'kode_type'	=> $data_kode_type,
							'nama' => $kode_type
						];
						$this->db->insert('mst_type', $data_type);
					}else{
						$data_kode_type = $cek_type['kode_type'];
					}

					$temp_data[] = array(
						'kode_kategori'			=> $kode_kategori,
						'kode_type'				=> $data_kode_type,
						'kode_merk'				=> $kode_merk,
						'kode_barang'			=> $kode_barang,
						'nama_barang'			=> $nama_barang,
						'tanggal_pembelian'		=> $tgl_pembelian,
						'harga_beli'			=> $harga_beli,
						'keterangan'			=> '',
						'keterangan_acct'		=> $keterangan_acct,
						'status_barang'			=> 'N',
						'barang_stock'			=> 'False',
						'serial_number'			=> $serial_number,
						'harga_asuransi'		=> '0',
						'tanggal_input'			=> date('Y-m-d'),
						'user_input'			=> $this->session->userdata('username'),
					);
				}
			}

			$insert = $this->db->insert_batch('mst_barang', $temp_data);
			if($insert) {
				$this->session->set_flashdata('success', 'Barang Berhasil Disimpan !!');
				redirect('master/barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/barang', 'refresh');
			}

		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
			redirect('master/barang', 'refresh');
		}
	}

}

?>
