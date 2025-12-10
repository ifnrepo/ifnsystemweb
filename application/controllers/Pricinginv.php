<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pricinginv extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('pricinginv_model', 'pricingmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept_pb($this->session->userdata('arrdep'));
        $data['depe'] = $this->pricingmodel->getdepe();
        $data['tglreq'] = $this->pricingmodel->gettglreq();
        $data['usersaveinv'] = $this->pricingmodel->usersaveinv();
        $data['userlockinv'] = $this->pricingmodel->userlockinv();
        $data['datkategori'] = $this->pricingmodel->getdatkategori();
        $data['tglkunci'] = $this->pricingmodel->tglkunci();
        $data['levnow'] = $this->session->userdata['level_user'] == 1 ? 'disabled' : '';
        $kode = [
            'dept_id' => $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang'),
            'level' => $this->session->userdata('levelsekarang') == null ? '' : $this->session->userdata('levelsekarang'),
        ];
        $data['data'] = $this->pb_model->getdatapb($kode);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'pricinginv';
        $this->load->view('layouts/header', $header);
        $this->load->view('pricinginv/pricinginv', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('deptsekarang');
        $this->session->unset_userdata('tujusekarang');
        $this->session->unset_userdata('levelsekarang');
        $this->session->unset_userdata('tglpricinginv');
        $this->session->unset_userdata('deptpricinginv');
        $this->session->unset_userdata('milik');
        $this->session->set_userdata('blpricing', date('m'));
        $this->session->set_userdata('thpricing', date('Y'));
        $this->session->set_userdata('levelsekarang', 1);
        $url = base_url('pricinginv');
        redirect($url);
    }
    public function getdata()
    {
        $this->session->set_userdata('blpricing', $_POST['bl']);
        $this->session->set_userdata('thpricing', $_POST['th']);
        $this->session->set_userdata('levelsekarang', $_POST['levelsekarang']);
        $this->session->unset_userdata('tglpricinginv');
        $this->session->unset_userdata('deptpricinginv');
        $this->session->unset_userdata('milik');
        echo 1;
    }
    public function getdatacutoff(){
        $this->session->set_userdata('tglpricinginv',$_POST['tglcutoff']);
        $this->session->set_userdata('deptpricinginv',$_POST['deptcutoff']);
        $this->session->set_userdata('milik',$_POST['milik']);
        echo 1;
    }
    public function gettglcutoff(){
        $dept = $_POST['dept'];
        $data = $this->pricingmodel->gettglcutoff($dept);
        $html = '<option value="all">-- Pilih Tgl Cut Off --</option>';
        foreach($data->result_array() as $data){
            $html .= '<option value="'.$data['tgl'].'">'.tglmysql($data['tgl']).'</option>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function getdatainv(){
        $arrayu = [];
        $filter_dept = $_POST['dept'];
        $filter_tgl = $_POST['tgl'];
        $filter_periode = $_POST['periode'];
        $filter_ctgr = $_POST['ctgr'];
        // $filter_buyer = $_POST['buyer'];
        // $filter_exnet = $_POST['exnet'];
        // if($filter_dept!=''){
        //     $arrayu['dept_id'] = $filter_dept;
        // }
        // if($filter_tgl!=""){
        //     $arrayu['tgl'] = $filter_tgl;
        // }else{
        //     $arrayu['tgl'] = '1970-01-01';
        // }
        if($filter_periode!="all"){
            $arrayu['periode'] = $filter_periode;
        }
        if($filter_ctgr!=''){
            $arrayu["LEFT(CONCAT(IFNULL(yidkategori,''),IFNULL(xidkategori,'')),4)"] = $filter_ctgr;
        }
        // if($filter_exnet!='all'){
        //     $arrayu['exnet'] = $filter_exnet;
        // }
        echo $this->pricingmodel->getdatainv($arrayu);
    }
    public function getdatainvdet(){
        $arrayu = [];
        $filter_dept = $_POST['dept'];
        $filter_tgl = $_POST['tgl'];
        $filter_periode = $_POST['periode'];
        $filter_ctgr = $_POST['ctgr'];
        // $filter_buyer = $_POST['buyer'];
        // $filter_exnet = $_POST['exnet'];
        // if($filter_dept!=''){
        //     $arrayu['dept_id'] = $filter_dept;
        // }
        // if($filter_tgl!=""){
        //     $arrayu['tgl'] = $filter_tgl;
        // }else{
        //     $arrayu['tgl'] = '1970-01-01';
        // }
        if($filter_periode!="all"){
            $arrayu['periode'] = $filter_periode;
        }
         if($filter_ctgr!=''){
            $arrayu["LEFT(CONCAT(IFNULL(yid_kategori,''),IFNULL(xid_kategori,'')),4)"] = $filter_ctgr;
        }
        // if($filter_buyer!='all'){
        //     $arrayu['id_buyer'] = $filter_buyer;
        // }
        // if($filter_exnet!='all'){
        //     $arrayu['exnet'] = $filter_exnet;
        // }
        echo $this->pricingmodel->getdatainvdet($arrayu);
    }
    public function addcutoff(){
        $this->load->view('pricinginv/addcutoff');
    }
    public function simpancutoff(){
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'catatan' => $_POST['cttn'],
            'user_add' => $this->session->userdata('id'),
            'tgl_add' => date('Y-m-d H:i:s')
        ];
        $send = $this->pricingmodel->simpancutoff($data);
        echo $send;
    }
    public function getdeptoncutoff(){
        $this->session->unset_userdata('deptpricinginv');
        $tgl = tglmysql($_POST['tgl']);
        $data = $this->pricingmodel->getdepe();
        $html = '<option value="">Semua</option>';
        foreach($data->result_array() as $data){
            $selek = $this->session->userdata('deptpricinginv')==$data['dept_id'] ? 'selected' : '';
            $ada = $this->pricingmodel->getdeptoncutoff($data['dept_id'],tglmysql($tgl));
            $html .= '<option value="'.$data['dept_id'].'" '.$ada.' '.$selek.'>'.$data['departemen'].'</option>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function breakdownbom(){
        $this->load->view('pricinginv/konfirmasibom');
    }
    public function breakdowninv(){
        $hasil = $this->pricingmodel->breakdowninv();
        echo $hasil;
    }
    public function lockinv(){
        $hasil = $this->pricingmodel->lockinv();
        if($hasil){
            $url = base_url().'pricinginv';
            redirect($url);
        }
    }
    public function unlockinv(){
        $hasil = $this->pricingmodel->unlockinv();
        if($hasil){
            $url = base_url().'pricinginv';
            redirect($url);
        }
    }

    // End Pricing Inv
    public function getdatadetailpb()
    {
        $kode = $_POST['id_header'];
        $data = $this->pb_model->getdatadetailpb($kode);
        $hasil = '';
        $no = 1;
        $jml = count($data);
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>" . $dt['nama_barang'] . "</td>";
            $hasil .= "<td>" . $dt['kode'] . "</td>";
            $hasil .= "<td>" . $dt['namasatuan'] . "</td>";
            $hasil .= "<td class='text-center'>" . rupiah($dt['pcs'], 0) . "</td>";
            $hasil .= "<td>" . rupiah($dt['kgs'], 2) . "</td>";
            $hasil .= "<td class='text-center font-bold'>" . $dt['sublok'] . "</td>";
            $hasil .= "<td class='text-center'>";
            $hasil .= "<a href='#' id='editdetailpb' rel='" . $dt['id'] . "' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='" . base_url() . 'pb/hapusdetailpb/' . $dt['id'] . "' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil, 'jmlrek' => $jml);
        echo json_encode($cocok);
    }
    public function tambahdata()
    {
        $this->load->view('pb/add_pb');
    }
    public function edittgl()
    {
        $this->load->view('pb/edit_tgl');
    }
    public function depttujupb()
    {
        $kode = $_POST['kode'];
        $this->session->set_userdata('deptsekarang', $kode);
        $cekdata = $this->pb_model->depttujupb($kode);
        echo $cekdata;
    }
    public function tambahpb()
    {
        if ($this->session->userdata('deptsekarang') == '' || $this->session->userdata('deptsekarang') == null || $this->session->userdata('tujusekarang') == '' || $this->session->userdata('tujusekarang') == null) {
            $this->session->set_flashdata('errorparam', 1);
            echo 0;
        } else {
            $data = [
                'dept_id' => $_POST['dept_id'],
                'dept_tuju' => $_POST['dept_tuju'],
                'tgl' => tglmysql($_POST['tgl']),
                'kode_dok' => 'PB',
                'id_perusahaan' => IDPERUSAHAAN,
                'pb_sv' => $_POST['jn'],
                'nomor_dok' => nomorpb(tglmysql($_POST['tgl']), $_POST['dept_id'], $_POST['dept_tuju'], $_POST['jn'])
            ];
            $simpan = $this->pb_model->tambahpb($data);
            echo $simpan['id'];
        }
    }
    public function updatepb()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id'],
            'nomor_bc' => $_POST['nombc']
        ];
        $simpan = $this->pb_model->updatepb($data);
        echo $simpan;
    }
    public function simpanpb($id)
    {
        $data = [
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d H:i:s'),
            'user_ok' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->pb_model->simpanpb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function validasipb($id)
    {
        $cek = $this->pb_model->cekfield($id, 'data_ok', 1)->num_rows();
        if ($cek == 1) {
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->pb_model->validasipb($data);
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function editvalidasipb($id)
    {
        $data = [
            'ok_valid' => 0,
            'tgl_valid' => null,
            'user_valid' => null,
            'id' => $id
        ];
        $simpan = $this->pb_model->validasipb($data);
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function editokpb($id)
    {
        $cek = $this->pb_model->cekfield($id, 'ok_valid', 0)->num_rows();
        if ($cek == 1) {
            $data = [
                'data_ok' => 0,
                'tgl_ok' => null,
                'user_ok' => null,
                'id' => $id
            ];
            $simpan = $this->pb_model->validasipb($data);
        } else {
            $this->session->set_flashdata('pesanerror', 'Bon permintaan sudah divalidasi !');
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function cancelpb($id)
    {
        $data['id'] = $id;
        $this->load->view('pb/cancelpb', $data);
    }
    public function simpancancelpb()
    {
        $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $hasil = $this->pb_model->simpancancelpb($data);
        echo $hasil;
    }
    public function datapb($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->pb_model->getdatabyid($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $data['sublok'] = $this->helpermodel->getdatasublok()->result_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'pb';
        $this->load->view('layouts/header', $header);
        $this->load->view('pb/datapb', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusdata($id)
    {
        $hasil = $this->pb_model->hapusdata($id);
        if ($hasil) {
            $url = base_url() . 'pb';
            redirect($url);
        }
    }
    public function addspecbarang()
    {
        $this->load->view('pb/addspecbarang');
    }
    public function getspecbarang()
    {
        $mode = $_POST['mode'];
        $brg = $_POST['data'];
        $html = '';
        $query = $this->pb_model->getspecbarang($mode, $brg);
        foreach ($query as $que) {
            $html .= "<tr>";
            $html .= "<td>" . $que['nama_barang'] . "</td>";
            $html .= "<td>" . $que['kode'] . "</td>";
            $html .= "<td>-</td>";
            $html .= "<td>";
            $html .= "<a href='#' class='btn btn-sm btn-success pilihbarang' style='padding: 3px !important;' rel1='" . $que['nama_barang'] . "' rel2='" . $que['id'] . "' rel3=" . $que['id_satuan'] . " rel4=" . $que['dln'] . ">Pilih</a>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function getdetailpbbyid()
    {
        $data = $_POST['id'];
        $hasil = $this->pb_model->getdatadetailpbbyid($data);
        echo json_encode($hasil);
    }
    public function simpandetailbarang()
    {
        $hasil = $this->pb_model->simpandetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function updatedetailbarang()
    {
        $hasil = $this->pb_model->updatedetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function hapusdetailpb($id)
    {
        $hasil = $this->pb_model->hapusdetailpb($id);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'pb/datapb/' . $kode;
            redirect($url);
        }
    }
    public function viewdetailpb($id, $mode = 0)
    {
        $data['header'] = $this->pb_model->getdatabyid($id);
        $data['detail'] = $this->pb_model->getdatadetailpb($id);
        $data['riwayat'] = riwayatdok($id);
        $data['mode'] = $mode;
        $this->load->view('pb/viewdetailpb', $data);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    function cetakqr2($isi, $id)
    {
        $tempdir = "temp/";
        $namafile = $id;
        $codeContents = $isi;
        $iconpath = "assets/image/BigLogo.png";
        QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_H, 4, 1);
        $filepath = $tempdir . $namafile . '.png';
        $QR = imagecreatefrompng($filepath);

        $logo = imagecreatefromstring(file_get_contents($iconpath));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        //besar logo
        $logo_qr_width = $QR_width / 4.3;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        //posisi logo
        imagecopyresampled($QR, $logo, $QR_width / 2.7, $QR_height / 2.7, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        imagepng($QR, $filepath);
        return $tempdir . $namafile;
    }
    public function cetakbon($id)
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        // $pdf->SetFillColor(7,178,251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/ifnLogo.png', 14, 10, 22);
        $pdf->Cell(30, 18, '', 1);
        $pdf->SetFont('Latob', '', 18);
        $pdf->Cell(120, 18, 'BON PERMINTAAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(14, 6, 'No Dok', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, 'FM-GD-03', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Revisi', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, '1', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Tanggal', 'TB');
        $pdf->Cell(2, 6, ':', 'TB');
        $pdf->Cell(24, 6, '10-04-2007', 'TRB');
        $pdf->ln(6);
        $pdf->Cell(190, 1, '', 1, 0, '', 1);
        $pdf->ln(1);
        $header = $this->pb_model->getdatabyid($id);
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . 'dibuat oleh : ' . datauser($header['user_ok'], 'name') . "\r\n" . 'Date : ' . tglmysql2($header['tgl_ok']);
        if ($header['ok_valid'] == 1) {
            $isi .= "\r\n" . 'disetujui oleh : ' . datauser($header['user_valid'], 'name') . "\r\n" . 'Date : ' . tglmysql2($header['tgl_valid']);
        }
        $qr = $this->cetakqr2($isi, $header['id']);
        $pdf->Image($qr . ".png", 177, 30, 18);
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(18, 5, 'Nomor', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['nomor_dok'], 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, 'Diperiksa & Disetujui Oleh', 'R', 0);
        $pdf->Cell(41, 5, 'Tanda Tangan', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Dept', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['departemen'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(41, 5, substr(datauser($header['user_valid'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['tgl'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(41, 5, substr(datauser($header['user_valid'], 'jabatan'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(80, 5, '', 'LBR', 0);
        $pdf->Cell(41, 5, '', 'BR', 0);
        $pdf->Cell(41, 5, '', 'BR', 0);
        $pdf->Cell(28, 5, '', 'BR', 1);
        $pdf->Cell(190, 1, '', 1, 1, '', 1);
        $pdf->Cell(8, 8, 'No', 'LRB', 0);
        $pdf->Cell(97, 8, 'Spesifikasi Barang', 'LRB', 0, 'C');
        $pdf->Cell(45, 8, 'Keterangan', 'LRB', 0, 'C');
        $pdf->Cell(20, 8, 'Jumlah', 'LRB', 0, 'C');
        $pdf->Cell(20, 8, 'Satuan', 'LRB', 1, 'C');
        $detail = $this->pb_model->getdatadetailpb($id);
        $no = 1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs'] == 0 ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(8, 6, $no++, 'LRB', 0);
            $pdf->Cell(97, 6, utf8_decode($det['nama_barang']), 'LBR', 0);
            $pdf->Cell(45, 6,  $det['keterangan'], 'LRB', 0);
            $pdf->Cell(20, 6, rupiah($jumlah, 0), 'LRB', 0, 'R');
            $pdf->Cell(20, 6, $det['kodesatuan'], 'LBR', 1, 'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(15, 5, 'Catatan : ', 0);
        $pdf->Cell(19, 5, 'Dokumen ini sudah ditanda tangani secara digital', 0);
        $pdf->Output('I', 'FM-GD-03.pdf');
    }
}
