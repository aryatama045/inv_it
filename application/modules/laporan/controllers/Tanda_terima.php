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
		$this->load->model('Model_global');

	}

	public function starter()
	{}

	public function index()
	{
		$this->starter();
		$this->render_template('barang/index',$this->data);
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
		$kategori   	= $this->input->post('kategori');
		$merk   		= $this->input->post('merk');
		$type   		= $this->input->post('type');
		$stock			= $this->input->post('stock');
		$status			= $this->input->post('status');
		$lokasi			= $this->input->post('lokasi');

		$data           = $this->Model_barang_laporan->getDataStore('result',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock,$status,$lokasi,$length,$start,$column,$order);
		$data_jum       = $this->Model_barang_laporan->getDataStore('numrows',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock,$status,$lokasi);

		$data_report    = $this->Model_barang_laporan->getDataStore('report',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock,$status,$lokasi);
		$this->session->set_flashdata('detail', $data_report);

		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_barang_laporan->getDataStore('numrows',$search_kode_barang,$search_name,$kategori,$merk,$type,$stock,$status,$lokasi);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value)  {

				$id		= $value['kode_barang'];

				$btn 	= '';
				$btn 	.= '<a href="'.base_url('master/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon  btn-success mb-1">
								<i class="fa fa-eye"></i> </a>
							</a>
							<a  href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon  btn-warning mb-1">
								<i class="fa fa-edit"></i> </a>
							</a>';
				$btn 	.= '<a hidden class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
				$btn 	.= "remove('".$id."')";
				$btn 	.= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
						<i class="fa fa-trash"></i></a>';

				$StatusBarang = $this->Model_global->getStatusBarang($value['status_barang']);

				if($value['lokasi_terakhir']){
					$getPerson = $this->Model_global->getPersonil($value['lokasi_terakhir']);

					if($getPerson){
						$LokasiAkhir = $getPerson['nip'].'-'.$getPerson['nama'];
					}else{
						$LokasiAkhir = '-';
					}

				}else{
					$LokasiAkhir = '-';
				}


                if($value['barang_stock'] == 'True'){
                    $getstock = $this->Model_global->getStockBarang($value['kode_barang']);
                    if($getstock != NULL){
                        $stock = $getstock['saldo_awal'] + $getstock['in'] - $getstock['out'];
                    }else{
                        $stock = '0';
                    }

					$getstockR = $this->Model_global->getStockRusak($value['kode_barang']);
					if($getstockR != NULL){
                        $stockR = $getstockR['saldo_awal'] + $getstockR['in'] - $getstockR['out'];
                    }else{
                        $stockR = '0';
                    }

                    $Qty 		= $stock;
					$QtyR 		= $stockR;
					$Stock    	= '<span class="btn btn-sm btn-icon btn-success">Stock</span>';
                }else{

					$getHistory = $this->Model_global->getMutasiBarang($value['kode_barang']);

					// tesx($getHistory);

					if($getHistory){
						$QtyR 	= '1';
					}else{
						$QtyR 	= '0';
					}

                    $Qty 		= '1';
					$Stock    	= '<span class="btn btn-sm btn-icon btn-info">Tidak</span>';
                }


				$Kategori = $this->Model_global->getKategori($value['kode_kategori']);
				if($Kategori == NULL){
					$Kategori['nama'] = '-';
				}else{
					$Kategori['nama'] = $Kategori['nama'];
				}

				$Merk     = $this->Model_global->getMerk($value['kode_merk']);
				if($Merk == NULL){
					$Merk['nama'] = '-';
				}else{
					$Merk['nama'] = $Merk['nama'];
				}

				$Type     = $this->Model_global->getType($value['kode_type']);
				if($Type == NULL){
					$Type['nama'] = '-';
				}else{
					$Type['nama'] = $Type['nama'];
				}

				$Keterangan 	= ($value['keterangan'] == NULL)? '-' : $value['keterangan'];
				$KeteranganAcct = ($value['keterangan_acct'] == NULL)? '-' : $value['keterangan_acct'];
				$SerialNumber 	= ($value['serial_number'] == NULL)? '-' : $value['serial_number'];

				$TglBeli		= ($value['tanggal_pembelian'] == NULL || $value['tanggal_pembelian'] == '00-00-0000')? '00-00-0000' : date('d-m-Y', strtotime($value['tanggal_pembelian']));
				$TglAkhir		= ($value['tanggal_lokasi_akhir'] == NULL || $value['tanggal_lokasi_akhir'] == '00-00-0000' || $value['tanggal_lokasi_akhir'] == ' 00-00-0000')? '00-00-0000' : date('d-m-Y', strtotime($value['tanggal_lokasi_akhir']));

				$output['data'][$key] = array(
					// $key+$start+1,
					$value['kode_barang'], //.'<br><small>S/N:'.$value['serial_number'].'</small>'
					uppercase(lowercase($value['nama_barang'])),
					$value['kode_kategori'].'<br><small> '.$Kategori['nama'].'</small>',
					$value['kode_merk'].'<br><small> '.$Merk['nama'].'</small>',
					$value['kode_type'].'<br><small> '.$Type['nama'].'</small>',
					$TglBeli,
					nominal($value['harga_beli']),
					$Keterangan,
					$KeteranganAcct,
					$StatusBarang['full_name'],
                    $TglAkhir,
					$LokasiAkhir,
					$SerialNumber,
					$Qty,
					$QtyR,
					$Stock,
					$value['opname'],
				);

				$key++;

			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

    public function export($type = NULL)
    {
		$data_post = $_POST;
        // $data = $this->session->flashdata('detail');

        tesx($type,$data_post );
    }

}

?>
