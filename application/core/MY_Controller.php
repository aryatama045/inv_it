<?php

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller
{
	var $permission = array();

	public function __construct()
	{
		parent::__construct();
		$group_data = array();
		$this->load->model('Model_menu');
		$this->load->model('Model_global');
		$this->load->model('transaksi/Model_tanda_terima');

	}

	public function logged_in()
	{
		$session_data = $this->session->userdata();
		if(!empty($session_data['loginStatus'])){
			if($session_data['loginStatus'] == TRUE) {
				redirect('dashboard', 'refresh');
			}
		}
	}

	public function not_logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['loginStatus'] == FALSE) {
			redirect('login', 'refresh');
		}
	}


	public function render_template($page = null, $data = array())
	{

		$this->auth->route_access();

		$menu	= $this->Model_menu->generateTree();
		$this->data['menu'] = $menu;

		// $ta		= $this->Model_global->getTahunAjaranAktif();
		// $this->data['tahun_ajaran']	= $ta['ta'];
		// $this->data['semester']		= $ta['smt'];

		$this->load->view('templates/header',$this->data);
		$this->load->view($page, $this->data);
		$this->load->view('templates/footer',$this->data);
	}


	public function render_template_pmb($page = null, $data = array())
	{

		$username 			= $this->session->userdata('username');

		$menu				= $this->Model_menu->generateTree();
		$this->data['menu'] = $menu;

		// $ta					= $this->Model_global->getTahunAjaranAktif();
		// $this->data['kd_ta']		= $ta['kd_ta'];
		// $this->data['tahun_ajaran']	= $ta['ta'];
		// $this->data['semester']		= $ta['smt'];

		$getdatauser 	= $this->Model_pmb->getDataUsername($username);
		$getdataPmb		= $this->Model_pmb->getDataPendaftaran($getdatauser['no_pmb'] ?? '');
		$this->data['no_pendaftaran']	 	= $getdatauser['no_pmb'] ?? '';
		$this->data['pmb']	 				= $getdataPmb;

		$this->load->view('templates/header_pmb',$this->data);
		$this->load->view($page, $this->data);
		$this->load->view('templates/footer_pmb',$this->data);
	}



	public function template_email($page = null, $data = array())
	{
		$this->load->view($page, $data);
	}



}
