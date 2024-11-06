<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kelompokpo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Kelompokpo_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');


        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['kelpo'] = $this->Kelompokpo_model->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('kelpo/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('kelpo/add');
    }

    public function simpandata()
    {
        $data = [
            'id' => $_POST['id'],
            'engklp' => $_POST['engklp'],
            'indklp' => $_POST['indklp'],
            'hs' => $_POST['hs'],
            'merek' => $_POST['merek'],
            'kelco' => $_POST['kelco'],
        ];
        $hasil = $this->Kelompokpo_model->simpan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function edit($id)
    {
        $data['data'] = $this->Kelompokpo_model->getdatabyid($id);
        $this->load->view('kelpo/edit', $data);
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'engklp' => $_POST['engklp'],
            'indklp' => $_POST['indklp'],
            'hs' => $_POST['hs'],
            'merek' => $_POST['merek'],
            'kelco' => $_POST['kelco'],
        ];
        $hasil = $this->Kelompokpo_model->updatedata($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function hapus($id)
    {
        $hasil = $this->Kelompokpo_model->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('kelompokpo');
            redirect($url);
        }
    }

    public function view($id)
    {
        $data['data'] = $this->Kelompokpo_model->getdatabyid($id);
        $this->load->view('kelpo/view', $data);
    }


    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA KELOMPOK PO"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "No"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "Kode"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "Produk (Englis)");
        $sheet->setCellValue('D2', "Produk (Indonesia)");
        $sheet->setCellValue('E2', "No Hs");
        $sheet->setCellValue('F2', "Merek");
        $sheet->setCellValue('G2', "Certificate");
        // Panggil model Get Data   
        $kelpo = $this->Kelompokpo_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($kelpo as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['id']);
            $sheet->setCellValue('C' . $numrow, $data['engklp']);
            $sheet->setCellValue('D' . $numrow, $data['indklp']);
            $sheet->setCellValue('E' . $numrow, $data['hs']);
            $sheet->setCellValue('F' . $numrow, $data['merek']);
            $sheet->setCellValue('G' . $numrow, $data['kelco']);

            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Kelompok PO");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kelompok PO.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA KELOMPOK PO ');
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
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->Cell(30, 18, 'DATA KELOMPOK PO');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(11, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(145, 8, 'Produk (Englis)', 1, 0, 'C');
        $pdf->Cell(85, 8, 'Produk (Indonesia)', 1, 0, 'C');
        $pdf->Cell(25, 8, 'No HS', 1, 0, 'C');
        // $pdf->Cell(25, 8, 'Merek', 1, 0, 'C');
        // $pdf->Cell(55, 8, 'Certificate', 1, 0, 'C');

        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->Kelompokpo_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(11, 6, $det['id'], 1);
            $pdf->Cell(145, 6, $det['engklp'], 1);
            $pdf->Cell(85, 6, $det['indklp'], 1);
            $pdf->Cell(25, 6, $det['hs'], 1);
            // $pdf->Cell(25, 6, $det['merek'], 1);
            // $pdf->Cell(55, 6, $det['kelco'], 1);

            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Agama.pdf');
        $this->helpermodel->isilog('Download PDF DATA AGAMA');
    }
}
