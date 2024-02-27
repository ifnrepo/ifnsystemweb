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
            'nama_customer' => $_POST['nama_customer'],
            'exdo' => $_POST['exdo'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->customer_model->simpancustomer($data);
        echo $hasil;
    }

    public function editcustomer($id)
    {

        $header['header'] = 'master';
        $data['data'] = $this->customer_model->getdatabyid($id);
        // $this->load->view('layouts/header', $header);
        $this->load->view('customer/editcustomer', $data);
        // $this->load->view('layouts/footer');
    }
    public function updatecustomer()
    {
        $data = [
            'id' => $_POST['id'],
            'kode_customer' => $_POST['kode_customer'],
            'nama_customer' => $_POST['nama_customer'],
            'exdo' => $_POST['exdo'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->customer_model->updatecustomer($data);
        // if ($hasil) {
        //     $this->session->set_flashdata('pesan', ' <div class="alert alert-success" role="alert"> Data  berhasil diperbarui.');
        // } else {
        //     $this->session->set_flashdata('pesan', ' <div class="alert alert-danger" role="alert"> Gagal memperbarui data ');
        // }
        //redirect('customer');
        echo $hasil;
    }

    public function hapuscustomer($id)
    {
        $hasil = $this->customer_model->hapuscustomer($id);
        if ($hasil) {
            $url = base_url() . 'customer';
            redirect($url);
        }
    }

    public function viewcustomer($id)
    {
        $data['data'] = $this->customer_model->getdatabyid($id);
        $this->load->view('customer/viewcustomer', $data);
    }
}
