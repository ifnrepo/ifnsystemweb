<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lockinv extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Personilmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('lockinvmodel');

        $this->load->library('upload');
    }
    public function index()
    {
        $header['header'] = 'manajemen';
        $data['lock'] = $this->lockinvmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'lockinv';
        $this->load->view('layouts/header', $header);
        $this->load->view('lockinv/lockinv', $data);
        $this->load->view('layouts/footer',$footer);
    }
    public function tambahdata()
    {
        $data['deptx'] = $this->lockinvmodel->getdept();
        $this->load->view('lockinv/add_lock',$data);
    }
    public function tambah(){
        $data = [
            'dept_id' => $_POST['dept'],
            'periode' => kodebulan($_POST['bulan']).$_POST['tahun'],
            'dibuat_oleh' => $this->session->userdata('id')
        ];
        $query = $this->lockinvmodel->tambah($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $query;
    }
    public function hapusdata($id)
    {
        $hasil = $this->lockinvmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('lockinv');
            redirect($url);
        }
    }
    public function saktosaw($periode){
        $hasil = $this->lockinvmodel->saktosaw($periode);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('lockinv');
            redirect($url);
        }
    }
    public function clear(){
        $this->session->unset_userdata('bllock');
        $this->session->set_userdata('thlock',date('Y'));
        $url = base_url().'lockinv';
        redirect($url);
    }
    public function setperiode(){
        $bl = $_POST['bl']=='all' ? 'all' : ($_POST['bl'] < 9 ? '0'.$_POST['bl'] : $_POST['bl']);
        $th = $_POST['th'];
        $this->session->set_userdata('bllock',$bl);
        $this->session->set_userdata('thlock',$th);
        echo 1;
    }
    // End Model
}
