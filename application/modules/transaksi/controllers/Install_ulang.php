<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install_ulang extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul']    = 'transaksi';
		$this->ctrl 	        = $this->router->fetch_class(); // Controller
		$this->func 	        = $this->router->fetch_method(); // Function
		$this->data['pagetitle']= capital($this->ctrl);
		$this->data['function'] = capital($this->func);

		$this->load->model('Model_install_ulang');

	}

	public function starter()
	{
		$this->data['new_nomor_transaksi'] = $this->Model_install_ulang->getNomorTransaksi();
	}

	public function index()
	{
		$this->starter();
		$this->render_template($this->ctrl.'/index',$this->data);
	}

	public function tambah()
	{
		$this->form_validation
            ->set_rules('kode_program[]', 'Kode Program','required',
				array('required' 	=> 'Kode Program Tidak Boleh Kosong !!',
            ));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_install_ulang->saveTambah();

			if($create_form['status'] === 'FALSE') {
				$this->session->set_flashdata('error', $create_form['message'].' </br> Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/'.$this->ctrl.'/tambah', 'refresh');
			} else {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template($this->ctrl.'/tambah',$this->data);
		}

	}

	public function show($id)
	{
		$this->form_validation
            ->set_rules('no_urut[]', 'Kode Program','required',
				array('required' 	=> 'Kode Program Tidak Boleh Kosong !!',
            ));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_install_ulang->saveUpdate($id);

			if($create_form['status'] === 'FALSE') {
				$this->session->set_flashdata('error', $create_form['message'].' </br> Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/'.$this->ctrl.'/detail/'.$id , 'refresh');
			} else {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}else{

			$this->starter();
			$this->data['header'] = $this->Model_install_ulang->getData($id, 'header');
			$this->data['detail'] = $this->Model_install_ulang->getData($id, 'detail');

			if($this->data['header']['nomor_transaksi']){
				$this->render_template($this->ctrl.'/detail',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}

	}

	public function check($id)
	{
		// Set custom message untuk callback validation
		$this->form_validation
		->set_rules('pic_check_checked[]', 'Check','callback_check_array_not_empty')
		->set_message('check_array_not_empty', 'Status <b>CHECK</b> Belum ada yang dipilih salah satunya !!');
        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_install_ulang->saveCheck($id);

			if($create_form['status'] === 'FALSE') {
				$this->session->set_flashdata('error', $create_form['message'].' </br> Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/'.$this->ctrl.'/check/'.$id , 'refresh');
			} else {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}else{

			$this->starter();
			$this->data['header'] = $this->Model_install_ulang->getData($id, 'header');
			$this->data['detail'] = $this->Model_install_ulang->getData($id, 'detail');

			if($this->data['header']['nomor_transaksi']){
				$this->render_template($this->ctrl.'/check',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}

	}


	public function approve($id)
	{
		$this->form_validation
            ->set_rules('no_urut[]', 'Kode Program','required',
				array('required' 	=> 'Kode Program Tidak Boleh Kosong !!',
            ));

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_install_ulang->saveApprove($id);

			if($create_form['status'] === 'FALSE') {
				$this->session->set_flashdata('error', $create_form['message'].' </br> Silahkan Cek kembali data yang di input !!');
				redirect('transaksi/'.$this->ctrl.'/approve/'.$id , 'refresh');
			} else {
				$this->session->set_flashdata('success', 'Berhasil Disimpan !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}else{

			
			$this->starter();
			$this->data['header'] = $this->Model_install_ulang->getData($id, 'header');
			$this->data['detail'] = $this->Model_install_ulang->getData($id, 'detail');

			if($this->data['header']['nomor_transaksi']){
				$this->render_template($this->ctrl.'/approve',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data !!');
				redirect('transaksi/'.$this->ctrl, 'refresh');
			}

		}

	}

	public function print_action()
	{
		$dataPost 			= 	$_POST;
        $nomor_transaksi   	=  	$dataPost['nomor_transaksi_print'];
        $pilih    			=	$dataPost['pilih_print'];

        $i=0;
        if($pilih){
            foreach ($pilih as $key => $value) {
                if($value){

					$data =  $this->Model_install_ulang->getData($nomor_transaksi[$key],'detail');

                    if ($data) {

						$pic_install 					= $this->Model_global->getStore($data[0]['pic_install']);
						$header['pic_install']    		= ($data[0]['pic_install'])?$pic_install['nip'].' - '.$pic_install['nama']:'';

						$pic_check 						= $this->Model_global->getStore($data[0]['pic_check']);
						$header['pic_check']    		= ($data[0]['pic_check'])?$pic_check['nip'].' - '.$pic_check['nama']:'';

						$pic_approve 					= $this->Model_global->getStore($data[0]['pic_approve']);
						$header['pic_approve']    		= ($data[0]['pic_approve'])?$pic_approve['nip'].' - '.$pic_approve['nama']:'';

						$pc_tujuan 						= $this->Model_global->getStore($data[0]['pc_tujuan']);
						$header['pc_tujuan']    		= ($data[0]['pc_tujuan'])?$pc_tujuan['kd_store'].' - '.$pc_tujuan['nama']:'';

                        $header['nomor_transaksi']    	= $data[0]['nomor_transaksi'];
                        $header['keterangan_header']    = $data[0]['keterangan_header'];
                        $header['tanggal_dokumen']		= tanggal($data[0]['tanggal_dokumen']);

						$header['tanggal_mulai'] 		= tanggal($data[0]['tanggal_mulai']);
						$header['tanggal_check'] 		= ($data[0]['tanggal_check'])?tanggal($data[0]['tanggal_check']):'';
						$header['tanggal_selesai']		= ($data[0]['tanggal_selesai'])?tanggal($data[0]['tanggal_selesai']):' Menunggu ';

						$header['pc_ip']				= $data[0]['pc_ip'];

						$getPCOS    = $this->Model_global->getDataInstallUlang($data[0]['pc_os'],'');
                        $header['pc_os']      = $getPCOS['nama_program'];

                        foreach ($data as $key => $value) {
							
                            $detail[$key]= array(
                                'no_urut'        		=> $value['no_urut'],
                                'program'    			=> $value['nama_program'],
								'barang'    			=> $value['kode_barang'].' - '.$value['nama_barang'],
								'keterangan_detail'     => $value['keterangan_detail'],
								'pic_check_checked'   	=> ($value['pic_check_checked'])?'OK':'Belum',
								'pic_install_checked'   => ($value['pic_install_checked'])?'OK':'Belum',
                            );
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
            $send_data['page_title']     = 'Print ';

			$this->load->view($this->ctrl.'/print',$send_data);
			
        }else{
            $this->session->set_flashdata('warning', 'Jika Muncul Popup Untuk Membuka Tab Baru dari browses pilih, "Allow/Izinkan"<br> Silakan Cetak Ulang');
            redirect('transaksi/'.$this->ctrl, 'refresh');
        }
	}

	public function store()
	{
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= ''; // $_REQUEST['order'][0]['column'];
		$order 			= ''; // $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   	= $this->input->post('search_name');
		$jenis   		= $this->input->post('jenis');
		$asal   		= $this->input->post('asal');
		$tujuan   		= $this->input->post('tujuan');

		$data           = $this->Model_install_ulang->getDataStore('result',$search_name,$tujuan,$length,$start,$column,$order);
		$data_jum       = $this->Model_install_ulang->getDataStore('numrows',$search_name,$tujuan);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_install_ulang->getDataStore('numrows',$search_name,$tujuan);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no=1;
			foreach ($data as $key => $value) {
				$id			= $value['nomor_transaksi'];
				$user_nip = $this->session->userdata('username');

				$btn 	= '';
				if(!empty($value['tanggal_check']) && empty($value['tanggal_selesai']) && $user_nip == $value['pic_approve']){
				$btn 	.= '
						<a href="'.base_url('transaksi/'.$this->ctrl.'/approve/'.$id).'" class="btn btn-sm btn-warning mb-1">
							APP
					
							</a>';
				}
				if(empty($value['tanggal_check']) && $user_nip == $value['pic_check']){
				$btn 	.= '
						<a href="'.base_url('transaksi/'.$this->ctrl.'/check/'.$id).'" class="btn btn-sm btn-warning mb-1">
							CHECK
						</a>';
				}

				$btn 	.= '
						<a href="'.base_url('transaksi/'.$this->ctrl.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
							<i class="fa fa-eye"></i>
						</a>
						<button type="button" onclick=\'_prints("'.$id.'")\'  class="btn btn-sm btn-icon btn-icon-only btn-info mb-1">
							<i class="fa fa-print"></i>
						</button>';

				$pic_install 	= '';
				$pic_check 		= '';
				$tujuan 		= '';
				if($value['pc_tujuan']){
					$tujuan   = $this->Model_global->getStore($value['pc_tujuan']);}
				
				if($value['pic_install']){
					$pic_install   = $this->Model_global->getStore($value['pic_install']);}

				$status = ($value['tanggal_selesai'])?'Selesai':'Proses';

				$output['data'][$key] = array(
					$value['nomor_transaksi'],
					($pic_install)?$pic_install['nip'].'-'.$pic_install['nama']:'-',
       ($tujuan)?$tujuan['nip'].'-'.$tujuan['nama']:'-',
					
					tanggal($value['tanggal_mulai']),
					tanggal($value['tanggal_check']),
					tanggal($value['tanggal_selesai']),
					$status,
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function getBarangData()
	{
		$output['data']		= array();
		$draw           	= $_REQUEST['draw'];
		$length         	= $_REQUEST['length'];
		$start          	= $_REQUEST['start'];
		$search_kode    	= $this->input->post('search_kode_barang');
		$search_nama    	= $this->input->post('search_nama_barang');

		$data           	= $this->Model_install_ulang->getBarangData('result',$search_kode,$search_nama,$length,$start);
		$data_jum       	= $this->Model_install_ulang->getBarangData('numrows',$search_kode,$search_nama);

		$output['draw'] 	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($data){
			foreach ($data as $key => $value)  {
				$output['data'][$key] = array(
					$value['kode_barang'],
					$value['nama_barang'],
					'<button type="button" class="btn btn-sm btn-success btn-pilih-barang" data-kode="'.$value['kode_barang'].'" data-nama="'.$value['nama_barang'].'"><i class="fa fa-check"></i> Pilih</button>',
				);
				$key++;
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function getProgramData()
	{
		$output['data']		= array();
		$draw           	= $_REQUEST['draw'];
		$length         	= $_REQUEST['length'];
		$start          	= $_REQUEST['start'];
		$search_kode    	= $this->input->post('search_kode_program');
		$search_nama    	= $this->input->post('search_nama_program');

		$data           	= $this->Model_install_ulang->getProgramData('result',$search_kode,$search_nama,$length,$start);
		$data_jum       	= $this->Model_install_ulang->getProgramData('numrows',$search_kode,$search_nama);

		$output['draw'] 	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($data){
			foreach ($data as $key => $value)  {
				$output['data'][$key] = array(
					$value['kode_program'],
					$value['nama_program'],
					'<button type="button" class="btn btn-sm btn-success btn-pilih-program" data-kode="'.$value['kode_program'].'" data-nama="'.$value['nama_program'].'"><i class="fa fa-check"></i> Pilih</button>',
				);
				$key++;
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	/* Custom Callback untuk validasi array checkbox */
	public function check_array_not_empty($value)
	{
		// tesx(($value));
		// $value adalah array dari pic_check_checked[]
		if (empty($value) ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	/* End Custom Callback */

}

?>
