<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ref_dokumen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('refdokumen_model');
        // $this-load->model('refdokumen_model)
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['refdok'] = $this->refdokumen_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('refdok/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('refdok/addrefdok');
    }

    public function simpanrefdok()
    {
        $data = [
            'kode' => $_POST['kode'],
            'ins' => $_POST['ins'],
            'nama_dokumen' => $_POST['nama_dokumen'],
        ];
        $hasil = $this->refdokumen_model->simpanrefdok($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editrefdok($kode)
    {
        $data['data'] = $this->refdokumen_model->getdatabyid($kode);
        $this->load->view('refdok/editrefdok', $data);
    }
    public function updaterefdok()
    {
        $data = [
            'kode' => $_POST['kode'],
            'ins' => $_POST['ins'],
            'nama_dokumen' => $_POST['nama_dokumen']
        ];
        $hasil = $this->refdokumen_model->updaterefdok($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusrefdok($kode)
    {
        $hasil = $this->refdokumen_model->hapusrefdok($kode);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('ref_dokumen');
            redirect($url);
        }
    }
}
