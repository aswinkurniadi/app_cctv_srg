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

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('cctv/display', $data);
		$this->load->view('templates/footer');
	}
}