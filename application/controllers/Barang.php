<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('barangmodel');
        $this->load->model('satuanmodel');
        $this->load->model('kategorimodel');
    }
	public function index()
	{  
        $header['header'] = 'master';
        $data['data'] = $this->barangmodel->getdata();
        $footer['fungsi'] = 'barang';
		$this->load->view('layouts/header',$header);
		$this->load->view('barang/barang',$data);
		$this->load->view('layouts/footer',$footer);
	}
    public function tambahdata(){
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['kode'] = time();
        $this->load->view('barang/addbarang',$data);
    }
    public function simpanbarang(){
        $data = [
            'kode'=>$_POST['kode'],
            'nama_barang'=>$_POST['nama'],
            'id_satuan'=>$_POST['sat'],
            'id_kategori'=>$_POST['kat'],
            'dln'=>$_POST['dln']
        ];
        $hasil = $this->barangmodel->simpanbarang($data);
        echo $hasil;
    }
    public function editbarang($id){
        $data['data'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $this->load->view('barang/editbarang',$data);
    }
    public function updatebarang(){
        $data = [
            'id'=>$_POST['id'],
            'kode'=>$_POST['kode'],
            'nama_barang'=>$_POST['nama'],
            'id_satuan'=>$_POST['sat'],
            'id_kategori'=>$_POST['kat'],
            'dln'=>$_POST['dln']
        ];
        $hasil = $this->barangmodel->updatebarang($data);
        echo $hasil;
    }
    public function hapusbarang($id){
        $hasil = $this->barangmodel->hapusbarang($id);
        if($hasil){
            $url = base_url().'barang';
            redirect($url);
        }
    }
    public function bombarang($id){
        $header['header'] = 'master';
        $data['detail'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['data'] = $this->barangmodel->getdatabom($id);
        $footer['fungsi'] = 'barang';
		$this->load->view('layouts/header',$header);
		$this->load->view('barang/bombarang',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function addbombarang($id){
        $data['barang'] = $this->barangmodel->getdata();
        $data['id_barang'] = $id; 
        $this->load->view('barang/addbombarang',$data);
    }
    public function simpanbombarang(){
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn']
        ];
        $hasil = $this->barangmodel->simpanbombarang($data);
        echo $hasil;
    }
    public function editbombarang($id){
        $data['barang'] = $this->barangmodel->getdata();
        $data['detail'] = $this->barangmodel->getdatabombyid($id)->row_array();
        $this->load->view('barang/editbombarang',$data);
    }
    public function updatebombarang(){
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn'],
            'id' => $_POST['id']
        ];
        $hasil = $this->barangmodel->updatebombarang($data);
        echo $hasil;
    }
    public function hapusbombarang($id,$idb){
        $hasil = $this->barangmodel->hapusbombarang($id);
        if($hasil){
            $url = base_url().'barang/bombarang/'.$idb;
            redirect($url);
        }
    }
}
