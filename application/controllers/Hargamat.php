<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hargamat extends CI_Controller {
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
        $this->load->model('adj_model', 'adjmodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('hargamat_model', 'hargamatmodel');
    }
	public function index()
	{  
        $header['header'] = 'other';
        // $data['data'] = $this->hargamatmodel->getdata();
        $data['kategori'] = $this->hargamatmodel->getdatakategori();
        $data['artikel'] = $this->hargamatmodel->getdataartikel();
        // $data['databbl'] = $this->taskmodel->getdatabbl();
        $footer['fungsi'] = 'hargamat';
		$this->load->view('layouts/header',$header);
		$this->load->view('hargamat/hargamat',$data);
		$this->load->view('layouts/footer',$footer);
	}
    public function getbarang(){
        $data['data'] = $this->hargamatmodel->getbarang();
        $this->load->view('hargamat/getbarang',$data);
    }
    public function simpanbarang(){
        $arrgo = [
            'data' => $_POST['out']
        ];
        $kode = $this->hargamatmodel->simpanbarang($arrgo);
        echo $kode;
    }
    public function addkondisi(){
        if($_POST['kate']!='all'){
            $this->session->set_flashdata('katehargamat',$_POST['kate']);
        }
        if($_POST['arti']!='all'){
            $this->session->set_flashdata('artihargamat',$_POST['arti']);
        }
        echo 1;
    }
    public function edithamat($id){
        $data['data'] = $this->hargamatmodel->getdatabyid($id)->row_array();
        $this->load->view('hargamat/edithamat',$data);
    }
    public function updatehamat(){
        $query = $this->hargamatmodel->updatehamat();
        if($query){
            $url = base_url().'hargamat';
            redirect($url);
        }
    }
    public function get_data_hargamat()
    {
        ob_start(); // buffer output
        header('Content-Type: application/json');

        $filter_kategori = $this->input->post('filter_kategori');
        $filter_inv = $this->input->post('filter_inv');
        $list = $this->hargamatmodel->get_datatables($filter_kategori,$filter_inv);
        $data = array();
        $no = $_POST['start'];
        $total = 0;$kgs=0;$pcs=0;
        foreach ($list as $field) {
            $tampil = $field->weight==0 ? $field->qty : $field->weight;
            $barang = $field->id_barang==0 ? $field->remark.' (ID not found)' : $field->nama_barang; 
            $no++;
            $row = array();
            $row[] = $barang;
            $row[] = tglmysql($field->tgl);
            $row[] = $field->nobontr;
            $row[] = rupiah($field->qty,0);
            $row[] = rupiah($field->weight,2);
            $row[] = rupiah($field->price,2);
            $row[] = rupiah($tampil*$field->price,2);
            $row[] = $field->nama_supplier;
            $row[] = $field->mt_uang;
            $row[] = rupiah($field->oth_amount,2);
            $row[] = rupiah($field->kurs,2);
            $buton = "<a href=".base_url().'hargamat/edithamat/'.$field->idx ." class='btn btn-sm btn-info' style='padding: 2px 5px !important;' data-bs-target='#modal-large' data-bs-toggle='modal' data-title='Edit HAMAT' title='EDIT ".trim($field->nama_barang)."><i class='fa fa-pencil mr-1'></i> Edit</a>";
            $row[] = $buton;

            $data[] = $row;
            $total += $tampil*$field->price;
            $pcs += $field->qty;
            $kgs += $field->weight;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->hargamatmodel->count_all(),
            "recordsFiltered" => $this->hargamatmodel->count_filtered($filter_kategori,$filter_inv),
            "jumlahTotal" => $total,
            "jumlahPcs" => $pcs,
            "jumlahKgs" => $kgs,
            "data" => $data,
        );
        $this->session->set_userdata('jmlrek',$this->hargamatmodel->hitungrec($filter_kategori,$filter_inv));
        // $isinya = $this->session->userdata('jmlrek');
        echo "<script type='text/javascript'>
                isirekod = '<?= base_url() ?>';
            </script>";
        $this->kedepan();
        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
    }
    function kedepan(){
        return 0;
    }
    //End Controller
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
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpb()
    {
         $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->pb_model->simpancancelpb($data);
        $this->helpermodel->isilog($this->db->last_query());
        // if ($simpan) {
        //     // $this->session->set_flashdata('tabdef',$tab);
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
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
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelbbl()
    {
        $id = $_POST['id'];
        $kolom = $_POST['ke'];
        $ketcancel = $_POST['ketcancel'];
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 2,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'ketcancel' => $_POST['ketcancel'],
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        // if ($simpan) {
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
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
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpo()
    {
        $id = $_POST['id'];
        $kolom = $_POST['ke'];
        $ketcancel = $_POST['ketcancel'];
        $arraykolom=['data_ok','ok_pp','ok_valid','ok_tuju','ok_pc'];
        $arraytgl=['tgl_ok','tgl_pp','tgl_valid','tgl_tuju','tgl_pc'];
        $arrayuser=['user_ok','user_pp','user_valid','user_tuju','user_pc'];
        $cek = $this->taskmodel->cekfield($id,$arraykolom[$kolom-1],0)->num_rows();
        if($cek==1){
            $data = [
                $arraykolom[$kolom-1] => 2,
                $arraytgl[$kolom-1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom-1] => $this->session->userdata('id'),
                'id' => $id,
                'ketcancel' => $ketcancel,
            ];
            $simpan = $this->taskmodel->validasipo($data);
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        // if ($simpan) {
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
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
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan =1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function validasiadj($id)
    {
        $cek = $this->taskmodel->cekfield($id,'data_ok',1)->num_rows();
        if($cek==1){
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasiadj($data);
            $this->helpermodel->isilog($this->db->last_query());
        }else{
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function canceladj()
    {
         $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->taskmodel->simpancanceladj($data);
        $this->helpermodel->isilog($this->db->last_query());
        // if ($simpan) {
        //     $this->session->set_flashdata('tabdef',$tab);
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
    }
    public function canceltask($id=0,$ke=0){
        $data['ke'] = $ke;
        $data['data'] = $this->taskmodel->getdatabyid($id);
        $this->load->view('task/canceltask',$data);
    }
}
