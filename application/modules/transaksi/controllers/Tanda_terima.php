<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tanda_terima extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'transaksi';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_tanda_terima');

	}

	public function starter()
	{
		$this->data['new_nomor_transaksi'] = $this->Model_tanda_terima->getNomorTransaksi();
	}

	public function index()
	{
		$this->starter();
		$this->render_template('tanda_terima/index',$this->data);
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
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_tanda_terima->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_tanda_terima->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_tanda_terima->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no=1;
			foreach ($data as $key => $value) {
				$id		= $value['nomor_transaksi'];

				$btn 	= '';
				$btn 	.= '
						<a href="'.base_url('transaksi/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
							<i class="fa fa-eye"></i>
						</a>
						<button type="button" onclick=\'_prints("'.$value['nomor_transaksi'].'")\'  class="btn btn-sm btn-icon btn-icon-only btn-info mb-1">
							<i class="fa fa-print"></i>
						</button>';

						// $btn 	.= '<a href="'.base_url('transaksi/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
						// 			<i class="fa fa-edit"></i> </a>
						// 		</a>';

						// $btn .= ' <a class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
						// $btn .= "remove('".$id."')";
						// $btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
						// 		<i class="fa fa-trash"></i></a>

						// </div>';


				$output['data'][$key] = array(
					$value['kode_dokumen'],
					$value['nomor_transaksi'],
					tanggal($value['tanggal']),
					$value['pengirim'],
					($value['tujuan'])?$value['tujuan']:$value['penerima'],
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
		$this->data['header'] = $this->Model_tanda_terima->getData($id, 'header');
		$this->data['detail'] = $this->Model_tanda_terima->getData($id);

		if($this->data['header']['nomor_transaksi']){
			$this->render_template('tanda_terima/detail',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
			redirect('transaksi/tanda_terima', 'refresh');
		}

	}

	public function tambah()
	{
		$this->form_validation->set_rules('kd_brg[]', 'Kode Barang','required',
				array(	'required' 	=> 'Kode Barang Tidak Boleh Kosong !!',
		));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_tanda_terima->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/tanda_terima', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/tanda_terima/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('tanda_terima/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('nama' ,'Nama' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_tanda_terima->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Nama : "'.$_POST['nama'].'" <br> Berhasil Di Update !!');
				redirect('master/barang', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/tanda_terima/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['barang'] = $this->Model_tanda_terima->getBarang($id);

			if($this->data['barang']['kode_barang']){
				$this->render_template('tanda_terima/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/tanda_terima/edit/'.$id, 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_tanda_terima->saveDelete($id);

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



	public function print_action()
	{
		$dataPost 			= $_POST;
        $nomor_transaksi   	=  	$dataPost['nomor_transaksi_print'];
        $pilih    			=	$dataPost['pilih_print'];

        $i=0;
        if($pilih){
            foreach ($pilih as $key => $value) {
                if($value){
					$data =  $this->Model_tanda_terima->getData($nomor_transaksi[$key],'detail');

                    if ($data) {

						$pengirim 	= $this->Model_global->getPersonil($data[0]['pengirim']);
						$header['pengirim']    			= $pengirim['nip'].'-'.$pengirim['nama'];

						$penerima 	= $this->Model_global->getPersonil($data[0]['penerima']);
						$header['penerima']    			= ($data[0]['penerima'])?$penerima['nip'].'-'.$penerima['nama']:'';

						$header['tujuan'] 				= $data[0]['tujuan'];

                        $header['nomor_transaksi']    	= $data[0]['nomor_transaksi'];
                        $header['kode_dokumen']    		= $data[0]['kode_dokumen'];
                        $header['user_input'] 			= $data[0]['user_input'];
                        $header['keterangan']    		= $data[0]['keterangan'];
                        $header['tanggal']				= date('d-m-Y', strtotime($data[0]['tanggal']));
						$header['tanggal_pengiriman']	= date('d-m-Y', strtotime($data[0]['tanggal_pengiriman']));
                        $header['total'] 				= 0;

                        foreach ($data as $key => $value) {
                            $detail[$key]= array(
                                'no_urut'        		=> $value['no_urut'],
                                'kode_barang'    		=> $value['kode_barang'],
                                'nama_barang'    		=> $value['nama_barang'],
                                'status_barang'        	=> $value['status_barang'].'-'.$value['nama_status'],
								'qty'        			=> $value['qty'],
								'keterangan_barang'     => $value['keterangan_barang'],
                            );
                            $header['total']+=$value['qty'];
                        }

                        $output[$i] = array(
                            'header'    => $header,
                            'detail'     => $detail,
                        );

                    }else{
                        $output[$i] = array(
                            'header'    => array(),
                            'detail'     => array(),
                        );
                    }
                    $i++;
                }
            }
        }

        if(isset($output)){
            $send_data['data']         	 = $output;
            $send_data['printer']        = 'laser jet';
            $send_data['page_title']     = 'Print BKB';
            $this->load->view('tanda_terima/print', $send_data);
        }else{
            $this->session->set_flashdata('warning', 'Jika Muncul Popup Untuk Membuka Tab Baru dari browses pilih, "Allow/Izinkan"<br> Silakan Cetak Ulang');
            redirect('transaksi/tanda_terima', 'refresh');
        }
	}


	// Import Excel
	public function import_excel(){
		$this->load->library(array('excel'));
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$kode_dokumen 		= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$nomor_transaksi 	= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$nomor_transaksi_um = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$tanggal 			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$tujuan 			= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$pengirim 			= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$tanggal_pengiriman	= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$penerima 			= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$tanggal_input 		= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$user_input 		= $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$jumlah_detail		= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$manual 			= $worksheet->getCellByColumnAndRow(11, $row)->getValue();
					$tanggal_batal		= $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$keterangan_batal	= $worksheet->getCellByColumnAndRow(13, $row)->getValue();
					$tgl_terima_it		= $worksheet->getCellByColumnAndRow(14, $row)->getValue();

					if(strtotime($tanggal_batal) > 0){
						$tgl_batal = date('Y-m-d H:i:s', strtotime($tanggal_batal));
					}else{
						$tgl_batal = '0000-00-00 00:00:00';
					}

					if(strtotime($tgl_terima_it) > 0){
						$tgl_terimaIT = date('Y-m-d', strtotime($tgl_terima_it));
					}else{
						$tgl_terimaIT = '0000-00-00';
					}

					if(strtotime($tanggal_input) > 0){
						$tgl_input = date('Y-m-d', strtotime($tanggal_input));
					}else{
						$tgl_input = '0000-00-00';
					}

					if(strtotime($tanggal_pengiriman) > 0){
						$tgl_pengiriman = date('Y-m-d', strtotime($tanggal_pengiriman));
					}else{
						$tgl_pengiriman = '0000-00-00';
					}

					if(strtotime($tanggal) > 0){
						$tgl = date('Y-m-d', strtotime($tanggal));
					}else{
						$tgl = '0000-00-00';
					}

					$temp_data[] = array(
						'kode_dokumen'			=> $kode_dokumen,
						'nomor_transaksi'		=> $nomor_transaksi,
						'nomor_transaksi_num'	=> trim($nomor_transaksi_um),
						'tanggal'				=> $tgl,
						'tujuan'				=> $tujuan,
						'pengirim'				=> $pengirim,
						'tanggal_pengiriman'	=> $tgl_pengiriman,
						'penerima'				=> $penerima,
						'tanggal_input'			=> $tgl_input,
						'user_input'			=> $user_input,
						'jumlah_detail'			=> $jumlah_detail,
						'manual'				=> $manual,
						'tanggal_batal'			=> $tgl_batal,
						'keterangan_batal'		=> $keterangan_batal,
						'tgl_terima_it'			=> $tgl_terimaIT,
					);
				}
			}

			$insert = $this->db->insert_batch('tanda_terima_h', $temp_data);
			if($insert){
				$this->session->set_flashdata('success', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			echo "Tidak ada file yang masuk";
		}
	}


}

?>
