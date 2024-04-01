<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pb extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model','deptmodel');
    }
    public function index(){
        $header['header'] = 'transaksi';
        // $data['data'] = $this->barangmodel->getdata();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $footer['fungsi'] = 'pb';
		$this->load->view('layouts/header',$header);
		$this->load->view('pb/pb',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function getdatapb(){
        $hasil = '';
        $kode = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
        ];
        $data = $this->pb_model->getdatapb($kode);
        foreach ($data as $hsl) {
            
            $hasil .= "<tr>";
            $hasil .= "<td>".tglmysql($hsl['tgl'])."</td>";
            $hasil .= "<td>".$hsl['nomor_dok']."</td>";
            $hasil .= "<td></td>";
            $hasil .= "<td></td>";
            $hasil .= "<td>";
            $hasil .= "<a href=".base_url().'pb/datapb/'.$hsl["id"]." class='btn btn-sm btn-primary btn-flat mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='#' class='btn btn-sm btn-danger btn-flat mr-1' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini ?' data-href=".base_url() . 'pb/hapusdata/' . $hsl["id"]." title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup'=>$hasil);
		echo json_encode($cocok);
    }
    public function tambahdata(){
        $this->load->view('pb/add_pb');
    }
    public function depttujupb(){
        $kode = $_POST['kode'];
        $cekdata = $this->pb_model->depttujupb($kode);
        echo $cekdata;
    }
    public function tambahpb(){
        $data = [
            'dept_id'=>$_POST['dept_id'],
            'dept_tuju'=>$_POST['dept_tuju'],
            'tgl'=>tglmysql($_POST['tgl']),
            'kode_dok'=>'PB',
            'id_perusahaan'=>'IFN',
            'nomor_dok'=>nomorpb(tglmysql($_POST['tgl']),$_POST['dept_id'],$_POST['dept_tuju'])
        ];
        $simpan = $this->pb_model->tambahpb($data);
        echo $simpan['id'];
    }
    public function datapb($id){
        $header['header'] = 'transaksi';
        $data['data'] = $this->pb_model->getdatabyid($id);
        $footer['fungsi'] = 'pb';
		$this->load->view('layouts/header',$header);
		$this->load->view('pb/datapb',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function hapusdata($id){
        $hasil = $this->pb_model->hapusdata($id);
        if($hasil){
            $url = base_url().'pb';
            redirect($url);
        }
    }
}