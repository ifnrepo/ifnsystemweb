<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Bcmaterial extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('satuanmodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('inv_model', 'invmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdeptout($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $data['levnow'] = $this->session->userdata['level_user'] == 1 ? 'disabled' : '';
        $this->session->set_userdata('currdept', 'GM');
        $data['repbeac'] = 1;
        if ($this->session->userdata('viewinv') == null) {
            $this->session->set_userdata('viewinv', 1);
        }
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-d'));
            $data['tglakhir'] = tglmysql(lastday($this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-01'));
            $data['data'] = null;
            $data['kat'] = null;
            $data['katbece'] = null;
            $data['ifndln'] = null;
            $data['gbg'] = '';
            $data['kategoricari'] = 'Cari Barang';
        } else {
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['data'] = $this->invmodel->getdata();
            $data['kat'] = $this->invmodel->getdatakategori();
            $data['katbece'] = $this->invmodel->getdatabc();
            $data['ifndln'] = $this->session->userdata('ifndln');
            $data['gbg'] = $this->session->userdata('gbg') == 1 ? 'checked' : '';
            $data['kategoricari'] = $this->session->userdata('kategoricari');
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'inv';
        $this->load->view('layouts/header', $header);
        $this->load->view('inv/inv', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function tambahdata()
    {
        $this->load->view('satuan/addsatuan');
    }
    public function simpansatuan()
    {
        $data = [
            'kodesatuan' => $_POST['kode'],
            'kodebc' => $_POST['bc'],
            'namasatuan' => $_POST['nama']
        ];
        $hasil = $this->satuanmodel->simpansatuan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editsatuan($id)
    {
        $data['data'] = $this->satuanmodel->getdatabyid($id)->row_array();
        $this->load->view('satuan/editsatuan', $data);
    }
    public function updatesatuan()
    {
        $data = [
            'id' => $_POST['id'],
            'kodesatuan' => $_POST['kode'],
            'kodebc' => $_POST['bc'],
            'namasatuan' => $_POST['nama']
        ];
        $hasil = $this->satuanmodel->updatesatuan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapussatuan($id)
    {
        $hasil = $this->satuanmodel->hapussatuan($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'satuan';
            redirect($url);
        }
    }
    public function toexcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "INVENTORY " . $this->session->userdata('currdept')); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "ID"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "SKU");
        $sheet->setCellValue('E2', "NOMOR IB");
        $sheet->setCellValue('F2', "INSNO");
        $sheet->setCellValue('G2', "SATUAN");
        $sheet->setCellValue('H2', "QTY");
        $sheet->setCellValue('I2', "KGS");
        $sheet->setCellValue('J2', "NAMA KATEGORI/NETTYPE");
        // Panggil model Get Data   
        $inv = $this->invmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv->result_array() as $data) {
            $spekbarang = $data['nama_barang'] == null ? $data['spek'] : substr($data['nama_barang'], 0, 75);
            $sku = viewsku(id: $data['kode'], po: $data['po'], no: $data['item'], dis: $data['dis']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['id_barang']);
            $sheet->setCellValue('C' . $numrow, $spekbarang);
            $sheet->setCellValue('D' . $numrow, $sku);
            $sheet->setCellValue('E' . $numrow, $data['nobontr']);
            $sheet->setCellValue('F' . $numrow, $data['insno']);
            $sheet->setCellValue('G' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('H' . $numrow, $data['pcs'] + $data['pcsin'] - $data['pcsout']);
            $sheet->setCellValue('I' . $numrow, $data['kgs'] + $data['kgsin'] - $data['kgsout']);
            $sheet->setCellValue('J' . $numrow, $data['name_kategori']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA INV");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data INV.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA INVENTORY' . $this->session->userdata('currdept'));
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
        $pdf->Cell(30, 18, 'DATA INVENTORY');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(14, 8, 'KODE BRG', 1, 0, 'C');
        $pdf->Cell(115, 8, 'NAMA BARANG', 1, 0, 'C');
        $pdf->Cell(23, 8, 'SAT', 1, 0, 'C');
        $pdf->Cell(38, 8, 'SALDO AWAL', 1, 0, 'C');
        $pdf->Cell(12, 8, 'PEMASUKAN', 1, 0, 'C');
        $pdf->Cell(13, 8, 'PENGELUARAN', 1, 0, 'C');
        $pdf->Cell(13, 8, 'ADJ', 1, 0, 'C');
        $pdf->Cell(35, 8, 'SALDO AKHIR', 1, 0, 'C');
        $pdf->Cell(35, 8, 'SO', 1, 0, 'C');
        $pdf->Cell(35, 8, 'SELISIH', 1, 0, 'C');
        $pdf->Cell(35, 8, 'KET', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        // $inv = $this->invmodel->getdata_export();
        // $no = 1;
        // foreach ($inv->result_array() as $det) {
        //     $spekbarang = $det['nama_barang'] == null ? $det['spek'] : substr($det['nama_barang'], 0, 75);
        //     $sku = viewsku(id: $det['kode'], po: $det['po'], no: $det['item'], dis: $det['dis']);
        //     $pdf->Cell(10, 6, $no++, 1, 0, 'C');
        //     $pdf->Cell(14, 6, $det['id_barang'], 1);
        //     $pdf->Cell(115, 6, $spekbarang, 1);
        //     $pdf->Cell(23, 6, $sku, 1);
        //     $pdf->Cell(38, 6, $det['nobontr'], 1);
        //     // $pdf->Cell(25, 6, $det['insno'], 1);
        //     $pdf->Cell(12, 6, $det['kodesatuan'], 1);
        //     $pdf->Cell(13, 6, $det['pcs'] + $det['pcsin'] - $det['pcsout'], 1);
        //     $pdf->Cell(13, 6, $det['kgs'] + $det['kgsin'] - $det['kgsout'], 1);
        //     $pdf->Cell(35, 6, $det['name_kategori'], 1);
        //     $pdf->ln(6);
        // }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data inventory.pdf');
        $this->helpermodel->isilog('Download PDF DATA INVENTORY');
    }
}
