<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Opname extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('dept_model');
        $this->load->model('opname_model','opnamemodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('barangmodel');

        $this->load->library('Pdf');
        $this->load->library('pagination');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'periode' => $this->opnamemodel->getdataperiode(),
            'detailperiode' => $this->opnamemodel->getdetailperiode(),
            'fungsi' => 'opname',
            'datarekap' => $this->opnamemodel->getdashboard()
        ];
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/opname', $data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('periodeopname');
        $url = base_url().'opname';
        redirect($url);
    }

    public function getperiode()
    {
        $this->session->set_userdata('periodeopname',$_POST['tgl']);
        // $this->session->set_userdata('periodeopname',$_POST['tgl']);
        echo 1;
    }
    public function getdata()
    {
        $this->session->set_userdata('currdeptopname',$_POST['dept']);
        $this->session->set_userdata('kepemilikanopname',$_POST['milik']);
        $this->session->set_userdata('exdo',$_POST['exdo']);
        $this->session->set_userdata('cari-rekapopname',$_POST['cari']);
        $this->session->set_userdata('perpage-rekapopname',$_POST['perpage']);
        echo 1;
    }
    public function clearrekaopname(){
        $this->session->unset_userdata('currdeptopname');
        $this->session->unset_userdata('kepemilikanopname');
        $this->session->unset_userdata('exdo');
        $this->session->unset_userdata('cari-rekapopname');
        $this->session->set_userdata('perpage-rekapopname',25);
        $url = base_url().'opname/dataopname';
        redirect($url);
    }

    public function addperiode(){
        $data['data'] = $this->opnamemodel->getdataperiode();
        $this->load->view('opname/addperiode',$data);
    }
    public function addpersenstok(){
        $data['data'] = $this->opnamemodel->getdatapersentase();
        $this->load->view('opname/addpersenstok',$data);
    }

    public function simpanperiode()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['cttn'],
            'user_add' => $this->session->userdata('id'),
            'tgl_add' => date('Y-m-d H:i:s')
        ];
        $hasil = $this->opnamemodel->simpanperiode($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusperiode($id)
    {
        $hasil = $this->opnamemodel->hapusperiode($id);
        if($hasil){
            $url = base_url().'opname';
            redirect($url);
        }
    }
    public function editperiode()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['cttn'],
            'id' => $_POST['id']
        ];
        $hasil = $this->opnamemodel->updateperiode($data);
        echo $hasil;
    }
    public function updatepersenstok(){
        $data = [
            'dept' => $_POST['dept'],
            'verif' => toAngka($_POST['verif']),
            'rilis' => toAngka($_POST['rilis']),
        ];
        $hasil = $this->opnamemodel->updatepersenstok($data);
        echo json_encode($hasil->result());
    }

    public function dataopname()
    {
        $config['base_url'] = base_url().'opname/dataopname/'; // The URL to your controller method
        $config['total_rows'] = $this->opnamemodel->countdata(); // Total records in your table
        $config['per_page'] = $this->session->userdata('perpage-rekapopname')=='' ? 25 : $this->session->userdata('perpage-rekapopname'); // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $header['header'] = 'rekapopname';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'periode' => $this->opnamemodel->getdataperiode(),
            'fungsi' => 'dataopname',
            'datadept' => $this->opnamemodel->getdatadept(),
            'data' => $this->opnamemodel->getdata($config['per_page'],$page),
            'jumlahrek' => $config['total_rows'] 
        ];
        $data['links'] = $this->pagination->create_links();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/dataopname', $data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function getdataopname($mode=0){
        $arrayu = [];
        $filter_kategori = $_POST['filt'];
        $filter_exdo = $_POST['exdo'];
        $filter_stok = $_POST['stok'];
        $filter_buyer = $_POST['buyer'];
        $filter_exnet = $_POST['exnet'];
        $filter_aneh = $_POST['dataneh'];
        if($filter_kategori!='all'){
            $arrayu['id_kategori'] = $filter_kategori;
        }
        if($filter_exdo!="all"){
            $arrayu['exdo'] = $filter_exdo;
        }
        if($filter_stok!="all"){
            $arrayu['stok'] = $filter_stok;
        }
        if($filter_buyer!='all'){
            $arrayu['id_buyer'] = $filter_buyer;
        }
        if($filter_exnet!='all'){
            $arrayu['exnet'] = $filter_exnet;
        }
        if($filter_aneh=='true'){
            $arrayu['minus'] = 1;
        }
        echo $this->opnamemodel->getdatabaru($arrayu,$mode);
    }
    public function editrekapopname($isi)
    {   
        $data['data'] = $this->opnamemodel->getdatabyid($isi);
        $this->load->view('opname/editbarangopname', $data);
    }
    public function updatestokopname(){
        $data = [
            'id' => $_POST['id'],
            'po' => $_POST['po'],
            'item' => $_POST['item'],
            'dis' => $_POST['dis'],
            'id_barang' => $_POST['idb'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'insno' => $_POST['insno'],
            'nobontr' => $_POST['nobontr'],
            'exnet' => $_POST['exnet'],
            'nobale' => $_POST['nobale'],
            'stok' => $_POST['stok'],
        ];
        echo $this->opnamemodel->updatestokopname($data);
    }
    public function hapusrekapopname($id){
        $hasil = $this->opnamemodel->hapusrekapopname($id);
        if($hasil){
            $url = base_url().'opname/dataopname';
            redirect($url);
        }
    }
    public function tambahdataopname(){
        // $dept = $this->session->userdata('currdeptopname');
        $header['header'] = 'master';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'periode' => $this->opnamemodel->getdataperiode(),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept()
        ];
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/addopname', $data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function entrydata(){
        $header['header'] = 'entri';
        if($this->session->userdata('rolestokopname')==4){
            $this->session->set_userdata('statusstok',2);
        }
        if($this->session->userdata('rolestokopname')==3){
            $this->session->set_userdata('statusstok',1);
        }
        $data = [
            'dept' => $this->dept_model->getdata(),
            'data' => $this->opnamemodel->getdatastok(),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept(),
            'detailperiode' => $this->opnamemodel->getdetailperiode(),
            'rekapsublok' => $this->opnamemodel->getrekapsublok()
        ];
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/entryopname',$data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function filterstok(){
        $stat = $_POST['status'];
        $dept = $_POST['dept'];
        if($stat != ''){
            $this->session->set_userdata('statusstok',$stat);
        }else{
            $this->session->unset_userdata('statusstok');
        }
        if($dept != ''){
            $this->session->set_userdata('deptstok',$dept);
        }else{
            $this->session->unset_userdata('deptstok');
        }
        echo 1;
    }
    public function addsublok(){
        $header['header'] = 'entri';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'data' => $this->opnamemodel->getdatasublok(),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept()
        ];
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/addsublok',$data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function addsublokclear(){
        $this->session->unset_userdata('deptsublok');
        $url = base_url().'opname/addsublok';
        redirect($url);
    }
    public function getkodelokasi(){
        $dept = $_POST['dept'];
        $query = $this->opnamemodel->getkodelokasi($dept);
        echo $query;
    }
    public function setdeptsublok(){
        $dept = $_POST['dept'];
        $this->session->set_userdata('deptsublok',$dept);
        echo 1;
    }
    public function simpansublok(){
        $data = [
            'kode_lokasi' => $_POST['kode'],
            'nama_lokasi' => $_POST['nama'],
            'dept_id' => $_POST['dept']
        ];
        $query = $this->opnamemodel->simpansublok($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data tersimpan !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }
    public function hapussublok($id){
        $query = $this->opnamemodel->hapussublok($id);
        if($query){
            $url = base_url().'opname/addsublok';
            redirect($url);
        }
    }
    public function editsublok(){
        $data = $_POST['id'];
        $query = $this->opnamemodel->getdatasublokbyid($data);
        echo json_encode($query);
    }
    public function updatesublok(){
        $data = [
            'id' => $_POST['id'],
            'nama_lokasi' => $_POST['nama']
        ];
        $query = $this->opnamemodel->updatesublok($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data terupdate !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }

    public function addstok(){
        $data['lokasi'] = $this->opnamemodel->getlokasi();
        $this->load->view('opname/addstok',$data);
    }
    public function simpanstok(){
        $data = [
            'kode_lokasi' => $_POST['kodelokasi'],
            'periode' => $this->session->userdata('periodeopname'),
            'dept_id' => $this->session->userdata('deptstok'),
        ];
        $query = $this->opnamemodel->simpanstok($data);
        echo $query;
    }
    public function hapusstok($id){
        $query = $this->opnamemodel->hapusstok($id);
        if($query){
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function entristok($page,$id){
        $config['base_url'] = base_url().'opname/entristok/'; // The URL to your controller method
        $config['total_rows'] = $this->opnamemodel->countdatadetailstok($id); // Total records in your table
        $config['per_page'] = 15; // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['suffix'] = '/'.$this->uri->segment(4);
        $config['first_url'] = $config['base_url'] .'0/'. $config['suffix'];
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $header['header'] = 'entri';
        $data = [
            'header' => $this->opnamemodel->getdatastokbyid($id),
            'data' => $this->opnamemodel->getdatadetailstok($id,$config['per_page'],$page),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept(),
            'detailperiode' => $this->opnamemodel->getdetailperiode(),
            'jumlahrek' => $this->opnamemodel->countdatadetailstok($id),
        ];
        $data['links'] = $this->pagination->create_links();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        if($this->session->userdata('sel-cari')==''){
            $this->session->set_userdata('sel-cari','barang');
        }
        $cekonmachine = $this->opnamemodel->getdatastokbyid($id);

        $this->load->view('layouts/opname/header', $header);
        if(trim(strtoupper($cekonmachine['nama_lokasi']))=='ON MACHINE'){
            $this->load->view('opname/entrionmachine',$data);
        }else{
            $this->load->view('opname/entristok',$data);
        }
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function editentristok(){
        $id = $_POST['id'];
        $page = $_POST['page'];
        $kode = $_POST['kode'];
        $query = $this->opnamemodel->getdataentristokbyid($id);
        echo json_encode($query);
    }
    public function cari($kode,$dept,$id){
        if($kode=='caribarang'){
            $query['data'] = $this->opnamemodel->caribarang($dept,$id);
            $this->load->view('opname/pilihbarang',$query);      
        }else if($kode=='cariinsnopo' || $kode=='cariinsnomesin' ){
            if($kode=='cariinsnopo'){
                $query['data'] = $this->opnamemodel->caripo($dept,$id);
            }else{
                $query['data'] = $this->opnamemodel->cariinsnomesin($dept,$id);
            }
            $this->load->view('opname/pilihpo',$query);
        }else if($kode=='carispekbarang'){
            $query['data'] = $this->opnamemodel->carispekbarang($dept,$id);
            $this->load->view('opname/pilihspek',$query);
        }
    }
    public function cariidbarang(){
        $dept = $_POST['dept'];
        $keyw = $_POST['keyw'];
        $this->session->set_userdata('sel-cari','barang');
        $query = $this->opnamemodel->cariidbarang($dept,$keyw);
        $jmlrek = $query->num_rows();
        $hasil = array('jumlah' => $jmlrek,'hasil' => $query->result());
        echo json_encode($hasil);
    }
    public function cariinsnopo(){
        $dept = $_POST['dept'];
        $keyw = $_POST['keyw'];
        $this->session->set_userdata('sel-cari','insnopo');
        $query = $this->opnamemodel->cariinsnopo($dept,$keyw);
        $jmlrek = $query->num_rows();
        $hasil = array('jumlah' => $jmlrek,'hasil' => $query->result());
        echo json_encode($hasil);
    }
    public function cariinsnomesin(){
        $dept = $_POST['dept'];
        $keyw = $_POST['keyw'];
        $this->session->set_userdata('sel-cari','insnomesin');
        $query = $this->opnamemodel->cariinsnomesin($dept,$keyw);
        $jmlrek = $query->num_rows();
        $hasil = array('jumlah' => $jmlrek,'hasil' => $query->result());
        echo json_encode($hasil);
    }
    public function carispekbarang(){
        $dept = $_POST['dept'];
        $keyw = $_POST['keyw'];
        $this->session->set_userdata('sel-cari','spekbar');
        $query = $this->opnamemodel->carispekbarang($dept,$keyw);
        $jmlrek = $query->num_rows();
        $hasil = array('jumlah' => $jmlrek,'hasil' => $query->result());
        echo json_encode($hasil);
    }
    public function cariberatpo(){
        $data = $_POST['po'].$_POST['item'].$_POST['dis'];
        $sat = $_POST['sat'];
        echo $this->opnamemodel->cariberatpo($sat,$data);
    }
    public function simpanentristok(){
        $id = $_POST['id'];
        $data = [
            'tgl' => $this->session->userdata('periodeopname'),
            'id_stokopname' => $_POST['id'],
			'dept_id' => $_POST['dept'],
			'po' => $_POST['po'],
			'item' => $_POST['item'],
			'dis' => $_POST['dis'],
			'id_barang' => $_POST['idb'],
			'insno' => strtoupper($_POST['insno']),
			'nobontr' => strtoupper($_POST['nobontr']),
			'exnet' => $_POST['exnet'],
			'stok' => $_POST['stok'],
			'dln' => $_POST['dln'],
			'nobale' => strtoupper($_POST['nobale']),
			'satuan' => $_POST['satuan'],
			'ket' => $_POST['ket'],
			'pcs' => toAngka($_POST['pcs']),
			'kgs' => toAngka($_POST['kgs'])
        ];
        $query = $this->opnamemodel->simpanentristok($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil disimpan !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }
    public function updateentristok(){
        $data = [
			'po' => $_POST['po'],
			'item' => $_POST['item'],
			'dis' => $_POST['dis'],
			'id_barang' => $_POST['idb'],
			'insno' => strtoupper($_POST['insno']),
			'nobontr' => strtoupper($_POST['nobontr']),
			'exnet' => $_POST['exnet'],
			'stok' => $_POST['stok'],
			'dln' => $_POST['dln'],
			'nobale' => strtoupper($_POST['nobale']),
			'satuan' => $_POST['satuan'],
			'ket' => $_POST['ket'],
			'pcs' => toAngka($_POST['pcs']),
			'kgs' => toAngka($_POST['kgs']),
            'id' => $_POST['id'],
            'urut' => $_POST['urut'],
        ];
        $query = $this->opnamemodel->updateentristok($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil diupdate !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }
    public function hapusentristok($page,$kode,$id){
        $query = $this->opnamemodel->hapusentristok($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil dihapus !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function selesaiinput($page,$kode,$id){
        $query = $this->opnamemodel->selesaiinput($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data input Selesai, Terima kasih !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function batalinput($page,$kode,$id){
        $query = $this->opnamemodel->batalinput($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil dikembalikan agar bisa di Edit !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function selesaiverifikasi1($page,$kode,$id){
        $query = $this->opnamemodel->selesaiverifikasi($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data Verifikasi Selesai, Terima kasih !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function batalverifikasi1($page,$kode,$id){
        $query = $this->opnamemodel->batalverifikasi($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil dikembalikan ke status SELESAI, Terima kasih !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function selesairilis($page,$kode,$id){
        $query = $this->opnamemodel->selesairilis($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data Verifikasi Selesai, Terima kasih !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function batalrilis($page,$kode,$id){
        $query = $this->opnamemodel->batalrilis($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil dikembalikan ke status Verifikasi Data, Terima kasih !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entrydata';
            redirect($url);
        }
    }
    public function verifentristok(){
        $id = $_POST['id'];
        $query = $this->opnamemodel->verifentristok($id);
        if($query){        
            echo strtoupper(datauser($query['user_verif'],'username')).' <span class="font-10">'.tglmysql2($query['tgl_verif']).'</span>';
        }
    }
    public function verifentrimesin(){
        $id = $_POST['id'];
        $query = $this->opnamemodel->verifentrimesin($id);
        if($query){        
            echo strtoupper(datauser($query['user_verif'],'username')).' <span class="font-10">'.tglmysql2($query['tgl_verif']).'</span>';
        }
    }
    public function rilisentristok(){
        $id = $_POST['id'];
        $query = $this->opnamemodel->rilisentristok($id);
        if($query){        
            echo strtoupper(datauser($query['user_rilis'],'username')).' <span class="font-10">'.tglmysql2($query['tgl_rilis']).'</span>';
        }
    }
    public function rilisentrimesin(){
        $id = $_POST['id'];
        $query = $this->opnamemodel->rilisentrimesin($id);
        if($query){        
            echo strtoupper(datauser($query['user_rilis'],'username')).' <span class="font-10">'.tglmysql2($query['tgl_rilis']).'</span>';
        }
    }
    public function batalkanverifstok($page,$id){
        $query = $this->opnamemodel->batalkanverifstok($id);
        if($query){
            $kode = $query['id_stokopname'];
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function batalkanrilisstok($page,$id){
        $query = $this->opnamemodel->batalkanrilisstok($id);
        if($query){
            $kode = $query['id_stokopname'];
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function batalkanrilismesin($page,$id){
        $query = $this->opnamemodel->batalkanrilismesin($id);
        if($query){
            $kode = $query['id_stokopname'];
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function tambahdataonmachine($page,$id){
        $header['header'] = 'entri';
        $data = [
            'header' => $this->opnamemodel->getdatastokbyid($id),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept(),
            'detailperiode' => $this->opnamemodel->getdetailperiode(),
            'jumlahrek' => $this->opnamemodel->countdatadetailstok($id),
            'mesin' => $this->opnamemodel->getmesinnetting($id),
            'bobin' => $this->opnamemodel->getdatabobin()
        ];
        $data['links'] = $this->pagination->create_links();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/addonmachine',$data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function simpandataonmesin(){
        $data = [
            'id_stokopname' => $_POST['id'],
			'machno' => $_POST['mesin'],
			'po' => $_POST['po'], 
			'item' => $_POST['item'],
			'dis' => $_POST['dis'],
			'brg_id' => $_POST['idbarang'], 
			'insno' => $_POST['insno'], 
			'bunko' => toAngka($_POST['bunko']),
			'bunjmlbox' => toAngka($_POST['bunjmlbox']),
			'bunbrtbox' => toAngka($_POST['bunbrtbox']),
			'bunjmlmsn' => toAngka($_POST['bunjmlmsn']),
			'bunbrtmsn' => toAngka($_POST['bunbrtmsn']),
			'jnsbob' => $_POST['jnsbob'],
			'bobko' => toAngka($_POST['bobko']),
			'bobisi' => toAngka($_POST['bobisi']),
			'bobjmlmsn' => toAngka($_POST['bobjmlmsn']),
			'jmbobspl' => toAngka($_POST['jmbobspl']),
			'lot_dari' => toAngka($_POST['lot_dari']),
			'lot_sampai' => toAngka($_POST['lot_sampai']),
			'rpm' => toAngka($_POST['rpm']),
        ];
        $query = $this->opnamemodel->simpandataonmachine($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data on Machine tersimpan !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }
    public function updatedataonmesin(){
        $data = [
            'id' => $_POST['id'],
            'idstok' => $_POST['idstok'],
			'machno' => $_POST['mesin'],
			'po' => $_POST['po'], 
			'item' => $_POST['item'],
			'dis' => $_POST['dis'],
			'brg_id' => $_POST['idbarang'], 
			'insno' => $_POST['insno'], 
			'bunko' => toAngka($_POST['bunko']),
			'bunjmlbox' => toAngka($_POST['bunjmlbox']),
			'bunbrtbox' => toAngka($_POST['bunbrtbox']),
			'bunjmlmsn' => toAngka($_POST['bunjmlmsn']),
			'bunbrtmsn' => toAngka($_POST['bunbrtmsn']),
			'jnsbob' => $_POST['jnsbob'],
			'bobko' => toAngka($_POST['bobko']),
			'bobisi' => toAngka($_POST['bobisi']),
			'bobjmlmsn' => toAngka($_POST['bobjmlmsn']),
			'jmbobspl' => toAngka($_POST['jmbobspl']),
			'lot_dari' => toAngka($_POST['lot_dari']),
			'lot_sampai' => toAngka($_POST['lot_sampai']),
			'rpm' => toAngka($_POST['rpm']),
        ];
        $query = $this->opnamemodel->updatedataonmachine($data);
        if($query){
            $this->session->set_flashdata('pesanerror','Data on Machine terupdate !');
            $this->session->set_flashdata('errorsimpan',1);
            echo $query;
        }
    }
    public function hapusentrionmesin($page,$kode,$id){
        $query = $this->opnamemodel->hapusentrionmesin($id);
        if($query){
            $this->session->set_flashdata('pesanerror','Data berhasil dihapus !');
            $this->session->set_flashdata('errorsimpan',1);
            
            $url = base_url().'opname/entristok/'.$page.'/'.$kode;
            redirect($url);
        }
    }
    public function editentrionmesin($page,$kode,$id){
        $header['header'] = 'entri';
        $data = [
            'header' => $this->opnamemodel->getdatastokbyid($kode),
            'data' => $this->opnamemodel->getdataonmesinbyid($id),
            'fungsi' => 'opname',
            'datadept' => $this->opnamemodel->getdatadept(),
            'detailperiode' => $this->opnamemodel->getdetailperiode(),
            'jumlahrek' => $this->opnamemodel->countdatadetailstok($id),
            'mesin' => $this->opnamemodel->getmesinnetting(),
            'bobin' => $this->opnamemodel->getdatabobin()
        ];
        $data['links'] = $this->pagination->create_links();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/opname/header', $header);
        $this->load->view('opname/editonmachine',$data);
        $this->load->view('layouts/opname/footer', $footer);
    }
    public function getberatbobin(){
        $kode = $_POST['bob'];
        $data = $this->db->get_where('tb_bobbin',['kodebob' => $kode])->row_array();
        echo $data['berat'];
    }
    public function carisublok(){
        $isi = $_POST['cari'];
        $this->session->set_userdata('cari-sublok',$isi);
        echo 1;
    }
    public function carientri(){
        $isi = $_POST['cari'];
        $this->session->set_userdata('cari-entri',$isi);
        echo 1;
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA DEPARTEMEN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE "); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA DEPARTEMEN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "KATEGORI");
        $sheet->setCellValue('E2', "OTH");
        // Panggil model Get Data   
        $dept = $this->dept_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($dept as $data) {
            $oth = cekoth($data['pb'], $data['bbl'], $data['adj']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['dept_id']);
            $sheet->setCellValue('C' . $numrow, $data['departemen']);
            $sheet->setCellValue('D' . $numrow, strtoupper($data['nama']));
            $sheet->setCellValue('E' . $numrow, $oth);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Departemen");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Departemen.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA DEPARTEMEN');
    }
    public function cetakpdf()
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->SetFillColor(7, 178, 251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 155, 5, 55);
        $pdf->Cell(30, 18, 'DATA DEPARTEMEN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(20, 8, 'KODE', 1, 0, 'C');
        $pdf->Cell(55, 8, 'NAMA DEPARTEMEN', 1, 0, 'C');
        $pdf->Cell(55, 8, 'KATEGORI', 1, 0, 'C');
        $pdf->Cell(55, 8, 'OTHER', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->dept_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $oth = cekoth($det['pb'], $det['bbl'], $det['adj']);
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(20, 6, $det['dept_id'], 1);
            $pdf->Cell(55, 6, $det['departemen'], 1);
            $pdf->Cell(55, 6, strtoupper($det['nama']), 1);
            $pdf->Cell(55, 6, $oth, 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Departemen.pdf');
        $this->helpermodel->isilog('Download PDF DATA DEPARTEMEN');
    }
}
