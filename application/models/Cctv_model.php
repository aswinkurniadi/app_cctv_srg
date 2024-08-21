<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cctv_model extends CI_Model
{
	public function getAllData()
	{
		$this->db->select('*');
		$this->db->from('cctv a');
		$this->db->join('group b', 'a.id_group = b.id_group','left');
		$this->db->order_by('a.id_cctv', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}	

	public function getAllDataLive()
	{
		$this->db->select('*');
		$this->db->from('live_cctv a');
		$this->db->join('group b', 'a.id_group = b.id_group','left');
		$this->db->join('cctv c', 'b.id_group = c.id_group','left');
		$this->db->order_by('a.id_live', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}	

	public function getDataById($id)
	{
		return $this->db->get_where('cctv', ['id_cctv' => $id])->row_array();
	}

	public function insert()
	{
		$data = [
			'nm_cctv' => $this->input->post('nama'),
			'id_group' => $this->input->post('id_group'),
			'url_rtsp' => $this->input->post('url_rtsp'),
			'url_directory' => $this->input->post('url_directory'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'almt' => $this->input->post('almt'),
			'stts' => $this->input->post('stts'),
			'date_created' => time(),
		];

		$this->db->insert('cctv', $data);
	}

	public function update($id_cctv)
	{
		$data = [
			'nm_cctv' => $this->input->post('nama'),
			'id_group' => $this->input->post('id_group'),
			'url_rtsp' => $this->input->post('url_rtsp'),
			'url_directory' => $this->input->post('url_directory'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'almt' => $this->input->post('almt'),
			'stts' => $this->input->post('stts'),
		];

        $this->db->where('id_cctv', $id_cctv);
		$this->db->update('cctv', $data);
	}

	public function delete($id_cctv)
	{
		return $this->db->delete('cctv', ['id_cctv' => $id_cctv]);
	}

	// live cctv
	public function getLiveCCTV()
	{
		$this->db->select('*');
		$this->db->from('live_cctv a');
		$this->db->join('group b', 'a.id_group = b.id_group','left');
		$query = $this->db->get()->row_array();
		return $query;
	}
}