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
        // $this->load->model('kategorimodel');
    }
	public function index()
	{  
        $header['header'] = 'master';
        $data['data'] = $this->barangmodel->getdata();
        $footer['footer'] = 'barang';
		$this->load->view('layouts/header',$header);
		$this->load->view('barang/barang',$data);
		$this->load->view('layouts/footer',$footer);
	}
    public function tambahdata(){
        $this->load->view('satuan/addsatuan');
    }
    public function simpansatuan(){
        $data = [
            'kodesatuan'=>$_POST['kode'],
            'namasatuan'=>$_POST['nama']
        ];
        $hasil = $this->satuanmodel->simpansatuan($data);
        echo $hasil;
    }
    public function editsatuan($id){
        $data['data'] = $this->satuanmodel->getdatabyid($id)->row_array();
        $this->load->view('satuan/editsatuan',$data);
    }
    public function updatesatuan(){
        $data = [
            'id'=>$_POST['id'],
            'kodesatuan'=>$_POST['kode'],
            'namasatuan'=>$_POST['nama']
        ];
        $hasil = $this->satuanmodel->updatesatuan($data);
        echo $hasil;
    }
    public function hapussatuan($id){
        $hasil = $this->satuanmodel->hapussatuan($id);
        if($hasil){
            $url = base_url().'satuan';
            redirect($url);
        }
    }
}
