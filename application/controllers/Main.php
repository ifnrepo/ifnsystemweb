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
        $this->load->model('helper_model','helpermodel');
    }
	public function index()
	{
        $dataproduksi = $this->helpermodel->dataproduksi();
		$this->load->view('layouts/header');
        $data['dataproduksi'] = $dataproduksi;
		$this->load->view('main',$data);
        $footer['fungsi'] = 'main';
        $footer['dataproduksi'] = $dataproduksi;
		$this->load->view('layouts/footer',$footer);
	}
}
