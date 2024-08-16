<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logact extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('logactmodel');
    }
    public function index()
    {
        $header['header'] = 'other';
        // $data['data'] = $this->barangmodel->getdata();
        // $data['kategori_options'] = $this->barangmodel->getFilter();
        if($this->session->userdata('tglawallog')==null){
            $this->session->set_userdata('tglawallog',date('Y-m-01'));
        }
        if($this->session->userdata('tglakhirlog')==null){
            $this->session->set_userdata('tglakhirlog',date('Y-m-t'));
        }
        if($this->session->userdata('tglawallog')!=null && $this->session->userdata('tglakhirlog')!=null){
            $data['data'] = $this->logactmodel->getdata();
            $data['datauser'] = $this->logactmodel->getdatauser();
        }
        $footer['fungsi'] = 'logact';
        $this->load->view('layouts/header', $header);
        $this->load->view('logact/logact',$data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $this->session->unset_userdata('tglawallog');
        $this->session->unset_userdata('tglakhirlog');
        $this->session->unset_userdata('userlogact');
        $url = base_url().'logact';
        redirect($url);
    }
    public function updatetgl(){
        $tgaw = $_POST['tgaw'];
        $tgak = $_POST['tgak'];
        $userlog = $_POST['usr'];
        $this->session->set_userdata('tglawallog',tglmysql($tgaw));
        $this->session->set_userdata('tglakhirlog',tglmysql($tgak));
        $this->session->set_userdata('userlogact',$userlog);
        $url = base_url().'logact';
        redirect($url);
    }
    //End Controller 
    public function tambahdata()
    {
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['kode'] = time();
        $this->load->view('barang/addbarang', $data);
    }
    public function simpanbarang()
    {
        $data = [
            'kode' => $_POST['kode'],
            'nama_barang' => $_POST['nama'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv']
        ];
        $hasil = $this->barangmodel->simpanbarang($data);
        echo $hasil;
    }
    public function editbarang($id)
    {
        $data['data'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $this->load->view('barang/editbarang', $data);
    }
    public function updatebarang()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'nama_barang' => $_POST['nama'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv']
        ];
        $hasil = $this->barangmodel->updatebarang($data);
        echo $hasil;
    }
    public function hapusbarang($id)
    {
        $hasil = $this->barangmodel->hapusbarang($id);
        if ($hasil) {
            $url = base_url() . 'barang';
            redirect($url);
        }
    }
    public function bombarang($id)
    {
        $header['header'] = 'master';
        $data['detail'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['data'] = $this->barangmodel->getdatabom($id);
        $footer['fungsi'] = 'barang';
        $this->load->view('layouts/header', $header);
        $this->load->view('barang/bombarang', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function addbombarang($id)
    {
        $data['barang'] = $this->barangmodel->getdatajson();
        $data['id_barang'] = $id;
        $this->load->view('barang/addbombarang', $data);
    }
    public function simpanbombarang()
    {
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn']
        ];
        $hasil = $this->barangmodel->simpanbombarang($data);
        echo $hasil;
    }
    public function editbombarang($id)
    {
        $data['barang'] = $this->barangmodel->getdata();
        $data['detail'] = $this->barangmodel->getdatabombyid($id)->row_array();
        $this->load->view('barang/editbombarang', $data);
    }
    public function updatebombarang()
    {
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn'],
            'id' => $_POST['id']
        ];
        $hasil = $this->barangmodel->updatebombarang($data);
        echo $hasil;
    }
    public function hapusbombarang($id, $idb)
    {
        $hasil = $this->barangmodel->hapusbombarang($id);
        if ($hasil) {
            $url = base_url() . 'barang/bombarang/' . $idb;
            redirect($url);
        }
    }
    // public function get_data_barang()
    // {
    //     $list = $this->barangmodel->get_datatables();
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $field) {
    //         $no++;
    //         $row = array();
    //         $row[] = $no;
    //         $row[] = $field->kode;
    //         $row[] = $field->nama_barang;
    //         $row[] = $field->nama_kategori;
    //         $row[] = $field->namasatuan;
    //         if ($field->dln == 1) {
    //             $row[] = '<i class="fa fa-check text-success"></i>';
    //         } else {
    //             $row[] = '-';
    //         }
    //         $jmbon = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg badge-notification badge-pill'>" . $field->jmbom . "</span>" : "";
    //         $buton = "<a href=" . base_url() . 'barang/editbarang/' . $field->id . " class='btn btn-sm btn-primary btn-icon text-white mr-1' rel=" . $field->id . " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
    //         $buton .= "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" . base_url() . 'barang/hapusbarang/' . $field->id . "><i class='fa fa-trash-o'></i></a>";
    //         $buton .= "<a href=" . base_url() . 'barang/bombarang/' . $field->id . " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM" . $jmbon . "</a>";
    //         $row[] = $buton;

    //         $data[] = $row;
    //     }
    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->barangmodel->count_all(),
    //         "recordsFiltered" => $this->barangmodel->count_filtered(),
    //         "data" => $data,
    //     );
    //     echo json_encode($output);
    // }

    public function get_data_barang()
    {
        ob_start(); // buffer output
        header('Content-Type: application/json');

        $filter_kategori = $this->input->post('filter_kategori');
        $list = $this->barangmodel->get_datatables($filter_kategori);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kode;
            $row[] = $field->nama_barang;
            $row[] = $field->nama_kategori;
            $row[] = $field->namasatuan;
            if ($field->dln == 1) {
                $row[] = '<i class="fa fa-check text-success"></i>';
            } else {
                $row[] = '-';
            }
            if ($field->noinv == 1) {
                $row[] = '<i class="fa fa-check text-success"></i>';
            } else {
                $row[] = '-';
            }
            $jmbon = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg badge-notification badge-pill'>" . $field->jmbom . "</span>" : "";
            $buton = "<a href=" . base_url() . 'barang/editbarang/' . $field->id . " class='btn btn-sm btn-primary btn-icon text-white mr-1' rel=" . $field->id . " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
            $buton .= "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" . base_url() . 'barang/hapusbarang/' . $field->id . "><i class='fa fa-trash-o'></i></a>";
            $buton .= "<a href=" . base_url() . 'barang/bombarang/' . $field->id . " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM" . $jmbon . "</a>";
            $row[] = $buton;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barangmodel->count_all(),
            "recordsFiltered" => $this->barangmodel->count_filtered($filter_kategori),
            "data" => $data,
        );

        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
    }
}
