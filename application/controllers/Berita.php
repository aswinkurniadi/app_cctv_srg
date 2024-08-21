<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		$data['title'] = 'Berita';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->admin->getAllByTable('berita', 'id_berita', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('berita/index', $data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
		$data = [
	        "desk" => $this->input->post('desk', true),
	        "stts" => $this->input->post('stts', true),
		];

		$this->admin->addDatabyTable('berita', $data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berita berhasil ditambahkan! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('berita');
	}

	public function update()
	{
		$id_berita = $this->input->post('id_berita', true);

		$data = [
	        "desk" => $this->input->post('desk', true),
	        "stts" => $this->input->post('stts', true),
		];

		$this->admin->updateDatabyTable('berita', 'id_berita', $id_berita, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Berita berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('berita');
	}

	public function delete($id)
	{
		$this->admin->deleteDataById('berita', 'id_berita', $id);
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Berita berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('berita');
	}


}