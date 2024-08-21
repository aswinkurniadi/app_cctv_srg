<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
	 	parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model', 'admin');
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		// GetData
		$data['jumlahuser'] = $this->admin->count('user');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}