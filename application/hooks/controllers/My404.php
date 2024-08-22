<?php 
class My404 extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
 } 

 public function index() 
 { 
    // $this->output->set_status_header('404'); 
    $this->load->view('layouts/header.php');
    $this->load->view('layouts/my404.php');
    $this->load->view('layouts/footer.php');
 } 
}