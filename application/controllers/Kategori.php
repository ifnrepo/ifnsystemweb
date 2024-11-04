<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('kategorimodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['kategori'] = $this->kategorimodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('kategori/index', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function tambahdata()
    {
        $this->load->view('kategori/addkategori');
    }

    public function simpankategori()
    {
        $data = [
            'kategori_id' => $_POST['kategori_id'],
            'nama_kategori' => $_POST['nama_kategori'],
            'urut' => $_POST['urut'],
            'kode' => $_POST['kode'],
            'ket' => $_POST['ket'],
            'jns' => $_POST['jns'],
            'net' => $_POST['net']
        ];
        $hasil = $this->kategorimodel->simpankategori($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editkategori($id)
    {
        // $data['data'] = $this->kategorimodel->getdatabyid($id)->row_array();
        $data['data'] = $this->kategorimodel->getdatabyid($id);
        $this->load->view('kategori/editkategori', $data);
    }
    public function updatekategori()
    {
        $data = [
            'id' => $_POST['id'],
            'kategori_id' => $_POST['kategori_id'],
            'nama_kategori' => $_POST['nama_kategori'],
            'urut' => $_POST['urut'],
            'kode' => $_POST['kode'],
            'ket' => $_POST['ket'],
            'jns' => $_POST['jns'],
            'net' => $_POST['net']
        ];
        $hasil = $this->kategorimodel->updatekategori($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapuskategori($id)
    {
        $hasil = $this->kategorimodel->hapuskategori($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'kategori';
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
