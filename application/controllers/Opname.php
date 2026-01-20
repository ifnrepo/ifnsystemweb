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
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'periode' => $this->opnamemodel->getdataperiode(),
            'fungsi' => 'opname'
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
        echo 1;
    }

    public function addperiode(){
        $data['data'] = $this->opnamemodel->getdataperiode();
        $this->load->view('opname/addperiode',$data);
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

    public function dataopname()
    {
        $header['header'] = 'master';
        $data = [
            'dept' => $this->dept_model->getdata(),
            'periode' => $this->opnamemodel->getdataperiode(),
            'fungsi' => 'dataopname',
            'datadept' => $this->opnamemodel->getdatadept()
        ];
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
