<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tanda_terima extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		// $this->auth->route_access();
		$this->data['modul'] = 'Laporan';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('master/Model_barang');
		$this->load->model('Model_barang_laporan');
		$this->load->model('Model_tanda_terima_laporan');
		$this->load->model('Model_global');

	}

	public function starter()
	{}

	public function index()
	{
		$this->starter();
		$this->render_template('tanda_terima/index',$this->data);
	}


	public function store()
	{
		$cn 			= $this->router->fetch_class(); // Controller
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= '';
		$order 			= '';

        $output['data']	= array();
		$search_kode_barang = '';
		$search_name   	= $this->input->post('search_name');
		$jenis   		= $this->input->post('jenis');
		$merk   		= $this->input->post('merk');
		$type   		= $this->input->post('type');
		$stock			= $this->input->post('stock');
		$status			= $this->input->post('status');
		$lokasi			= $this->input->post('lokasi');

		$tgl_awal		= $this->input->post('tgl_awal');
		$tgl_akhir		= $this->input->post('tgl_akhir');

		$data           = $this->Model_tanda_terima_laporan->getDataTandaTerima('result',$search_kode_barang,$search_name,$jenis,$merk,$type,$stock,$status,$lokasi,$tgl_awal,$tgl_akhir,$length,$start,$column,$order);
		$data_jum       = $this->Model_tanda_terima_laporan->getDataTandaTerima('numrows',$search_kode_barang,$search_name,$jenis,$merk,$type,$stock,$status,$lokasi,$tgl_awal,$tgl_akhir);

		// $data_report    = $this->Model_tanda_terima_laporan->getDataTandaTerima('report',$search_kode_barang,$search_name,$jenis,$merk,$type,$stock,$status,$lokasi,$tgl_awal,$tgl_akhir);
		// $this->session->set_flashdata('detail', $data_report);

		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" ){
			$data_jum = $this->Model_tanda_terima_laporan->getDataTandaTerima('numrows',$search_kode_barang,$search_name,$jenis,$merk,$type,$stock,$status,$lokasi,$tgl_awal,$tgl_akhir);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value)  {

				if($value['pengirim']){
					$getPengirim    = $this->Model_global->getPersonil($value['pengirim']);
					if($getPengirim){
						$pengirim       = $getPengirim['nip'].'<br>'.$getPengirim['nama'];
					}else{
						$pengirim       = '-';
					}
				}else{
					$pengirim       = '-';
				}

				if($value['penerima']){

					$getPenerima    = $this->Model_global->getPersonil($value['penerima']);
					if($getPenerima){
						$penerima       = $getPenerima['nip'].' <br>'.$getPenerima['nama'];
					}else{
						$penerima       = '-';
					}
				}else{
					$penerima       = '-';
				}

				if($value['tujuan']){
					$getTujuan    	= $this->Model_global->getPersonil($value['tujuan']);
					if($getTujuan){
						$tujuan       	= $getTujuan['nip'].'<br>'.$getTujuan['nama'];
					}else{
						$tujuan       	= '-';
					}
				}else{
					$tujuan       	= '-';
				}

				$output['data'][$key] = array(
					'<b>'.$value['nomor_transaksi'].'</b>',
					$value['kode_dokumen'],
					date('d-m-Y',strtotime($value['tanggal'])),
					$pengirim,
					$penerima,
					$tujuan,
					$value['kode_barang'],
					$value['nama_barang'],
					$value['qty'],
					$value['nama_status'],
				);

			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

    public function export($type = NULL)
    {
		$data = $_POST;
		
		$search_name		= $data['search_name'];
		$jenis				= $data['jenis'];
		$type				= $data['type'];
		$tgl_awal			= $data['tgl_awal'];
		$tgl_akhir			= $data['tgl_akhir'];

		$detail = $this->Model_tanda_terima_laporan->getDataTandaTerima('report','',$search_name,$jenis,'',$type,'','','',$tgl_awal,$tgl_akhir,'','','','');

		$output['data']['detail'] = $detail;
		$export = $this->Model_tanda_terima_laporan->exportExcel($output['data']);

    }

}

?>
