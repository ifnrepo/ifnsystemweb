<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bbl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('bbl_model');
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $kode = [
            'dept_id' => $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang'),
            'level' => $this->session->userdata('levelsekarang') == null ? '' : $this->session->userdata('levelsekarang'),
        ];
        $data['data'] = $this->bbl_model->getdatapb($kode);
        $footer['fungsi'] = 'bbl';
        $this->load->view('layouts/header', $header);
        $this->load->view('bbl/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('bbl/add_bbl');
    }

    public function tambahpb()
    {
        $data = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'tgl' => tglmysql($_POST['tgl']),
            'kode_dok' => 'BBL',
            'id_perusahaan' => IDPERUSAHAAN,
            'nomor_dok' => nomorbbl(tglmysql($_POST['tgl']), $_POST['dept_id'], $_POST['dept_tuju'])
        ];
        $simpan = $this->bbl_model->tambah_bbl($data);
        echo $simpan['id'];
    }

    public function databbl($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->bbl_model->getdatabyid($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $data['barang'] = $this->db->get('barang')->result_array();
        $footer['fungsi'] = 'bbl';
        $this->load->view('layouts/header', $header);
        $this->load->view('bbl/databbl', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function edittgl()
    {
        $this->load->view('bbl/edit_tgl');
    }

    public function updatebbl()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->bbl_model->update_bbl($data);
        echo $simpan;
    }
    public function addspecbarang()
    {
        $this->load->view('bbl/addspecbarang');
    }

    public function getspecbarang()
    {
        $nomor_dok = $_POST['data'];
        $html = '';
        $query = $this->bbl_model->getspecbarang($nomor_dok);
        foreach ($query as $que) {
            $html .= "<tr>";
            $html .= "<td>" . $que['nomor_dok'] . "</td>";
            $html .= "<td>" . $que['nama_barang'] . "</td>";
            $html .= "<td>" . $que['kodesatuan'] . "</td>";
            $html .= "<td>";

            $html .= "<a href='#' class='btn btn-sm btn-success pilihbarang' style='padding: 3px !important;' rel1='" . $que['nomor_dok'] . "' rel2='" . $que['id_barang'] . "' rel3='" . $que['id_satuan'] . "' >Pilih</a>";

            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function simpandetailbarang()
    {
        $hasil = $this->bbl_model->simpandetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'bbl/databbl/' . $kode;
            redirect($url);
        }
    }
    public function getdatadetail_bbl()
    {
        $kode = $_POST['id_header'];
        $data = $this->bbl_model->getdatadetail_bbl($kode);
        $hasil = '';
        $no = 1;
        $jml = count($data);
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>" . $dt['nomor_dok'] . "</td>";
            $hasil .= "<td>" . $dt['nama_barang'] . "</td>";
            $hasil .= "<td>" . $dt['kodesatuan'] . "</td>";
            $hasil .= "<td>" . $dt['keterangan'] . "</td>";
            $hasil .= "<td class='text-center'>";
            $hasil .= "<a href='#' id='editdetailbbl' rel='" . $dt['id'] . "' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='" . base_url() . 'bbl/hapusdetailpbbl/' . $dt['id'] . "' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil, 'jmlrek' => $jml);
        echo json_encode($cocok);
    }

    public function viewdetailbbl($id)
    {
        $data['header'] = $this->bbl_model->getdatabyid($id);
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $this->load->view('pb/viewdetailpb', $data);
    }
}
