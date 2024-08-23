<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userapps extends CI_Controller
{
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
		$this->load->model('dept_model', 'deptmodel');
		$this->load->model('userappsmodel','usermodel');
		$this->load->model('helper_model', 'helpermodel');
	}
	public function index()
	{
		$header['header'] = 'manajemen';
		$data['data'] = $this->userappsmodel->getdata();
		$this->load->view('layouts/header', $header);
		$this->load->view('userapps/userapps', $data);
		$this->load->view('layouts/footer');
	}
	public function hapusdata($id)
	{
		$hasil = $this->userappsmodel->hapusdata($id);
		if ($hasil) {
			$url = base_url('userapps');
			redirect($url);
		}
	}
	public function tambahdata()
	{
		$header['header'] = 'manajemen';
		$data['action'] = base_url() . 'userapps/simpandata';
		$data['data'] = $this->userappsmodel->getdata();
		$data['daftardept'] = $this->deptmodel->getdata();
		$data['jmldept'] = $this->deptmodel->jmldept();
		$data['deptpb'] = $this->deptmodel->getdata_dept_pb();
		$data['dept'] = $this->db->order_by('departemen')->get('dept')->result_array();
		$data['level'] = $this->db->get('level_user')->result_array();
		$data['jabat'] = $this->db->get('jabatan')->result_array();
		$footer['fungsi'] = 'userapps';
		$this->load->view('layouts/header', $header);
		$this->load->view('userapps/adduserapps', $data);
		$this->load->view('layouts/footer', $footer);
	}
	public function editdata($id)
	{
		$header['header'] = 'manajemen';
		$data['action'] = base_url() . 'userapps/updatedata';
		$data['user'] = $this->userappsmodel->getdatabyid($id)->row_array();
		$data['daftardept'] = $this->deptmodel->getdata();
		$data['jmldept'] = $this->deptmodel->jmldept();
		$data['deptpb'] = $this->deptmodel->getdata_dept_pb();
		$data['level'] = $this->db->get('level_user')->result_array();
		$data['dept'] = $this->db->order_by('departemen')->get('dept')->result_array();
		$data['jabat'] = $this->db->get('jabatan')->result_array();
		$footer['fungsi'] = 'userapps';
		$this->load->view('layouts/header', $header);
		$this->load->view('userapps/edituserapps', $data);
		$this->load->view('layouts/footer', $footer);
	}
	public function simpandata()
	{
		$query = $this->userappsmodel->simpandata();
		if ($query) {
			$url = base_url('userapps');
			redirect($url);
		}
	}
	public function updatedata()
	{
		$query = $this->userappsmodel->updatedata();
		if ($query) {
			$url = base_url('userapps');
			redirect($url);
		}
	}
	public function viewuser($id)
	{
		$data['user'] = $this->userappsmodel->getdatabyid($id)->row_array();
		$this->load->view('userapps/viewuser', $data);
	}
	public function refreshsess($id,$urrl=''){
		$hasil = $this->userappsmodel->refreshsess($id);
		if($hasil){
			$url  = base_url($urrl);
			redirect($url);
		}
	}
}
