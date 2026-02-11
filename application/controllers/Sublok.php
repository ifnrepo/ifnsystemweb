<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class Sublok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('dept_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('barangmodel');
        $this->load->model('bcmasukmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
        // require_once(APPPATH . 'libraries/Pdf.php');
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['title'] = 'Sub Lokasi';

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'sublok';
        $this->load->view('layouts/header', $header);
        $this->load->view('sublok/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    // public function cekkonfirmizin(){
    // 	$jenis = $_POST['jenis'];
    // 	$id = $_POST['id'];
    // 	$temp = $this->m_cuti->getdatadetailizin($id);
    // 	$hasil = $this->m_konfirm->konfirmizin($temp['jnizin'],$id)->result_array();
    // 	echo json_encode($hasil);
    // }

    // public function repizin(){
    // 	$head['act'] = 1;
    // 	$footer['footer'] = 'repkonfirm';
    // 	$data['judul'] = 'Data Konfirmasi Surat Izin';
    // 	$data['urltujuan'] = base_url().'konfirm/ubahtgl';
    // 	if(!$this->session->flashdata('tglizin')){
    // 		$this->session->set_flashdata('tglizin',date('d-m-Y'));
    // 	}else{
    // 		$this->session->set_flashdata('tglizin',$this->session->flashdata('tglizin'));
    // 	}
    // 	$data['datakonfirm'] = $this->m_konfirm->getdatakonfirm();
    // 	$this->load->view('page/header',$head);
    // 	$this->load->view('page/konfirmizinrep',$data);
    // 	$this->load->view('page/footer',$footer);
    // }

    // public function ubahtgl(){
    // 	$tgl = $_POST['tgl'];
    // 	$this->session->set_flashdata('tglizin',$tgl);
    // 	echo true;
    // }

    // public function kembali(){
    // 	$this->session->set_flashdata('pesan','qrcodeberhasil');
    // 	echo true;
    // }
}
