<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('po_model', 'pomodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('supplier_model', 'suppliermodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('mtuangmodel');
        $this->load->model('helper_model','helpermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $kode = [
            'jnpo' => $this->session->userdata('jn_po') == null ? 'DO' : $this->session->userdata('jn_po'),
        ];
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $data['data'] = $this->pomodel->getdata($kode);
        $footer['fungsi'] = 'po';
        $this->load->view('layouts/header', $header);
        $this->load->view('po/po', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->set_userdata('bl', (int)date('m'));
        $this->session->set_userdata('th', date('Y'));
        $this->session->set_userdata('jn_po', 'DO');
        $url = base_url() . 'po';
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function getdatapo()
    {
        $this->session->set_userdata('jn_po', $_POST['jn']);
        echo 1;
    }
    public function tambahdatapo()
    {
        $kode = $this->pomodel->tambahdatapo();
        if ($kode) {
            $url = base_url() . 'po/datapo/' . $kode;
            redirect($url);
        }
    }
    public function datapo($kode)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->pomodel->getdatabyid($kode);
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $jne = $this->session->userdata('jn_po')=='DO' ? 0 : 1;
        $data['termspay'] = $this->helpermodel->getterms($jne);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'po';
        $this->load->view('layouts/header', $header);
        $this->load->view('po/datapo', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function updatepo()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            // 'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->pomodel->updatepo($data);
        echo $simpan;
    }
    public function getbarangpo()
    {
        // $data['datadetail'] = $this->pomodel->getbarangpo();
        $this->load->view('po/getbarangpo');
    }
    public function getdetailbarangpo(){
        $data = $_POST['data'];
        $query = $this->pomodel->getbarangpo($data);
        $html  = '';
        $no=0; 
        foreach ($query->result_array() as $que) { $no++;
            $html .= "<tr>";
            $html .= "<td>".$que['nomor_dok']."</td>";
            $html .= "<td>" . $que['nomorpb'] . "</td>";
            $html .= "<td>" . $que['nama_barang'] . "</td>";
            $html .= "<td>";
            $html .= "<label class='form-check'>";
            $html .= "<input class='form-check-input' name='cekpilihbarang' title='cekbok".$no."' id='cekbok".$no."' rel='".$que['iddetbbl']."' type='checkbox'>";
            $html .= "<span class='form-check-label'>Pilih</span>";
            $html .= "</label>";
            $html .= "</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function adddetailpo(){
        $id = $_POST['id'];
        $brg = $_POST['brg'];
        $data = [
            'id' => $id,
            'data' => $brg
        ];
        $simpan = $this->pomodel->adddetailpo($data);
        echo $simpan;
    }

    public function getdata()
    {
        $this->session->set_userdata('deptsekarang', $_POST['dept_id']);
        $this->session->set_userdata('tujusekarang', $_POST['dept_tuju']);
        echo 1;
    }
    public function getdatadetailpo()
    {
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->pomodel->getdatadetailpo($id);
        $totalharga = 0;
        $no = 0;
        foreach ($query as $que) {
            $no++;
            $tampil = $que['pcs']==0 ? $que['kgs'] : $que['pcs'];
            $hasil .= "<tr>";
            $hasil .= "<td>" . $no . "</td>";
            $hasil .= "<td>" . $que['nama_barang'] . "</td>";
            $hasil .= "<td>" . $que['brg_id'] . "</td>";
            $hasil .= "<td>" . rupiah($tampil, 0) . "</td>";
            $hasil .= "<td>" . $que['namasatuan'] . "</td>";
            $hasil .= "<td>" . rupiah($que['harga'], 4) . "</td>";
            $hasil .= "<td>" . rupiah($que['harga']*$tampil, 2) . "</td>";
            $hasil .= "<td>";
            $hasil .= "<a href=" . base_url() . 'po/editdetailpo/' . $que['id'] . " class='btn btn-sm btn-primary mr-1' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "<a href='#' data-href=" . base_url() . 'po/hapusdetailpo/' . $que['id'] .'/'.$que['id_header']. " class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-message='Akan menghapus data ini ' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $totalharga += $que['harga']*$tampil;
        }
        $cocok = array('datagroup' => $hasil,'totalharga' => $totalharga);
        echo json_encode($cocok);
    }
    public function editdetailpo($id){
        $data['data'] = $this->pomodel->getdetailpobyid($id);
        $this->load->view('po/editdetailpo',$data);
    }
    public function hapusdetailpo($id,$detid){
        $hasil = $this->pomodel->hapusdetailpo($id);
        if($hasil){
            $url = base_url().'po/datapo/'.$detid;
            redirect($url);
        }
    }
    public function updatehargadetail()
    {
        $kondisi = [
            'id' => $_POST['id'],
            'harga' => $_POST['harga'],
            'pcs' => $_POST['qty'],
        ];
        $hasil = $this->pomodel->updatehargadetail($kondisi);
        echo $hasil;
    }

    public function edittgl()
    {
        $this->load->view('po/edit_tgl');
    }
    public function editsupplier()
    {
        $this->load->view('po/editsupplier');
    }
    public function getsupplierbyname()
    {
        $nama = $_POST['data'];
        $hasil = '';
        $query = $this->suppliermodel->getdatabyname($nama);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $hasil .= "<tr>";
                $hasil .= "<td class='text-primary'>" . $data['nama_supplier'] . "</td>";
                $hasil .= "<td>" . substr($data['alamat'], 0, 35) . "</td>";
                $hasil .= "<td><a href='#' class='btn btn-sm btn-success' rel='" . $data['id'] . "' id='pilihsupplier'>Pilih</a></td></tr>";
            }
        } else {
            $hasil .= "<tr>";
            $hasil .= '<td colspan="3" class="text-center">No Data / Cari dahulu data</td></tr>';
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function editdetailout($id)
    {
        $data['data'] = $this->out_model->getdatadetailoutbyid($id);
        $this->load->view('out/editdetailout', $data);
    }
    public function invoice($id)
    {
        $header['header'] = 'transaksi';
        $data['header'] = $this->pomodel->getdatabyid($id);
        $data['detail'] = $this->pomodel->getdatadetailpo($id);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'po';
        $this->load->view('layouts/header', $header);
        $this->load->view('po/invoice',$data);
        $this->load->view('layouts/footer', $footer);
    }
    public function addnobontr($id, $idbarang)
    {
        $data['data'] = $this->out_model->getdatagm($idbarang);
        $data['iddetail'] = $id;
        $data['header'] = $this->out_model->getdatagm($idbarang)->row_array();
        $this->load->view('out/addnobontr', $data);
    }
    public function editnobontr()
    {
        $data = [
            'idstok' => $_POST['id'],
            'nobontr' => $_POST['bon'],
            'id' => $_POST['idd']
        ];
        $hasil = $this->out_model->editnobontr($data);
        echo $hasil;
    }
    public function updatedetail()
    {
        $data = [
            'id' => $_POST['id'],
            'kgs' => $_POST['kgs'],
            'pcs' => $_POST['pcs'],
            'tempbbl' => $_POST['tempbbl']
        ];
        $query = $this->out_model->updatedetail($data);
        echo $query;
    }
    public function updatesupplier(){
        $data = [
            'id' => $_POST['id'],
            'id_supplier' => $_POST['rel']
        ];
        $hasil = $this->pomodel->updatesupplier($data);
        echo $hasil;
    }
    public function updatebykolom($kolom){
        $data = [
            'id' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->pomodel->updatebykolom($data);
        echo $hasil;
    }
    public function updatekolom($kolom){
        $data = [
            'id_header' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->pomodel->updatekolom($_POST['tbl'],$data,'id_header');
        echo $hasil;
    }

    public function simpanpo($id)
    {
        $cekdetail = $this->pomodel->cekdetail($id);
        if($cekdetail['xharga']==0){
            $data = [
                'user_ok' => $this->session->userdata('id'),
                'data_ok' => 1,
                'tgl_ok' => date('Y-m-d H:i:s'),
                'id' => $id,
                'totalharga' => $cekdetail['totalharga'],
                'total' => 'totalharga - diskon',
                'jumlah' => '((totalharga-diskon)+ppn)-pph'
            ];
            $query = $this->pomodel->simpanpo($data);
            if ($query) {
                $url = base_url() . 'po';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $url = base_url() . 'po/datapo/'.$id;
            redirect($url);
        }
    }
    public function hapuspo($id)
    {
        $cek = $this->pomodel->cekfield($id,'data_ok',0)->num_rows();
        if($cek==1){
            $query = $this->pomodel->hapuspo($id);
            if ($query) {
                $url = base_url() . 'po';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',2);
            $url = base_url().'po';
            redirect($url);
        }
    }
    public function editpo($id){
        $cek = $this->pomodel->cekfield($id,'ok_valid',0)->num_rows();
        if($cek==1){
            $data = [
                'data_ok' => 0,
                'user_ok' => null,
                'tgl_ok' => null,
                'id' => $id
            ];
            $hasil = $this->pomodel->editpo($data);
            if($hasil){
                $url = base_url().'po';
                redirect($url);
            }else{
                $this->session->set_flashdata('errorsimpan',3);
                $url = base_url().'po';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',2);
            $url = base_url().'po';
            redirect($url);
        }
    }
    public function viewdetail($id,$mode=0)
    {
        $data['header'] = $this->pomodel->getdatabyid($id);
        $data['detail'] = $this->pomodel->getdatadetailpo($id);
        $data['riwayat'] = riwayatpo($id);
        $data['mode'] = $mode;
        $this->load->view('po/viewdetailpo', $data);
    }
    public function resetdetail($id)
    {
        $query = $this->out_model->resetdetail($id);
        if ($query) {
            $url = base_url() . 'out/dataout/' . $id;
            redirect($url);
        }
    }
    public function simpanheaderout($id)
    {
        $query = $this->out_model->simpanheaderout($id);
        if ($query) {
            $url = base_url() . 'out';
        } else {
            $url = base_url() . 'out/dataout/' . $id;
        }
        redirect($url);
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
        $pdf->Cell(120, 18, 'BON PERPINDAHAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(14, 6, 'No Dok', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, 'FM-GD-05', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Revisi', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, '1', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Tanggal', 'TB');
        $pdf->Cell(2, 6, ':', 'TB');
        $pdf->Cell(24, 6, '11-04-2007', 'TRB');
        $pdf->ln(6);
        $pdf->Cell(190, 1, '', 1, 0, '', 1);
        $pdf->ln(1);
        $header = $this->out_model->getdatabyid($id);
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . 'Dikeluarkan Oleh : ' . datauser($header['user_ok'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_ok']);
        $isi .= "\r\n" . 'Diterima Oleh : ' . datauser($header['user_tuju'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_tuju']);
        $qr = $this->cetakqr2($isi, $header['id']);
        $pdf->Image($qr . ".png", 177, 30, 18);
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(18, 5, 'Nomor', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['nomor_dok'], 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(82, 5, 'Diperiksa & Disetujui Oleh', 'RB', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Dept', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['departemen'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, tglmysql($header['tgl']), 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'jabatan'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(80, 5, '', 'LBR', 0);
        $pdf->Cell(82, 5, '', 'BR', 0);
        $pdf->Cell(28, 5, '', 'BR', 1);
        $pdf->Cell(190, 1, '', 1, 1, '', 1);
        $pdf->Cell(6, 8, 'No', 'LRB', 0, 'C');
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(17, 4, 'Nomor PO/', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(80, 8, 'Spesifikasi Barang', 'LRB', 0, 'C');
        $pdf->Cell(8, 4, 'No.', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Pcs/', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Total', 'LR', 0, 'C');
        $pdf->Cell(33, 8, 'Keterangan', 'LRB', 0, 'C');
        $pdf->ln(4);
        $pdf->Cell(6, 4, '', 0);
        $pdf->Cell(17, 4, 'No Instruksi', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Lot', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Mc', 'B', 0, 'C');
        $pdf->Cell(80, 4, '', 0);
        $pdf->Cell(8, 4, 'Bale', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Pack', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Kgs', 'RB', 1, 'C');
        $detail = $this->out_model->getdatadetailout($id);
        $no = 1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs'] == null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(6, 6, $no++, 'LRB', 0);
            $pdf->Cell(17, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(80, 6, $det['nama_barang'], 'LBR', 0);
            $pdf->Cell(8, 6, '', 'LRB', 0);
            $pdf->Cell(16, 6, rupiah($det['pcs'], 0), 'LRB', 0, 'R');
            $pdf->Cell(16, 6, rupiah($det['kgs'], 0), 'LBR', 0, 'R');
            $pdf->Cell(33, 6, $det['keterangan'], 'LBR', 1, 'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(15, 5, 'Catatan : ', 0);
        $pdf->Cell(19, 5, 'Dokumen ini sudah ditanda tangani secara digital', 0);
        $pdf->Output('I', 'FM-GD-05.pdf');
    }
}
