<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	function get_users()
	{
		$this->db->order_by('nama', 'asc');
		return $this->db->get('users')
		->result();
	}

	function count_report($where)
	{
		$this->db->where($where);
		$query = $this->db->get('contact_report');
        return $query->num_rows();
	}

	function report_action($where)
	{
		$this->db->join('contact', 'contact.id_contact = contact_report.id_contact', 'left');
		$this->db->where($where);
		$this->db->order_by('contact_report.action_report', 'asc');
		$query = $this->db->get('contact_report');
        return $query->result();
	}

}

/* End of file M_dashboard.php */
/* Location: ./application/modules/dashboard/models/M_dashboard.php */