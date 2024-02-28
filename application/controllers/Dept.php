<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dept extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('dept_model');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['dept'] = $this->dept_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('dept/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('dept/add_dept');
    }

    public function simpandept()
    {
        $data = [
            'dept_id' => strtoupper($_POST['dept_id']),
            'departemen' => strtoupper($_POST['departemen'])
        ];
        $hasil = $this->dept_model->simpandept($data);
        echo $hasil;
    }
    public function editdept($dept_id)
    {
        $data['data'] = $this->dept_model->getdatabyid($dept_id);
        $this->load->view('dept/edit_dept', $data);
    }
    public function updatedept()
    {
        $data = [
            'dept_id' => strtoupper($_POST['dept_id']),
            'departemen' => strtoupper($_POST['departemen'])
        ];
        $hasil = $this->dept_model->updatedept($data);
        echo $hasil;
    }
    public function hapusdept($dept_id)
    {
        $hasil = $this->dept_model->hapusdept($dept_id);
        if ($hasil) {
            $url = base_url('dept');
            redirect($url);
        }
    }
}
