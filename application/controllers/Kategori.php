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
        $this->load->model('kategorimodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('helper_model','helpermodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['kategori'] = $this->kategorimodel->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('kategori/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('kategori/addkategori');
    }

    public function simpankategori()
    {
        $data = [
            'kategori_id' => $_POST['kategori_id'],
            'nama_kategori' => $_POST['nama_kategori']
        ];
        $hasil = $this->kategorimodel->simpankategori($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editkategori($id)
    {
        // $data['data'] = $this->kategorimodel->getdatabyid($id)->row_array();
        $data['data'] = $this->kategorimodel->getdatabyid($id);
        $this->load->view('kategori/editkategori', $data);
    }
    public function updatekategori()
    {
        $data = [
            'id' => $_POST['id'],
            'kategori_id' => $_POST['kategori_id'],
            'nama_kategori' => $_POST['nama_kategori']
        ];
        $hasil = $this->kategorimodel->updatekategori($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapuskategori($id)
    {
        $hasil = $this->kategorimodel->hapuskategori($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'kategori';
            redirect($url);
        }
    }
}
