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
        $this->load->model('bcmaterialmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['level'] = $this->usermodel->getdatalevel();
        if ($this->session->userdata('tglawalbcmaterial') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday($this->session->userdata('thbcmaterial') . '-' . $this->session->userdata('blbcmaterial') . '-01'));
            $data['data'] = null;
        }else{
            $data['tglawal'] = tglmysql($this->session->userdata('tglawalbcmaterial'));
            $data['tglakhir'] = tglmysql($this->session->userdata('tglakhirbcmaterial'));
            $data['data'] = $this->bcmaterialmodel->getdata();
        }
        $data['kategori'] = $this->bcmaterialmodel->getdatakategori();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'bcmaterial';
        $this->load->view('layouts/header', $header);
        // $this->load->view('inv/inv', $data);
        $this->load->view('bcmaterial/bcmaterial', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $this->session->unset_userdata('tglawalbcmaterial');
        $this->session->unset_userdata('tglakhirbcmaterial');
        $this->session->unset_userdata('kepemilikan');
        $this->session->unset_userdata('katebar');
        $this->session->set_userdata('thbcmaterial',date('Y'));
        $this->session->set_userdata('blbcmaterial',date('m'));
        $url = base_url().'bcmaterial';
        redirect($url);
    }
    public function getdata(){
        $monthawal = date('m',strtotime(tglmysql($_POST['tga'])));
        $tahunawal = date('Y',strtotime(tglmysql($_POST['tga'])));
        $jaditahun = '01-'.$monthawal.'-'.$tahunawal;
        $this->session->set_userdata('tglawalbcmaterial',tglmysql($jaditahun));
        $this->session->set_userdata('tglakhirbcmaterial',tglmysql($_POST['tgk']));
        $this->session->set_userdata('kepemilikan',$_POST['punya']);
        $this->session->set_userdata('katebar',$_POST['katbar']);
        echo 1;
    }
    public function getdatabyid($id){
        $kodata = $this->bcmaterialmodel->getdatabyid($id);
        $data['header'] = $kodata->row_array();
        $data['detail'] = $kodata;
        $this->load->view('bcmaterial/viewdetail', $data);
    }
    public function toexcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "INVENTORY " . $this->session->userdata('currdept')); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        
        $sheet->setCellValue('A2', "Periode " . tglmysql($this->session->userdata('tglawal')).' s/d '.tglmysql($this->session->userdata('tglakhir'))); // Set kolom A1 dengan tulisan "DATA SISWA"    
        // $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B3', "SKU"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C3', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D3', "UNIT");
        $sheet->setCellValue('E3', "SAW");
        $sheet->setCellValue('F3', "IN");
        $sheet->setCellValue('G3', "OUT");
        $sheet->setCellValue('H3', "ADJ");
        $sheet->setCellValue('I3', "SAK");
        $sheet->setCellValue('J3', "OPNAME");

        $sheet->getColumnDimension('A')->setWidth(4.71);
        $sheet->getColumnDimension('C')->setWidth(56.71);
        // Panggil model Get Data   
        $inv = $this->bcmaterialmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 4;
        $jmpc = 0;$jmkg=0;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv->result_array() as $data) {
            $spekbarang = namaspekbarang($data['id_barang']);
            $sku = namaspekbarang($data['id_barang'],'kode');
            $saldo = $data['saldokgs'] > 0 ? $data['saldokgs'] : $data['saldopcs']; 
            $in = $data['saldokgs'] > 0 ? $data['inkgs'] : $data['inpcs']; 
            $out = $data['saldokgs'] > 0 ? $data['outkgs'] : $data['outpcs']; 
            $sat = $data['saldokgs'] > 0 ? 'KGS' : $data['kodesatuan'];     
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, $spekbarang);
            $sheet->setCellValue('D' . $numrow, $sat);
            $sheet->setCellValue('E' . $numrow, $saldo);
            $sheet->setCellValue('F' . $numrow, $in);
            $sheet->setCellValue('G' . $numrow, $out);
            $sheet->setCellValue('H' . $numrow, 0);
            $sheet->setCellValue('I' . $numrow, (float) $saldo + (float) $in - (float) $out);
            $sheet->setCellValue('J' . $numrow, 0);
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
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 225, 8, 65);
        $pdf->Cell(30, 5, 'DATA INVENTORY BAHAN BAKU',0,1);
        $pdf->Cell(30, 5, 'Periode : '.tgl_indo($this->session->userdata('tglawal')).' s/d '.tgl_indo($this->session->userdata('tglakhir')));
        $pdf->ln(9);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(14, 8, 'SKU', 1, 0, 'C');
        $pdf->Cell(88, 8, 'NAMA BARANG', 1, 0, 'C');
        $pdf->Cell(10, 8, 'SAT', 1, 0, 'C');
        $pdf->Cell(20, 8, 'S. AWAL', 1, 0, 'C');
        $pdf->Cell(20, 8, 'IN', 1, 0, 'C');
        $pdf->Cell(20, 8, 'OUT', 1, 0, 'C');
        $pdf->Cell(20, 8, 'ADJ', 1, 0, 'C');
        $pdf->Cell(20, 8, 'S. AKHIR', 1, 0, 'C');
        $pdf->Cell(20, 8, 'SO', 1, 0, 'C');
        $pdf->Cell(20, 8, 'SELISIH', 1, 0, 'C');
        $pdf->Cell(15, 8, 'KET', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 9);
        $pdf->ln(8);
        $inv = $this->bcmaterialmodel->getdata();
        $no = 1;
        foreach ($inv->result_array() as $data) {
            $spekbarang = namaspekbarang($data['id_barang']);
            $sku = namaspekbarang($data['id_barang'],'kode');
            $saldo = $data['saldokgs'] > 0 ? $data['saldokgs'] : $data['saldopcs']; 
            $in = $data['saldokgs'] > 0 ? $data['inkgs'] : $data['inpcs']; 
            $out = $data['saldokgs'] > 0 ? $data['outkgs'] : $data['outpcs']; 
            $sat = $data['saldokgs'] > 0 ? 'KGS' : $data['kodesatuan'];

            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(14, 6, '', 1);
            $pdf->Cell(88, 6, substr($spekbarang,0,48), 1);
            $pdf->Cell(10, 6, $sat, 1);
            $pdf->Cell(20, 6,rupiah($saldo,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah($in,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah($out,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah(0,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah((float) $saldo + (float) $in - (float) $out,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah(0,2), 1,0,'R');
            $pdf->Cell(20, 6,rupiah(0,2), 1,0,'R');
            $pdf->Cell(15, 6,'', 1);
        //     $pdf->Cell(12, 6, $det['kodesatuan'], 1);
        //     $pdf->Cell(13, 6, $det['pcs'] + $det['pcsin'] - $det['pcsout'], 1);
        //     $pdf->Cell(13, 6, $det['kgs'] + $det['kgsin'] - $det['kgsout'], 1);
        //     $pdf->Cell(35, 6, $det['name_kategori'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(85, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data inventory.pdf');
        $this->helpermodel->isilog('Download PDF DATA INVENTORY');
    }
}
