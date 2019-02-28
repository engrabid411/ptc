<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
	    $this->load->model('Login_model');
   	}
	public function index()
	{
		
		$this->load->view('login');

	}

	
	public function doLogin()
	{
		$this->Login_model->validateuser('abid@gmail.com','marwat',1);
	}

}
