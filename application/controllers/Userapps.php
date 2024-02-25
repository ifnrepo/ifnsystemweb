<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userapps extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
		'<script type="text/JavaScript">  
     			pesan("Test","error"); 
				alert("OKE");
     		</script>';
        $this->load->model('userappsmodel');
    }
	public function index()
	{
		$header['header'] = 'manajemen';
		$data['data'] = $this->userappsmodel->getdata();
		$this->load->view('layouts/header',$header);
		$this->load->view('userapps/userapps',$data);
		$this->load->view('layouts/footer');
	}
	public function hapusdata($id){
		$hasil = $this->userappsmodel->hapusdata($id);
		if($hasil){
			$url = base_url('userapps');
            redirect($url);
		}
	}
	public function tambahdata(){
		$header['header'] = 'manajemen';
		$data['action'] = base_url().'userapps/simpandata';
		$footer['fungsi'] = 'userapps';
		$this->load->view('layouts/header',$header);
		$this->load->view('userapps/adduserapps',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function editdata($id){
		$header['header'] = 'manajemen';
		$data['action'] = base_url().'userapps/updatedata';
		$data['user'] = $this->userappsmodel->getdatabyid($id)->row_array();
		$footer['fungsi'] = 'userapps';
		$this->load->view('layouts/header',$header);
		$this->load->view('userapps/edituserapps',$data);
		$this->load->view('layouts/footer',$footer);
	}
	public function simpandata(){
		$query = $this->userappsmodel->simpandata();
		if($query){
			$url = base_url('userapps');
            redirect($url);
		}
	}
	public function updatedata(){
		$query = $this->userappsmodel->updatedata();
		if($query){
			$url = base_url('userapps');
            redirect($url);
		}
	}
	public function viewuser($id){
		$data['user'] = $this->userappsmodel->getdatabyid($id)->row_array();
		$this->load->view('userapps/viewuser',$data);
	}
}
