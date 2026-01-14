<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Inv extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('inv_model', 'invmodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdeptout($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $data['levnow'] = $this->session->userdata['level_user'] == 1 ? 'disabled' : '';
        $data['kat'] = $this->invmodel->getdatakategori();
        $data['buyer'] = $this->invmodel->getbuyer();
        $data['getopname'] = $this->invmodel->getopname();
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday(date('Y') . '-' . date('m') . '-01'));
            $data['currdept'] = "$%";
            $data['ifndln'] = 'X';
            $data['req_inv'] = 0;
            // $data['buyer'] = []; 
        }else{
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['currdept'] = $this->session->userdata('currdept');
            $data['ifndln'] = $this->session->userdata('ifndln');
            $data['req_inv'] = $this->invmodel->getreqinv();
            // if($this->session->userdata('currdept')=='GF'){
            // }else{
            //     $data['buyer'] = [];
            // }
        }
        // $data['data'] = $this->invmodel->getdatabaru();
        $data['kategoricari'] = 'Cari Barang';
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'inv';
        $this->load->view('layouts/header', $header);
        $this->load->view('inv/inv', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('tglawal');
        $this->session->unset_userdata('tglakhir');
        $this->session->unset_userdata('currdept');
        // $this->session->unset_userdata('gbg');
        // $this->session->set_userdata('bl', date('m'));
        // $this->session->set_userdata('th', date('Y'));
        $this->session->set_userdata('gbg', 1);
        $this->session->set_userdata('invharga', 0);
        $this->session->unset_userdata('katcari');
        $this->session->unset_userdata('nomorbcnya');
        $this->session->unset_userdata('ifndln');
        $url = base_url('Inv');
        redirect($url);
    }
    public function getdata()
    {
        $monthawal = date('m',strtotime(tglmysql($_POST['tga'])));
        $tahunawal = date('Y',strtotime(tglmysql($_POST['tga'])));
        $jaditahun = '01-'.$monthawal.'-'.$tahunawal;
        $this->session->set_userdata('tglawal', $jaditahun);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('currdept', $_POST['dpt']);
        $this->session->set_userdata('ifndln', $_POST['idln']);
        echo 1;
    }
    public function getdatabaru($mode=0){
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
        echo $this->invmodel->getdatabaru($arrayu,$mode);
    }
    public function simpandatainv(){
        $hasil = $this->invmodel->simpandatainv();
        if($hasil){
            $url = base_url('Inv');
        redirect($url);
        }
    }
    public function getdatawip()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('currdept', $_POST['dpt']);
        $this->session->set_userdata('filterkat', $_POST['kat']);
        $this->session->set_userdata('kategoricari', $_POST['kcari']);
        if (isset($_POST['cari'])) {
            if ($_POST['cari'] == '') {
                $this->session->unset_userdata('katcari');
            } else {
                $this->session->set_userdata('katcari', $_POST['cari']);
            }
        } else {
            $this->session->unset_userdata('katcari');
        }
        echo 1;
    }
    public function getdatawipbaru()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('currdept', $_POST['dpt']);
        $this->session->set_userdata('filterkat', $_POST['kat']);
        $this->session->set_userdata('kategoricari', $_POST['kcari']);
        $this->session->set_userdata('ifndln', $_POST['ifndln']);
        if (isset($_POST['cari'])) {
            if ($_POST['cari'] == '') {
                $this->session->unset_userdata('katcari');
            } else {
                $this->session->set_userdata('katcari', $_POST['cari']);
            }
        } else {
            $this->session->unset_userdata('katcari');
        }
        $kuer = $this->invmodel->getkgspcswip($_POST['kat'], $_POST['ifndln']);
        $this->session->set_userdata('jmlpcs', $kuer['pecees']);
        $this->session->set_userdata('jmlkgs', $kuer['kagees']);
        $this->session->set_userdata('jmlrec', $kuer['rekod']);
        echo 1;
    }
    public function getdatagf()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('currdept', $_POST['dpt']);
        $this->session->set_userdata('filterkat', $_POST['kat']);
        $this->session->set_userdata('kategoricari', $_POST['kcari']);
        $this->session->set_userdata('ifndln', $_POST['ifndln']);
        if (isset($_POST['cari'])) {
            if ($_POST['cari'] == '') {
                $this->session->unset_userdata('katcari');
            } else {
                $this->session->set_userdata('katcari', $_POST['cari']);
            }
        } else {
            $this->session->unset_userdata('katcari');
        }
        $kuer = $this->invmodel->getkgspcsgf($_POST['kat'], $_POST['ifndln']);
        $this->session->set_userdata('jmlpcs', $kuer['pecees']);
        $this->session->set_userdata('jmlkgs', $kuer['kagees']);
        $this->session->set_userdata('jmlrec', $kuer['rekod']);
        echo 1;
    }
    public function viewharga()
    {
        $isi = $_POST['cek'];
        $this->session->set_userdata('invharga', $isi);
        // $url = base_url().'Inv';
        // redirect($url);
        echo 1;
    }
    public function viewinv()
    {
        $isi = $_POST['cek'];
        $this->session->set_userdata('viewinv', $isi);
        // $url = base_url().'Inv';
        // redirect($url);
        echo 1;
    }
    public function confirmverifikasidata($id)
    {
        $data['data'] = $this->invmodel->getdatasaldo($id);
        $this->load->view('inv/konfirmasisaldo', $data);
    }
    public function batalverifikasidata($id)
    {
        $data['data'] = $this->invmodel->getdatasaldo($id);
        $this->load->view('inv/ubahkonfirmasisaldo', $data);
    }
    public function verifikasidata()
    {
        $id = $_POST['id'];
        $simpan = $this->invmodel->verifikasidata($id);
        echo json_encode($simpan);
    }
    public function cancelverifikasidata()
    {
        $id = $_POST['id'];
        $simpan = $this->invmodel->cancelverifikasidata($id);
        echo json_encode($simpan);
    }
    public function toexcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "INVENTORY " . $this->session->userdata('currdept')); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->setCellValue('A2', "Periode " . tgl_indo(tglmysql($this->session->userdata('tglawal')))." s/d ".tgl_indo(tglmysql($this->session->userdata('tglakhir')))); // Set kolom A1 dengan tulisan "DATA SISWA"    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B3', "KODE BARANG"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C3', "NAMA BARANG"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D3', "SATUAN");
        $sheet->setCellValue('E3', "SALDO AWAL QTY");
        $sheet->setCellValue('F3', "SALDO AWAL KGS");
        $sheet->setCellValue('G3', "IN QTY");
        $sheet->setCellValue('H3', "IN KGS");
        $sheet->setCellValue('I3', "OUT QTY");
        $sheet->setCellValue('J3', "OUT KGS");
        $sheet->setCellValue('K3', "ADJ QTY");
        $sheet->setCellValue('L3', "ADJ PCS");
        $sheet->setCellValue('M3', "SALDO AKHIR QTY");
        $sheet->setCellValue('N3', "SALDO AKHIR KGS");
        $sheet->setCellValue('O3', "SO QTY");
        $sheet->setCellValue('P3', "SO KGS");
        $sheet->setCellValue('Q3', "SELISIH QTY");
        $sheet->setCellValue('R3', "SELISIH KGS");
        $sheet->setCellValue('S3', "KETERANGAN");
        $sheet->setCellValue('T3', "KETERANGAN");
        // Panggil model Get Data   
        $arrayu = [];
        $inv = $this->invmodel->toexcel();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 4;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv->result_array() as $data) {
            $spekbarang = $data['nama_barang'] == null ? $data['spek'] : substr($data['nama_barang'], 0, 75);
            $saldo_awal = $data['kodesatuan'] == 'KGS' ? $data['saldokgs'] : ($data['saldopcs'] ?? 0);
            $pemasukan = $data['kodesatuan'] == 'KGS' ? $data['inkgs'] : ($data['inpcs'] ?? 0);
            $pengeluaran = $data['kodesatuan'] == 'KGS' ? $data['outkgs'] : ($data['outpcs'] ?? 0);
            $saldo_akhir = $saldo_awal + $pemasukan - $pengeluaran;
            $sku = viewsku(id: $data['kode'], po: $data['po'], no: $data['item'], dis: $data['dis']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, $spekbarang);
            $sheet->setCellValue('D' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('E' . $numrow, $data['saldopcs']);
            $sheet->setCellValue('F' . $numrow, $data['saldokgs']);
            $sheet->setCellValue('G' . $numrow, $data['inpcs']);
            $sheet->setCellValue('H' . $numrow, $data['inkgs']);
            $sheet->setCellValue('I' . $numrow, $data['outpcs']);
            $sheet->setCellValue('J' . $numrow, $data['outkgs']);
            $sheet->setCellValue('K' . $numrow, $data['adjpcs']);
            $sheet->setCellValue('L' . $numrow, $data['adjkgs']);
            $sheet->setCellValue('M' . $numrow, $data['saldopcs']+$data['inpcs']-$data['outpcs']);
            $sheet->setCellValue('N' . $numrow, $data['saldokgs']+$data['inkgs']-$data['outkgs']);
            $sheet->setCellValue('O' . $numrow, '-');
            $sheet->setCellValue('P' . $numrow, '-');
            $sheet->setCellValue('Q' . $numrow, '-');
            $sheet->setCellValue('R' . $numrow, '-');
            $sheet->setCellValue('S' . $numrow, '-');
            $sheet->setCellValue('T' . $numrow, $data['nobale']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA INV");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data INV.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA INVENTORY' . $this->session->userdata('currdept'));
    }

    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->SetFillColor(7, 178, 251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->Cell(30, 18, 'DATA INVENTORY');
        $pdf->ln(12);
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->Cell(7, 8, 'No', 1, 0, 'C');
        $pdf->Cell(14, 8, 'KODE BRG', 1, 0, 'C');
        $pdf->Cell(90, 8, 'NAMA BARANG', 1, 0, 'C');
        $pdf->Cell(7, 8, 'SAT', 1, 0, 'C');
        $pdf->Cell(19, 8, 'SALDO AWAL', 1, 0, 'C');
        $pdf->Cell(19, 8, 'PEMASUKAN', 1, 0, 'C');
        $pdf->Cell(20, 8, 'PENGELUARAN', 1, 0, 'C');
        $pdf->Cell(19, 8, 'ADJ', 1, 0, 'C');
        $pdf->Cell(19, 8, 'SALDO AKHIR', 1, 0, 'C');
        $pdf->Cell(19, 8, 'SO', 1, 0, 'C');
        $pdf->Cell(19, 8, 'SELISIH', 1, 0, 'C');
        $pdf->Cell(19, 8, 'KET', 1, 0, 'C');
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->ln(8);
        // $inv = $this->invmodel->getexport_data();
        $inv = $this->invmodel->getexport_data();
        $no = 1;
        foreach ($inv->result_array() as $det) {
            $spekbarang = $det['nama_barang'] == null ? $det['spek'] : substr($det['nama_barang'], 0, 75);
            $saldo_awal = $det['kodesatuan'] == 'KGS' ? $det['kgs'] : ($det['pcs'] ?? 0);
            $pemasukan = $det['kodesatuan'] == 'KGS' ? $det['kgsin'] : ($det['pcsin'] ?? 0);
            $pengeluaran = $det['kodesatuan'] == 'KGS' ? $det['kgsout'] : ($det['pcsout'] ?? 0);
            $saldo_akhir = $saldo_awal + $pemasukan - $pengeluaran;
            $sku = viewsku(id: $det['kode'], po: $det['po'], no: $det['item'], dis: $det['dis']);
            $pdf->Cell(7, 6, $no++, 1, 0, 'C');
            $pdf->Cell(14, 6, $sku, 1);
            $pdf->Cell(90, 6, $spekbarang, 1);
            $pdf->Cell(7, 6, $det['kodesatuan'], 1);
            $pdf->Cell(19, 6, $saldo_awal, 1, 0, 'R');
            $pdf->Cell(19, 6, $pemasukan, 1, 0, 'R');
            $pdf->Cell(20, 6, $pengeluaran, 1, 0, 'R');
            $pdf->Cell(19, 6, '-', 1, 0, 'C');
            $pdf->Cell(19, 6, $saldo_akhir, 1, 0, 'R');
            $pdf->Cell(19, 6, '-', 1, 0, 'C');
            $pdf->Cell(19, 6, '', 1, 0, 'C');
            $pdf->Cell(19, 6, '-', 1, 0, 'C');



            // $pdf->Cell(18, 6, $saldo_akhir, 1, 0, 'R');

            // $pdf->Cell(25, 6, $det['kgs_awal'], 1);
            // // $pdf->Cell(25, 6, $det['insno'], 1);
            // $pdf->Cell(12, 6, $det['kodesatuan'], 1);
            // $pdf->Cell(13, 6, $det['pcs'] + $det['pcsin'] - $det['pcsout'], 1);
            // $pdf->Cell(13, 6, $det['kgs'] + $det['kgsin'] - $det['kgsout'], 1);
            // $pdf->Cell(35, 6, $det['name_kategori'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data inventory.pdf');
        $this->helpermodel->isilog('Download PDF DATA INVENTORY');
    }
    //END INV Controllers 
    public function getdatadetailpb()
    {
        $kode = $_POST['id_header'];
        $data = $this->pb_model->getdatadetailpb($kode);
        $hasil = '';
        $no = 1;
        $jml = count($data);
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>" . $dt['nama_barang'] . "</td>";
            $hasil .= "<td>" . $dt['kode'] . "</td>";
            $hasil .= "<td>" . $dt['namasatuan'] . "</td>";
            $hasil .= "<td class='text-center'>" . rupiah($dt['pcs'], 0) . "</td>";
            $hasil .= "<td>" . rupiah($dt['kgs'], 0) . "</td>";
            $hasil .= "<td class='text-center'>";
            $hasil .= "<a href='#' id='editdetailpb' rel='" . $dt['id'] . "' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='" . base_url() . 'pb/hapusdetailpb/' . $dt['id'] . "' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil, 'jmlrek' => $jml);
        echo json_encode($cocok);
    }
    public function tambahdata()
    {
        $this->load->view('pb/add_pb');
    }
    public function edittgl()
    {
        $this->load->view('pb/edit_tgl');
    }
    public function depttujupb()
    {
        $kode = $_POST['kode'];
        $this->session->set_userdata('deptsekarang', $kode);
        $cekdata = $this->pb_model->depttujupb($kode);
        echo $cekdata;
    }
    public function tambahpb()
    {
        $data = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'tgl' => tglmysql($_POST['tgl']),
            'kode_dok' => 'PB',
            'id_perusahaan' => IDPERUSAHAAN,
            'nomor_dok' => nomorpb(tglmysql($_POST['tgl']), $_POST['dept_id'], $_POST['dept_tuju'])
        ];
        $simpan = $this->pb_model->tambahpb($data);
        echo $simpan['id'];
    }
    public function updatepb()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->pb_model->updatepb($data);
        echo $simpan;
    }
    public function simpanpb($id)
    {
        $data = [
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d H:i:s'),
            'user_ok' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->pb_model->simpanpb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function validasipb($id)
    {
        $data = [
            'ok_valid' => 1,
            'tgl_valid' => date('Y-m-d H:i:s'),
            'user_valid' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->pb_model->validasipb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function editvalidasipb($id)
    {
        $data = [
            'ok_valid' => 0,
            'tgl_valid' => null,
            'user_valid' => null,
            'id' => $id
        ];
        $simpan = $this->pb_model->validasipb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function editokpb($id)
    {
        $data = [
            'data_ok' => 0,
            'tgl_ok' => null,
            'user_ok' => null,
            'id' => $id
        ];
        $simpan = $this->pb_model->validasipb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function cancelpb($id)
    {
        $data['id'] = $id;
        $this->load->view('pb/cancelpb', $data);
    }
    public function simpancancelpb()
    {
        $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $hasil = $this->pb_model->simpancancelpb($data);
        echo $hasil;
    }
    public function datapb($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->pb_model->getdatabyid($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $footer['fungsi'] = 'pb';
        $this->load->view('layouts/header', $header);
        $this->load->view('pb/datapb', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusdata($id)
    {
        $hasil = $this->pb_model->hapusdata($id);
        if ($hasil) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function addspecbarang()
    {
        $this->load->view('pb/addspecbarang');
    }
    public function getspecbarang()
    {
        $mode = $_POST['mode'];
        $brg = $_POST['data'];
        $html = '';
        $query = $this->pb_model->getspecbarang($mode, $brg);
        foreach ($query as $que) {
            $html .= "<tr>";
            $html .= "<td>" . $que['nama_barang'] . "</td>";
            $html .= "<td>" . $que['kode'] . "</td>";
            $html .= "<td>Satuan</td>";
            $html .= "<td>";
            $html .= "<a href='#' class='btn btn-sm btn-success pilihbarang' style='padding: 3px !important;' rel1='" . $que['nama_barang'] . "' rel2='" . $que['id'] . "' rel3=" . $que['id_satuan'] . ">Pilih</a>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function getdetailpbbyid()
    {
        $data = $_POST['id'];
        $hasil = $this->pb_model->getdatadetailpbbyid($data);
        echo json_encode($hasil);
    }
    public function simpandetailbarang()
    {
        $hasil = $this->pb_model->simpandetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function updatedetailbarang()
    {
        $hasil = $this->pb_model->updatedetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function hapusdetailpb($id)
    {
        $hasil = $this->pb_model->hapusdetailpb($id);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function viewdetail($isi = '',$mode=0)
    {
        $split = explode('-', $isi);
        // $array = [
        //     'po' => decrypto($split[1]),
        //     'item' => decrypto($split[2]),
        //     'dis' => $split[3],
        //     'id_barang' => $split[4],
        //     'nobontr' => decrypto($split[5]),
        //     'insno' => decrypto($split[6]),
        //     // 'insno' => $split[6],
        //     'nobale' => decrypto($split[7]),
        //     'nomor_bc' => decrypto($split[8])
        // ];
        // $array2 = [
        //     'id_barang' => $split[4],
        //     'nobontr' => decrypto($split[5]),
        // ];
        $array = [
            'po' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[1])))),
            'item' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[2])))),
            'dis' => $split[3],
            'id_barang' => $split[4],
            'nobontr' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[5])))),
            'insno' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[6])))),
            // 'insno' => $split[6],
            'nobale' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[7])))),
            'nomor_bc' => $split[8]
        ];
        $array2 = [
            'id_barang' => $split[4],
            'nobontr' => str_replace('%20',' ',str_replace('+','/',str_replace('?','-',rawurldecode($split[5])))),
        ];
       
        $data['header'] = $this->invmodel->getdatadetailbaru($array)->row_array();
        $data['detail'] = $this->invmodel->getdatadetailbaru($array);
        $data['dok'] = $this->invmodel->getdatadok($array2)->row_array();
        // $data['detailbom'] = $this->invmodel->getdatadetailbom($data['header']['id_bom']);
        $data['detailbom'] = $this->invmodel->getdatadetailbom($array);
        $data['isi'] = $array;
        $data['dok2'] = NULL;
        $this->load->view('inv/viewdetail',$data);
    }
    public function viewdetailwip($isi = '')
    {
        $split = explode('-', $isi);
        $array = [
            'po' => decrypto($split[1]),
            'item' => decrypto($split[2]),
            'dis' => $split[3],
            'id_barang' => $split[4],
            'nobontr' => decrypto($split[5]),
            'insno' => decrypto($split[6]),
            'nobale' => decrypto($split[7])
        ];
        $array2 = [
            'id_barang' => $split[4],
            'nobontr' => decrypto($split[5]),
        ];
        $data['header'] = $this->invmodel->getdatadetailwip($array)->row_array();
        $data['detail'] = $this->invmodel->getdatadetailwip($array);
        $data['dok'] = $this->invmodel->getdatadok($array2)->row_array();
        $data['isi'] = $array;
        $this->load->view('inv/viewdetail', $data);
    }
    public function getdatareport(){
        $hasil = $this->invmodel->getdatareport();
        echo json_encode($hasil);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        echo 1;
    }
    function cetakqr2($isi, $id)
    {
        $tempdir = "temp/";
        $namafile = $id;
        $codeContents = $isi;
        QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_L, 4, 1);
        return $tempdir . $namafile;
    }
    public function cetakbon($id)
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        // $pdf->SetFillColor(7,178,251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/ifnLogo.png', 14, 10, 22);
        $pdf->Cell(30, 18, '', 1);
        $pdf->SetFont('Latob', '', 18);
        $pdf->Cell(120, 18, 'BON PERMINTAAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(14, 6, 'No Dok', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, 'FM-GD-03', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Revisi', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, '1', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Tanggal', 'TB');
        $pdf->Cell(2, 6, ':', 'TB');
        $pdf->Cell(24, 6, '10-04-2007', 'TRB');
        $pdf->ln(6);
        $pdf->Cell(190, 1, '', 1, 0, '', 1);
        $pdf->ln(1);
        $header = $this->pb_model->getdatabyid($id);
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . datauser($header['user_tuju'], 'name') . "\r\n" . 'Date : ' . tglmysql2($header['tgl_tuju']);
        $qr = $this->cetakqr2($isi, $header['id']);
        $pdf->Image($qr . ".png", 177, 30, 18);
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(18, 5, 'Nomor', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['nomor_dok'], 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, 'Diperiksa & Disetujui Oleh', 'R', 0);
        $pdf->Cell(41, 5, 'Tanda Tangan', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Dept', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['departemen'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(41, 5, substr(datauser($header['user_tuju'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['tgl'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(41, 5, substr(datauser($header['user_tuju'], 'jabatan'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(80, 5, '', 'LBR', 0);
        $pdf->Cell(41, 5, '', 'BR', 0);
        $pdf->Cell(41, 5, '', 'BR', 0);
        $pdf->Cell(28, 5, '', 'BR', 1);
        $pdf->Cell(190, 1, '', 1, 1, '', 1);
        $pdf->Cell(8, 8, 'No', 'LRB', 0);
        $pdf->Cell(97, 8, 'Spesifikasi Barang', 'LRB', 0, 'C');
        $pdf->Cell(45, 8, 'Keterangan', 'LRB', 0, 'C');
        $pdf->Cell(20, 8, 'Jumlah', 'LRB', 0, 'C');
        $pdf->Cell(20, 8, 'Satuan', 'LRB', 1, 'C');
        $detail = $this->pb_model->getdatadetailpb($id);
        $no = 1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs'] == null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(8, 6, $no++, 'LRB', 0);
            $pdf->Cell(97, 6, $det['nama_barang'], 'LBR', 0);
            $pdf->Cell(45, 6, '', 'LRB', 0);
            $pdf->Cell(20, 6, rupiah($jumlah, 0), 'LRB', 0, 'R');
            $pdf->Cell(20, 6, $det['kodesatuan'], 'LBR', 1, 'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(15, 5, 'Catatan : ', 0);
        $pdf->Cell(19, 5, 'Dokumen ini sudah ditanda tangani secara digital', 0);
        $pdf->Output('I', 'FM-GD-03.pdf');
    }
}
