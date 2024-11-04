<?php 
class My404 extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
    $this->load->model('helper_model','helpermodel');
 } 

 public function index() 
 { 
    // $this->output->set_status_header('404'); 
    $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
    $this->load->view('layouts/header.php');
    $this->load->view('layouts/my404.php');
    $this->load->view('layouts/footer.php',$footer);
 } 
}