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
		$this->data['kode_kategori'] = $this->Model_kategori->getKodeKategori();
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
				$btn 	.= '<a hidden href="'.base_url('master/'.$cn.'/show/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-success mb-1">
								<i class="fa fa-eye"></i> </a>
							</a>
							<a href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="btn btn-sm btn-icon btn-icon-only btn-warning mb-1">
								<i class="fa fa-edit"></i> </a>
							</a>';

				$btn 	.= ' <a hidden class="btn btn-sm btn-icon btn-icon-only btn-danger mb-1" onclick="';
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

		$this->form_validation->set_rules('nama' ,'Nama Kategori ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			
			$nama = $_POST['nama'];

			
			// Validasi nama tidak boleh kosong
            if (empty($nama)) {
				$this->session->set_flashdata('error', 'Nama kategori tidak boleh kosong');
				redirect('master/kategori/tambah', 'refresh');
            }
            // Cek apakah nama sudah ada
            if ($this->is_name_exists($nama)) {
				$this->session->set_flashdata('error', 'Nama kategori "' . $nama . '" sudah ada, silakan gunakan nama lain');
				redirect('master/kategori/tambah', 'refresh');
            }
			
			// Generate kode unik
			$code = $this->generate_unique_code($nama);

            $data_kat = [
                'kode_kategori' => $code,
                'nama'          => $nama,
				'jenis'         => $_POST['jenis'],
            ];

            tesx($data_kat);

			$create_form = $this->Model_kategori->saveTambah($data_kat);

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
			$this->data['param'] = $this->Model_global->getKategori($id);

			if($this->data['param']['kode_kategori']){
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


    /**
     * Cek apakah nama kategori sudah ada di database
     * 
     * @param string $name Nama kategori
     * @param int $exclude_id ID yang dikecualikan (untuk update)
     * @return boolean True jika sudah ada, False jika belum
     */
    private function is_name_exists($name) {
        return $this->Model_kategori->check_name_exists($name);
    }

    /**
     * Cek apakah kode kategori sudah ada di database
     * 
     * @param string $code Kode yang akan dicek
     * @return boolean True jika sudah ada, False jika belum
     */
    private function is_code_exists($code) {
        return $this->Model_kategori->check_code_exists($code);
    }

    /**
     * Generate kode kategori unik dari nama
     * 
     * @param string $name Nama kategori
     * @return string Kode kategori yang unik
     */
    public function generate_unique_code($name) {
        // Generate kode dasar dari nama
        $base_code = generate_category_code($name);
        
        // Ambil semua kode yang sudah ada di database
        $existing_codes = $this->get_all_existing_codes();
        
        // Generate kode unik
        $unique_code = generate_unique_category_code($base_code, $existing_codes);
        
        return $unique_code;
    }

    /**
     * Ambil semua kode kategori yang sudah ada di database
     * 
     * @return array Array berisi semua kode kategori
     */
    private function get_all_existing_codes() {
        $categories = $this->Model_kategori->get_all_codes();
        $codes = array();
        
        foreach ($categories as $category) {
            $codes[] = $category->kode_kategori; // Sesuaikan dengan nama field di tabel
        }
        
        return $codes;
    }


	/**
     * Validasi nama kategori via AJAX
     */
    public function check_name() {
        if ($this->input->is_ajax_request()) {
            $name = trim($this->input->post('name'));
            $id = $this->input->post('id'); // untuk update
            
            if (empty($name)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Nama kategori tidak boleh kosong'
                );
            } elseif ($this->is_name_exists($name, $id)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Nama kategori "' . $name . '" sudah ada'
                );
            } else {
                $response = array(
                    'status' => 'success',
                    'message' => 'Nama kategori tersedia'
                );
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function preview_code() {
        if ($this->input->is_ajax_request()) {
            $name = $this->input->post('name');
            
            if (!empty($name)) {
                $code = $this->generate_unique_code($name);
                
                $response = array(
                    'status' => 'success',
                    'code' => $code
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Nama kategori tidak boleh kosong'
                );
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    /**
     * Validasi kode kategori (untuk update data)
     * 
     * @param string $code Kode yang akan divalidasi
     * @param int $id ID kategori (untuk exclude saat update)
     * @return boolean
     */
    public function validate_code($code, $id = null) {
        return $this->Model_kategori->validate_code($code, $id);
    }


}

?>
