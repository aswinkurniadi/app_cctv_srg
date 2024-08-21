<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cctv extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
		$this->load->model('Cctv_model','cctv');
	}

	public function index()
	{
		$data['title'] = 'Daftar CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->cctv->getAllData();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('cctv/index', $data);
		$this->load->view('templates/footer');
	}

	public function live()
	{
		$data['title'] = 'Live CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_group'] = $this->admin->getAllByTable('group', 'id_group', 'ASC');

		$data['dt_setting'] = $this->admin->GetDataById('setting', 'id_setting', 1);
		$data['dt_allCCTVLive'] = $this->cctv->getAllDataLive();
		$data['dt_LiveById'] = $this->cctv->getLiveCCTV();

		$this->form_validation->set_rules('id_group','', 'required');

		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('cctv/live', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'id_group' => $this->input->post('id_group'),
			];

			// ubah id_live			
	        $this->db->where('id_live', 1);
			$this->db->update('live_cctv', $data);

			$this->session->set_flashdata('message', '
				<div class="alert alert-primary" role="alert">
					Data berhasil dibuka!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
				</div>');
			redirect('cctv/live');
		}
	}

	// tambah
	public function add()
	{
		$data['title'] = 'Tambah CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_group'] = $this->admin->getAllByTable('group', 'id_group', 'ASC');

		$this->form_validation->set_rules('nama','', 'required');

		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('cctv/add', $data);
			$this->load->view('templates/footer');
		} else {

			$this->cctv->insert();
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
					Data berhasil disimpan!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
				</div>');
			redirect('cctv');
		}
	}

	// ubah
	public function edit($id_cctv)
	{
		$data['title'] = 'Tambah CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dtById'] = $this->cctv->getDataById($id_cctv);
		$data['dt_group'] = $this->admin->getAllByTable('group', 'id_group', 'ASC');

		$this->form_validation->set_rules('nama','', 'required');

		if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('cctv/edit', $data);
			$this->load->view('templates/footer');
		} else {

			$this->cctv->update($id_cctv);
			$this->session->set_flashdata('message', '
				<div class="alert alert-primary" role="alert">
					Data berhasil diubah!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
				</div>');
			redirect('cctv');
		}		
	}

	// hapus
	public function delete($id_cctv) 
	{
		$this->cctv->delete($id_cctv);
		$this->session->set_flashdata('message', '
			<div class="alert alert-danger" role="alert">
				Data berhasil dihapus!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button>
			</div>');
		redirect('cctv');		
	}

	// script terminal cctv
	public function terminal()
	{
		$data['title'] = 'Script Terminal CCTV';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$dt_group = $this->admin->getAllByTable('group', 'id_group', 'ASC');

		$result = array();
		foreach($dt_group as $row) {
			$result[] = $this->createScript($row['id_group']);
		}

		echo json_encode($result);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('cctv/terminal', $data);
		$this->load->view('templates/footer');
	}

	public function createScript($id_group)
	{
		$dt_setting = $this->admin->GetDataById('setting', 'id_setting', 1);

		$brs_1 = "start cmd /k ffmpeg -v verbose -i ";
		$brs_2 = " -vcodec libx264 -r 25 -b:v 100000 -crf 31 -acodec aac -sc_threshold 0 -f hls -hls_time 1 -segment_time 1 -hls_list_size 1 -hls_flags delete_segments -hls_delete_threshold 60 ";

		$this->db->where_in('a.id_group', $id_group);
		$dt_allcctv = $this->cctv->getAllData();

		$res = array();
		foreach($dt_allcctv as $row) {
			$res[] = $brs_1.'"'.$row['url_rtsp'].'"'.$brs_2.$dt_setting['url_xampp'].$row['url_directory'];
		}
		return $res;
	}
}