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
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel','usermodel');
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
    public function clear(){
        $this->session->unset_userdata('deptsekarang');
        $this->session->unset_userdata('tujusekarang');
        $url = base_url('Pb');
        redirect($url);
    }
    public function getdatapb(){
        $hasil = '';
        $kode = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
        ];
        $this->session->set_userdata('tujusekarang',$_POST['dept_tuju']);
        $data = $this->pb_model->getdatapb($kode);
        foreach ($data as $hsl) {
            $jmlrec = $hsl['jumlah_barang']==null ? '' : $hsl['jumlah_barang'].' Item ';
            $hasil .= "<tr>";
            $hasil .= "<td>".tglmysql($hsl['tgl'])."</td>";
            $hasil .= "<td class='font-bold'>".$hsl['nomor_dok']."</td>";
            $hasil .= "<td>".$jmlrec."</td>";
            $hasil .= "<td style='line-height: 13px'>".datauser($hsl['user_ok'],'name')."<br><span style='font-size: 10px;'>".tglmysql($hsl['tgl_ok'])."</span></td>";
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
    public function getdatadetailpb(){
        $kode = $_POST['id_header'];
        $data = $this->pb_model->getdatadetailpb($kode);
        $hasil = '';
        $no=1;
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>".$dt['nama_barang']."</td>";
            $hasil .= "<td>".$dt['kode']."</td>";
            $hasil .= "<td>".$dt['namasatuan']."</td>";
            $hasil .= "<td class='text-center'>".rupiah($dt['pcs'],0)."</td>";
            $hasil .= "<td>".rupiah($dt['kgs'],0)."</td>";
            $hasil .= "<td class='text-center'>";
            $hasil .= "<a href='#' id='editdetailpb' rel='".$dt['id']."' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='".base_url().'pb/hapusdetailpb/'.$dt['id']."' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup'=>$hasil);
		echo json_encode($cocok);
    }
    public function tambahdata(){
        $this->load->view('pb/add_pb');
    }
    public function edittgl(){
        $this->load->view('pb/edit_tgl');
    }
    public function depttujupb(){
        $kode = $_POST['kode'];
        $this->session->set_userdata('deptsekarang',$kode);
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
    public function updatepb(){
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->pb_model->updatepb($data);
        echo $simpan;
    }
    public function simpanpb($id){
        $data = [
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d'),
            'user_ok' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->pb_model->simpanpb($data);
        if($simpan){
            $url = base_url().'pb';
            redirect($url);
        }
    }
    public function datapb($id){
        $header['header'] = 'transaksi';
        $data['data'] = $this->pb_model->getdatabyid($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
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
    public function addspecbarang(){
        $this->load->view('pb/addspecbarang');
    }
    public function getspecbarang(){
        $mode = $_POST['mode'];
        $brg = $_POST['data'];
        $html = '';
        $query = $this->pb_model->getspecbarang($mode,$brg);
        foreach($query as $que){
            $html .= "<tr>";
            $html .= "<td>".$que['nama_barang']."</td>";
            $html .= "<td>".$que['kode']."</td>";
            $html .= "<td>Satuan</td>";
            $html .= "<td>";
            $html .= "<a href='#' class='btn btn-sm btn-success pilihbarang' style='padding: 3px !important;' rel1='".$que['nama_barang']."' rel2='".$que['id']."' rel3=".$que['id_satuan'].">Pilih</a>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup'=>$html);
        echo json_encode($cocok);
    }
    public function getdetailpbbyid(){
        $data = $_POST['id'];
        $hasil = $this->pb_model->getdatadetailpbbyid($data);
        echo json_encode($hasil);
    }
    public function simpandetailbarang(){
        $hasil = $this->pb_model->simpandetailbarang();
        if($hasil){
            $kode = $hasil['id'];
            $url = base_url().'pb/datapb/'.$kode;
            redirect($url);
        }
    }
    public function updatedetailbarang(){
        $hasil = $this->pb_model->updatedetailbarang();
        if($hasil){
            $kode = $hasil['id'];
            $url = base_url().'pb/datapb/'.$kode;
            redirect($url);
        }
    }
    public function hapusdetailpb($id){
        $hasil = $this->pb_model->hapusdetailpb($id);
        if($hasil){
            $kode = $hasil['id'];
            $url = base_url().'pb/datapb/'.$kode;
            redirect($url);
        }
    }
}