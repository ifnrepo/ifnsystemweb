<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('supplier_model');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['supplier'] = $this->supplier_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('supplier/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('supplier/addsupplier');
    }

    public function simpansupplier()
    {
        $data = [
            'kode' => $_POST['kode'],
            'nama_supplier' => $_POST['nama_supplier'],
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
            'jabatan' => $_POST['jabatan'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->supplier_model->simpansupplier($data);
        echo $hasil;
    }
    public function editsupplier($id)
    {

        $header['header'] = 'master';
        $data['data'] = $this->supplier_model->getdatabyid($id);
        // $this->load->view('layouts/header', $header);
        $this->load->view('supplier/editsupplier', $data);
        // $this->load->view('layouts/footer');
    }
    public function updatesupplier()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'nama_supplier' => $_POST['nama_supplier'],
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
            'jabatan' => $_POST['jabatan'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->supplier_model->updatesupplier($data);
        echo $hasil;
    }

    public function hapussupplier($id)
    {
        $hasil = $this->supplier_model->hapussupplier($id);
        if ($hasil) {
            $url = base_url() . 'supplier';
            redirect($url);
        }
    }

    public function viewsupplier($id)
    {
        $data['data'] = $this->supplier_model->getdatabyid($id);
        $this->load->view('supplier/viewsupplier', $data);
    }
}
