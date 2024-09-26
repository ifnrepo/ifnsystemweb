<?php
defined('BASEPATH') or exit('No direct script access allowed');

class jabatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('jabatanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['jabatan'] = $this->jabatanmodel->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('jabatan/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('jabatan/add');
    }

    public function simpandata()
    {
        $data = [
            'nama_jabatan' => $_POST['nama_jabatan'],
            'nojab' => $_POST['nojab'],
        ];
        $hasil = $this->jabatanmodel->simpan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function edit($id)
    {
        $data['data'] = $this->jabatanmodel->getdatabyid($id);
        $this->load->view('jabatan/edit', $data);
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nama_jabatan' => $_POST['nama_jabatan'],
            'nojab' => $_POST['nojab'],
        ];
        $hasil = $this->jabatanmodel->updatedata($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapus($id)
    {
        $hasil = $this->jabatanmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('jabatan');
            redirect($url);
        }
    }
}
