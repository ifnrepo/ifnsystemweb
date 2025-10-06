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
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('B2:H2')->setCellValue('B2', 'KAWASAN BERIKAT PT. INDONEPTUNE NET MANUFACTURING');
        $sheet->mergeCells('B3:H3')->setCellValue('B3', 'LAPORAN PEMASUKAN BARANG PER DOKUMEN PABEAN');
        $sheet->mergeCells('B4:H4')->setCellValue('B4', "PERIODE: " . $this->session->userdata('tglawal') . " S/D " . $this->session->userdata('tglakhir'));
        $sheet->getStyle('B2:B4')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('B2:B4')->getAlignment()->setHorizontal('left');


        $sheet->mergeCells('B6:B7')->setCellValue('B6', 'No Urut');
        $sheet->mergeCells('C6:C7')->setCellValue('C6', 'Jenis Dokumen');
        $sheet->mergeCells('D6:E6')->setCellValue('D6', 'Dokumen Pabean');
        $sheet->mergeCells('F6:G6')->setCellValue('F6', 'Bukti Penerimaan Barang');
        $sheet->mergeCells('H6:H7')->setCellValue('H6', 'Pemasok/Pengirim');
        $sheet->mergeCells('I6:I7')->setCellValue('I6', 'Kode Barang');
        $sheet->mergeCells('J6:J7')->setCellValue('J6', 'Nama Barang');
        $sheet->mergeCells('K6:K7')->setCellValue('K6', 'Satuan');
        $sheet->mergeCells('L6:L7')->setCellValue('L6', 'Jumlah');
        $sheet->mergeCells('M6:M7')->setCellValue('M6', 'Kgs');
        $sheet->mergeCells('N6:N7')->setCellValue('N6', 'Nilai Barang (IDR)');
        $sheet->mergeCells('O6:O7')->setCellValue('O6', 'Nilai Barang (USD)');


        $sheet->setCellValue('D7', 'Nomor');
        $sheet->setCellValue('E7', 'Tanggal');
        $sheet->setCellValue('F7', 'Nomor');
        $sheet->setCellValue('G7', 'Tanggal');


        $sheet->getColumnDimension('B')->setWidth(6);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(35);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(75);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(12);

        $sheet->getStyle('B6:O7')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9D9D9'],
            ],
        ]);

        $bcmasuk = $this->bcmasukmodel->getdata_export();
        $no = 1;
        $numrow = 8;
        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];

            if ($data['xmtuang'] == 'USD') {
                $nilaiusd = $data['harga'] * $nilaiqty;
                $nilaiidr = $nilaiusd * $data['kurs_usd'];
            } else {
                $nilaiidr = $data['harga'] * $nilaiqty;
                $nilaiusd = $nilaiidr / $data['kurs_usd'];
            }

            $sheet->setCellValue('B' . $numrow,  $no);
            $sheet->setCellValue('C' . $numrow, "BC " . $data['jns_bc']);
            $sheet->setCellValue('D' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('E' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('F' . $numrow, $data['nomor_dok']);
            $sheet->setCellValue('G' . $numrow, $data['tgl']);
            $sheet->setCellValue('H' . $numrow, $data['nama_supplier']);
            $sheet->setCellValue('I' . $numrow, $data['kode']);
            $sheet->setCellValue('J' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('K' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('L' . $numrow, $nilaiqty);
            $sheet->setCellValue('M' . $numrow, $data['kgs']);
            $sheet->setCellValue('N' . $numrow, $nilaiidr);
            $sheet->setCellValue('O' . $numrow, $nilaiusd);

            $numrow++;
            $no++;
        }
        $sheet->getStyle('B8:O' . ($numrow - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan_pemasukan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }


    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->AddPage();


        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(0, 6, 'KAWASAN BERIKAT PT. INDONEPTUNE NET MANUFACTURING', 0, 1, 'L');
        $pdf->Cell(0, 6, 'LAPORAN PEMASUKAN BARANG PER DOKUMEN PABEAN', 0, 1, 'L');
        $pdf->Cell(0, 6, 'PERIODE: ' . $this->session->userdata('tglawal') . ' S/D ' . $this->session->userdata('tglakhir'), 0, 1, 'L');
        $pdf->Ln(3);


        $pdf->SetFont('Latob', '', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetDrawColor(0, 0, 0);

        $y = $pdf->GetY();

        $pdf->Cell(7, 12, 'No', 1, 0, 'C', true);
        $pdf->Cell(8, 12, 'Jenis', 1, 0, 'C', true);

        $x_doc = $pdf->GetX();
        $pdf->Cell(25, 6, 'Dokumen Pabean', 1, 0, 'C', true);
        $pdf->SetXY($x_doc, $y + 6);
        $pdf->Cell(10, 6, 'Nomor', 1, 0, 'C', true);
        $pdf->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $pdf->SetXY($x_doc + 25, $y);

        $x_bukti = $pdf->GetX();
        $pdf->Cell(42, 6, 'Bukti Penerimaan Barang', 1, 0, 'C', true);
        $pdf->SetXY($x_bukti, $y + 6);
        $pdf->Cell(27, 6, 'Nomor', 1, 0, 'C', true);
        $pdf->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $pdf->SetXY($x_bukti + 42, $y);

        $pdf->Cell(45, 12, 'Pemasok/Pengirim', 1, 0, 'C', true);
        $pdf->Cell(15, 12, 'Kode', 1, 0, 'C', true);
        $pdf->Cell(90, 12, 'Nama Barang', 1, 0, 'C', true);
        $pdf->Cell(8, 12, 'Sat', 1, 0, 'C', true);
        $pdf->Cell(10, 12, 'Jum', 1, 0, 'C', true);
        $pdf->Cell(10, 12, 'Kgs', 1, 0, 'C', true);
        $pdf->Cell(20, 12, 'Nilai (IDR)', 1, 1, 'C', true);


        $pdf->SetFont('Lato', '', 7);
        $bcmasuk = $this->bcmasukmodel->getdata_export();
        $no = 1;

        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];

            if ($data['xmtuang'] == 'USD') {
                $nilaiusd = $data['harga'] * $nilaiqty;
                $nilaiidr = $nilaiusd * $data['kurs_usd'];
            } else {
                $nilaiidr = $data['harga'] * $nilaiqty;
                $nilaiusd = $nilaiidr / $data['kurs_usd'];
            }

            $pdf->Cell(7, 6, $no++, 1, 0, 'C');
            $pdf->Cell(8, 6, 'BC ' . $data['jns_bc'], 1, 0, 'C');
            $pdf->Cell(10, 6, $data['nomor_bc'], 1, 0, 'C');
            $pdf->Cell(15, 6, $data['tgl_bc'], 1, 0, 'C');
            $pdf->Cell(27, 6, $data['nomor_dok'], 1, 0, 'C');
            $pdf->Cell(15, 6, $data['tgl'], 1, 0, 'C');
            $pdf->Cell(45, 6, $data['nama_supplier'], 1, 0);
            $pdf->Cell(15, 6, $data['kode'], 1, 0, 'C');
            $pdf->Cell(90, 6, $data['nama_barang'], 1, 0);
            $pdf->Cell(8, 6, $data['kodesatuan'], 1, 0, 'C');
            $pdf->Cell(10, 6, number_format($nilaiqty, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(10, 6, number_format($data['kgs'], 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(20, 6, number_format($nilaiidr, 2, ',', '.'), 1, 1, 'R');
        }

        $pdf->Ln(3);
        $pdf->SetFont('Latob', '', 7);
        $pdf->Cell(0, 5, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

        $pdf->Output('I', 'Laporan_Pemasukan_Barang.pdf');
        $this->helpermodel->isilog('Download PDF Laporan Pemasukan Barang');
    }
}
