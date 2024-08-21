<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		$data['title'] = 'Menu Manajemen';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->admin->getAllByTable('menu', 'id_menu', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('menu/index', $data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
		$data = [
	        "nama" => $this->input->post('nama', true),
		];

		$this->admin->addDatabyTable('menu', $data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">menu berhasil ditambahkan! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu');
	}

	public function update()
	{
		$id_menu = $this->input->post('id_menu', true);

		$data = [
	        "nama" => $this->input->post('nama', true),
		];

		$this->admin->updateDatabyTable('menu', 'id_menu', $id_menu, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">menu berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu');
	}

	public function delete($id)
	{
		$this->admin->deleteDataById('menu', 'id_menu', $id);
		$this->admin->deleteDataById('sub_menu', 'id_menu', $id);
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">menu berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu');
	}



	// submenu
	public function sub_menu($id_menu)
	{
		$data['title'] = 'Sub Menu Manajemen';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['id_menu'] = $id_menu;
		$data['dt_menu'] = $this->admin->GetDataById('menu', 'id_menu', $id_menu);
		$data['dt_all'] = $this->admin->getAllByTableAndSite('sub_menu', 'id_sub_menu', 'asc', 'id_menu', $id_menu);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('menu/submenu', $data);
		$this->load->view('templates/footer');
	}

	public function add_sub_menu()
	{
		$id_menu = $this->input->post('id_menu', true);

		$data = [
	        "id_menu" => $this->input->post('id_menu', true),
	        "nama" => $this->input->post('nama', true),
	        "url" => $this->input->post('url', true),
		];

		$this->admin->addDatabyTable('sub_menu', $data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Sub menu berhasil ditambahkan! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu/sub_menu/'.$id_menu);
	}

	public function sub_menu_update()
	{
		$id_menu = $this->input->post('id_menu', true);
		$id_sub_menu = $this->input->post('id_sub_menu', true);

		$data = [
	        "nama" => $this->input->post('nama', true),
	        "url" => $this->input->post('url', true),
		];

		$this->admin->updateDatabyTable('sub_menu', 'id_sub_menu', $id_sub_menu, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">sub menu berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu/sub_menu/'.$id_menu);
	}

	public function delete_sub_menu()
	{
		$id_menu = $this->input->post('id_menu', true);
		$id_sub_menu = $this->input->post('id_sub_menu', true);



		$this->admin->deleteDataById('sub_menu', 'id_sub_menu', $id_sub_menu);

		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">sub menu berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('menu/sub_menu/'.$id_menu);
	}



}