<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Billmaterial extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('billmaterialmodel');
        $this->load->model('barangmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['material'] = $this->billmaterialmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'billmaterial';
        $this->load->view('layouts/header', $header);
        $this->load->view('billmaterial/index', $data);
        $this->load->view('layouts/footer',$footer);
    }
    public function carisku(){
        $kode = $_POST['kode'];
        $this->session->set_userdata('katcari',$kode);
        $url = base_url() . 'billmaterial';
        redirect($url);
    }
    public function kosongkancari(){
        $this->session->unset_userdata('katcari',$kode);
        $url = base_url() . 'billmaterial';
        redirect($url);
    }
    public function view($id)
    {
        $data['data'] = $this->billmaterialmodel->getdatabyid($id);
        $data['detail'] = $this->billmaterialmodel->getdatadetailbyid($id);
        $this->load->view('billmaterial/viewmaterial', $data);
    }
    public function tambahdata()
    {
        $header['header'] = 'master';
        $data['material'] = $this->billmaterialmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'billmaterial';
        $this->load->view('layouts/header', $header);
        $this->load->view('billmaterial/addbillmaterial');
        $this->load->view('layouts/footer',$footer);
    }
    public function edit($id)
    {
        $header['header'] = 'master';
        $data['material'] = $this->billmaterialmodel->getdatabyid($id);
        $data['detail'] = $this->billmaterialmodel->getdatadetailbyid($id);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'billmaterial';
        $this->load->view('layouts/header', $header);
        $this->load->view('billmaterial/editbillmaterial', $data);
        $this->load->view('layouts/footer',$footer);
    }
    public function hapusdetail($id,$head){
        $hasil = $this->billmaterialmodel->hapusdetail($id,$head);
        if($hasil){
            $url = base_url() . 'billmaterial/edit/'.$head;
            redirect($url);
        }
    }
    public function tambahdetail($id){
        $data['detail'] = $this->billmaterialmodel->getdatadetailbyid($id);
        $this->load->view('billmaterial/editdetailbillmaterial', $data);
    }
    public function simpandetail()
    {
        $data = [
            'id_bom' => $_POST['idhead'],
            'id_barang' => $_POST['id'],
            'nobontr' => strtoupper(trim($_POST['nobontr'])),
            'persen' => toAngka($_POST['persen']),
        ];
        $hasil = $this->billmaterialmodel->simpandetail($data);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
        }
        echo $hasil;
    }
    public function updatedetail()
    {
        $data = [
            'id_bom' => $_POST['idhead'],
            'id' => $_POST['iddet'],
            'id_barang' => $_POST['id'],
            'nobontr' => strtoupper(trim($_POST['nobontr'])),
            'persen' => toAngka($_POST['persen']),
        ];
        $hasil = $this->billmaterialmodel->updatedetail($data);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
        }
        echo $hasil;
    }
    public function simpandata(){
        $data = [
            'po' => strtoupper($_POST['po']),
            'item' => $_POST['item'],
            'dis' => $_POST['dis'],
            'id_barang' => $_POST['id_barang'],
            'insno' => strtoupper($_POST['insno']),
            'nobale' => $_POST['nobale'],
            'nobontr' => strtoupper($_POST['nobontr']),
            'dl' => $_POST['dl'],
        ];
        $hasil = $this->billmaterialmodel->simpandata($data);
        echo $hasil;
    }
    public function hapus($id)
    {
        $hasil = $this->billmaterialmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'billmaterial';
            redirect($url);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA KATEGORI"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "ID KATEGORI"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA KATEGORI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NO URUT"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('E2', "KODE"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('F2', "KETERANGAN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('G2', "JNS");
        $sheet->setCellValue('H2', "NET");
        // Panggil model Get Data   
        $kategori = $this->kategorimodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($kategori as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kategori_id']);
            $sheet->setCellValue('C' . $numrow, $data['nama_kategori']);
            $sheet->setCellValue('D' . $numrow, $data['urut']);
            $sheet->setCellValue('E' . $numrow, $data['kode']);
            $sheet->setCellValue('F' . $numrow, $data['ket']);
            $sheet->setCellValue('G' . $numrow, $data['jns']);
            $sheet->setCellValue('H' . $numrow, $data['net']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA KATEGORI");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kategori.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA KATEGORI');
    }
    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
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
        $pdf->Cell(30, 18, 'DATA KATEGORI');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Id Kategori', 1, 0, 'C');
        $pdf->Cell(80, 8, 'Nama Kategori', 1, 0, 'C');
        $pdf->Cell(10, 8, 'Urut', 1, 0, 'C');
        $pdf->Cell(10, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(10, 8, 'Jns', 1, 0, 'C');
        $pdf->Cell(10, 8, 'Net', 1, 0, 'C');
        $pdf->Cell(120, 8, 'Ket', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->kategorimodel->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(20, 6, $det['kategori_id'], 1);
            $pdf->Cell(80, 6, $det['nama_kategori'], 1);
            $pdf->Cell(10, 6, $det['urut'], 1);
            $pdf->Cell(10, 6, $det['kode'], 1);
            $pdf->Cell(10, 6, $det['jns'], 1);
            $pdf->Cell(10, 6, $det['net'], 1);
            $pdf->Cell(120, 6, $det['ket'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Kategori.pdf');
        $this->helpermodel->isilog('Download PDF DATA SATUAN');
    }
}
