<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	public function getRoleById($id)
	{
		return $this->db->get_where('user_role', ['id_role' => $id])->row_array();
	}

	public function editRole()
	{
		$data = [
        	"role" => $this->input->post('role', true)
		];

		$this->db->where('id_role', $this->input->post('id'));
		$this->db->update('user_role', $data);
	}

	public function deleteRole($id)
	{
		return $this->db->delete('user_role', ['id_role' => $id]);
	}

	public function getUser()
	{	
		$this->db->select('*');
		$this->db->from('user');
		$this->db->order_by("id_role", "asc");
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function getUserById($id)
	{
		return $this->db->get_where('user', ['id_user' => $id])->row_array();
	}

	public function deleteUser($id)
	{
		return $this->db->delete('user', ['id_user' => $id]);
	}

	public function count($table)
    {
        return $this->db->count_all($table);
    }

	public function companyProfile()
	{
		return $this->db->get_where('profile', ['id_profile' => 1])->row_array();
	}




	// group dan video
	public function getAllDataLink()
	{
		$this->db->select('*');
		$this->db->from('group');
		$this->db->join('video', 'group.id_group = video.id_group','right');
		$this->db->order_by('video.id_video', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}	

	public function getAllDataLinkByGrup($id)
	{
		$this->db->select('*');
		$this->db->from('group');
		$this->db->join('video', 'group.id_group = video.id_group','right');
		$this->db->where('video.id_group', $id);
		$this->db->order_by('video.id_video', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}	




	// untuk keseluruhan
	public function getAllByTable($table, $primary, $urut)
	{	
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($primary, $urut);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function getAllByTableAndSite($table, $primary, $urut, $id_where, $value)
	{	
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($id_where, $value);
		$this->db->order_by($primary, $urut);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function GetDataById($table, $primary, $value)
	{
		return $this->db->get_where($table, [$primary => $value])->row_array();
	}

	public function addDatabyTable($table,$data_array)
	{	
		$this->db->insert($table, $data_array);
	}

	public function updateDatabyTable($table, $primary, $value, $data_array)
	{	
		$this->db->where($primary, $value);
		$this->db->update($table, $data_array);
	}

	public function deleteDataById($table, $primary, $value)
	{
		return $this->db->delete($table, [$primary => $value]);
	}
}