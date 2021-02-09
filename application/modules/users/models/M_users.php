<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

	function get_user($where=null)
	{
		if ($where != null) {
			$this->db->where($where);
			return $this->db->get('users')
				->row();
		}else{
			$this->db->order_by('nama', 'asc');
			return $this->db->get('users')
				->result();
		}
	}

}

/* End of file M_users.php */
/* Location: ./application/modules/users/models/M_users.php */