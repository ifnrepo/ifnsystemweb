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
        $this->load->model('barangmodel');
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
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(35);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(75);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(17);
        $sheet->getColumnDimension('O')->setWidth(15);

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
                    'color' => ['argb' => 'FF000000']
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
        $ceknomor_bc = '';

        foreach ($bcmasuk->result_array() as $data) {

            $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis']);
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);

            if ($data['nomor_bc'] == $ceknomor_bc) {
                $sheet->setCellValue('B' . $numrow, '');
            } else {
                $sheet->setCellValue('B' . $numrow, $no);
                $no++;
            }

            if (!empty($data['nama_supplier'])) {
                $suppl = $data['nama_supplier'];
            } elseif (!empty($data['nama_rekanan'])) {
                $suppl = $data['nama_rekanan'];
            } else {
                $suppl = $data['departemen'];
            }


            $kurs_data = getkurssekarang($data['tgl_aju'])->row();

            $kurs_usd = (empty($data['kurs_usd']) || $data['kurs_usd'] == 0)
                ? (($kurs_data && isset($kurs_data->usd)) ? $kurs_data->usd : 0)
                : $data['kurs_usd'];

            $kurs_yen = (empty($data['kurs_yen']) || $data['kurs_yen'] == 0)
                ? (($kurs_data && isset($kurs_data->jpy)) ? $kurs_data->jpy : 0)
                : $data['kurs_yen'];

            if ($data['mtuang'] == 1) {
                $harga_idr = $data['harga'];
                $harga_usd = $data['harga'] / $kurs_usd;
            } elseif ($data['mtuang'] == 2) {
                $harga_usd = $data['harga'];
                $harga_idr = $data['harga'] * $kurs_usd;
            } elseif ($data['mtuang'] == 3) {
                $harga_idr = $data['harga'] * $kurs_yen;
                $harga_usd = ($data['harga'] * $kurs_yen) / $kurs_usd;
            }

            $pengali = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
            $subtotal_idr = $harga_idr * $pengali;
            $subtotal_usd = $harga_usd * $pengali;


            $sheet->setCellValue('C' . $numrow, "BC " . $data['jns_bc']);
            $sheet->setCellValue('D' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('E' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('F' . $numrow, $data['nomor_dok']);
            $sheet->setCellValue('G' . $numrow, $data['tgl']);
            $sheet->setCellValue('H' . $numrow, $suppl);
            $sheet->setCellValue('I' . $numrow, $sku);
            $sheet->setCellValue('J' . $numrow, $spekbarang);
            $sheet->setCellValue('K' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('L' . $numrow, $nilaiqty);
            $sheet->setCellValue('M' . $numrow, $data['kgs']);
            $sheet->setCellValueExplicit('N' . $numrow, rupiah($subtotal_idr, 2), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue('O' . $numrow, rupiah($subtotal_usd, 2));

            $ceknomor_bc = $data['nomor_bc'];
            $numrow++;
        }

        $sheet->getStyle('B8:O' . ($numrow - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->getStyle('B8:K' . ($numrow - 1))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L8:O' . ($numrow - 1))
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN BC MASUK.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function cetakpdf()
    {
        $pdf = new PDF_Bcmasuk('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->AddPage();

        $pdf->SetFont('Lato', '', 7);
        $bcmasuk = $this->bcmasukmodel->getdata_export();
        $no = 1;
        $ceknomor_bc = '';

        foreach ($bcmasuk->result_array() as $data) {
            $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis']);
            $nilaiqty = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];



            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);

            if (!empty($data['nama_supplier'])) {
                $suppl = $data['nama_supplier'];
            } elseif (!empty($data['nama_rekanan'])) {
                $suppl = $data['nama_rekanan'];
            } else {
                $suppl = $data['departemen'];
            }


            $kurs_data = getkurssekarang($data['tgl_aju'])->row();

            $kurs_usd = (empty($data['kurs_usd']) || $data['kurs_usd'] == 0)
                ? (($kurs_data && isset($kurs_data->usd)) ? $kurs_data->usd : 0)
                : $data['kurs_usd'];

            $kurs_yen = (empty($data['kurs_yen']) || $data['kurs_yen'] == 0)
                ? (($kurs_data && isset($kurs_data->jpy)) ? $kurs_data->jpy : 0)
                : $data['kurs_yen'];

            if ($data['mtuang'] == 1) {
                $harga_idr = $data['harga'];
                $harga_usd = $data['harga'] / $kurs_usd;
            } elseif ($data['mtuang'] == 2) {
                $harga_usd = $data['harga'];
                $harga_idr = $data['harga'] * $kurs_usd;
            } elseif ($data['mtuang'] == 3) {
                $harga_idr = $data['harga'] * $kurs_yen;
                $harga_usd = ($data['harga'] * $kurs_yen) / $kurs_usd;
            }
            $pengali = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];

            $subtotal_idr = $harga_idr * $pengali;
            $subtotal_usd = $harga_usd * $pengali;




            $tinggi = 6;


            $x_awal = $pdf->GetX();
            $y_awal = $pdf->GetY();

            $lebarNamaBarang = 70;
            $nbNama = $pdf->NbLines($lebarNamaBarang, $data['nama_barang']);
            $tinggiMaks = $nbNama * $tinggi;



            if ($data['nomor_bc'] == $ceknomor_bc) {
                $pdf->Cell(6, $tinggiMaks, '', 1, 0, 'C');
            } else {
                $pdf->Cell(6, $tinggiMaks, $no, 1, 0, 'C');
                $no++;
            }

            $pdf->Cell(10, $tinggiMaks, 'BC ' . $data['jns_bc'], 1, 0, 'L');
            $pdf->Cell(10, $tinggiMaks, $data['nomor_bc'], 1, 0, 'L');
            $pdf->Cell(15, $tinggiMaks, $data['tgl_bc'], 1, 0, 'L');
            $nomor_dok = trim(str_replace([',', '.', '…'], '', $data['nomor_dok']));
            $pdf->Cell(35, $tinggiMaks, $nomor_dok, 1, 0, 'L');

            $pdf->Cell(15, $tinggiMaks, $data['tgl'], 1, 0, 'L');
            $pdf->Cell(45, $tinggiMaks, $suppl, 1, 0, 'L');
            $pdf->Cell(15, $tinggiMaks, $sku, 1, 0, 'L');


            $x_nama = $pdf->GetX();
            $y_nama = $pdf->GetY();
            $pdf->MultiCell($lebarNamaBarang, $tinggi,  $spekbarang, 1, 'L');


            $pdf->SetXY($x_nama + $lebarNamaBarang, $y_nama);

            $pdf->Cell(6, $tinggiMaks, $data['kodesatuan'], 1, 0, 'L');
            $pdf->Cell(12, $tinggiMaks, number_format($nilaiqty, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(12, $tinggiMaks, number_format($data['kgs'], 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(18, $tinggiMaks, number_format($subtotal_idr, 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(15, $tinggiMaks, number_format($subtotal_usd, 2, ',', '.'), 1, 1, 'R');

            $ceknomor_bc = $data['nomor_bc'];
        }




        // Info waktu cetak (opsional)
        // $pdf->Ln(3);
        // $pdf->SetFont('Latob', '', 7);
        // $pdf->Cell(0, 5, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

        $pdf->Output('I', 'Laporan Bc Masuk.pdf');
        $this->helpermodel->isilog('Download PDF Laporan Bc Masuk');
    }
}
