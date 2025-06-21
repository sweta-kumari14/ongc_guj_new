<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Unauthorised_c extends MY_Controller {

 	public function __construct()
 	{
 		parent:: __construct();
 	}

	public function index()
	{
		$this->load->view('unauthorised_view');
	}
}
?>