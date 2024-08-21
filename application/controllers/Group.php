<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		$data['title'] = 'Group';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->admin->getAllByTable('group', 'id_group', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('group/index', $data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
		$data = [
	        "nm" => $this->input->post('nm', true),
		];

		$this->admin->addDatabyTable('group', $data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Group berhasil ditambahkan! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('group');
	}

	public function update()
	{
		$id_group = $this->input->post('id_group', true);

		$data = [
	        "nm" => $this->input->post('nm', true),
		];

		$this->admin->updateDatabyTable('group', 'id_group', $id_group, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Group berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('group');
	}

	public function delete($id)
	{
		$this->admin->deleteDataById('group', 'id_group', $id);
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Group berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('group');
	}

	// detail
	public function detail($id)
	{
		$dt_group = $this->admin->GetDataById('group', 'id_group', $id);
		$data['title'] = 'Group '.$dt_group['nm'];
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$this->load->model('Cctv_model','cctv');

		$this->db->where_in('a.id_group', $id);
		$data['dt_allRes'] = $this->cctv->getAllData();

		$data['dt_group'] = $this->admin->getAllByTable('group', 'id_group', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('group/detail', $data);
		$this->load->view('templates/footer');
	}

	public function update_group()
	{
		$id_cctv = $this->input->post('id_cctv', true);
		$id_group_lm = $this->input->post('id_group_lm', true);

		$data = [
	        "id_group" => $this->input->post('id_group', true),
		];

		$this->admin->updateDatabyTable('cctv', 'id_cctv', $id_cctv, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Group berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('group/detail/'.$id_group_lm);

	}


}