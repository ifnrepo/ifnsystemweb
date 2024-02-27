<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nettype extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('nettype_model');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['nettype'] = $this->nettype_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('nettype/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('nettype/addnettype');
    }

    public function simpannettype()
    {
        $data = [
            'name_nettype' => $_POST['name_nettype'],
        ];
        $hasil = $this->nettype_model->simpannettype($data);
        echo $hasil;
    }
    public function editnettype($id)
    {
        $data['data'] = $this->nettype_model->getdatabyid($id);
        $this->load->view('nettype/editnettype', $data);
    }
    public function updatenettype()
    {
        $data = [
            'id' => $_POST['id'],
            'name_nettype' => $_POST['name_nettype'],
        ];
        $hasil = $this->nettype_model->updatenettype($data);
        echo $hasil;
    }
    public function hapusnettype($id)
    {
        $hasil = $this->nettype_model->hapusnettype($id);
        if ($hasil) {
            $url = base_url('nettype');
            redirect($url);
        }
    }
}
