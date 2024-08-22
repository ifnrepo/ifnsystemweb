<?php
defined('BASEPATH') or exit('No direct script access allowed');

class grup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('grupmodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['grup'] = $this->grupmodel->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('grup/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('grup/add');
    }

    public function simpandata()
    {
        $data = [
            'nama_grup' => $_POST['nama_grup'],
        ];
        $hasil = $this->grupmodel->simpan($data);
        echo $hasil;
    }
    public function edit($id)
    {
        $data['data'] = $this->grupmodel->getdatabyid($id);
        $this->load->view('grup/edit', $data);
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nama_grup' => $_POST['nama_grup'],
        ];
        $hasil = $this->grupmodel->updatedata($data);
        echo $hasil;
    }
    public function hapus($id)
    {
        $hasil = $this->grupmodel->hapus($id);
        if ($hasil) {
            $url = base_url('grup');
            redirect($url);
        }
    }
}
