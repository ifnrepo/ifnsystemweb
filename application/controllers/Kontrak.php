<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('kontrak_model', 'kontrakmodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['deprekanan'] = $this->helpermodel->getkontrakrekanan();
        if ($this->session->userdata('statuskontrak') == "") {
            $this->session->set_userdata('statuskontrak', 1);
        }
        $kode = [
            'dept_id' => $this->session->userdata('deptkontrak') == null ? '' : $this->session->userdata('deptkontrak'),
            'jnsbc' => $this->session->userdata('jnsbckontrak') == null ? '' : $this->session->userdata('jnsbckontrak'),
            'status' => $this->session->userdata('statuskontrak'),
            'thkontrak' => $this->session->userdata('thkontrak') == null ? '' : $this->session->userdata('thkontrak'),
        ];
        $this->session->unset_userdata('sesikontrak');
        $data['data'] = $this->kontrakmodel->getdatakontrak($kode);
        $data['jmlpcskgs'] = $this->kontrakmodel->getdatapcskgskontrak($kode)->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'kontrak';
        $this->load->view('layouts/header', $header);
        $this->load->view('kontrak/kontrak', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('deptkontrak');
        $this->session->unset_userdata('jnsbckontrak');
        $this->session->unset_userdata('statuskontrak');
        $this->session->set_userdata('thkontrak', date('Y'));
        $this->session->set_userdata('bl', date('m'));
        $this->session->set_userdata('th', date('Y'));
        $url = base_url('Kontrak');
        redirect($url);
    }
    public function adddata()
    {
        $header['header'] = 'transaksi';
        $data['mode'] = 'INPUT';
        if ($this->session->userdata('sesikontrak') == '') {
            $data['data'] = $this->kontrakmodel->adddata()->row_array();
        } else {
            $data['data'] = $this->kontrakmodel->getdata($this->session->userdata('sesikontrak'))->row_array();
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'kontrak';
        $this->load->view('layouts/header', $header);
        $this->load->view('kontrak/addkontrak', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function editdata($sesi)
    {
        $header['header'] = 'transaksi';
        $data['mode'] = 'EDIT';
        $this->session->set_userdata('sesikontrak', $sesi);
        $data['data'] = $this->kontrakmodel->getdata($this->session->userdata('sesikontrak'))->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'kontrak';
        $this->load->view('layouts/header', $header);
        $this->load->view('kontrak/addkontrak', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function getdata()
    {
        $this->session->set_userdata('deptkontrak', $_POST['dept_id']);
        $this->session->set_userdata('jnsbckontrak', $_POST['jnsbc']);
        $this->session->set_userdata('statuskontrak', $_POST['status']);
        $this->session->set_userdata('thkontrak', $_POST['thkontrak']);
        // $url = base_url('kontrak');
        // redirect($url);
        echo 1;
    }

    public function hapuskontrak($id)
    {
        $hapus = $this->kontrakmodel->hapuskontrak($id);
        if ($hapus) {
            $url = base_url('kontrak');
            redirect($url);
        }
    }
    public function simpankontrak()
    {
        $data = $_POST;
        $simpan = $this->kontrakmodel->simpankontrak($data);
        if ($simpan) {
            $url = base_url('kontrak');
            redirect($url);
        }
    }
    public function loaddetailkontrak()
    {
        $id = $_POST['id'];
        $mode = $_POST['mode'];
        $part_of_url = $mode == 'INPUT' ? 'adddata' : 'editdata';
        $data = $this->kontrakmodel->loaddetailkontrak($id);
        $html = '';
        foreach ($data->result_array() as $det) {
            $html .= '<tr>';
            $html .= '<td>' . $det['kategori'] . '</td>';
            $html .= '<td>' . $det['uraian'] . '</td>';
            $html .= '<td>' . $det['hscode'] . '</td>';
            $html .= '<td class="text-right">' . rupiah($det['pcs'], 0) . '</td>';
            $html .= '<td class="text-right">' . rupiah($det['kgs'], 2) . '</td>';
            $html .= '<td class="text-center"><a href="#" class="btn btn-sm btn-danger btn-flat p-0" style="padding: 2px 3px !important;" data-href="' . base_url() . 'kontrak/hapusdetailkontrak/' . $det['id'] . '/' . $part_of_url . '" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Hapus Detail Kontrak">Hapus</a></td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function adddetail($idkontrak)
    {
        $data['idkontrak'] = $idkontrak;
        $this->load->view('kontrak/adddetail', $data);
    }
    public function view($sesi, $mode = 0)
    {
        $this->session->set_userdata('sesikontrak', $sesi);
        $data['header'] = $this->kontrakmodel->getdata($this->session->userdata('sesikontrak'))->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $data['detail'] = $this->kontrakmodel->getDetail_kontrak($sesi);
        $data['terima'] = $this->kontrakmodel->getdatapengembalian($sesi);
        $data['mode'] = $mode;
        $this->load->view('kontrak/view', $data);
    }
    public function simpandetailkontrak()
    {
        $data = [
            'id_kontrak' => $_POST['id_kontrak'],
            'kode_kategori' => $_POST['kode_kategori'],
            'kategori' => $_POST['kategori'],
            'uraian' => $_POST['uraian'],
            'hscode' => $_POST['hscode'],
            'pcs' => toangka($_POST['pcs']),
            'kgs' => toangka($_POST['kgs']),
        ];
        $simpan = $this->kontrakmodel->simpandetailkontrak($data);
        echo $simpan;
    }
    public function hapusdetailkontrak($id, $id2)
    {
        $hapus = $this->kontrakmodel->hapusdetailkontrak($id);
        if ($hapus) {
            $url = base_url('kontrak/' . $id2);
            redirect($url);
        }
    }
    public function viewdetail($id, $mode = 0)
    {
        $data['header'] = $this->kontrakmodel->getdata($id)->row_array();
        $data['transaksi'] = $this->kontrakmodel->gettransaksikontrak($id);
        $this->load->view('kontrak/viewdetail', $data);
    }
    public function simpankedatabase()
    {
        $data = [
            'tabel' => $_POST['tbl'],
            'kolom' => $_POST['kolom'],
            'isi' => $_POST['data'],
            'id' => $_POST['aidi']
        ];
        $hasil = $this->kontrakmodel->simpankedatabase($data);
        echo $hasil;
    }
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
            'id' => $_POST['id']
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
    public function viewdetailpb($id)
    {
        $data['header'] = $this->pb_model->getdatabyid($id);
        $data['detail'] = $this->pb_model->getdatadetailpb($id);
        $data['riwayat'] = riwayatdok($id);
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
