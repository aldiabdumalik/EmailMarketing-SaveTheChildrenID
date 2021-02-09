<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_landing extends CI_Model {

	function detail_contact($id)
	{
		$this->db->join('users_video', 'users_video.id_video = contact.id_contact', 'left');
		$this->db->where('contact.id_contact', $id);
		return $this->db->get('contact')
			->row();
	}

	function users_id($id)
	{
		$this->db->where('id_contact', $id);
		return $this->db->get('contact')
			->row();
	}

}

/* End of file M_landing.php */
/* Location: ./application/modules/landing/models/M_landing.php */