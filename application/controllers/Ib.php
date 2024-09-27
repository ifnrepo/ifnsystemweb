<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('ib_model', 'ibmodel');
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
        $data['depbbl'] = $this->deptmodel->getdata_dept_bbl(1);
        $kode = $this->session->userdata('depttuju');
        $data['data'] = $this->ibmodel->getdata($kode);
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/ib', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->set_userdata('bl', (int)date('m'));
        $this->session->set_userdata('th', date('Y'));
        $this->session->set_userdata('depttuju', '');
        $url = base_url() . 'ib';
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function getdataib()
    {
        $this->session->set_userdata('depttuju', $_POST['dept']);
        echo 1;
    }
    public function tambahdataib()
    {
        if($this->session->userdata('depttuju')!=null){
            $kode = $this->ibmodel->tambahdataib();
            if ($kode) {
                $url = base_url() . 'ib/dataib/' . $kode;
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $url = base_url() . 'ib';
            redirect($url);
        }
    }
    public function cekbc()
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatabyid($kode);
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/datacekbc', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusib($id)
    {
        $query = $this->ibmodel->hapusib($id);
        if ($query) {
            $url = base_url() . 'ib';
            redirect($url);
        }
    }

    public function viewdetail($id)
    {
        $data['header'] = $this->ibmodel->getdatabyid($id);
        $data['detail'] = $this->ibmodel->getdatadetailib($id);
        $this->load->view('ib/viewdetailib', $data);
    }
    public function dataib($kode)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatabyid($kode);
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/dataib', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function updatebykolom($kolom){
        $data = [
            'id' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatebykolom($data);
        echo $hasil;
    }
    public function updatekolom($kolom){
        $data = [
            'id_header' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatekolom($_POST['tbl'],$data,'id');
        echo $hasil;
    }
    public function getbarangib($sup='')
    {
        if($sup==''){
            $data['datadetail'] = $this->ibmodel->getbarangibl();
            $this->load->view('ib/getbarangibl',$data);
        }else{
            $data['header'] = $this->suppliermodel->getdatabyid($sup);
            $data['datadetail'] = $this->ibmodel->getbarangib($sup);
            $this->load->view('ib/getbarangib',$data);
        }
    }
        public function editsupplier()
    {
        $this->load->view('ib/editsupplier');
    }
    public function adddetailib(){
        $id = $_POST['id'];
        $brg = $_POST['brg'];
        $data = [
            'id' => $id,
            'data' => $brg
        ];
        $simpan = $this->ibmodel->adddetailib($data);
        echo $simpan;
    }
    public function getdatadetailib()
    {
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->ibmodel->getdatadetailib($id);
        $header = $this->ibmodel->getdatabyid($id);
        $totalharga = 0;
        $no = 0;
        foreach ($query as $que) {
            $no++;
            $tampil = $que['pcs']==0 ? $que['kgs'] : $que['pcs'];
            $tampil2 = $que['pcsmintaa']==0 ? $que['kgsmintaa'] : $que['pcsmintaa'];
            $hasil .= "<tr>";
            $hasil .= "<td>" . $no . "</td>";
            $hasil .= "<td>" . $que['nama_barang'] . "</td>";
            $hasil .= "<td>" . $que['brg_id'] . "</td>";
            $hasil .= "<td>" . $que['namasatuan'] . "</td>";
            $hasil .= "<td>" . rupiah($tampil2, 0) . "</td>";
            $hasil .= "<td>" . rupiah($tampil, 0) . "</td>";
            if($header['jn_ib']==1){
            $hasil .= "<td>" . rupiah($que['harga'],2) . "</td>";
            }
            $hasil .= "<td>";
            $hasil .= "<a href=" . base_url() . 'ib/editdetailib/' . $que['id'] . " class='btn btn-sm btn-primary mr-1' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "<a href='#' data-href=" . base_url() . 'ib/hapusdetailib/' . $que['id'] .'/'.$que['id_header']. " class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-message='Akan menghapus data ini ' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $totalharga += $que['harga']*$tampil;
        }
        $cocok = array('datagroup' => $hasil,'totalharga' => $totalharga,'jmlrek'=>$no);
        echo json_encode($cocok);
    }
    public function hapusdetailib($id,$detid){
        $hasil = $this->ibmodel->hapusdetailib($id);
        if($hasil){
            $url = base_url().'ib/dataib/'.$detid;
            redirect($url);
        }
    }
    public function editdetailib($id){
        $data['data'] = $this->ibmodel->getdetailibbyid($id);
        $data['header'] = $this->ibmodel->getdatabyid($id);
        $this->load->view('ib/editdetailib',$data);
    }
    public function updatepcskgs()
    {
        $kondisi = [
            'id' => $_POST['id'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'harga' => $_POST['hrg'],
        ];
        $hasil = $this->ibmodel->updatepcskgs($kondisi);
        echo $hasil;
    }
    public function simpanib($id)
    {
        $cekdetail = $this->ibmodel->cekdetail($id);
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
            $query = $this->ibmodel->simpanib($data);
            if ($query) {
                $url = base_url() . 'ib';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $url = base_url() . 'po/datapo/'.$id;
            redirect($url);
        }
    }
    public function editib($id){
        $cek = $this->ibmodel->cekfield($id,'ok_valid',0)->num_rows();
        if($cek==1){
            $data = [
                'data_ok' => 0,
                'user_ok' => null,
                'tgl_ok' => null,
                'id' => $id
            ];
            $hasil = $this->ibmodel->editib($data);
            if($hasil){
                $url = base_url().'ib';
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
    public function cekhargabarang(){
        $id  = $_POST['id'];
        $hasil = $this->ibmodel->cekhargabarang($id);
        echo $hasil;
    }
    //End IB Controller
    
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
        $data['datadetail'] = $this->pomodel->getbarangpo();
        $this->load->view('po/getbarangpo',$data);
    }


    public function getdata()
    {
        $this->session->set_userdata('deptsekarang', $_POST['dept_id']);
        $this->session->set_userdata('tujusekarang', $_POST['dept_tuju']);
        echo 1;
    }
    
    



    public function edittgl()
    {
        $this->load->view('po/edit_tgl');
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
    

    
    public function hapuspo($id)
    {
        $query = $this->pomodel->hapuspo($id);
        if ($query) {
            $url = base_url() . 'po';
            redirect($url);
        }
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
