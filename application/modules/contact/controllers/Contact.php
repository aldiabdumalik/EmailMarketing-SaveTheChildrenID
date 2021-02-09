<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact;
use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Model\NewContact;
class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in !== true) {
			redirect('login.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model([
			'M_contact' => 'model',
			'DataTables' => 'datatables'
		]);
	}

	public function index()
	{
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Contact',
			'content' => 'contact',
			'js' => 'contact'
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	public function download_template()
	{
		$nama_file = 'TEMPLATE-IMPORT-CONTACT'.date('YmdHis').'.xlsx';

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Nama Kontak')
			->setCellValue('B1', 'Email Kontak');

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nama_file.'"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit();
	}

	public function import_contact()
	{
		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

			$arr_file = explode('.', $_FILES['berkas_excel']['name']);
			$extension = end($arr_file);

			if('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			for($i = 1; $i < count($sheetData); $i++){
				$this->add_contact($sheetData[$i]['0'], $sheetData[$i]['1']);
			}
			$this->get_contact_campign();
			redirect('contact.html','refresh');
		}
	}

	private function add_contact($nama, $email)
	{
		$params = [
			'name' => $nama,
			'campaign' => [
				'campaignId' => $this->session->myid
			],
			'email' => $email
		];
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.getresponse.com/v3/contacts',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($params),
		CURLOPT_HTTPHEADER => array(
				'X-Auth-Token: your api-key',
				'Content-Type: application/json'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}

	private function get_contact_campign()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.getresponse.com/v3/campaigns/'.$this->session->myid.'/contacts',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
				'X-Auth-Token: your api-key'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$res = json_decode($response);
		foreach ($res as $r) {
			$req = $this->model->get_contact($r->contactId);
			if (empty($req)) {
				$data = [
					'id_contact' => $r->contactId,
					'id_users' => $this->session->myid,
					'nama_contact' => $r->name,
					'email_contact' => $r->email,
					'tanggal_import' => date('Y-m-d H:i:s')
				];
				$this->db->insert('contact', $data);
			}
			$this->update_costum_url($r->contactId);
		}
		return true;
	}

	private function update_costum_url($idcontact)
	{
		$params = [
			'customFieldValues' => [
				[
					'customFieldId' => 'DO',
					'value' => [
						'https://video-savethechildren.org/landing.html?contact='.$idcontact
					]
				],
				[
					'customFieldId' => 'Df',
					'value' => [
						'https://video-savethechildren.org/uploads/thumb/'.$idcontact.'.jpg'
					]
				]
			]
		];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.getresponse.com/v3/contacts/'.$idcontact.'/custom-fields',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($params),
		CURLOPT_HTTPHEADER => array(
				'X-Auth-Token: your api-key',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
	}

	public function delete_contact()
	{
		$post = file_get_contents('php://input');
		
		$post = json_decode($post);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.getresponse.com/v3/contacts/'.$post->id,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'DELETE',
		CURLOPT_HTTPHEADER => array(
				'X-Auth-Token: your api-key'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$where = [
			'id_contact' => $post->id,
			'id_users' => $this->session->myid
		];
		$this->db->delete('contact', $where);
		$this->template->response([
			'status' => true,
			'message' => 'Contact berhasil dihapus'
		]);
	}

	public function DataTables()
	{
		$list = $this->datatables->get_datatables();
        $data = array();
        $no = 1;
        foreach ($list as $field) {
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_contact;
            $row[] = $field->email_contact;
            $row[] = '<button type="button" class="btn btn-outline-danger btn-sm btn-block contact-delete" data-id="'.$field->id_contact.'"><i class="fa fa-trash"></i></button>';

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

/* End of file Contact.php */
/* Location: ./application/modules/contact/controllers/Contact.php */