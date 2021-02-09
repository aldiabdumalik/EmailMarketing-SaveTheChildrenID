<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sendmail extends CI_Model {

	function get_kontak_page($page)
	{
		$limit = 20;
		$offset = (int)$page*$limit;
		$this->db->where('id_users', $this->session->myid);
		$this->db->order_by('nama_contact', 'asc');
		return $this->db->get('contact', $limit, $offset)
			->result();
	}

	function count_page()
	{
		$this->db->where('id_users', $this->session->myid);
		$this->db->order_by('nama_contact', 'asc');
		return $this->db->get('contact')
			->result();
	}

	function get_kontak_all()
	{
		$this->db->where('id_users', $this->session->myid);
		$this->db->order_by('nama_contact', 'asc');
		return $this->db->get('contact')
			->result();
	}

}

/* End of file M_sendmail.php */
/* Location: ./application/modules/sendmail/models/M_sendmail.php */