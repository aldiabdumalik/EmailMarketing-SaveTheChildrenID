<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		session_destroy();
		redirect('login.html','refresh');
	}

}

/* End of file Logout.php */
/* Location: ./application/modules/logout/controllers/Logout.php */