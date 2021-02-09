<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Video extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in !== true) {
			redirect('login.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model([
			'M_video' => 'model'
		]);
	}

	public function index()
	{
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Video & Thumbnail',
			'content' => 'video',
			'js' => 'video'
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	public function call_video()
	{
		$req = $this->model->get_video();
		if (!empty($req)) {
			$this->template->response([
				'status' => true,
				'data' => $req
			]);
		}else{
			$this->template->response([
				'status' => false,
				'message' => 'Data Tidak Ditemukan'
			]);
		}
	}

	public function upload_thumb()
	{
		$config['upload_path'] = './uploads/thumb/';
		$config['allowed_types'] = 'jpg';
		$config['remove_spaces'] = FALSE;
		$this->load->library('upload', $config);
		if (file_exists('./uploads/thumb/'.$_FILES['userfile']['name'])){
			unlink('./uploads/thumb/'.$_FILES['userfile']['name']);
		}
		if ($this->upload->do_upload('userfile')){
			$todb = [
				'id_video' => $this->upload->data('raw_name'),
				'thumb_video' => $this->upload->data('file_name'),
			];
			$cek = $this->model->usersvideo($this->upload->data('raw_name'));
			if (empty($cek)) {
				$this->db->insert('users_video', $todb);
			}else{
				$this->db->update('users_video', $todb, ['id_video' => $this->upload->data('raw_name')]);
			}
		}
		$this->template->response([
			'status' => true,
			'message' => 'File berhasil diupload'
		]);
	}

	public function upload_video()
	{
		$config['upload_path'] = './uploads/video/';
		$config['allowed_types'] = 'mp4';
		$config['remove_spaces'] = FALSE;
		$this->load->library('upload', $config);
		if (file_exists('./uploads/video/'.$_FILES['userfile']['name'])){
			unlink('./uploads/video/'.$_FILES['userfile']['name']);
		}
		if ($this->upload->do_upload('userfile')){
			$todb = [
				'id_video' => $this->upload->data('raw_name'),
				'nama_video' => $this->upload->data('file_name'),
			];
			$cek = $this->model->usersvideo($this->upload->data('raw_name'));
			if (empty($cek)) {
				$this->db->insert('users_video', $todb);
			}else{
				$this->db->update('users_video', $todb, ['id_video' => $this->upload->data('raw_name')]);
			}
		}
		$this->template->response([
			'status' => true,
			'message' => 'File berhasil diupload'
		]);
	}

	public function download_format()
	{
		$nama_file = 'FORMAT-UPLOAD-VIDEO-'.date('YmdHis').'.xlsx';
		$contact = $this->model->get_contact();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Id Kontak')
			->setCellValue('C1', 'Nama Kontak')
			->setCellValue('D1', 'Email Kontak')
			->setCellValue('E1', 'Id User')
			->setCellValue('F1', 'Nama User');


		$kolom = 2;
		$nomor = 1;
		foreach($contact as $m) {

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $m->id_contact)
				->setCellValue('C' . $kolom, $m->nama_contact)
				->setCellValue('D' . $kolom, $m->email_contact)
				->setCellValue('E' . $kolom, $m->id_users)
				->setCellValue('F' . $kolom, $m->nama);

			$kolom++;
			$nomor++;

		} 

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nama_file.'"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit();
	}

	public function update_video()
	{
		$this->load->library('upload');
		if ($this->input->post('upload_thumb') == 'yes') {
			$config1['upload_path'] = './uploads/thumb/';
			$config1['allowed_types'] = 'gif|jpg|png|jpeg';
			$config1['remove_spaces'] = TRUE;
			$config1['encrypt_name'] = TRUE;
			$this->upload->initialize($config1);
			if ($this->upload->do_upload('thumbnail')) {
				$data['thumb_video'] = $this->upload->data('file_name');
				$this->db->update('video', $data, ['id_video' => 1]);
			}else{
				$this->template->response([
					'status' => false,
					'message' => $this->upload->display_errors()
				]);
			}
		}
		if ($this->input->post('upload_video') == 'yes') {
			$config2['upload_path'] = './uploads/video/';
			$config2['allowed_types'] = 'mp4';
			$config2['remove_spaces'] = TRUE;
			$config2['encrypt_name'] = TRUE;
			$this->upload->initialize($config2);
			if ($this->upload->do_upload('video')) {
				$data['nama_video'] = $this->upload->data('file_name');
				$this->db->update('video', $data, ['id_video' => 1]);
			}else{
				$this->template->response([
					'status' => false,
					'message' => $this->upload->display_errors()
				]);
			}
		}
		$this->template->response([
			'status' => true,
			'message' => 'Thumbnail & Video Berhasil diperbaharui'
		]);
	}

}

/* End of file Video.php */
/* Location: ./application/modules/video/controllers/Video.php */