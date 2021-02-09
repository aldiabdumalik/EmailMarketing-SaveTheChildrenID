<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Template');
		$this->load->model([
			'M_landing' => 'model'
		]);
	}

	public function index()
	{
		$data = array();
		if ($this->input->get('contact') != "") {
			$contact = $this->model->detail_contact($this->input->get('contact'));
			$users = $this->model->users_id($this->input->get('contact'));
			$data = [
				'id_contact' => $this->input->get('contact'),
				'id_users' => $users->id_users,
				'action_report' => 'click',
				'tgl_report' => date('Y-m-d H:i:s')
			];
			$this->db->insert('contact_report', $data);
			$data['contact'] = $contact;
		}
		$this->load->view('landing', $data);
	}

	public function post_action()
	{
		$users = $this->model->users_id($this->input->post('contact'));
		$data = [
			'id_contact' => $this->input->post('contact'),
			'id_users' => $users->id_users,
			'action_report' => $this->input->post('action'),
			'tgl_report' => date('Y-m-d H:i:s')
		];
		$this->db->insert('contact_report', $data);
	}

	public function download_video($name)
	{
		$this->load->helper('download');
		$file = './uploads/video/'.$name;
		force_download($file, NULL);
		// $this->template->response([
		// 	'status' => true,
		// 	'data' => $file
		// ]);
	}

	public function report_video()
	{
		$users = $this->model->users_id($this->input->post('contact'));
		$data = [
			'id_contact' => $this->input->post('contact'),
			'id_users' => $users->id_users,
			'action_report' => $this->input->post('action'),
			'tgl_report' => date('Y-m-d H:i:s')
		];
		$this->db->insert('contact_report', $data);
	}

}

/* End of file Landing.php */
/* Location: ./application/modules/landing/controllers/Landing.php */