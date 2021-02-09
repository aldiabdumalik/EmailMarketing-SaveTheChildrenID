<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Contacts\GetContacts\GetContacts;

use Getresponse\Sdk\Operation\Contacts\DeleteContact\DeleteContact;
use Getresponse\Sdk\Operation\Contacts\DeleteContact\DeleteContactUrlQueryParameters;

// use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact;
use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Model\NewContact;

use Getresponse\Sdk\Operation\Model;
use Getresponse\Sdk\Operation\Contacts\UpdateContact\UpdateContact;

use Getresponse\Sdk\Operation\Campaigns\GetCampaigns\GetCampaigns;

// use Getresponse\Sdk\GetresponseClientFactory;
// use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Model\FromFieldReference;
use Getresponse\Sdk\Operation\Model\MessageContent;
use Getresponse\Sdk\Operation\Model\NewNewsletter;
use Getresponse\Sdk\Operation\Model\NewsletterSendSettings;
use Getresponse\Sdk\Operation\Newsletters\CreateNewsletter\CreateNewsletter;

class Test extends CI_Controller {

	public function index()
	{
		$getContactsOperation = new GetContacts();
		$client = GetresponseClientFactory::createWithApiKey('');
		$response = $client->call($getContactsOperation);

		// getData returns decoded data as an array
		$data = $response->getData();

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function create()
	{
		$createContact = new NewContact(
			new CampaignReference('KZkyX'),
			'123cadangan@gmail.com'
		);

		$createContactOperation = new CreateContact($createContact);
		$client = GetresponseClientFactory::createWithApiKey('');
		$response = $client->call($createContactOperation);

		if ($response->isSuccess()) {
			print 'OK';
		}
	}

	public function delete_con()
	{
		$params = [
			'name' => 1,
			'campaign' => [
				'campaignId' => 1
			],
			'email' => 1
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
				'X-Auth-Token: api-key ',
				'Content-Type: application/json'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}

	public function getcontact()
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
				'X-Auth-Token: api-key '
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$res = json_decode($response);
		foreach ($res as $r) {
			$data[] = [
				'id_contact' => $r->contactId,
				'nama_contact' => $r->name,
				'email_contact' => $r->email
			];
		}
		print_r($data);
	}

	public function client()
	{
		$client = GetresponseClientFactory::createWithApiKey('');
		$campaignsOperation = new GetCampaigns();
		$response = $client->call($campaignsOperation);
		print_r($response->getData());
	}

	public function send_email()
	{
		$body = file_get_contents('./uploads/landing/email_new.html');
		$client = GetresponseClientFactory::createWithApiKey('kus81o8u19comg0k0x51j1kijrucg6g7');

		$createNewsletterContent = new MessageContent();
		$createNewsletterContent->setHtml($body);
		// $createNewsletterContent->setPlain(uniqid('APIv3 PHP SDK test content - ', true));
		$createNewsletterSendSettings = new NewsletterSendSettings();
		$createNewsletterSendSettings->setSelectedContacts(array(
			// 'fBY9', 
			// 'fBVH', 
			// 'fBV0', 
			// 'fBYG', 
			// 'fBYi',
			// 'fBV1',
			// 'fBV4',
			// 'fBVQ',
			'fBV3'
		));

		$createNewsletter = new NewNewsletter(
			'Video Save the Children',
			new FromFieldReference('7'),
			new CampaignReference('jj'),
			$createNewsletterContent,
			$createNewsletterSendSettings
		);
		$createNewsletterOperation = new CreateNewsletter($createNewsletter);

		$response = $client->call($createNewsletterOperation);

		// print_r($response->getData());
		$req = $response->getData();
		$dataNl = [
			'id_nl' => $req['newsletterId'],
			'nama_nl' => $req['name'],
			'status_nl' => $req['sendMetrics']['status']
		];
		print_r($dataNl);
	}

	public function getawal()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.getresponse.com/v3/accounts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


		$headers = array();
		$headers[] = 'X-Auth-Token: api-key ';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		print_r($result);
	}

	public function get_contact()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.getresponse.com/v3/contacts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		$headers = array();
		$headers[] = 'X-Auth-Token: api-key ';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		print_r($result);
	}

	public function create_campign()
	{
		$form = [
			'name' => 'updutech111',
			'content' => [],
			'subject' => 'Annual report',
			'campaign' => [
			'	campaignId' => 'KZkyX'
			],
			'fromField' => [
				'fromFieldId' => 'aldiabdul341@gmail.com'
			],
			'replyTo' => [
				'fromFieldId' => 'aldiabdul341@gmail.com'
			],
			'sendSettings' => []
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
				'X-Auth-Token: api-key ',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$res = json_decode($response);
		if (!empty($res->campaignId)) {
			print_r($res->confirmation->fromField->fromFieldId);
		}
	}


	public function private_contoh()
	{
		echo $this->test123();
	}

	private function test123()
	{
		$search = array(' ', "'", '"', "%", "&", "+", "*", "!", "-");
		$aran = "Aldi Abdu Malik";
		$aran = str_replace($search, "", $aran);
		return strtolower($aran);
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */