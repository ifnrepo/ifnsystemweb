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
    }
	public function index()
	{  
        $header['header'] = 'pendingtask';
        $data['datapb'] = $this->taskmodel->getdatapb();
        $footer['footer'] = 'satuan';
		$this->load->view('layouts/header',$header);
		$this->load->view('task/index',$data);
		$this->load->view('layouts/footer',$footer);
	}
    public function validasipb($id,$tab)
    {
        $data = [
            'ok_valid' => 1,
            'tgl_valid' => date('Y-m-d H:i:s'),
            'user_valid' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->pb_model->validasipb($data);
        if ($simpan) {
            $this->session->set_flashdata('tabdef',$tab);
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
}
