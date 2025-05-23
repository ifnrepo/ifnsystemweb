<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


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
        // require_once(APPPATH . 'libraries/Pdf.php');
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
        $this->session->unset_userdata('nopen');
        $url = base_url('bcmasuk');
        redirect($url);
    }

    public function getdata()
    {
        $this->session->set_userdata('tglawal', $_POST['tga']);
        $this->session->set_userdata('tglakhir', $_POST['tgk']);
        $this->session->set_userdata('jnsbc', $_POST['jns']);
        if (isset($_POST['nopen'])) {
            $this->session->set_userdata('nopen', $_POST['nopen']);
        } else {
            $this->session->unset_userdata('nopen');
        }
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
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', "BC MASUK " . $this->session->userdata('jnsbc'));
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE KANTOR"); // Set kolom B3 dengan tulisan "KODE" 
        $sheet->setCellValue('C2', "KODE DOKUMEN");
        $sheet->setCellValue('D2', "NOMOR DAFTAR");
        $sheet->setCellValue('E2', "TANGGAL DAFTAR");
        $sheet->setCellValue('F2', "NAMA PENERIMA");
        $sheet->setCellValue('G2', "NO BUKTI PENGIRIM BARANG");
        $sheet->setCellValue('H2', "TANGGAL NO BUKTI PENGIRIM BARANG");
        $sheet->setCellValue('I2', "KODE BARANG");
        $sheet->setCellValue('J2', "URAIAN BARANG");
        $sheet->setCellValue('K2', "JENIS SATUAN");
        $sheet->setCellValue('L2', "JUMLAH SATUAN");
        $sheet->setCellValue('M2', "KODE VALUTA");
        $sheet->setCellValue('N2', "NILAI BARANG");
        $bcmasuk = $this->bcmasukmodel->getdata_export();
        $no = 1;


        $numrow = 3;
        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
            $nilaiidr = $data['xmtuang'] != 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            $nilaiusd = $data['xmtuang'] == 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            $sheet->setCellValue('A' . $numrow,  $no);
            $sheet->setCellValue('B' . $numrow, '');
            $sheet->setCellValue('C' . $numrow, $data['jns_bc']);
            $sheet->setCellValue('D' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('E' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('F' . $numrow, $data['nama_supplier']);
            $sheet->setCellValue('G' . $numrow, $data['nomor_dok']);
            $sheet->setCellValue('H' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('I' . $numrow, $data['kode']);
            $sheet->setCellValue('J' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('K' . $numrow, $data['kode_satuan']);
            $sheet->setCellValue('L' . $numrow, $nilaiqty);
            $sheet->setCellValue('M' . $numrow, 'IDR');
            $sheet->setCellValue('N' . $numrow, $nilaiidr);


            $no++;
            $numrow++;
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
        $this->helpermodel->isilog('Download Excel DATA BC MASUK');
    }
    //End Controller

    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
        // $pdf->AliasNbPages();
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->SetFillColor(7, 178, 251);
        $pdf->SetFont('Latob', '', 12);
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'DATA BC MASUK', 0, 1, 'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'I', 7);
        $pdf->SetY(14);
        // $pdf->Cell(0, 10, 'Halaman: ' . $pdf->PageNo(), 0, 0, 'C');
        $pdf->Ln(15);


        $pdf->SetFillColor(220, 220, 220); // WARNA

        $x = $pdf->GetX();
        $y = $pdf->GetY();


        $pdf->Cell(8, 8, 'NO', 1, 0, 'C', true);
        $pdf->Cell(15, 8, 'Kode Kantor', 1, 0, 'C', true);


        $x_kode_dok = $pdf->GetX();
        $pdf->MultiCell(8, 4, 'Kode Dok', 1, 'C', true);


        $pdf->SetXY($x_kode_dok + 8, $y);
        $pdf->Cell(14, 8, 'No Daftar', 1, 0, 'C', true);
        $pdf->Cell(13, 8, 'Tgl Daftar', 1, 0, 'C', true);
        $pdf->Cell(38, 8, 'Nama Penerima', 1, 0, 'C', true);

        $x_no_bukti = $pdf->GetX();
        $pdf->MultiCell(24, 4, "No Bukti Pengirim Barang", 1, 'C', true);


        $pdf->SetXY($x_no_bukti + 24, $y);
        $pdf->MultiCell(24, 4, "Tgl No Bukti Pengiriman Barang", 1, 'C', true);


        $pdf->SetXY($x_no_bukti + 24 + 24, $y);
        $pdf->MultiCell(12, 4, 'Kode Barang', 1, 'C', true);
        $pdf->SetXY($x_no_bukti + 24 + 24 + 12, $y);
        $pdf->Cell(70, 8, 'Urian Barang', 1, 0, 'C', true);
        $pdf->MultiCell(10, 4, 'Jenis Satuan', 1, 'C', true);
        $pdf->SetXY($x_no_bukti + 24 + 24 + 12 + 70 + 10, $y);
        $pdf->MultiCell(10, 4, 'Jumlah Satuan', 1, 'C', true);
        $pdf->SetXY($x_no_bukti + 24 + 24 + 12 + 70 + 10 + 10, $y);
        $pdf->MultiCell(10, 4, 'Kode Valuta', 1, 'C', true);
        $pdf->SetXY($x_no_bukti + 24 + 24 + 12 + 70 + 10 + 10 + 10, $y);
        $pdf->Cell(18, 8, 'Nilai Barang', 1, 0, 'C', true);


        $pdf->Ln(2);


        $pdf->SetFont('Lato', '', 6);
        $pdf->Ln(6);
        $bcmasuk = $this->bcmasukmodel->getdata_export();

        $no = 1;

        foreach ($bcmasuk->result_array() as $det) {
            $nilaiqty = $det['kodesatuan'] == 'KGS' ? $det['kgs'] : $det['pcs'];
            $nilaiidr = $det['xmtuang'] != 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
            $nilaiusd = $det['xmtuang'] == 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
            $pdf->Cell(8, 6, $no++, 1, 0, 'C');
            $pdf->Cell(15, 6, '', 1, 0, 'C');
            $pdf->Cell(8, 6, $det['jns_bc'], 1, 0, 'C');
            $pdf->Cell(14, 6, $det['nomor_bc'], 1, 0, 'C');
            $pdf->Cell(13, 6, date('d-m-Y', strtotime($det['tgl_bc'])), 1, 0, 'C');
            $pdf->Cell(38, 6, $det['nama_supplier'], 1, 0);
            $pdf->Cell(24, 6, $det['nomor_dok'], 1, 0);
            $pdf->Cell(24, 6, date('d-m-Y', strtotime($det['tgl_bc'])), 1, 0, 'C');
            $pdf->Cell(12, 6, $det['kode'], 1, 0, 'L');
            $pdf->Cell(70, 6, $det['nama_barang'], 1, 0);
            $pdf->Cell(10, 6, $det['kodesatuan'], 1, 0, 'C');
            $pdf->Cell(10, 6, number_format($nilaiqty, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(10, 6, 'IDR', 1, 0, 'C');
            $pdf->Cell(18, 6, number_format($nilaiidr, 2, ',', '.'), 1, 0, 'R');

            // $pdf->Cell(30, 6, number_format($nilaiusd, 2, ',', '.'), 1, 0, 'R');

            $pdf->Ln(6);
        }

        $pdf->SetFont('Lato', '', 7);
        $pdf->Ln(10);
        $pdf->Output('I', 'Data Bc Masuk.pdf');
        $this->helpermodel->isilog('Download PDF DATA BC MASUK');
    }
    // public function cetakpdf()
    // {
    //     $pdf = new PDF('L', 'mm', 'A4');
    //     $pdf->AliasNbPages();
    //     $pdf->AddFont('Lato', '', 'Lato-Regular.php');
    //     $pdf->AddFont('Latob', '', 'Lato-Bold.php');
    //     $pdf->AddPage();


    //     $tglawal = $this->input->get('tglawal');
    //     $tglakhir = $this->input->get('tglakhir');

    //     $this->session->set_userdata('tglawal', $tglawal);
    //     $this->session->set_userdata('tglakhir', $tglakhir);

    //     $bcmasuk = $this->bcmasukmodel->getdataexcel();

    //     $no = 1;

    //     foreach ($bcmasuk->result_array() as $det) {
    //         $nilaiqty = $det['kodesatuan'] == 'KGS' ? $det['kgs'] : $det['pcs'];
    //         $nilaiidr = $det['xmtuang'] != 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
    //         $nilaiusd = $det['xmtuang'] == 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
    //         $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    //         $pdf->Cell(12, 6, 'BC. ' . $det['jns_bc'], 1);
    //         $pdf->Cell(16, 6, $det['nomor_bc'], 1);
    //         $pdf->Cell(23, 6, $det['tgl_bc'], 1);
    //         $pdf->Cell(35, 6, $det['nomor_dok'], 1);
    //         $pdf->Cell(23, 6, $det['tgl_bc'], 1);
    //         $pdf->Cell(80, 6, $det['nama_supplier'], 1);
    //         $pdf->Cell(10, 6, $det['kodesatuan'], 1);
    //         $pdf->Cell(21, 6, $nilaiqty, 1);
    //         $pdf->Cell(27, 6, $nilaiidr, 1);
    //         $pdf->Cell(23, 6, $nilaiusd, 1);
    //         $pdf->Ln(6);
    //     }

    //     $pdf->SetFont('Lato', '', 8);
    //     $pdf->Ln(10);
    //     $pdf->Output('I', 'Data Bc Masuk.pdf');
    //     $this->helpermodel->isilog('Download PDF DATA BC MASUK');
    // }
}
