<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        // $this->load->model('personilmodel');
        // $this->load->model('usermodel');
    }
	public function index()
	{
		$this->load->view('layouts/header');
		$this->load->view('main');
		$this->load->view('layouts/footer');
	}
}
