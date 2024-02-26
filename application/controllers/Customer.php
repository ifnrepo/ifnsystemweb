<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('customer_model');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['customer'] = $this->customer_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('customer/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('customer/addcustomer');
    }

    public function simpancustomer()
    {
        $data = [
            'kode_customer' => $_POST['kode_customer'],
            'nama_customer' => $_POST['nama_custumer'],
            'exdo' => $_POST['exdo'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'nama_customer' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan'],
        ];
        $hasil = $this->customer_model->simpancustomer($data);
        echo $hasil;
    }
    public function editcustomer($id)
    {

        $header['header'] = 'master';
        $data['data'] = $this->customer_model->getdatabyid($id);

        $this->form_validation->set_rules('kode_customer', 'Kode_customer', 'required');
        $this->form_validation->set_rules('nama_customer', 'Nama_customer', 'required');
        $this->form_validation->set_rules('exdo', 'Exdo', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('desa', 'Desa', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kab_kota', 'Kab_kota', 'required');
        $this->form_validation->set_rules('propinsi', 'Propinsi', 'required');
        $this->form_validation->set_rules('npwp', 'Npwp', 'required');
        $this->form_validation->set_rules('telp', 'Telp', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('kontak', 'Kontak', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('layouts/header', $header);
            $this->load->view('customer/editcustomer', $data);
            $this->load->view('layouts/footer');
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Update Data Gagal !</div>');
            redirect('');
        }
    }
    public function updatecostumer()
    {
        $data = [
            'id' => $_POST['id'],
            'kode_customer' => $_POST['kode_customer'],
            'nama_customer' => $_POST['nama_customer'],
            'exdo' => $_POST['exdo'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'nama_customer' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->costomer_model->updatecostumer($data);
        echo $hasil;
    }
    public function hapuscostomer($id)
    {
        $hasil = $this->costomer_model->hapuscostomer($id);
        if ($hasil) {
            $url = base_url() . 'costomer';
            redirect($url);
        }
    }

    public function viewcustomer($id)
    {
        $data['data'] = $this->customer_model->getdatabyid($id);
        $this->load->view('customer/viewcustomer', $data);
    }
}
