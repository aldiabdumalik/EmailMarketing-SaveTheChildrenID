<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Model\FromFieldReference;
use Getresponse\Sdk\Operation\Model\MessageContent;
use Getresponse\Sdk\Operation\Model\NewNewsletter;
use Getresponse\Sdk\Operation\Model\NewsletterSendSettings;
use Getresponse\Sdk\Operation\Newsletters\CreateNewsletter\CreateNewsletter;
class Sendmail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged_in !== true) {
			redirect('login.html','refresh');
		}
		$this->load->library('Template');
		$this->load->model([
			'M_sendmail' => 'model',
			'DataTables' => 'datatables'
		]);
	}

	public function index()
	{
		$req = $this->model->count_page();
		if (!empty($req)) {
			$page = ceil(count($req)/20);
		}else{
			$page = 0;
		}
		$data_1 = $this->template->highadmin();
		$data_2 = [
			'title' => 'Send Email',
			'content' => 'sendmail',
			'js' => 'sendmail',
			'page' => $page
		];
		$data = array_merge($data_1, $data_2);
		$this->load->view('template/template', $data);
	}

	public function kontak_perpage()
	{
		$req = $this->model->get_kontak_page($this->input->get('page'));
		if (!empty($req)) {
			$this->template->response([
				'status' => true,
				'data' => $req
			]);
		}else{
			$this->template->response([
				'status' => false,
				'message' => 'Belum ada kontak, silahkan lakukan import terlebih dahulu'
			]);
		}
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

	public function sendmail_post()
	{
		$post = file_get_contents('php://input');
		$post = json_decode($post);
		$kontak = array();
		$req = $this->model->get_kontak_all();
		if (!empty($req)) {
			foreach ($req as $k) {
				$kontak[] = $k->id_contact;
			}

			$body = file_get_contents('./uploads/landing/email_new.html');
			$client = GetresponseClientFactory::createWithApiKey('your api-key');
			$createNewsletterContent = new MessageContent();
			$createNewsletterContent->setHtml($body);
			$createNewsletterSendSettings = new NewsletterSendSettings();
			$createNewsletterSendSettings->setSelectedContacts($kontak);

			$createNewsletter = new NewNewsletter(
				$post->subject,
				new FromFieldReference('7'),
				new CampaignReference($this->session->myid),
				$createNewsletterContent,
				$createNewsletterSendSettings
			);
			$createNewsletterOperation = new CreateNewsletter($createNewsletter);
			$response = $client->call($createNewsletterOperation);
			$req = $response->getData();
			$dataNl = [
				'id_nl' => $req['newsletterId'],
				'id_campaign' => $this->session->myid,
				'id_users' => $this->session->myid,
				'nama_nl' => $req['name'],
				'status_nl' => $req['sendMetrics']['status'],
				'dikirim_nl' => date('Y-m-d H:i:s')
			];
			$this->db->insert('newsletter', $dataNl);
			$this->template->response([
				'status' => true,
				'message' => 'Pengiriman berhasil...'
			]);
		}else{
			$this->template->response([
				'status' => false,
				'data' => $kontak,
				'message' => 'Pengiriman gagal...'
			]);
		}
	}

}

/* End of file Sendmail.php */
/* Location: ./application/modules/sendmail/controllers/Sendmail.php */