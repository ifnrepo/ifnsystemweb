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
        $this->load->model('Ponet_model','ponetmodel');
        $this->load->model('Helper_model','helpermodel');
        $this->load->helper('ifn_helper');
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['data'] = $this->ponetmodel->getdata();
        $data['maxrek'] = $this->ponetmodel->getmaxminidpo();
        $data['futoito'] = $this->ponetmodel->getfutoito($data['data']['id']);
        $data['sidemark'] = $this->ponetmodel->getsidemark($data['data']['id']);
        $data['shipmark'] = $this->ponetmodel->getshipmark($data['data']['id']);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ponet';
        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index',$data);
        $this->load->view('layouts/footer',$footer);
    }

    public function view($id)
    {
        $header['header'] = 'other';
        $data['data'] = $this->ponetmodel->getdata($id);
        $data['maxrek'] = $this->ponetmodel->getmaxminidpo();
        $data['futoito'] = $this->ponetmodel->getfutoito($data['data']['id']);
        $data['sidemark'] = $this->ponetmodel->getsidemark($data['data']['id']);
        $data['shipmark'] = $this->ponetmodel->getshipmark($data['data']['id']);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ponet';
        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index',$data);
        $this->load->view('layouts/footer',$footer);
    }
    public function prevrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->prevrec($id);
        echo $hasil['idpo'];
    }
    public function nextrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->nextrec($id);
        echo $hasil['idpo'];
    }
    public function currentrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->currentrec($id);
        echo $hasil['idpo'];
    }

    public function caripoid($po)
    {
        $data['data'] = slashganti($po); 
        $this->load->view('ponet/caripo', $data);
    }
    public function caripo()
    {
        $this->load->view('ponet/caripo');
    }
    public function caridatapo(){
        $data = [
            'po' => trim($_POST['po']),
            'item' => trim($_POST['item'])
        ];
        $hasil = $this->ponetmodel->caridatapo($data);
        $html = '';
        if($hasil->num_rows() > 0){
            foreach($hasil->result_array() as $hsl){
                $warna = trim($hsl['spek'])=='CANCELED'? 'text-danger' : '';
                $html .= '<tr>';
                $html .= '<td>'.viewsku($hsl['po'],$hsl['item'],$hsl['dis']).'</td>';
                $html .= '<td class="'.$warna.'">'.spekpo($hsl['po'],$hsl['item'],$hsl['dis']).'</td>';
                $html .= '<td>'.$hsl['nama_customer'].'</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="'.base_url('ponet/view/'.$hsl['id']).'" class="btn btn-sm btn-success font-kecil" style="padding: 0px 2px !important;">Pilih</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '<tr><td colspan="4" class="text-center">Data tidak ditemukan <a href="#" id="resetcari">Cari Ulang ?</a></td></tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
}
