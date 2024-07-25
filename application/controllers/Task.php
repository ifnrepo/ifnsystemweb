<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('taskmodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('pb_model');
        $this->load->model('bbl_model');
        $this->load->model('dept_model', 'deptmodel');
    }
	public function index()
	{  
        $header['header'] = 'pendingtask';
        $data['data'] = $this->taskmodel->getdata($this->session->userdata('modetask'));
        // $data['databbl'] = $this->taskmodel->getdatabbl();
        $footer['fungsi'] = 'pendingtask';
		$this->load->view('layouts/header',$header);
		$this->load->view('task/task',$data);
		$this->load->view('layouts/footer',$footer);
	}
    public function mode(){
        $this->session->set_userdata('modetask',$_POST['id']);
        echo 1;
    }
    public function clear(){
        $this->session->unset_userdata('modetask');
        $url = base_url().'task';
        redirect($url);
    }
    public function validasipb($id)
    {
        $cek = $this->pb_model->cekfield($id,'data_ok',1)->num_rows();
        if($cek==1){
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->pb_model->validasipb($data);
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpb($id,$tab)
    {
         $data = [
            'id' => $id,
            // 'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->pb_model->simpancancelpb($data);
        if ($simpan) {
            $this->session->set_flashdata('tabdef',$tab);
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function validasibbl($id,$kolom)
    {
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 1,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelbbl($id,$kolom)
    {
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 2,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function validasipo($id,$kolom)
    {
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 1,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasipo($data);
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpo($id,$kolom)
    {
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 2,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasipo($data);
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function editbbl($id){
        $header['header'] = 'pendingtask';
        // $data['data'] = $this->taskmodel->getdata($this->session->userdata('modetask'));
        $data['header'] = $this->bbl_model->getdatabyid($id);
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $data['departemen'] = $this->deptmodel->getdata_dept_pb();
        $footer['fungsi'] = 'pendingtask';
		$this->load->view('layouts/header',$header);
		$this->load->view('task/editbbl',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function editapprovebbl($id,$kolom){
        $cek = $this->taskmodel->cekfield($id,'ok_tuju',0)->num_rows();
        if($cek==1){
             $data = [
                'ok_valid' => 0,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
        }else{
            $simpan =1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
}
