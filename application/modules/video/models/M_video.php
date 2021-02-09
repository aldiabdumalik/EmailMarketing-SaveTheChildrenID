<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_video extends CI_Model {

	function get_video()
	{
		return $this->db->get('video')
		->row();
	}

	function get_contact()
	{
		$this->db->join('users', 'users.id = contact.id_users', 'left');
		$this->db->order_by('users.nama', 'asc');
		return $this->db->get('contact')
			->result();
	}

	function usersvideo($id)
	{
		$this->db->where('id_video', $id);
		return $this->db->get('users_video')
			->row();
	}

}

/* End of file M_video.php */
/* Location: ./application/modules/video/models/M_video.php */