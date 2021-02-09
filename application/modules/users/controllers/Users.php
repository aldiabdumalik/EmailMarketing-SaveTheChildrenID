<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in !== true) {
			redirect('login.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model([
			'M_users' => 'model',
			'DataTables' => 'datatables'
		]);
	}

	public function index()
	{
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Users List',
			'content' => 'users',
			'js' => 'users'
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	public function create_user()
	{
		$post = file_get_contents('php://input');
		$post = json_decode($post);
		if ($post->id == "") {
			$search = array(' ', "'", '"', "%", "&", "+", "*", "!", "-");
			$nama = strtolower(str_replace($search, "", $post->nama));
			$req = $this->create_campign($nama, $post->email);
			$res = json_decode($req);
			if (!empty($res->campaignId)) {
				$data = [
					'id' => $res->campaignId,
					'fromfield' => $res->confirmation->fromField->fromFieldId,
					'nama' => $post->nama,
					'email' => $post->email,
					'password' => $post->password,
					'level' => $post->level,
					'tanggal' => date('Y-m-d H:i:s'),
				];
				$query = $this->db->insert('users', $data);
				$this->template->response([
					'status' => true,
					'message' => 'User berhasil ditambahkan...'
				]);
			}else{
				$this->template->response([
					'status' => false,
					'message' => 'User gagal ditambahkan, silahkan ulangi beberapa saat lagi...',
					'error' => $res
				]);
			}
		}else{
			$data = [
				'nama' => $post->nama,
				'email' => $post->email,
				'password' => $post->password,
				'level' => $post->level,
				'tanggal' => date('Y-m-d H:i:s'),
			];
			$query = $this->db->update('users', $data, ['id' => $post->id]);
			$this->template->response([
				'status' => true,
				'message' => 'User berhasil diupdate...'
			]);
		}
	}

	public function delete_user()
	{
		$post = file_get_contents('php://input');
		$post = json_decode($post);
		$query = $this->db->delete('users', ['id' => $post->id]);
		$this->template->response([
			'status' => true,
			'message' => 'User dengan id '.$post->id.' berhasil dihapus...'
		]);
	}

	public function call_user()
	{
		if ($this->input->get('id') != null) {
			$where = [
				'id' => $this->input->get('id')
			];
			$req = $this->model->get_user($where);
		}else{
			$req = $this->model->get_user();
		}
		$this->template->response([
			'status' => true,
			'data' => $req
		]);
	}

	private function create_campign($name, $email)
	{
		$form = [
			'name' => 'stc_'.$name
		];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.getresponse.com/v3/campaigns',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($form),
		CURLOPT_HTTPHEADER => array(
				'X-Auth-Token: your api-key',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

	public function DataTables()
	{
		$list = $this->datatables->get_datatables();
        $data = array();
        $no = 1;
        foreach ($list as $field) {
            $row = array();
            $row[] = $no;
            $row[] = $field->id;
            $row[] = $field->nama;
            $row[] = $field->email;
            $row[] = $field->level == 1 ? "Admin" : "User";
            $row[] = '
            	<button type="button" class="btn btn-outline-warning btn-sm users-edit" data-id="'.$field->id.'"><i class="fa fa-pencil"></i></button>
            	<button type="button" class="btn btn-outline-danger btn-sm users-delete" data-id="'.$field->id.'"><i class="fa fa-trash"></i></button>
            ';

            $data[] = $row;
            $no++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatables->count_all(),
            "recordsFiltered" => $this->datatables->count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
	}

}

/* End of file Users.php */
/* Location: ./application/modules/users/controllers/Users.php */