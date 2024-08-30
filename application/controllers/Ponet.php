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
        $this->load->helper('ifn_helper');
    }

    public function index()
    {
        $header['header'] = 'manajemen';
        $po = trim($this->input->post('keyword'));
        $buy = $this->input->post('kategori');
        $checked = $this->input->post('checked');
        $data['po'] = [];

        // cek key ,kategori,cheked
        if (!empty($po) && !empty($buy) || !empty($checked)) {
            $results = $this->Ponet_model->cariData($po, $buy, $checked);

            if ($results) {
                foreach ($results as &$result) {
                    $result['lim'] = limit_date($result['lim']);
                }
                $data['po'] = $results;
            } else {
                $data['message'] = 'Data tidak ditemukan.';
            }
        }

        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index', $data);
        $this->load->view('layouts/footer');
    }

    public function view($id)
    {
        $header['header'] = 'manajemen';
        $data['detail'] = $this->Ponet_model->GetDataByid($id);

        if ($data['detail']) {
            $data['detail']['lim'] = limit_date($data['detail']['lim']);
        }

        $this->load->view('ponet/detail', $data);
    }
}
