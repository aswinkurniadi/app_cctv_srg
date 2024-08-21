<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{ 
	public function __construct()
	{
	 	parent::__construct();
		is_logged_in();
		if (!is_admin()) {
            redirect('auth/blocked');
        }
		$this->load->model('Admin_model','admin');
	}

    public function index()
    {

    	$data['title'] = 'User Management';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");

		$data['user_all'] = $this->admin->getUser();
		$data['user_role'] = $this->db->get('user_role')->result_array();

		$this->form_validation->set_rules('name','Role', 'required');
		$this->form_validation->set_rules('role_id','Role', 'required');
		$this->form_validation->set_rules('email','Role', 'required');
		$this->form_validation->set_rules('password','Role', 'required');
		$this->form_validation->set_rules('date','Role', 'required');

		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/user_management', $data);
			$this->load->view('templates/footer');
		} else {
			$name 		= $this->input->post('name');
			$role_id 	= $this->input->post('role_id');
			$username 		= $this->input->post('username');
			$email 		= $this->input->post('email');
			$password 	= password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$date 		= $this->input->post('date');
			$is_active 	= $this->input->post('is_active');

			 $data = [
	            'name' => $name,
	            'username' => $username,
	            'email' => $email,
	            'image' => 'default.jpg',
	            'password' => $password,
	            'id_role' => $role_id,
	            'is_active' => $is_active,
	            'date_created' => time()
	        ];
			$this->db->insert('user', $data);
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
					New Data User added
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
				</div>');
			redirect('admin');
		}
    }

    public function edit_user_management($id)
    {
    	$data['title'] = 'Edit User';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();
		

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");

    	$data['user'] = $this->admin->getUserById($id);
    	$password = $data['user']['password'];

    	$data['user_role'] = $this->db->get('user_role')->result_array();

    	$this->form_validation->set_rules('name','Role', 'required');
		$this->form_validation->set_rules('role_id','Role', 'required');
		$this->form_validation->set_rules('email','Role', 'required');
		$this->form_validation->set_rules('date','Role', 'required');
		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/edit_user_management', $data);
			$this->load->view('templates/footer');
		} else {
			$name = $this->input->post('name');
			$role_id = $this->input->post('role_id');
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$date = $this->input->post('date');
			$is_active = $this->input->post('is_active');

			// cek jika ada gambar yang akan diuload
			$upload_image = $_FILES['image']['name'];

			echo $upload_image;

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']      = '2048';
				$config['upload_path']   = './assets/img/profile/';

				$this->load->library('upload', $config);

				if($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ($old_image){
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}

					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					echo $this->upload->dispay_errors();
				}
			}

	        $this->db->set('name', $name);
	        $this->db->set('username', $username);
	        $this->db->set('email', $email);
	        $this->db->set('id_role', $role_id);
	        $this->db->set('is_active', $is_active);
	        $this->db->set('date_created', time());

	        $this->db->where('id_user', $this->input->post('id'));
			$this->db->update('user');

	    	$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User has been updated!
	    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button></div>');
	    	redirect('admin');
    	}
    }

    public function delete_user_management($id)
    {
    	$data['admin'] = $this->admin->getUserById($id);
		$name = $data['admin']['name'];
		$this->admin->deleteUser($id);
    	$this->session->set_flashdata('message', '
    		<div class="alert alert-danger" role="alert">
			User '. $name .' has been deleted!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
			</div>');
    	redirect('admin');
    }



    public function detail_access($id_role)
    {
    	$data['title'] = 'Akses User';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();		

		date_default_timezone_set('Asia/Jakarta');
		$data['date'] = date("Y-m-d");

		$data['id_role'] = $id_role;
		$dt_menu_all = $this->admin->getAllByTable('menu', 'id_menu', 'asc');

		$data['dt_all_menu'] = array();
		foreach($dt_menu_all as $row) {
			$userAccess = $this->getallUserAccess($row['id_menu'], $id_role);

			$data['dt_all_menu'][] = array(
				'id_menu' => $row['id_menu'],
				'nama' => $row['nama'],
				'dt_sub_menu' => $userAccess,
			);
		}

		// echo json_encode($data['dt_all_menu']);

    	$this->form_validation->set_rules('id_role','', 'required');

		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/access_user', $data);
			$this->load->view('templates/footer');
		} else {

			$id_role = $this->input->post('id_role');
			$id_sub_menu = $this->input->post('id_sub_menu[]');

			// hapus data
			$this->admin->deleteDataById('user_access', 'id_role', $id_role);
			
			// tambah data
			foreach($id_sub_menu as $row) {
				$data_insert = array(
					'id_role' => intval($id_role),
					'id_sub_menu' => intval($row),
				);

				$this->db->insert('user_access', $data_insert);
			}

	    	$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access User berhasil diupadate!
	    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button></div>');
	    	redirect('admin/detail_access/'.$id_role);
		}
    }

   	function getallUserAccess($id_menu, $id_role)
   	{
		$this->load->model('Menu_model','menu');

		$dt_sub_menu = $this->admin->getAllByTableAndSite('sub_menu', 'id_sub_menu', 'asc', 'id_menu', $id_menu);
		$data = array();
		foreach($dt_sub_menu as $row) {
			$sttsUserAccess = $this->menu->getUserAccess($id_role, $row['id_sub_menu']);

			$stts = 0;
			if(empty($sttsUserAccess)) {
				$stts = 0;
			} else {
				$stts = 1;
			}

			$data[] = array(
				'id_sub_menu' => $row['id_sub_menu'],
				'nama' => $row['nama'],
				'url' => $row['url'],
				'stts_access' => $stts
			);
		}

		return $data;
   	}
}
