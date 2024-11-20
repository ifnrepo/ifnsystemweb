<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Bcmasuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('dept_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('bcmasukmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['dept'] = $this->dept_model->getdata();
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday(date('Y') . '-' . date('m') . '-01'));
            $data['jns'] = null;
            $data['data'] = null;
        } else {
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['jns'] = $this->session->userdata('jnsbc');
            $data['data'] = $this->bcmasukmodel->getdata();
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'bcmasuk';
        $this->load->view('layouts/header', $header);
        $this->load->view('bcmasuk/bcmasuk', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function clear()
    {
        $this->session->unset_userdata('tglawal');
        $this->session->unset_userdata('tglakhir');
        $this->session->unset_userdata('jnsbc');
        $this->session->unset_userdata('filterkat');
        $url = base_url('bcmasuk');
        redirect($url);
    }

    public function getdata()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('jnsbc', $_POST['jns']);
        echo 1;
    }
    public function viewdetail($id)
    {
        $data['riwayat'] = riwayatbcmasuk($id);
        $data['detail'] = $this->bcmasukmodel->getdatabyid($id)->row_array();
        $data['databarang'] = $this->bcmasukmodel->getdetailbyid($id);
        $this->load->view('bcmasuk/viewdetail', $data);
    }
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "BC MASUK " . $this->session->userdata('jnsbc')); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "JNS DOK"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "TGL DOK"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NOMOR DOK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NO TERIMA");
        $sheet->setCellValue('E2', "TGL TERIMA");
        $sheet->setCellValue('F2', "PEMASOK/PENGIRIM");
        $sheet->setCellValue('G2', "KODE BARANG");
        $sheet->setCellValue('H2', "SPEK BARANG");
        $sheet->setCellValue('I2', "URAIAN BARANG");
        $sheet->setCellValue('J2', "SAT");
        $sheet->setCellValue('K2', "QTY");
        $sheet->setCellValue('L2', "NILAI IDR");
        $sheet->setCellValue('M2', "NILAI USD");
        $sheet->setCellValue('N2', "KGS (BRUTO)");
        $sheet->setCellValue('O2', "KGS (NETTO)");
        // Panggil model Get Data   
        $bcmasuk = $this->bcmasukmodel->getdataexcel();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
            $nilaiidr = $data['xmtuang'] != 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            $nilaiusd = $data['xmtuang'] == 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $data['jns_bc']);
            $sheet->setCellValue('B' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('C' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('D' . $numrow, $data['tgl']);
            $sheet->setCellValue('E' . $numrow, $data['nomor_dok']);
            $sheet->setCellValue('F' . $numrow, $data['nama_supplier']);
            $sheet->setCellValue('G' . $numrow, $data['kode']);
            $sheet->setCellValue('H' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('I' . $numrow, $data['nama_alias']);
            $sheet->setCellValue('J' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('K' . $numrow, $nilaiqty);
            $sheet->setCellValue('L' . $numrow, $nilaiidr);
            $sheet->setCellValue('M' . $numrow, $nilaiusd);
            $sheet->setCellValue('N' . $numrow, $data['bruto']);
            $sheet->setCellValue('O' . $numrow, $data['kgs']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data BC Masuk");
        $jns = $this->session->userdata('jnsbc') == 'Y' ? 'ALL' : $this->session->userdata('jnsbc');
        $title = 'BC ' . $jns . ' ' . $this->session->userdata('tglawal') . ' sd ' . $this->session->userdata('tglakhir');

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $title . '.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA DEPARTEMEN');
    }
    //End Controller

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
        $pdf->Cell(30, 18, 'DATA BC MASUK');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(15, 8, 'BC', 1, 0, 'C');
        $pdf->Cell(20, 8, 'DOK', 1, 0, 'C');
        $pdf->Cell(23, 8, 'TGL DOK', 1, 0, 'C');
        $pdf->Cell(130, 8, 'SPEK BARANG', 1, 0, 'C');
        $pdf->Cell(80, 8, 'PEMASOK', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $bcmasuk = $this->bcmasukmodel->getdataexcel();
        $no = 1;
        foreach ($bcmasuk->result_array() as $det) {

            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(15, 6, 'BC. ' . $det['jns_bc'], 1);
            $pdf->Cell(20, 6, $det['nomor_bc'], 1);
            $pdf->Cell(23, 6, $det['tgl_bc'], 1);
            $pdf->Cell(130, 6, $det['nama_barang'], 1);
            $pdf->Cell(80, 6, $det['nama_supplier'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Bc Masuk.pdf');
        $this->helpermodel->isilog('Download PDF DATA BC MASUK');
    }
}
