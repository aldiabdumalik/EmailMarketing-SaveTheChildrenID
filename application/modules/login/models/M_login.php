<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

	function login($email, $password)
	{
		$this->db->select('id, fromfield, nama, email, foto, level');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		return $this->db->get('users')
			->row();
	}

}

/* End of file M_login.php */
/* Location: ./application/modules/login/models/M_login.php */