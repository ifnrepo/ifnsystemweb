<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ponet extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Ponet_model');
    }

    public function index()
    {
        $header['header'] = 'manajemen';
        $po = trim($this->input->post('keyword'));
        $data['po'] = [];

        if (!empty($po)) {
            $data['po'] = $this->Ponet_model->cariData($po);
        }

        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index', $data);
        $this->load->view('layouts/footer');
    }

    public function view($id)
    {
        $header['header'] = 'manajemen';
        $data['detail'] = $this->Ponet_model->GetDataByid($id);

        $this->load->view('ponet/detail', $data);
    }
}
