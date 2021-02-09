<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in !== true) {
			redirect('login.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model('M_dashboard', 'model');
	}

	public function index()
	{
		$click = $this->count_report('click');
		$watching = $this->count_report('watching');
		$download = $this->count_report('download');
		$users = $this->model->get_users();
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Dashboard',
			'content' => 'dashboard',
			'js' => 'dashboard',
			'users' => $users,
			'click' => $click,
			'watching' => $watching,
			'download' => $download
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	private function count_report($action)
	{
		$where = [
			'MONTH(tgl_report)' => date('m'),
			'YEAR(tgl_report)' => date('Y'),
			'id_users' => $this->session->myid
		];
		if ($action == 'click') {
			$where['action_report'] = 'click';
			$report = $this->model->count_report($where);
		}else{
			$where['action_report'] = 'watching';
			$report = $this->model->count_report($where);
		}
		return $report;
	}

	public function excel_report()
	{
		$where = array();
		if ($this->input->post('report-user')) {
			$where['contact_report.id_users'] = $this->input->post('report-user');
		}else{
			$where['contact_report.id_users'] = $this->session->myid;
		}
		if ($this->input->post('report-action') != 'all') {
			$where['contact_report.action_report'] = $this->input->post('report-action');
		}
		if ($this->input->post('report-bulan') != 'all') {
			$where['MONTH(contact_report.tgl_report)'] = $this->input->post('report-bulan');
		}
		$where['YEAR(contact_report.tgl_report)'] = $this->input->post('report-tahun');
		$report = $this->model->report_action($where);
		$nama_file = 'REPORT-ACTION-'.date('YmdHis').'.xlsx';

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Id Kontak')
			->setCellValue('C1', 'Nama Kontak')
			->setCellValue('D1', 'Email Kontak')
			->setCellValue('E1', 'Aksi')
			->setCellValue('F1', 'Tanggal');


		$kolom = 2;
		$nomor = 1;
		foreach($report as $m) {

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $m->id_contact)
				->setCellValue('C' . $kolom, $m->nama_contact)
				->setCellValue('D' . $kolom, $m->email_contact)
				->setCellValue('E' . $kolom, $m->action_report)
				->setCellValue('F' . $kolom, date('d-m-Y H:i', strtotime($m->tgl_report)));

			$kolom++;
			$nomor++;

		} 

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nama_file.'"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/dashboard/controllers/Dashboard.php */