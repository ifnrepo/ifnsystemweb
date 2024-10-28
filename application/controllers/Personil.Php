<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personil extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Personilmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->library('upload');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['personil'] = $this->Personilmodel->getdata();
        $data['dept_options'] = $this->Personilmodel->getFilter();
        $footer['fungsi'] = 'personil';
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    // public function filter()
    // {
    //     $filter = $this->input->post('filter');

    //     if ($filter == 'all') {
    //         $data['personil'] = $this->Personilmodel->getdata();
    //     } else {
    //         $data['personil'] = $this->Personilmodel->getdataByFilter($filter);
    //     }
    //     $header['header'] = 'master';
    //     $this->load->view('layouts/header', $header);
    //     $this->load->view('personil/index', $data);
    //     $this->load->view('layouts/footer');
    // }


    public function tambahdata()

    {
        $header['header'] = 'master';
        $data['jabatan'] = $this->db->get('jabatan')->result_array();
        $data['grups'] = $this->db->get('grup')->result_array();
        $data['dept'] = $this->db->get('dept')->result_array();
        $data['agama'] = $this->db->get('tb_agama')->result_array();
        $data['pendidikan'] = $this->db->get('tb_pendidikan')->result_array();
        $data['status'] = $this->db->get('tb_status')->result_array();
        $data['action'] = base_url() . 'personil/simpandata';
        $footer['fungsi'] = 'personil';
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/add', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function uploadfoto()
    {
        $this->Personilmodel->upload_foto();
    }

    public function simpandata()
    {
        $query = $this->Personilmodel->simpandata();
        $this->helpermodel->isilog($this->db->last_query());
        if ($query) {
            $url = base_url('personil');
            redirect($url);
        }
    }

    public function edit($personil_id)
    {
        $header['header'] = 'master';
        $data['jabatan'] = $this->db->get('jabatan')->result_array();
        $data['grups'] = $this->db->get('grup')->result_array();
        $data['dept'] = $this->db->get('dept')->result_array();
        $data['agama'] = $this->db->get('tb_agama')->result_array();
        $data['pendidikan'] = $this->db->get('tb_pendidikan')->result_array();
        $data['status'] = $this->db->get('tb_status')->result_array();
        $data['personil'] = $this->Personilmodel->getdatabyid($personil_id)->row_array();

        $data['actionfoto'] = base_url() . 'personil/updatefoto';
        $data['actionkolom'] = base_url() . 'personil/updatedata/' . $personil_id;
        $footer['fungsi'] = 'personil';
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/edit', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function updatefoto()
    {
        $this->Personilmodel->updatefoto_baru();
    }


    public function updatedata()
    {
        $query = $this->Personilmodel->updatedata();
        $this->helpermodel->isilog($this->db->last_query());
        if ($query) {
            $url = base_url('personil');
            redirect($url);
        }
    }

    public function hapusdata($personil_id)
    {
        $hasil = $this->Personilmodel->hapus($personil_id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('personil');
            redirect($url);
        }
    }

    public function view($personil_id)
    {
        $data['jabatan'] = $this->db->get('jabatan')->result_array();
        $data['grups'] = $this->db->get('grup')->result_array();
        $data['dept'] = $this->db->get('dept')->result_array();
        $data['agama'] = $this->db->get('tb_agama')->result_array();
        $data['pendidikan'] = $this->db->get('tb_pendidikan')->result_array();
        $data['status'] = $this->db->get('tb_status')->result_array();
        $data['personil'] = $this->Personilmodel->getdatabyid($personil_id)->row_array();
        $this->load->view('personil/viewpersonil', $data);
    }
}
