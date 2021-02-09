<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kosong extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Template');
	}

	public function index()
	{
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'kosong',
			'content' => 'kosong',
			'js' => 'kosong'
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	public function test_upload()
	{
		$config['upload_path'] = './uploads/video/';
		$config['allowed_types'] = 'mp4';
		$config['remove_spaces'] = FALSE;
		$this->load->library('upload', $config);
		if (file_exists('./uploads/video/'.$_FILES['userfile']['name'])){
			unlink('./uploads/video/'.$_FILES['userfile']['name']);
		}
		if ($this->upload->do_upload('userfile')){
			$data = array('upload_data' => $this->upload->data());
			$error = array('error' => $this->upload->display_errors());
		}
		echo json_encode(['file_exists' => $file_exists]);
	}

}

/* End of file Kosong.php */
/* Location: ./application/modules/kosongan/controllers/Kosong.php */