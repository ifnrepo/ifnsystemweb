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
        $this->load->model('sublokmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
        // require_once(APPPATH . 'libraries/Pdf.php');
    }

    public function index()
    {
        $header['header'] = 'sublok';
        $data['title'] = 'Add Data Sub Lokasi';
        $data['deptlokasi'] = $this->sublokmodel->getdeplokasi();
        $data['lokasi'] = $this->sublokmodel->getlokasi();
        $data['data'] = $this->sublokmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'sublok';
        $this->load->view('layouts/header', $header);
        $this->load->view('sublok/index', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $this->session->set_userdata('blsublok',date('m'));
        $this->session->set_userdata('thsublok',date('Y'));
        $this->session->unset_userdata('deptsublok');
        $this->session->unset_userdata('sublokasi');
        $url = base_url().'sublok';
        redirect($url);
    }
    public function getdata(){
        $dept = $_POST['dept'];
        $bl = $_POST['bulan'];
        $th = $_POST['tahun'];
        if($dept!=''){
            $this->session->set_userdata('deptsublok',$dept);
        }
        $this->session->unset_userdata('sublokasi');
        $this->session->set_userdata('blsublok',$bl);
        $this->session->set_userdata('thsublok',$th);
        echo 1;
    }
    public function filterdata(){
        $sub = $_POST['sub'];
        $this->session->set_userdata('sublokasi',$sub);
        echo 1;
    }
    public function adddata($id){
        $hasil = $this->sublokmodel->adddata($id);
        if($hasil){
            $url = base_url().'sublok/inputdata/'.$hasil;
            redirect($url);
        }
    }
    public function inputdata($id){
        $header['header'] = 'sublok';
        $data['title'] = 'Input Data Sub Lokasi';
        $data['header'] = $this->sublokmodel->getdatabyid($id);
        $data['data'] = $this->sublokmodel->getdatadetail($id);
        $data['lokasi'] = $this->sublokmodel->getlokasi();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'sublok';
        $this->load->view('layouts/header', $header);
        $this->load->view('sublok/inputdata', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusdata($id){
        $data = $this->sublokmodel->hapusdata($id);
        if($data){
            $url = base_url().'sublok';
            redirect($url);
        }
    }
    public function scandata($id){
        $header['header'] = 'sublok';
        $data['title'] = 'Add Data';
        $data['header'] = $this->sublokmodel->getdatabyid($id);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'sublok';
        $this->load->view('layouts/header', $header);
        $this->load->view('sublok/adddata', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function inimasukdata(){
        $insno = $_POST['insno'];
        $lot = $_POST['lot'];
        $jlr = $_POST['jlr'];
        $po = [];
        $data = $this->sublokmodel->cekmasukdata($insno);
        foreach($data->result_array() as $dt){
           $po[] = array('po' => $dt['po'],'item' => $dt['item'],'dis' =>$dt['dis']);
        }
        // $datapo = array()
        $cocok = array('datapo' => $po);
        echo json_encode($cocok);
        // echo $cocok;
    }
    public function pilihpo($insno){
        $datains = str_replace('@','-',str_replace('-',' ',$insno));
        $data['data'] = $this->sublokmodel->cekmasukdata($datains);
        $this->load->view('sublok/pilihpo', $data);
    }
    public function tambahketemp(){
        $data = [
            'ind' => $_POST['ind'],
            'id' => $_POST['id'],
            'lot' => $_POST['lot'],
            'jalur' => $_POST['jlr'],
            'insno' => $_POST['ins']
        ];

        $hasil = $this->sublokmodel->tambahketemp($data);
        echo $hasil;
    }
    public function hapusdettemp($id){
        $db = $this->sublokmodel->hapusdettemp($id);
        $url = base_url().'sublok/scandata/'.$db;
        redirect($url);
    }
    public function getdatatemp(){
        $html = '';
        $id = $_POST['id_header'];
        $datatemp = $this->sublokmodel->getdatatemp($id);
        if($datatemp->num_rows() > 0){
            // $hasiltemp = $datatemp->row_array();
            $no=1;
            foreach($datatemp->result_array() as $hsl){
                $dis = $hsl['dis']!=0 ? ' dis '.$hsl['dis'] : '';
                $html .= '<tr>';
                $html .= '<td>'.$no++.'</td>';
                $html .= '<td class="line-12">'.$hsl["po"].'#'.$hsl["item"].$dis.'<br><span class="font-kecil text-cyan">'.$hsl["insno"].'</span></td>';
                $html .= '<td>'.$hsl['lot'].'-'.$hsl['jalur'].'</td>';
                $html .= '<td>1</td>';
                $html .= '<td><a href="'.base_url().'sublok/hapusdettemp/'.$hsl['id'].'" class="btn btn-sm btn-danger">Hapus</a></td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '<tr>';
            $html .= '<td colspan="5" class="text-center">Data Kosong</td>';
            $html .= '</tr>';
        }

        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function simpantempkeasli($id){
        $data = $this->sublokmodel->simpantempkeasli($id);
        if($data){
            $url = base_url().'sublok/inputdata/'.$id;
            redirect($url);
        }
    }
    public function hapusinputdata($id,$head){
        $data = $this->sublokmodel->hapusinputdata($id,$head);
        if($data){
            $url = base_url().'sublok/inputdata/'.$head;
            redirect($url);
        }
    }
    public function simpandata($id){
        $data = $this->sublokmodel->simpandata($id);
        if($data){
            $url = base_url().'sublok';
            redirect($url);
        }
    }
    public function viewdetail($id){
        $data['header'] = $this->sublokmodel->getdatabyid($id);
        $data['data'] = $this->sublokmodel->getdatadetail($id);
        $this->load->view('sublok/viewdetail', $data);
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
