<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	public function getUserAccess($id_role, $id_sub_menu)
	{
		$this->db->select('*');
		$this->db->from('user_access');
		$array = array('id_role' => $id_role, 'id_sub_menu' => $id_sub_menu);
		$this->db->where($array);
		$query = $this->db->get()->row_array();
		return $query;
	}

	public function getAllAccessByID()
	{
		// memperoleh data by id terkait
	}
}