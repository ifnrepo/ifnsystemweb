<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Invmesin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('invmesin_model','invmesinmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['data'] = $this->invmesinmodel->getdata()->result_array();
        $data['lokasi'] = $this->invmesinmodel->getdatalokasi();
        $footer['fungsi'] = 'invmesin';
        $this->load->view('layouts/header', $header);
        $this->load->view('invmesin/index', $data);
        $this->load->view('layouts/footer',$footer);
    }
    public function clear(){
        $this->session->set_userdata('th',date('Y'));
        $this->session->set_userdata('bl',date('m'));
        $this->session->unset_userdata('lokasimesin',date('Y'));
        $url = base_url().'invmesin';
        redirect($url);
    }
    public function ubahperiode(){
        $this->session->set_userdata('th',$_POST['th']);
        $this->session->set_userdata('bl',$_POST['bl']);
        $this->session->set_userdata('lokasimesin',$_POST['lok']);
        echo 1;
    }
    public function getdetail($id){
        $data['header'] = $this->invmesinmodel->getdatabyid($id)->row_array();
        $data['detail'] = $this->invmesinmodel->getdatadetail($id);
        $this->load->view('invmesin/viewdetail',$data);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "MUTASI MESIN/ASSET"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA MESIN/ASSET"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "UNIT");
        $sheet->setCellValue('E2', "LOKASI");
        $sheet->setCellValue('F2', "SAW");
        $sheet->setCellValue('G2', "IN");
        $sheet->setCellValue('H2', "OUT");
        $sheet->setCellValue('I2', "ADJ");
        $sheet->setCellValue('J2', "SALDO");
        $sheet->setCellValue('K2', "OPNAME");
        $sheet->setCellValue('L2', "KETERANGAN");
        // Panggil model Get Data   
        $dept = $this->invmesinmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($dept->result_array() as $data) {
            // $oth = cekoth($data['pb'], $data['bbl'], $data['adj']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode_fix']);
            $sheet->setCellValue('C' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('D' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('E' . $numrow, $data['lokasi']);
            $sheet->setCellValue('F' . $numrow, $data['sawi']);
            $sheet->setCellValue('G' . $numrow, $data['ini']);
            $sheet->setCellValue('H' . $numrow, $data['outi']);
            $sheet->setCellValue('I' . $numrow, $data['adji']);
            $sheet->setCellValue('J' . $numrow, $data['sawi']+$data['ini']-$data['outi']);
            $sheet->setCellValue('K' . $numrow, 0);
            $sheet->setCellValue('L' . $numrow, 'Sesuai');
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Asset");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="BarangModal.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA MESIN/ASSET');
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
