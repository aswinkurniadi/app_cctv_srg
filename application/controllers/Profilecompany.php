<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profilecompany extends CI_Controller 
{ 
	public function __construct()
	{
	 	parent::__construct();
		is_logged_in();
	}

	public function index()
    {
    	$data['title'] = 'Profile Perusahaan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();
		$this->load->model('Admin_model','admin');

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('profilecompany/index', $data);
		$this->load->view('templates/footer');
    }

    public function edit_profile_perusahaan($id)
    {
    	$data['title'] = 'Ubah Profile Perusahaan';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => $id])->row_array();
		$this->load->model('Admin_model','admin');

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");

		$this->form_validation->set_rules('name','', 'required');
		$this->form_validation->set_rules('almt','', 'required');
		$this->form_validation->set_rules('no_telp','', 'required');
		$this->form_validation->set_rules('email','', 'required');
		$this->form_validation->set_rules('content','', 'required');
		$this->form_validation->set_rules('time_zone','', 'required');
		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('profilecompany/edit_profile_perusahaan', $data);
			$this->load->view('templates/footer');
		} else {
			
			// cek jika ada gambar yang akan diuload
			$upload_image = $_FILES['image']['name'];
			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']      = '2048';
				$config['upload_path']   = './assets/img/profile_perusahaan/';

				$this->load->library('upload', $config);

				if($this->upload->do_upload('image')) {
					$old_image = $data['profile']['logo'];
					unlink(FCPATH . 'assets/img/profile_perusahaan/' . $old_image);

					$new_image = $this->upload->data('file_name');
					$this->db->set('logo', $new_image);
				} else {
					echo $this->upload->dispay_errors();
				}
			}

			$data = [
				'name' => $this->input->post('name'),
				'almt' => $this->input->post('almt'),
				'no_telp' => $this->input->post('no_telp'),
				'email' => $this->input->post('email'),
				'deskripsi' => $this->input->post('content'),
				'time_zone' => $this->input->post('time_zone'),
			];

        	$this->db->where('id_profile', $this->input->post('id'));
			$this->db->update('profile', $data);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile Company has been updated!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button></div>');
    		redirect('profilecompany/');
		}
    }
}