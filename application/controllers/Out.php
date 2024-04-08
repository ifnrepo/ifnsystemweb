<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Out extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('out_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model','deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel','usermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index(){
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $footer['fungsi'] = 'out';
		$this->load->view('layouts/header',$header);
		$this->load->view('out/out',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function clear(){
        $this->session->set_userdata('bl',date('m'));
        $this->session->set_userdata('th',date('Y'));
        $url = base_url().'out';
        redirect($url);
    }
    public function depttuju(){
        $kode = $_POST['kode'];
        $this->session->set_userdata('deptsekarang',$kode);
        $query = $this->out_model->getdepttuju($kode);
        foreach ($query->result_array() as $que) {
            $selek = $this->session->userdata('tujusekarang')==$que['dept_id'] ? 'selected' : '';
            $hasil .= "<option value='".$que['dept_id']."' rel='".$que['departemen']."' ".$selek.">".$que['departemen']."</option>";
        }
        echo $hasil;
    }
    public function ubahperiode(){
        $this->session->unset_userdata('deptsekarang');
        $this->session->unset_userdata('tujusekarang');
        $this->session->set_userdata('bl',$_POST['bl']);
        $this->session->set_userdata('th',$_POST['th']);
        echo 1;
    }
    public function getdata(){
        $hasil = '';
        $kode = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju']
        ];
        $this->session->set_userdata('tujusekarang',$_POST['dept_tuju']);
        $query = $this->out_model->getdata($kode);
        foreach ($query as $que) {
            $jmlrek = $que['jumlah_barang'] != null ? $que['jumlah_barang'].' Item' : '';
            $hasil .= "<tr>";
            $hasil .= "<td>".tglmysql($que['tgl'])."</td>";
            $hasil .= "<td class='font-bold'><a href='".base_url().'out/viewdetailout/'.$que['id']."' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='Ubah data Detail'>".$que['nomor_dok']."</a></td>";
            $hasil .= "<td>".$jmlrek."</td>";
            $hasil .= "<td>".datauser($que['user_tuju'],'name')."<br><span style='font-size: 11px;'>".tglmysql2($que['tgl_valid'])."</span></td>";
            $hasil .= "<td>".$que['keterangan']."</td>";
            $hasil .= "<td>";
            $hasil .= "<a href=".base_url().'out/cetakbon/'.$que['id']." target='_blank' class='btn btn-sm btn-danger' title='Cetak Data'><i class='fa fa-file-pdf-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function getdatadetailout(){
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->out_model->getdatadetailout($id);
        foreach ($query as $que) {
            $hasil .= "<tr>";
            $hasil .= "<td>".$que['nama_barang']."</td>";
            $hasil .= "<td>".$que['brg_id']."</td>";
            $hasil .= "<td>".$que['namasatuan']."</td>";
            $hasil .= "<td>".rupiah($que['pcsminta'],0)."</td>";
            $hasil .= "<td>".rupiah($que['kgsminta'],0)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['pcs'],0)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['kgs'],0)."</td>";
            $hasil .= "<td>";
            $hasil .= "<a href=".base_url().'out/editdetailout/'.$que['id']." class='btn btn-sm btn-primary' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function tambahdata(){
        $kondisi = [
            'dept_id' => $this->session->userdata('tujusekarang'),
            'dept_tuju' => $this->session->userdata('deptsekarang'),
            'kode_dok' => 'PB',
            'id_keluar' => null,
            'data_ok' => 1,
            'ok_tuju' => 1,
            'ok_valid' => 0
        ];
        $data['bon'] = $this->out_model->getbon($kondisi);
        $this->load->view('out/add_out',$data);
    }
    public function tambahdataout($id){
        $kode = $this->out_model->tambahdataout($id);
        if($kode){
            $url = base_url().'out/dataout/'.$kode;
            redirect($url);
        }
    }
    public function edit_tgl(){
        $this->load->view('out/edit_tgl');
    }
    public function updateout(){
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->out_model->updateout($data);
        echo $simpan;
    }
    public function editdetailout($id){
        $data['data'] = $this->out_model->getdatadetailoutbyid($id);
        $this->load->view('out/editdetailout',$data);
    }
    public function updatedetail(){
        $data = [
            'id' => $_POST['id'],
            'kgs' => $_POST['kgs'],
            'pcs' => $_POST['pcs'],
        ];
        $query = $this->out_model->updatedetail($data);
        echo $query;
    }
    public function dataout($kode){
        $header['header'] = 'transaksi';
        $data['data'] = $this->out_model->getdatabyid($kode);
        $data['mode'] = 'tambah';
        $footer['fungsi'] = 'out';
		$this->load->view('layouts/header',$header);
		$this->load->view('out/dataout',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function simpanout($id){
        $data = [
            'ok_valid' => 1,
            'user_valid' => $this->session->userdata('id'),
            'data_ok' => 1,
            'ok_tuju' => 1,
            'tgl_valid' => date('Y-m-d H:i:s'),
            'id' => $id
        ];
        $query = $this->out_model->simpanout($data);
        if($query){
            $url = base_url().'out';
            redirect($url);
        }
    }
    public function hapusdataout($id){
        $query = $this->out_model->hapusdataout($id);
        if($query){
            $url = base_url().'out';
            redirect($url);
        }
    }
    public function viewdetailout($id){
        $data['header'] = $this->out_model->getdatabyid($id);
        $data['detail'] = $this->out_model->getdatadetailout($id);
        $this->load->view('out/viewdetailout',$data);
    }
}