<?php
/**
 * 
 */
class Template {

	private $CI;
	protected $_ci;

    function __construct() {
        $this->CI =& get_instance();
        $this->_ci =& get_instance();
        $this->CI->load->helper('form');
    }

	function highadmin()
	{
		$data['css'] = 'template/css';
		$data['body'] = 'template/body';
		$data['javascript'] = 'template/javascript';
		return $data;
	}

	function _is_ajax()
    {
        if (!$this->CI->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    }

    function gnum($length)
    {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }

    function gstring($length)
    {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }

	function time_since($original)
	{
		date_default_timezone_set('Asia/Jakarta');
		$chunks = array(
		array(60 * 60 * 24 * 365, 'tahun'),
		array(60 * 60 * 24 * 30, 'bulan'),
		array(60 * 60 * 24 * 7, 'minggu'),
		array(60 * 60 * 24, 'hari'),
		array(60 * 60, 'jam'),
		array(60, 'menit'),
		);

		$today = time();
		$since = $today - $original;

		if ($since > 604800)
		{
		$print = date("M jS", $original);
		if ($since > 31536000)
		{
		$print .= ", " . date("Y", $original);
		}
		return $print;
		}

		for ($i = 0, $j = count($chunks); $i < $j; $i++)
		{
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		if (($count = floor($since / $seconds)) != 0)
		break;
		}

		$print = ($count == 1) ? '1 ' . $name : "$count {$name}";
		return $print . ' yang lalu';
	}

	function response($array=array())
	{
		echo json_encode($array);
		exit();
	}

}