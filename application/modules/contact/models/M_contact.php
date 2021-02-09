<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_contact extends CI_Model {

	function get_contact($id)
	{
		$this->db->where('id_contact', $id);
		return $this->db->get('contact')
			->row();
	}

}

/* End of file M_contact.php */
/* Location: ./application/modules/contact/models/M_contact.php */