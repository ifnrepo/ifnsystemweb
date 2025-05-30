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
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
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
        $data['kategori'] = $this->nettype_model->getdata_kategori();
        $this->load->view('nettype/addnettype', $data);
    }

    public function simpannettype()
    {
        $data = [
            'name_nettype' => $_POST['name_nettype'],
            'id_kategori' => $_POST['id_kategori'],
        ];
        $hasil = $this->nettype_model->simpannettype($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editnettype($id)
    {
        $data['data'] = $this->nettype_model->getdatabyid($id);
        $data['kategori'] = $this->nettype_model->getdata_kategori();
        $this->load->view('nettype/editnettype', $data);
    }
    public function updatenettype()
    {
        $data = [
            'id' => $_POST['id'],
            'name_nettype' => $_POST['name_nettype'],
        ];
        $hasil = $this->nettype_model->updatenettype($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusnettype($id)
    {
        $hasil = $this->nettype_model->hapusnettype($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('nettype');
            redirect($url);
        }
    }
}
