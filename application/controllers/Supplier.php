<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('supplier_imodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['kategori'] = $this->supplier_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('supplier/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('supplier/addkategori');
    }

    public function simpansupplier()
    {
        $data = [
            'kategori_id' => $_POST['kategori_id'],
            'nama_kategori' => $_POST['nama_kategori']
        ];
        $hasil = $this->supplier_model->simpansupplier($data);
        echo $hasil;
    }
    // public function editkategori($id)
    // {
    //     // $data['data'] = $this->kategorimodel->getdatabyid($id)->row_array();
    //     $data['data'] = $this->kategorimodel->getdatabyid($id);
    //     $this->load->view('kategori/editkategori', $data);
    // }
    // public function updatekategori()
    // {
    //     $data = [
    //         'id' => $_POST['id'],
    //         'kategori_id' => $_POST['kategori_id'],
    //         'nama_kategori' => $_POST['nama_kategori']
    //     ];
    //     $hasil = $this->kategorimodel->updatekategori($data);
    //     echo $hasil;
    // }
    // public function hapuskategori($id)
    // {
    //     $hasil = $this->kategorimodel->hapuskaetgori($id);
    //     if ($hasil) {
    //         $url = base_url() . 'kategori';
    //         redirect($url);
    //     }
    // }
}
