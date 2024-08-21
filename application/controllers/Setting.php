<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller 
{ 
	public function __construct()
	{
	 	parent::__construct();
		is_logged_in();
	}

	public function index()
    {
    	$data['title'] = 'Pengaturan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();
		$this->load->model('Admin_model','admin');

		$data['dtByid'] = $this->admin->GetDataById('setting', 'id_setting', 1);

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('setting/index', $data);
		$this->load->view('templates/footer');
    }

    // simpan domain
    public function save_domain()
    {
    	$this->load->model('Admin_model','admin');

    	$data = [
			'domain' => $this->input->post('domain'),
		];

    	$this->db->where('id_setting', 1);
		$this->db->update('setting', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perubahan domain berhasil disimpan!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
		redirect('setting/');

    }

    public function save_url_xampp()
    {
    	$this->load->model('Admin_model','admin');

    	$data = [
			'url_xampp' => $this->input->post('url_xampp'),
		];

    	$this->db->where('id_setting', 1);
		$this->db->update('setting', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perubahan domain berhasil disimpan!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
		redirect('setting/');    	
    }
}