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
        if ($this->session->userdata('statTgl') == "") {
            $date = date('Y-m-d');
            $this->session->set_userdata('tglmonbcawal', strtotime('-30 day', strtotime($date)));
            $this->session->set_userdata('tglmonbcakhir', strtotime('0 day', strtotime($date)));
        }
        $dataproduksi = $this->helpermodel->dataproduksi();
        $kurshariini = $this->helpermodel->getkurssekarang(date('Y-m-d'))->row_array();
        $datakurs = $this->helpermodel->getkurs30hari();
        $datapersonlogin = $this->helpermodel->getpersonloginpermonth(date('Y-m-d'));
        $datajumlahbc = $this->helpermodel->getdatabc2bulan();
		$this->load->view('layouts/header');
        $data['dataproduksi'] = $dataproduksi;
        $data['kurshariini'] = $kurshariini;
        $data['personlogin'] = $datapersonlogin;
        $data['bc2bulan'] = $datajumlahbc;
		$this->load->view('main',$data);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'main';
        $footer['dataproduksi'] = $dataproduksi;
        $footer['datakurs'] = $datakurs;
        $footer['personlogin'] = $datapersonlogin;
        $footer['bc2bulan'] = $datajumlahbc;
		$this->load->view('layouts/footer',$footer);
	}
    public function ceknotif(){
        if ($this->session->userdata('getinifn') == "") {
            echo 99999;
        }else{
            $jumlah = $this->taskmodel->getuntukvalidasi();
            echo $jumlah;
        }
    }
    public function settglmonitoring(){
        $tglawal = tglmysql($_POST['tglawal']);
        $tglakhir = tglmysql($_POST['tglakhir']);
        if(jumlahhari($tglawal,$tglakhir)==9999){
            $this->session->unset_userdata('statTgl');
            $this->session->set_flashdata('errortanggalbcmon','Tanggal akhir BC harus lebih besar daripada Tanggal awal BC');
        }else{
            $this->session->set_userdata('tglmonbcawal', strtotime('0 day', strtotime($tglawal)));
            $this->session->set_userdata('tglmonbcakhir', strtotime('0 day', strtotime($tglakhir)));
            $this->session->set_userdata('statTgl',1);
        }
        echo 1;
    }
    public function resettglmonitoring(){
        $this->session->unset_userdata('statTgl');
        $url = base_url('Main');
        redirect($url);
    }
}
