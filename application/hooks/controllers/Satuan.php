<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('helper_model','helpermodel');
    }
	public function index()
	{  
        $header['header'] = 'master';
        $data['data'] = $this->satuanmodel->getdata();
        $footer['footer'] = 'satuan';
		$this->load->view('layouts/header',$header);
		$this->load->view('satuan/satuan',$data);
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
        $this->helpermodel->isilog($this->db->last_query());
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
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapussatuan($id){
        $hasil = $this->satuanmodel->hapussatuan($id);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url().'satuan';
            redirect($url);
        }
    }
}
