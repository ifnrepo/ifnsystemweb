<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pb extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
    }
    public function index(){
        $header['header'] = 'transaksi';
        // $data['data'] = $this->barangmodel->getdata();
        $footer['fungsi'] = 'pb';
		$this->load->view('layouts/header',$header);
		$this->load->view('pb/pb');
		$this->load->view('layouts/footer',$footer);
    }
}