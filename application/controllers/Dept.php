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
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
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
        $data['katedept'] = $this->dept_model->getdatakatedept();
        $this->load->view('dept/add_dept', $data);
    }

    public function simpandept()
    {
        $data = [
            'dept_id' => strtoupper($_POST['dept_id']),
            'departemen' => strtoupper($_POST['departemen']),
            'katedept_id' => strtoupper($_POST['kat']),
            'pb' => $_POST['pb'],
            'bbl' => $_POST['bbl'],
            'adj' => $_POST['adj']
        ];
        $hasil = $this->dept_model->simpandept($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    // public function editdept($dept_id)
    // {
    //     $data['data'] = $this->dept_model->getdatabyid($dept_id);
    //     $data['katedept'] = $this->dept_model->getdatakatedept();
    //     $this->load->view('dept/edit_dept', $data);
    // }

    public function edit_new($dept_id)
    {
        $header['header'] = 'master';
        $data['action'] = base_url() . 'dept/updatedata';
        $data['data'] = $this->dept_model->getdatabyid($dept_id);
        $data['departemen'] = $this->dept_model->getdata();
        $data['katedept'] = $this->dept_model->getdatakatedept();
        $footer['fungsi'] = 'dept';

        $this->load->view('layouts/header', $header);
        $this->load->view('dept/edit_new', $data);
        $this->load->view('layouts/footer', $footer);
    }
    // public function updatedept()
    // {
    //     $data = [
    //         'dept_id' => strtoupper($_POST['dept_id']),
    //         'departemen' => strtoupper($_POST['departemen']),
    //         'katedept_id' => strtoupper($_POST['kat']),
    //         'pb' => $_POST['pb'],
    //         'bbl' => $_POST['bbl'],
    //         'adj' => $_POST['adj']
    //     ];
    //     $hasil = $this->dept_model->updatedept($data);
    //     echo $hasil;
    // }

    public function updatedata()
    {
        $query = $this->dept_model->updatedata();
        $this->helpermodel->isilog($this->db->last_query());
        if ($query) {
            $url = base_url('dept');
            redirect($url);
        }
    }
    public function hapusdept($dept_id)
    {
        $hasil = $this->dept_model->hapusdept($dept_id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('dept');
            redirect($url);
        }
    }

    public function view($dept_id)
    {
        $data['dept'] = $this->dept_model->getdatabyid($dept_id);
        $this->load->view('dept/view', $data);
    }
}
