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
        $this->load->model('dept_model','deptmodel');
    }
    public function index(){
        $header['header'] = 'transaksi';
        // $data['data'] = $this->barangmodel->getdata();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $footer['fungsi'] = 'pb';
		$this->load->view('layouts/header',$header);
		$this->load->view('pb/pb',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function tambahdata(){
        $this->load->view('pb/add_pb');
    }
}