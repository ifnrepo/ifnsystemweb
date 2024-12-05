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
        $sheet->mergeCells('A2:A3');
        $sheet->setCellValue('A2', "JENIS");
        $sheet->mergeCells('B2:C2');
        $sheet->setCellValue('B2', "DOKUMEN PABEAN");
        $sheet->setCellValue('B3', "TGL DOK");
        $sheet->setCellValue('C3', "NOMOR DOK");
        $sheet->mergeCells('D2:E2');
        $sheet->setCellValue('D2', "BUKTI PENERIMAAN BARANG");
        $sheet->setCellValue('D3', "NO TERIMA");
        $sheet->setCellValue('E3', "TGL TERIMA");
        $sheet->mergeCells('F2:F3');
        $sheet->setCellValue('F2', "PEMASOK");
        $sheet->mergeCells('G2:G3');
        $sheet->setCellValue('G2', "KODE BARANG");
        $sheet->mergeCells('H2:H3');
        $sheet->setCellValue('H2', "SPEK BARANG");
        $sheet->mergeCells('I2:I3');
        $sheet->setCellValue('I2', "URAIAN BARANG");
        $sheet->mergeCells('J2:J3');
        $sheet->setCellValue('J2', "SAT");
        $sheet->mergeCells('K2:K3');
        $sheet->setCellValue('K2', "QTY");
        $sheet->mergeCells('L2:M2');
        $sheet->setCellValue('L2', "NILAI BARANG");
        $sheet->setCellValue('L3', "NILAI IDR");
        $sheet->setCellValue('M3', "NILAI USD");
        $sheet->mergeCells('N2:O2');
        $sheet->setCellValue('N2', "KILO");
        $sheet->setCellValue('N3', "KGS (BRUTO)");
        $sheet->setCellValue('O3', "KGS (NETTO)");

        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B3')->getFont()->setBold(true);
        $sheet->getStyle('C3')->getFont()->setBold(true);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->getStyle('E3')->getFont()->setBold(true);
        $sheet->getStyle('L3')->getFont()->setBold(true);
        $sheet->getStyle('M3')->getFont()->setBold(true);
        $sheet->getStyle('N3')->getFont()->setBold(true);
        $sheet->getStyle('O3')->getFont()->setBold(true);
        $sheet->getStyle('A2:A3')->getFont()->setBold(true);
        $sheet->getStyle('A2:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:C2')->getFont()->setBold(true);
        $sheet->getStyle('B2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:C3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D2:E2')->getFont()->setBold(true);
        $sheet->getStyle('D2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:E2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F2:F3')->getFont()->setBold(true);
        $sheet->getStyle('F2:F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2:E3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('G2:G3')->getFont()->setBold(true);
        $sheet->getStyle('G2:G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('H2:H3')->getFont()->setBold(true);
        $sheet->getStyle('H2:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H2:H3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('I2:I3')->getFont()->setBold(true);
        $sheet->getStyle('I2:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:I3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('J2:J3')->getFont()->setBold(true);
        $sheet->getStyle('J2:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:J3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('K2:K3')->getFont()->setBold(true);
        $sheet->getStyle('K2:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K2:K3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L2:M2')->getFont()->setBold(true);
        $sheet->getStyle('L2:M2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L2:M2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('N2:O2')->getFont()->setBold(true);
        $sheet->getStyle('N2:O2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N2:O2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        $this->session->set_userdata('tglawal', $tglawal);
        $this->session->set_userdata('tglakhir', $tglakhir);

        $bcmasuk = $this->bcmasukmodel->getdataexcel($tglawal, $tglakhir);
        $no = 1;


        $numrow = 4;
        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
            $nilaiidr = $data['xmtuang'] != 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            $nilaiusd = $data['xmtuang'] == 'USD' ? $data['harga'] * $nilaiqty : ($data['harga'] * $nilaiqty) * $data['kurs_usd'];
            $sheet->setCellValue('A' . $numrow, 'BC. ' .  $data['jns_bc']);
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
        $this->helpermodel->isilog('Download Excel DATA DEPARTEMEN');
    }
    //End Controller

    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
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
        $pdf->SetFont('Arial', 'I', 8); // Font untuk nomor halaman
        $pdf->SetY(14);
        $pdf->Cell(0, 10, 'Halaman: ' . $pdf->PageNo(), 0, 0, 'C');
        $pdf->Ln(15);

        // sett lebar kolom
        $col_no = 10;
        $col_jenis = 12;
        $col_dokumen = 39;
        $col_penerimaan = 58;
        $col_pemasok = 80;
        $col_sat = 10;
        $col_jumlah = 21;
        $nilai_barang = 50;

        $pdf->Cell($col_no, 13, 'NO', 1, 0, 'C');
        $pdf->Cell($col_jenis, 13, 'JENIS', 1, 0, 'C');
        $pdf->Cell($col_dokumen, 6, 'DOKUMEN PABEAN', 1, 0, 'C');
        $pdf->Cell($col_penerimaan, 6, 'BUKTI PENERIMAAN BRG', 1, 0, 'C');
        $pdf->Cell($col_pemasok, 13, 'PEMASOK/PENGIRIM', 1, 0, 'C');
        $pdf->Cell($col_sat, 13, 'SAT', 1, 0, 'C');
        $pdf->Cell($col_jumlah, 13, 'JUMLAH', 1, 0, 'C');
        $pdf->Cell($nilai_barang, 6, 'NILAI BARANG', 1, 0, 'C');

        // Sub-header
        $pdf->SetXY(32, 35);
        $pdf->Cell(16, 7, 'NOMOR', 1, 0, 'C');
        $pdf->Cell(23, 7, 'TANGGAL', 1, 0, 'C');
        $pdf->Cell(35, 7, 'NOMOR', 1, 0, 'C');
        $pdf->Cell(23, 7, 'TANGGAL', 1, 0, 'C');
        $pdf->SetXY(240, 35);
        $pdf->Cell(27, 7, 'IDR', 1, 0, 'C');
        $pdf->Cell(23, 7, 'USD', 1, 0, 'C');
        $pdf->Ln(7);

        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');

        $this->session->set_userdata('tglawal', $tglawal);
        $this->session->set_userdata('tglakhir', $tglakhir);
        $bcmasuk = $this->bcmasukmodel->getdataexcel();

        $no = 1;

        foreach ($bcmasuk->result_array() as $det) {
            $nilaiqty = $det['kodesatuan'] == 'KGS' ? $det['kgs'] : $det['pcs'];
            $nilaiidr = $det['xmtuang'] != 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
            $nilaiusd = $det['xmtuang'] == 'USD' ? $det['harga'] * $nilaiqty : ($det['harga'] * $nilaiqty) * $det['kurs_usd'];
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(12, 6, 'BC. ' . $det['jns_bc'], 1);
            $pdf->Cell(16, 6, $det['nomor_bc'], 1);
            $pdf->Cell(23, 6, $det['tgl_bc'], 1);
            $pdf->Cell(35, 6, $det['nomor_dok'], 1);
            $pdf->Cell(23, 6, $det['tgl_bc'], 1);
            $pdf->Cell(80, 6, $det['nama_supplier'], 1);
            $pdf->Cell(10, 6, $det['kodesatuan'], 1);
            $pdf->Cell(21, 6, number_format($nilaiqty, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(27, 6, number_format($nilaiidr, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(23, 6, number_format($nilaiusd, 2, ',', '.'), 1, 0, 'R');

            $pdf->Ln(6);
        }

        $pdf->SetFont('Lato', '', 8);
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
