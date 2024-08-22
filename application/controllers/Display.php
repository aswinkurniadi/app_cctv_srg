<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Display extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model','admin');
		$this->load->model('Cctv_model','cctv');
	}

	public function index()
	{
		$data['title'] = 'Display CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		// tanggal hari ini
		date_default_timezone_set('Asia/Jakarta');
		$data['now'] = date("d M Y");

		// daftar cctv		
		$data['dt_allCCTV'] = $this->cctv->getAllData();
		$data['dt_setting'] = $this->admin->GetDataById('setting', 'id_setting', 1);


		$result = array();
		foreach($data['dt_allCCTV'] as $row){
			$url = $data['dt_setting']['domain'].$row['url_directory'];
			$result[] = array($row['latitude'], $row['longitude'], $row['nm_cctv'], $url);
		}


		$data['dt_AllCCTVInit'] = json_encode($result);

		$this->load->view('display/index', $data);
	}
}