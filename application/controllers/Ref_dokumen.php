<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ref_dokumen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('refdokumen_model');
        // $this-load->model('refdokumen_model)
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['refdok'] = $this->refdokumen_model->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('refdok/index', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function tambahdata()
    {
        $this->load->view('refdok/addrefdok');
    }

    public function simpanrefdok()
    {
        $data = [
            'kode' => $_POST['kode'],
            'ins' => $_POST['ins'],
            'nama_dokumen' => $_POST['nama_dokumen'],
        ];
        $hasil = $this->refdokumen_model->simpanrefdok($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editrefdok($kode)
    {
        $data['data'] = $this->refdokumen_model->getdatabyid($kode);
        $this->load->view('refdok/editrefdok', $data);
    }
    public function updaterefdok()
    {
        $data = [
            'kode' => $_POST['kode'],
            'ins' => $_POST['ins'],
            'nama_dokumen' => $_POST['nama_dokumen']
        ];
        $hasil = $this->refdokumen_model->updaterefdok($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusrefdok($kode)
    {
        $hasil = $this->refdokumen_model->hapusrefdok($kode);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('ref_dokumen');
            redirect($url);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA REFERENSI DOCUMENT"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "INS"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NAMA DOCUMEN");
        // Panggil model Get Data   
        $ref = $this->refdokumen_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($ref as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode']);
            $sheet->setCellValue('C' . $numrow, $data['ins']);
            $sheet->setCellValue('D' . $numrow, $data['nama_dokumen']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Referensi Dokumen");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Referensi Dokumen.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA REFERENSI DOKUMEN');
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
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->Cell(30, 18, 'DATA REFERENSI DOKUMEN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Ins', 1, 0, 'C');
        $pdf->Cell(110, 8, 'Nama Dokumen', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->refdokumen_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(35, 6, $det['kode'], 1);
            $pdf->Cell(35, 6, $det['ins'], 1);
            $pdf->Cell(110, 6, $det['nama_dokumen'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Referensi Dokumen.pdf');
        $this->helpermodel->isilog('Download PDF DATA REFERENSI DOKUMEN');
    }
}
