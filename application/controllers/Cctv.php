<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cctv extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        // $this->load->model('personilmodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('helper_model','helpermodel');
    }
	public function index()
	{
        $header['header'] = 'other';
		$this->load->view('layouts/header',$header);
		$this->load->view('cctv/cctv');
        $footer['fungsi'] = 'cctv';
		$this->load->view('layouts/footer',$footer);
	}
}
