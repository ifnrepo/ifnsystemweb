<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_dept extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('kategori_dept_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['kategori_departemen'] = $this->kategori_dept_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('kategori_dept/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('kategori_dept/add_kategori_dept');
    }

    public function simpan()
    {
        $data = [
            'nama' => $_POST['nama']
        ];
        $hasil = $this->kategori_dept_model->simpan_kategdept($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function edit($id)
    {
        $data['data'] = $this->kategori_dept_model->getdatabyid($id);
        $this->load->view('kategori_dept/edit_kategori_dept', $data);
    }
    public function update_kategdept()
    {
        $data = [
            'id' => $_POST['id'],
            'nama' => $_POST['nama']
        ];
        $hasil = $this->kategori_dept_model->update_kategdept($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapus($id)
    {
        $hasil = $this->kategori_dept_model->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('kategori_dept');
            redirect($url);
        }
    }
}
