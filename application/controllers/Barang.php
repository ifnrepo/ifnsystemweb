<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('barangmodel');
        $this->load->model('satuanmodel');
        $this->load->model('kategorimodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
    }
    public function index()
    {
        $header['header'] = 'master';
        // $data['data'] = $this->barangmodel->getdata();
        $data['kategori_options'] = $this->barangmodel->getFilter();
        $footer['fungsi'] = 'barang';
        $this->load->view('layouts/header', $header);
        $this->load->view('barang/barang', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $this->session->unset_userdata('viewalias');
        $url = base_url().'barang';
        redirect($url);
    }
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
            'nama_alias' => $_POST['namali'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv'],
            'act' => $_POST['act'],
        ];
        $hasil = $this->barangmodel->simpanbarang($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editbarang($id,$nom)
    {
        $data['data'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['rekrow'] = $nom-1;
        $this->load->view('barang/editbarang', $data);
    }
    public function isistock($id,$nom)
    {
        $data['data'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['rekrow'] = $nom-1;
        $this->load->view('barang/isistock', $data);
    }
    public function updatebarang()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'nama_barang' => $_POST['nama'],
            'nama_alias' => $_POST['namali'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv'],
            'act' => $_POST['act'],
        ];
        $hasil = $this->barangmodel->updatebarang($data);
        echo json_encode($hasil->result());
    }
    public function hapusbarang($id)
    {
        $hasil = $this->barangmodel->hapusbarang($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
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
        $this->helpermodel->isilog($this->db->last_query());
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
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusbombarang($id, $idb)
    {
        $hasil = $this->barangmodel->hapusbombarang($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'barang/bombarang/' . $idb;
            redirect($url);
        }
    }
    public function updatestock(){
        $data = [
            'id' => $_POST['id'],
            'safety_stock' => $_POST['safety']
        ];
        $hasil = $this->barangmodel->updatestock($data);
        echo json_encode($hasil->result());
    }
    public function updateview(){
        $data = $_POST['isinya'];
        $this->session->set_userdata('viewalias',$data);
        echo 1;
    }

    public function get_data_barang()
    {
        ob_start(); // buffer output
        header('Content-Type: application/json');

        $filter_kategori = $this->input->post('filter_kategori');
        $filter_inv = $this->input->post('filter_inv');
        $filter_act = $this->input->post('filter_act');
        $list = $this->barangmodel->get_datatables($filter_kategori,$filter_inv,$filter_act);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kode;
            $row[] = $field->nama_barang;
            if($this->session->userdata('viewalias')==1){
                $row[] = $field->nama_alias;
            }
            $row[] = $field->nama_kategori;
            $row[] = $field->kodesatuan;
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
            if ($field->act == 1) {
                $row[] = '<i class="fa fa-check text-success"></i>';
            } else {
                $row[] = '<i class="fa fa-times text-danger"></i>';
            }
            if($field->safety_stock == 0){
                $row[] = '-';
            }else{
                $row[] = rupiah($field->safety_stock,2);
            }
            $jmbon = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg badge-notification badge-pill'>" . $field->jmbom . "</span>" : "";
            $buton = "<a href=" . base_url() . 'barang/editbarang/' . $field->id .'/'.$no." class='btn btn-sm btn-primary btn-icon text-white mr-1' rel=" . $field->id . " rel2=" . $no . " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
            $buton .= "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" . base_url() . 'barang/hapusbarang/' . $field->id . "><i class='fa fa-trash-o'></i></a>";
            $buton .= "<a href=" . base_url() . 'barang/isistock/' . $field->id .'/'.$no. " class='btn btn-sm btn-info btn-icon mr-1' id='stockbarang' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Isi Safety Stock' title='Isi Safety Stock' ><i class='fa fa-info pl-1 pr-1'></i></a>";
            $buton .= "<a href=" . base_url() . 'barang/bombarang/' . $field->id . " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM" . $jmbon . "</a>";
            $jmbon2 = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg ms-2'>" . $field->jmbom . "</span>" : "";
            $buton2 = '<div class="btn-group" role="group">';
            $buton2 .= '<label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" style="padding:3px 4px !important;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $buton2 .= 'Aksi';
            $buton2 .= '</label>';
            $buton2 .= '<div class="dropdown-menu">';
            $buton2 .= '<label class="dropdown-item p-1">';
            $buton2 .= '<a href='.base_url() . 'barang/editbarang/' . $field->id.'/'.$no.' rel="' . $field->id . '" rel2="' . $no . '" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit Data Barang" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="'.$key['id'].'" title="Edit data">';
            $buton2 .= '<i class="fa fa-edit pr-1"></i> Edit Data';
            $buton2 .= '</a>';
            $buton2 .= '</label>';
            $buton2 .= '<label class="dropdown-item p-1">';
            $buton2 .= '<a class="btn btn-sm btn-danger btn-icon text-white w-100" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href='.base_url() . 'barang/hapusbarang/' . $field->id.' title="Hapus data">';
            $buton2 .= '<i class="fa fa-trash-o pr-1"></i> Hapus Data';
            $buton2 .= '</a>';
            $buton2 .= '</label>';
            $buton2 .= '<label class="dropdown-item p-1">';
            $buton2 .= '<a href='.base_url() . 'barang/isistock/' . $field->id .' class="btn btn-sm btn-info btn-icon w-100" id="edituser" rel="'.$key['id'].'" title="View data" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Isi Safety Stock">';
            $buton2 .= '<i class="fa fa-info pr-1"></i> Isi Safety Stock';
            $buton2 .= '</a>';
            $buton2 .= '</label>';
            $buton2 .= '<label class="dropdown-item p-1">';
            $buton2 .= '<a href='.base_url() . 'barang/bombarang/' . $field->id .' class="btn btn-sm btn-cyan btn-icon w-100" id="edituser" rel="'.$key['id'].'" title="Add Data BOM" >';
            $buton2 .= 'BOM'.$jmbon2;
            $buton2 .= '</a>';
            $buton2 .= '</label>';
            $buton2 .= '</div>';
            $buton2 .= '</div>';
            $row[] = $buton2;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barangmodel->count_all(),
            "recordsFiltered" => $this->barangmodel->count_filtered($filter_kategori,$filter_inv,$filter_act),
            "data" => $data,
        );

        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
    }
}
