<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class jabatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('jabatanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['jabatan'] = $this->jabatanmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('jabatan/index', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function tambahdata()
    {
        $this->load->view('jabatan/add');
    }

    public function simpandata()
    {
        $data = [
            'nama_jabatan' => $_POST['nama_jabatan'],
            'nojab' => $_POST['nojab'],
        ];
        $hasil = $this->jabatanmodel->simpan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function edit($id)
    {
        $data['data'] = $this->jabatanmodel->getdatabyid($id);
        $this->load->view('jabatan/edit', $data);
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nama_jabatan' => $_POST['nama_jabatan'],
            'nojab' => $_POST['nojab'],
        ];
        $hasil = $this->jabatanmodel->updatedata($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapus($id)
    {
        $hasil = $this->jabatanmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('jabatan');
            redirect($url);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA JABATAN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "NAMA JABATAN"); // Set kolom B3 dengan tulisan "KODE"    
        // Panggil model Get Data   
        $jabatan = $this->jabatanmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($jabatan as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['nama_jabatan']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Jabatan");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Jabatan.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA JABATAN ');
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
        $pdf->Cell(30, 18, 'DATA JABATAN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(105, 8, 'Nama Jabatan', 1, 0, 'C');

        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->jabatanmodel->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(105, 6, $det['nama_jabatan'], 1);

            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data jabatan.pdf');
        $this->helpermodel->isilog('Download PDF DATA JABATAN');
    }
}
