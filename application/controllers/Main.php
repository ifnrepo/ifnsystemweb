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
        $this->load->model('taskmodel');
        $this->load->model('userappsmodel','usermodel');
    }
	public function index()
	{
        $dataproduksi = $this->helpermodel->dataproduksi();
        $kurshariini = $this->helpermodel->getkurssekarang(date('Y-m-d'))->row_array();
        $datakurs = $this->helpermodel->getkurs30hari();
        $datapersonlogin = $this->helpermodel->getpersonloginpermonth(date('Y-m-d'));
		$this->load->view('layouts/header');
        $data['dataproduksi'] = $dataproduksi;
        $data['kurshariini'] = $kurshariini;
        $data['personlogin'] = $datapersonlogin;
		$this->load->view('main',$data);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'main';
        $footer['dataproduksi'] = $dataproduksi;
        $footer['datakurs'] = $datakurs;
        $footer['personlogin'] = $datapersonlogin;
		$this->load->view('layouts/footer',$footer);
	}
    public function ceknotif(){
        $jumlah = $this->taskmodel->getuntukvalidasi();
        echo $jumlah;
    }
}
