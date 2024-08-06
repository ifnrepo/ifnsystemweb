<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adj extends CI_Controller
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
        $this->load->model('adj_model', 'adjmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['hakdep'] = $this->deptmodel->getdata_dept_adj($this->session->userdata('arrdep'));
        $data['data'] = $this->adjmodel->getdataadj();
        $footer['fungsi'] = 'adj';
        $this->load->view('layouts/header', $header);
        $this->load->view('adj/adj', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('currdept');
        $this->session->set_userdata('bl', date('m'));
        $this->session->set_userdata('th', date('Y'));
        $url = base_url('Adj');
        redirect($url);
    }
    public function getdataadj()
    {
        $this->session->set_userdata('currdept', $_POST['dept_id']);
        $url = base_url('adj');
        redirect($url);
    }
    public function getdatadetailadj()
    {
        $kode = $_POST['id_header'];
        $data = $this->adjmodel->getdatadetailadj($kode);
        $hasil = '';
        $no = 1;
        $jml = count($data);
        $jmlkgs = 0;$jmlpcs=0;
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>" . $dt['nama_barang'] . "</td>";
            $hasil .= "<td>" . $dt['kode'] . "</td>";
            $hasil .= "<td>" . $dt['namasatuan'] . "</td>";
            $hasil .= "<td class='text-center'>" . rupiah($dt['pcs'], 0) . "</td>";
            $hasil .= "<td>" . rupiah($dt['kgs'],2) . "</td>";
            $hasil .= "<td class='text-center'>";
            $hasil .= "<a href='#' id='editdetailadj' rel='" . $dt['id'] . "' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='" . base_url() . 'adj/hapusdetailadj/' . $dt['id'] . "' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $jmlpcs += $dt['pcs'];
            $jmlkgs += $dt['kgs'];
        }
        $cocok = array('datagroup' => $hasil, 'jmlrek' => $jml, 'jmlpcs' => $jmlpcs,'jmlkgs'=>$jmlkgs);
        echo json_encode($cocok);
    }
    public function tambahdata()
    {
        // $this->load->view('pb/add_pb');
        if($this->session->userdata('currdept')!=''){
            $data = [
                'dept_id' => $this->session->userdata('currdept'),
                'dept_tuju' => $this->session->userdata('currdept'),
                'tgl' => date('Y-m-d'),
                'kode_dok' => 'ADJ',
                'id_perusahaan' => IDPERUSAHAAN,
                'nomor_dok' => nomoradj(date('Y-m-d'), $this->session->userdata('currdept'))
            ];
            $simpan = $this->adjmodel->tambahadj($data);
            if($simpan){
                $url = base_url().'adj/dataadj/'.$simpan;
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorparam',1);
            $url = base_url().'adj';
            redirect($url);
        }
    }
    public function depttujuadj()
    {
        $kode = $_POST['kode'];
        $this->session->set_userdata('currdept', $kode);
        // $cekdata = $this->adjmodel->depttujupb($kode);
        echo 1;
    }
    public function hapusdataadj($id)
    {
        $hasil = $this->adjmodel->hapusdataadj($id);
        if ($hasil) {
            $this->session->set_flashdata('errorparam',2);
            $url = base_url() . 'adj';
            redirect($url);
        }
    }
    public function addspecbarang()
    {
        $this->load->view('adj/addspecbarang');
    }
    public function getspecbarang()
    {
        $mode = $_POST['mode'];
        $brg = $_POST['data'];
        $html = '';
        $query = $this->adjmodel->getspecbarang($mode, $brg);
        foreach ($query as $que) {
            $html .= "<tr>";
            $html .= "<td>" . $que['nama_barang'] . "</td>";
            $html .= "<td>" . $que['kode'] . "</td>";
            $html .= "<td>".$que['kodesatuan']."</td>";
            $html .= "<td>";
            $html .= "<a href='#' class='btn btn-sm btn-success pilihbarang' style='padding: 3px !important;' rel1='" . $que['nama_barang'] . "' rel2='" . $que['idx'] . "' rel3=" . $que['id_satuan'] . ">Pilih</a>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function simpandetailbarang()
    {
        $hasil = $this->adjmodel->simpandetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'adj/dataadj/' . $kode;
            redirect($url);
        }
    }
    public function getdetailadjbyid()
    {
        $data = $_POST['id'];
        $hasil = $this->adjmodel->getdatadetailadjbyid($data);
        echo json_encode($hasil);
    }
    public function updatedetailbarang()
    {
        $hasil = $this->adjmodel->updatedetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'adj/dataadj/' . $kode;
            redirect($url);
        }
    }
    public function hapusdetailadj($id)
    {
        $hasil = $this->adjmodel->hapusdetailadj($id);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'adj/dataadj/' . $kode;
            redirect($url);
        }
    }
    public function simpanadj($id)
    {
        $cek = $this->adjmodel->cekfield($id,'keterangan','');
        if($cek->num_rows() > 0){
            $this->session->set_flashdata('errorparam',4);
            $url = base_url() . 'adj/dataadj/'.$id;
            redirect($url);
        }else{
            $data = [
                'data_ok' => 1,
                'tgl_ok' => date('Y-m-d H:i:s'),
                'user_ok' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->adjmodel->simpanadj($data);
            if ($simpan) {
                $url = base_url() . 'adj';
                redirect($url);
            }
        }
    }
    public function editokadj($id)
    {
        $cek = $this->adjmodel->cekfield($id,'ok_valid',0)->num_rows();
        if($cek==1){
            $data = [
                'data_ok' => 0,
                'tgl_ok' => null,
                'user_ok' => null,
                'id' => $id
            ];
            $simpan = $this->adjmodel->validasiadj($data);
        }else{
            $this->session->set_flashdata('errorparam',3);
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'adj';
            redirect($url);
        }
    }
    public function viewdetailadj($id)
    {
        $data['header'] = $this->adjmodel->getdatabyid($id);
        $data['detail'] = $this->adjmodel->getdatadetailadj($id);
        $this->load->view('adj/viewdetailadj', $data);
    }
    //END ADJ Controllers
    public function edittgl()
    {
        $this->load->view('pb/edit_tgl');
    }
    public function tambahpb()
    {
        $data = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'tgl' => tglmysql($_POST['tgl']),
            'kode_dok' => 'ADJ',
            'id_perusahaan' => IDPERUSAHAAN,
            'pb_sv' => $_POST['jn'],
            'nomor_dok' => nomorpb(tglmysql($_POST['tgl']), $_POST['dept_id'], $_POST['dept_tuju'],$_POST['jn'])
        ];
        $simpan = $this->pb_model->tambahpb($data);
        echo $simpan['id'];
    }
    public function updatepb()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->pb_model->updatepb($data);
        echo $simpan;
    }

    public function validasipb($id)
    {
        $cek = $this->pb_model->cekfield($id,'data_ok',1)->num_rows();
        if($cek==1){
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->pb_model->validasipb($data);
        }else{
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
    public function dataadj($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->adjmodel->getdatabyid($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $footer['fungsi'] = 'adj';
        $this->load->view('layouts/header', $header);
        $this->load->view('adj/dataadj', $data);
        $this->load->view('layouts/footer', $footer);
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
        QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_L, 4, 1);
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
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . datauser($header['user_tuju'], 'name') . "\r\n" . 'Date : ' . tglmysql2($header['tgl_tuju']);
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
        $pdf->Cell(41, 5, substr(datauser($header['user_tuju'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(41, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['tgl'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(41, 5, substr(datauser($header['user_tuju'], 'jabatan'), 0, 20), 'R', 0);
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
            $jumlah = $det['pcs'] == null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(8, 6, $no++, 'LRB', 0);
            $pdf->Cell(97, 6, $det['nama_barang'], 'LBR', 0);
            $pdf->Cell(45, 6, '', 'LRB', 0);
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
