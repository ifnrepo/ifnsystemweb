<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Bcgf extends CI_Controller
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
        $this->load->model('bcgfmodel');

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
        $data['getopname'] = $this->bcgfmodel->getopname();
        if ($this->session->userdata('tglawalbcgf') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday(date('Y') . '-' . date('m') . '-01'));
        }else{
            $data['tglawal'] = $this->session->userdata('tglawalbcgf');
            $data['tglakhir'] = $this->session->userdata('tglakhirbcgf');
        }

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'bcgf';
        $this->load->view('layouts/header', $header);
        $this->load->view('bcgf/bcgf', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $awal = date('Y-m-01');
        $ahir = lastday(date('Y') . '-' . date('m') . '-01');
        $this->session->unset_userdata('tglawalbcgf');
        $this->session->unset_userdata('tglakhirbcgf');
        $this->session->unset_userdata('kepemilikanbcgf');
        $this->session->unset_userdata('exdobcgf');
        $this->session->set_userdata('jmlrec',0);
        $this->session->set_userdata('jmlkgs',0);
        $this->session->set_userdata('jmlpcs',0);
        $url = base_url() . 'bcgf';
        redirect($url);
    }
    public function getdata(){
        $monthawal = date('m',strtotime(tglmysql($_POST['tga'])));
        $tahunawal = date('Y',strtotime(tglmysql($_POST['tga'])));
        $jaditahun = '01-'.$monthawal.'-'.$tahunawal;
        $this->session->set_userdata('tglawalbcgf',$jaditahun);
        $this->session->set_userdata('tglakhirbcgf',$_POST['tgk']);
        $this->session->set_userdata('kepemilikanbcgf',$_POST['punya']);
        $this->session->set_userdata('exdobcgf',$_POST['exdo']);
        // $this->session->set_userdata('currdeptbcwip',$_POST['curr']);
        echo 1;
    }
    public function getdatabaru($mode=0){
        $arrayu = [];
        $filter_kategori = $_POST['filt'];
        $filter_exdo = $_POST['exdo'];
        $filter_stok = $_POST['stok'];
        $filter_buyer = $_POST['buyer'];
        $filter_exnet = $_POST['exnet'];
        $filter_aneh = $_POST['dataneh'];
        if($filter_kategori!='all'){
            $arrayu['xdln'] = $filter_kategori;
        }
        if($filter_exdo!="all"){
            $arrayu['exdo'] = $filter_exdo;
        }
        if($filter_stok!="all"){
            $arrayu['stok'] = $filter_stok;
        }
        if($filter_buyer!='all'){
            $arrayu['id_buyer'] = $filter_buyer;
        }
        if($filter_exnet!='all'){
            $arrayu['exnet'] = $filter_exnet;
        }
        if($filter_aneh=='true'){
            $arrayu['minus'] = 1;
        }
        echo $this->bcgfmodel->getdatabaru($arrayu,$mode);
    }   
    public function getdatabyid($id){
        $kodata = $this->bcgfmodel->getdatabyid($id);
        $data['header'] = $kodata->row_array();
        $data['detail'] = $kodata;
        $this->load->view('bcgf/viewdetail', $data);
    }
    public function getdataspekpo(){
        $po = $_POST['po'];
        $item = $_POST['item'];
        $dis = $_POST['dis'];

        $spek = $this->bcgfmodel->getdataspekpo($po,$item,$dis);
        echo $spek;
    }
    public function get_data_gf()
    {
        $noke = 0;
        $pecees = 0;
        ob_start(); // buffer output
        header('Content-Type: application/json');
        
        $filter_kategori = $this->input->post('katbar');
        $filt_ifndln = $this->input->post('ifndln');
        $list = $this->invmodel->get_datatablesgf($filter_kategori,$filt_ifndln);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $noke++;
            $isi = 'OME-' . trim(encrypto($field->po)) . '-' . trim(encrypto($field->item)) . '-' . trim($field->dis) . '-' . trim($field->id_barang) . '-' . trim(encrypto($field->nobontr)) . '-' . trim(encrypto($field->insno)) . '-'. trim(encrypto($field->nobale)) . '-';
            $spekbarang = $field->nama_barang == null ? $field->spek : substr($field->nama_barang, 0, 75);
            $cx='';
            if($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='GS'){
                if($field->kodesatuan=='KGS'){
                    if((float) $field->totkgs <= (float) $field->safety_stock){
                    $cx = 'text-red';
                    }
                }else{
                    if((float) $field->totpcs <= (float) $field->safety_stock){
                    $cx = 'text-red';
                    }
                }
            }
            $insno = $this->session->userdata('currdept') == 'GS' ? $field->insno : $field->insno;
            $nobontr = $this->session->userdata('currdept') == 'GS' ? $field->nobontr : $field->nobontr;
            $saldo = $field->pcs;
            $in = $field->pcsin;
            $out = $field->pcsout;
            $saldokg = $field->kgs;
            $inkg = $field->kgsin;
            $outkg = $field->kgsout;
            $sak = $saldo + $in - $out;
            $sakkg = $saldokg + $inkg - $outkg;
            $no++;
            if($field->user_verif == 0){
                $buton = '<a href="'.base_url() . 'inv/confirmverifikasidata/'.$field->idu.'" class="btn btn-success btn-sm font-bold" data-bs-toggle="modal" data-bs-target="#veriftask" data-tombol="Ya" data-message="Akan memverifikasi data <br> '.$field->nama_barang.'" style="padding: 2px 3px !important" id="verifrek'.$field->idu.'" rel="'.$field->idu.'" title="'.$field->idu.'"><span>Verify</span></a>';
            }else{
                if(datauser($this->session->userdata('id'),'cekbatalstok')==1){
                    $buton = '<a href="'.base_url() . 'inv/batalverifikasidata/'.$field->idu.'" data-bs-toggle="modal" data-bs-target="#canceltask" data-tombol="Ya" data-message="Akan membatalkan verifikasi data <br> '.$field->nama_barang.'" style="padding: 2px 3px !important" id="verifrek'.$field->idu.'" rel="'.$field->idu.'" title="'.$field->idu.'">
                          verified : '.substr(datauser($field->user_verif,'username'),0,9).'<br>
                          <span class="font-10">'.$field->tgl_verif.'</span>
                        </a>';
                }else{
                    $buton = 'verified : '.substr(datauser($field->user_verif,'username'),0,9).'<br>
                          <span class="font-10">'.$field->tgl_verif.'</span>';
                }
            }
            $row = array();
            $row[] = '<a href="'.base_url() . 'inv/viewdetailwip/' . $isi.'" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail" title="View Detail" id="namabarang" rel="'.$field->id_barang.'" rel2="'.$field->nama_barang.'" rel3="'.$isi.'" style="text-decoration: none;" class="'.$cx.'">'.$spekbarang.'</a>';
            $row[] = viewsku(id: $field->kode, po: $field->po, no: $field->item, dis: $field->dis);
            $row[] = $field->nobontr;
            $row[] = $field->insno;
            $row[] = $field->kodesatuan;
            $row[] = $field->nomor_bc;
            $row[] = $field->nobale;
            $row[] = rupiah($sak, 2);
            $row[] = rupiah($sakkg, 2);
            $row[] = '';
            $row[] = $buton;

            $data[] = $row;
            $pecees += $sak;
        }
        // $kagees = 1000000;
        $this->session->set_userdata('jmlrec',$this->invmodel->count_allgf());
        $output = array(
            "zzz" => $this->invmodel->getkgspcsgf($filter_kategori,$filt_ifndln),
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invmodel->count_allgf(),
            "recordsFiltered" => $this->invmodel->count_filteredgf($filter_kategori,$filt_ifndln),
            "data" => $data,
        );
        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
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

        $sheet->setCellValue('A1', "DATA INVENTORY ".$this->session->userdata('currdeptbcwip')); 
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        $sheet->setCellValue('A2', "Periode : ".$this->session->userdata('tglawalbcgf')." s/d ".$this->session->userdata('tglakhirbcgf')); 
        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B3', "KODE BARANG"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C3', "NAMA BARANG"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D3', "SATUAN");
        $sheet->setCellValue('E3', "BALE NO");
        $sheet->setCellValue('F3', "S.Awal (Pcs)");
        $sheet->setCellValue('G3', "S.Awal (Kgs)");
        $sheet->setCellValue('H3', "IN (Pcs)");
        $sheet->setCellValue('I3', "IN (Kgs)");
        $sheet->setCellValue('J3', "OUT (Pcs)");
        $sheet->setCellValue('K3', "OUT (Kgs)");
        $sheet->setCellValue('L3', "S.Akhir (Pcs)");
        $sheet->setCellValue('M3', "S.Akhir (Kgs)");
        // Panggil model Get Data   
        $data = $this->bcgfmodel->getdatahasil();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 4;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($data->result_array() as $data) {
            // Lakukan looping pada variabel      
            $sku = trim($data['xpo'])=='' ? namaspekbarang($data['id_barang'],'kode') : viewsku($data['xpo'],$data['xitem'],$data['xdis']);
            $saldo = $data['saldokgs']+$data['inkgs']-$data['outkgs']+$data['adjkgs'];
            $saldopcs = $data['saldopcs']+$data['inpcs']-$data['outpcs']+$data['adjpcs'];

            $adjpcsplus = 0;$adjkgsplus = 0;
            $adjpcsmin = 0;$adjkgsmin = 0;
            if($data['adjpcs']!=0 || $data['adjkgs']!=0){
                if($data['adjpcs'] > 0){
                    $adjpcsplus = $data['adjpcs'];
                }else{
                    $adjpcsmin = $data['adjpcs']*-1;
                }
                if($data['adjkgs'] > 0){
                    $adjkgsplus = $data['adjkgs'];
                }else{
                    $adjkgsmin = $data['adjkgs']*-1;
                }
            }
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, $data['spek']);
            $sheet->setCellValue('D' . $numrow, 'KGS');
            $sheet->setCellValue('E' . $numrow, $data['nobale']);
            $sheet->setCellValue('F' . $numrow, rupiah($data['saldopcs'],0));
            $sheet->setCellValue('G' . $numrow, rupiah($data['saldokgs'],2));
            $sheet->setCellValue('H' . $numrow, rupiah($data['inpcs']+$adjpcsplus,2));
            $sheet->setCellValue('I' . $numrow, rupiah($data['inkgs']+$adjkgsplus,2));
            $sheet->setCellValue('J' . $numrow, rupiah($data['outpcs']+$adjpcsmin,2));
            $sheet->setCellValue('K' . $numrow, rupiah($data['outkgs']+$adjkgsmin,2));
            $sheet->setCellValue('L' . $numrow, rupiah($saldopcs,2));
            $sheet->setCellValue('M' . $numrow, rupiah($saldo,2));
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Satuan");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Inv GF.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA SATUAN');
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
        $pdf->Cell(30, 18, 'DATA SATUAN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Kode Satuan', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Kode Bc', 1, 0, 'C');
        $pdf->Cell(100, 8, 'Nama Satuan', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->satuanmodel->getdata();
        $no = 1;
        foreach ($detail->result_array() as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(35, 6, $det['kodesatuan'], 1);
            $pdf->Cell(35, 6, $det['kodebc'], 1);
            $pdf->Cell(100, 6, $det['namasatuan'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Satuan.pdf');
        $this->helpermodel->isilog('Download PDF DATA SATUAN');
    }
}
