<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ponet extends CI_Controller
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
    }
    public function index()
    {
        $header['header'] = 'manajemen';
        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index');
        $this->load->view('layouts/footer');
    }
}
