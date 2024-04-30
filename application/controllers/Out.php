<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Out extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('out_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model','deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel','usermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index(){
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $footer['fungsi'] = 'out';
		$this->load->view('layouts/header',$header);
		$this->load->view('out/out',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function clear(){
        $this->session->set_userdata('bl',date('m'));
        $this->session->set_userdata('th',date('Y'));
        $url = base_url().'out';
        redirect($url);
    }
    public function depttuju(){
        $hasil = '';
        $kode = $_POST['kode'];
        $this->session->set_userdata('deptsekarang',$kode);
        $query = $this->out_model->getdepttuju($kode);
        foreach ($query->result_array() as $que) {
            $selek = $this->session->userdata('tujusekarang')==$que['dept_id'] ? 'selected' : '';
            $hasil .= "<option value='".$que['dept_id']."' rel='".$que['departemen']."' ".$selek.">".$que['departemen']."</option>";
        }
        echo $hasil;
    }
    public function ubahperiode(){
        $this->session->unset_userdata('deptsekarang');
        $this->session->unset_userdata('tujusekarang');
        $this->session->set_userdata('bl',$_POST['bl']);
        $this->session->set_userdata('th',$_POST['th']);
        echo 1;
    }
    public function getdata(){
        $hasil = '';
        $kode = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju']
        ];
        $this->session->set_userdata('tujusekarang',$_POST['dept_tuju']);
        $query = $this->out_model->getdata($kode);
        foreach ($query as $que) {
            $jmlrek = $que['jumlah_barang'] != null ? $que['jumlah_barang'].' Item' : '';
            $hasil .= "<tr>";
            $hasil .= "<td>".tglmysql($que['tgl'])."</td>";
            if($que['data_ok']==1){
                $hasil .= "<td class='font-bold'><a href='".base_url().'out/viewdetailout/'.$que['id']."' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail'>".$que['nomor_dok'].'<br><span class="font-kecil">'.$que['nodok']."</span></a></td>";
            }else{
                $hasil .= "<td class='font-bold'>".$que['nomor_dok'].'<br><span class="text-purple" style="font-size: 10px !important">'.$que['nodok']."</span></td>";
            }
            $hasil .= "<td>".$jmlrek."</td>";
            $hasil .= "<td>".datauser($que['user_ok'],'name')."<br><span style='font-size: 11px;'>".tglmysql2($que['tgl_ok'])."</span></td>";
            $hasil .= "<td>".$que['keterangan']."</td>";
            $hasil .= "<td>";
            if($que['data_ok']==0){
                $hasil .= "<a href=".base_url().'out/dataout/'.$que['id']." class='btn btn-sm btn-primary' style='padding: 3px 5px !important;' title='Cetak Data'><i class='fa fa-edit mr-1'></i> Lanjutkan Transaksi</a>";
            }else if($que['ok_tuju']==1){
                $hasil .= "<a href=".base_url().'out/cetakbon/'.$que['id']." target='_blank' class='btn btn-sm btn-danger' title='Cetak Data'><i class='fa fa-file-pdf-o'></i></a>";
            }
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function getdatadetailout(){
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->out_model->getdatadetailout($id);
        foreach ($query as $que) {
            $hasil .= "<tr>";
            $hasil .= "<td>".$que['nama_barang']."</td>";
            $hasil .= "<td>".$que['brg_id']."</td>";
            $hasil .= "<td>".$que['namasatuan']."</td>";
            $hasil .= "<td>".rupiah($que['pcsminta'],0)."</td>";
            $hasil .= "<td>".rupiah($que['kgsminta'],0)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['pcs'],0)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['kgs'],0)."</td>";
            $hasil .= "<td>";
            $hasil .= "<a href=".base_url().'out/editdetailout/'.$que['id']." class='btn btn-sm btn-primary' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function tambahdata(){
        $kondisi = [
            'dept_id' => $this->session->userdata('tujusekarang'),
            'dept_tuju' => $this->session->userdata('deptsekarang'),
            'kode_dok' => 'PB',
            'id_keluar' => null,
            'data_ok' => 1,
            'ok_tuju' => 1,
            'ok_valid' => 0
        ];
        $data['bon'] = $this->out_model->getbon($kondisi);
        $this->load->view('out/add_out',$data);
    }
    public function tambahdataout($id){
        $kode = $this->out_model->tambahdataout($id);
        if($kode){
            $url = base_url().'out/dataout/'.$kode;
            redirect($url);
        }
    }
    public function edit_tgl(){
        $this->load->view('out/edit_tgl');
    }
    public function updateout(){
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->out_model->updateout($data);
        echo $simpan;
    }
    public function editdetailout($id){
        $data['data'] = $this->out_model->getdatadetailoutbyid($id);
        $this->load->view('out/editdetailout',$data);
    }
    public function updatedetail(){
        $data = [
            'id' => $_POST['id'],
            'kgs' => $_POST['kgs'],
            'pcs' => $_POST['pcs'],
            'tempbbl' => $_POST['tempbbl']
        ];
        $query = $this->out_model->updatedetail($data);
        echo $query;
    }
    public function dataout($kode){
        $header['header'] = 'transaksi';
        $data['data'] = $this->out_model->getdatabyid($kode);
        $data['mode'] = 'tambah';
        $footer['fungsi'] = 'out';
		$this->load->view('layouts/header',$header);
		$this->load->view('out/dataout',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function simpanout($id){
        $data = [
            'ok_valid' => 1,
            'user_valid' => $this->session->userdata('id'),
            'data_ok' => 1,
            'ok_tuju' => 1,
            'tgl_valid' => date('Y-m-d H:i:s'),
            'id' => $id
        ];
        $query = $this->out_model->simpanout($data);
        if($query){
            $url = base_url().'out';
            redirect($url);
        }
    }
    public function hapusdataout($id){
        $query = $this->out_model->hapusdataout($id);
        if($query){
            $url = base_url().'out';
            redirect($url);
        }
    }
    public function viewdetailout($id){
        $data['header'] = $this->out_model->getdatabyid($id);
        $data['detail'] = $this->out_model->getdatadetailout($id);
        $this->load->view('out/viewdetailout',$data);
    }
    public function resetdetail($id){
        $query = $this->out_model->resetdetail($id);
        if($query){
            $url = base_url().'out/dataout/'.$id;
            redirect($url);
        }
    }
    public function simpanheaderout($id){
        $query = $this->out_model->simpanheaderout($id);
        if($query){
            $url = base_url().'out';
        }else{
            $url = base_url().'out/dataout/'.$id;
        }
        redirect($url);
    }
    function cetakqr2($isi,$id)
	{
		$tempdir = "temp/";
		$namafile = $id;
		$codeContents = $isi;
		QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_L, 4,1);
		return $tempdir . $namafile;
	}
    public function cetakbon($id){
        $pdf = new PDF('P','mm','A4');
		$pdf->AliasNbPages();
		// $pdf->setMargins(5,5,5);
		$pdf->AddFont('Lato','','Lato-Regular.php');
		$pdf->AddFont('Latob','','Lato-Bold.php');
		// $pdf->SetFillColor(7,178,251);
		$pdf->SetFont('Latob','',12);
		// $isi = $this->jualmodel->getrekap();
		$pdf->SetFillColor(205,205,205);
		$pdf->AddPage();
        $pdf->Image(base_url().'assets/image/ifnLogo.png',14,10,22);
        $pdf->Cell(30,18,'',1);
		$pdf->SetFont('Latob','',18);
        $pdf->Cell(120,18,'BON PERPINDAHAN',1,0,'C');
		$pdf->SetFont('Lato','',10);
        $pdf->Cell(14,6,'No Dok','T');
        $pdf->Cell(2,6,':','T');
        $pdf->Cell(24,6,'FM-GD-05','TR');
        $pdf->ln(6);
        $pdf->Cell(150,6,'',0);
        $pdf->Cell(14,6,'Revisi','T');
        $pdf->Cell(2,6,':','T');
        $pdf->Cell(24,6,'1','TR');
        $pdf->ln(6);
        $pdf->Cell(150,6,'',0);
        $pdf->Cell(14,6,'Tanggal','TB');
        $pdf->Cell(2,6,':','TB');
        $pdf->Cell(24,6,'11-04-2007','TRB');
        $pdf->ln(6);
        $pdf->Cell(190,1,'',1,0,'',1);
        $pdf->ln(1);
        $header = $this->out_model->getdatabyid($id);
        $isi = 'Nobon '.$header['nomor_dok']."\r\n".'Dikeluarkan Oleh : '.datauser($header['user_ok'],'name').'@'."\r\n".tglmysql2($header['tgl_ok']);
        $isi .= "\r\n".'Diterima Oleh : '.datauser($header['user_tuju'],'name').'@'."\r\n".tglmysql2($header['tgl_tuju']);
        $qr = $this->cetakqr2($isi,$header['id']);
        $pdf->Image($qr.".png",177,30,18);
		$pdf->SetFont('Lato','',10);
        $pdf->Cell(18,5,'Nomor','L',0);
        $pdf->Cell(2,5,':',0,0);
        $pdf->Cell(60,5,$header['nomor_dok'],'R',0);
		$pdf->SetFont('Lato','',9);
        $pdf->Cell(82,5,'Diperiksa & Disetujui Oleh','RB',0);
        $pdf->Cell(28,5,'','R',1);
        $pdf->Cell(18,5,'Dept','L',0);
        $pdf->Cell(2,5,':',0,0);
        $pdf->Cell(60,5,$header['departemen'],'R',0);
		$pdf->SetFont('Latob','',9);
        $pdf->Cell(82,5,substr(datauser($header['user_tuju'],'name'),0,20),'R',0);
		$pdf->SetFont('Lato','',9);
        $pdf->Cell(28,5,'','R',0);
        $pdf->Cell(28,5,'','R',1);
        $pdf->Cell(18,5,'Tanggal','L',0);
        $pdf->Cell(2,5,':',0,0);
        $pdf->Cell(60,5,tglmysql($header['tgl']),'R',0);
		$pdf->SetFont('Latob','',9);
        $pdf->Cell(82,5,substr(datauser($header['user_tuju'],'jabatan'),0,20),'R',0);
		$pdf->SetFont('Lato','',9);
        $pdf->Cell(28,5,'','R',1);
        $pdf->Cell(80,5,'','LBR',0);
        $pdf->Cell(82,5,'','BR',0);
        $pdf->Cell(28,5,'','BR',1);
        $pdf->Cell(190,1,'',1,1,'',1);
        $pdf->Cell(6,8,'No','LRB',0,'C');
		$pdf->SetFont('Lato','',8);
        $pdf->Cell(17,4,'Nomor PO/','LR',0,'C');
        $pdf->Cell(7,4,'No','LR',0,'C');
        $pdf->Cell(7,4,'No','LR',0,'C');
        $pdf->Cell(80,8,'Spesifikasi Barang','LRB',0,'C');
        $pdf->Cell(8,4,'No.','LR',0,'C');
        $pdf->Cell(16,4,'Pcs/','LR',0,'C');
        $pdf->Cell(16,4,'Total','LR',0,'C');
        $pdf->Cell(33,8,'Keterangan','LRB',0,'C');
        $pdf->ln(4);
        $pdf->Cell(6,4,'',0);
        $pdf->Cell(17,4,'No Instruksi','RB',0,'C');
        $pdf->Cell(7,4,'Lot','RB',0,'C');
        $pdf->Cell(7,4,'Mc','B',0,'C');
        $pdf->Cell(80,4,'',0);
        $pdf->Cell(8,4,'Bale','RB',0,'C');
        $pdf->Cell(16,4,'Pack','RB',0,'C');
        $pdf->Cell(16,4,'Kgs','RB',1,'C');
        $detail = $this->out_model->getdatadetailout($id);
        $no=1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs']==null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(6,6,$no++,'LRB',0);
            $pdf->Cell(17,6,'','LRB',0);
            $pdf->Cell(7,6,'','LRB',0);
            $pdf->Cell(7,6,'','LRB',0);
            $pdf->Cell(80,6,$det['nama_barang'],'LBR',0);
            $pdf->Cell(8,6,'','LRB',0);
            $pdf->Cell(16,6,rupiah($det['pcs'],0),'LRB',0,'R');
            $pdf->Cell(16,6,rupiah($det['kgs'],0),'LBR',0,'R');
            $pdf->Cell(33,6,$det['keterangan'],'LBR',1,'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato','',8);
        $pdf->Cell(15,5,'Catatan : ',0);
        $pdf->Cell(19,5,'Dokumen ini sudah ditanda tangani secara digital',0);
        $pdf->Output('I','FM-GD-05.pdf');
    }
}