<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in == true) {
			redirect('dashboard.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model('M_login', 'model');
	}
	
	public function index()
	{
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Login',
			'content' => 'login',
			'js' => 'login'
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template_login', $data);
	}

	public function login_post()
	{
		$post = file_get_contents('php://input');
		$post = json_decode($post);
		$req = $this->model->login($post->email, $post->password);
		if (isset($req)) {
			$userdata = array(
				'logged_in' => TRUE,
				'myid' => $req->id,
				'fromfield' => $req->fromfield,
				'myname' => $req->nama,
				'myemail' => $req->email,
				'mylevel' => $req->level,
			);
			$this->session->set_userdata($userdata);
			$this->template->response([
				'status' => true,
				'message' => 'Login berhasil tunggu beberapa saat...',
				'data' => $req
			]);
		}else{
			$this->template->response([
				'status' => true,
				'message' => 'Maaf login gagal, silahkan periksa kembali email & password Anda'
			]);
		}
	}

}

/* End of file Login.php */
/* Location: ./application/modules/login/controllers/Login.php */