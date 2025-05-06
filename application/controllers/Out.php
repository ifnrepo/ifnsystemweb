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
        $this->load->model('helper_model','helpermodel');
        $this->load->model('customer_model','customermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index(){
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $kode = [
            'dept_id' => $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang'),
        ];
        $data['data'] = $this->out_model->getdata($kode);
        $data['jumlahpcskgs'] = $this->out_model->getdatapcskgs($kode);
        $data['jmlrekod'] = $this->out_model->getrekod($kode);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'out';
        $this->session->unset_userdata('barangerror');
		$this->load->view('layouts/header',$header);
		$this->load->view('out/out',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function clear(){
        $this->session->unset_userdata('deptsekarang');
        $this->session->unset_userdata('tujusekarang');
        $this->session->set_userdata('bl',(int)date('m'));
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
        // $this->session->unset_userdata('deptsekarang');
        // $this->session->unset_userdata('tujusekarang');
        $this->session->set_userdata('bl',$_POST['bl']);
        $this->session->set_userdata('th',$_POST['th']);
        echo 1;
    }
    public function getdata(){
        $this->session->set_userdata('deptsekarang',$_POST['dept_id']);
        $this->session->set_userdata('tujusekarang',$_POST['dept_tuju']);
        echo 1;
    }
    public function getdatadetailout(){
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->out_model->getdatadetailout($id);
        $jumlah=0;
        $deptinsno = ['GP','RR'];
        foreach ($query as $que) {
            $tandakurang = $this->session->userdata('barangerror')==$que['id_barang'] ? 'text-danger' : '';
            $dis = $que['dis']==0 ? '' : ' dis '.$que['dis'];
            $sku = $que['brg_id']=='' ? $que['po'].'#'.$que['item'].$dis : $que['brg_id'];
            $hasil .= "<tr>";
            $hasil .= "<td><a class='".$tandakurang."' href='".base_url().'out/getdatadetail/'.$que['id_header']."/".$que['id']."' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Data Detail Barang : ".$que['nama_barang'].$que['spek']."'>".$que['nama_barang'].$que['spek']."</a></td>";
            $hasil .= "<td>".$sku."</td>";
            $hasil .= "<td>".$que['kodesatuan']."</td>";
                $hasil .= "<td>".rupiah($que['pcsminta'],0)."</td>";
                $hasil .= "<td>".rupiah($que['kgsminta'],2)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['pcs'],0)."</td>";
            $hasil .= "<td class='text-primary'>".rupiah($que['kgs'],2)."</td>";
            if($this->session->userdata('deptsekarang')=='GM' && $que['nobontr']!=''){
                $hasil .= "<td class='text-primary'>".$que['nobontr']."</td>";
            }else{
                if($this->session->userdata('deptsekarang')=='GM' && $que['nobontr']==''){
                    $hasil .= "<td class='text-primary'><a class='text-info' href='".base_url().'out/addnobontr/'.$que['id'].'/'.$que['id_barang']."' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Pilih Data Nobontr'>Pilih Nobontr</a></td>";
                }
            }
            if(in_array($this->session->userdata('deptsekarang'),$deptinsno) && $que['insno']!=''){
                $hasil .= "<td class='text-primary'>".$que['insno']."</td>";
            }else{
                if(in_array($this->session->userdata('deptsekarang'),$deptinsno) && $que['insno']==''){
                    $hasil .= "<td class='text-primary'><a href='".base_url().'out/addinsno/'.$que['id'].'/'.$que['id_barang']."' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Pilih Data insno'>Pilih Insno</a></td>";
                }
            }
            if($this->session->userdata('deptsekarang')=='GS'){
                $hasil .= "<td class='text-primary font-bold'>".$que['sublok']."</td>";
            }
            $hasil .= "<td>";
            $hasil .= "<a href=".base_url().'out/editdetailout/'.$que['id']." class='btn btn-sm btn-primary' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah Qty</a>";
            $hasil .= "<a href='#' data-href=".base_url().'out/hapusdetailout/'.$que['id'].'/'.$que['id_header']." data-message='Akan menghapus data barang ".$que['nama_barang']."' class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $jumlah++;
        }
        $cocok = array('datagroup' => $hasil,'jmlrek' => $jumlah);
        echo json_encode($cocok);
    }
    public function getdatadetail($id,$id2){
        $data['header'] = $this->out_model->getdatabyid($id)->row_array();
        $data['detail'] = $this->out_model->getdatadetail($id2);
        $this->load->view('out/viewdetailout2',$data);
    }
    public function tambahdata(){
        $data['bon'] = []; //$this->out_model->getbon()->result_array();
        $data['bonpb'] = $this->out_model->getnobonpb();
        $this->load->view('out/add_out',$data);
    }
    public function getbondengankey(){
        $bon = $_POST['bon'];
        $key = $_POST['barang'];
        $data = $this->out_model->getbondengankey($bon,$key);
        $html = '';
        if($data->num_rows() > 0){
            $no=1;
            foreach ($data->result_array() as $datkey) {
                $no++;
                $html .= '<tr>';
                $html .= '<td>'.$datkey['nama_barang'].'</td>';
                $html .= '<td style="font-size: 10px !important">'.tglmysql($datkey['tgl']).'</td>';
                $html .= '<td>'.$datkey['nomor_dok'].'</td>';
                $html .= '<td style="font-size: 10px !important">'.$datkey['keteranganx'].'</td>';
                $html .= '<td>';
                $html .= '<label class="form-check">';
                $html .= '<input class="form-check-input" name="cekpilihbarang" id="cekbok'.$no.'" rel="'.$datkey['idx'].'" type="checkbox" title="'.$datkey['idx'].'">';
                $html .= '<span class="form-check-label">Pilih</span>';
                $html .= '</label>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '</tr>';
            $html .= '<td colspan="5" class="text-center">Tidak ada Data</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function adddata($jn){
        if(($this->session->userdata('deptsekarang')=='' || $this->session->userdata('deptsekarang')==null) && ($this->session->userdata('tujusekarang')=='' || $this->session->userdata('tujusekarang')==null)){
            $this->session->set_flashdata('errorparam',1);
            $url = base_url().'out';
            redirect($url);
        }else{
            $hasil = $this->out_model->adddata($jn);
            if($hasil){
                $url = base_url().'out/dataout/'.$hasil;
                redirect($url);
            }
        }
    }
    public function tambahdataout(){
        $arrgo = [
            'id' => $_POST['id'],
            'data' => $_POST['out']
        ];
        $kode = $this->out_model->tambahdataout($arrgo);
        echo $kode;
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
    public function addnobontr($id,$idbarang){
        $head = $this->out_model->gethead($id)->row_array();
        $periode = date('m',strtotime($head['tgl'])).date('Y',strtotime($head['tgl']));
        $data['data'] = $this->out_model->getdatagm($idbarang,$periode);
        $data['iddetail'] = $id;
        $data['header'] = $this->out_model->getdatabarang($idbarang)->row_array();
        $this->load->view('out/addnobontr',$data);
    }
    public function addinsno($id,$idbarang){
        $data['data'] = $this->out_model->getdatagp($idbarang);
        $data['iddetail'] = $id;
        $data['header'] = $this->out_model->getdatabarang($idbarang)->row_array();
        $this->load->view('out/addinsno',$data);
    }
    public function editnobontr(){
        $data = [
            'idstok' => $_POST['id'],
            'nobontr' => $_POST['bon'],
            'id' => $_POST['idd']
        ];
        $hasil = $this->out_model->editnobontr($data);
        echo $hasil;
    }
    public function editinsno(){
        $data = [
            'idstok' => $_POST['id'],
            'insno' => $_POST['bon'],
            'id' => $_POST['idd']
        ];
        $hasil = $this->out_model->editinsno($data);
        echo $hasil;
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
    public function bagi2permintaan(){
        $data = [
            'id' => $_POST['id'],
            'kgs1' => $_POST['kgs1'],
            'pcs1' => $_POST['pcs1'],
            'kgs2' => $_POST['kgs2'],
            'pcs2' => $_POST['pcs2']
        ];
        $query = $this->out_model->bagi2permintaan($data);
        echo $query;
    }
    public function dataout($kode){
        $header['header'] = 'transaksi';
        $data['data'] = $this->out_model->getdatabyid($kode)->row_array();
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $data['mode'] = 'tambah';
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'out';
		$this->load->view('layouts/header',$header);
		$this->load->view('out/dataout',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function addbarangout(){
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $this->load->view('out/addbarangout',$data);
    }
    public function simpanout($id){
        $data = [
            'ok_tuju' => 1,
            'user_tuju' => $this->session->userdata('id'),
            'data_ok' => 1,
            'ok_valid' => 1,
            'tgl_tuju' => date('Y-m-d H:i:s'),
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
    public function hapusdetailout($id,$head){
        $query = $this->out_model->hapusdetailout($id);
        if($query){
            $url = base_url().'out/dataout/'.$head;
            redirect($url);
        }
    }
    public function viewdetailout($id){
        $data['header'] = $this->out_model->getdatabyid($id)->row_array();
        // $data['detail'] = $this->out_model->getdatadetailout($id);
        // $data['detail2'] = $this->out_model->getdatadetail($id);
        $this->load->view('out/viewdetailout',$data);
    }
    public function loaddetailout(){
        $id = $_POST['id'];
        $data = $this->out_model->getdatadetailout($id);
        $html = "";
        $no=1;
        $pcs =0;
        $kgs = 0;
         foreach ($data as $val) {
            $pcs += $val['pcs'];
            $kgs += $val['kgs'];
            $sku =($val['po']=='') ?$val['brg_id'] : ($val['po'].'#'.$val['item'].' '.($val['dis']==0 ? '' : ' dis '.$val['dis']));
            if($this->session->userdata('deptsekarang')=='GF' && $this->session->userdata('tujusekarang')=='CU'){
                $spek = $val['po']=='' ? $val['nama_barang'] : (($val['engklp']=='') ? $val['spek'] : $val['engklp']);
            }else{
                $spek = $val['po']=='' ? $val['nama_barang'] : $val['spek'];
            }
            $html .= "<tr>";
            $html .= "<td>".$val['seri_barang'].'. '.$spek."</td>";
            $html .= "<td>".$sku."</td>";
            $html .= "<td>".$val['namasatuan']."</td>";
            $html .= "<td class='text-right'>".rupiah($val['pcs'],0)."</td>";
            $html .= "<td class='text-right'>".rupiah($val['kgs'],2)."</td>";
            $html .= "<td>".$val['nodok']."</td>";
            $html .= "</tr>";
        }
        $html .= "<tr>";
        $html .= "<td colspan='3' class='text-end'>TOTAL</td>";
        $html .= "<td class='text-right font-bold'>".rupiah($pcs,0)."</td>";
        $html .= "<td class='text-right font-bold'>".rupiah($kgs,4)."</td>";
        $html .= "<td></td>";
        $html .= "</tr>";
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function loaddetailout2(){
        $id = $_POST['id'];
        $data = $this->out_model->getdatadetailall($id);
        $html = "";
        $no=1;
        $pcs =0;
        $kgs = 0;
       foreach ($data as $val) { 
        $ketbc = $val['bcnomor']!=null ? 'BC. '.trim($val['jns_bc']).'-'.$val['bcnomor'].'('.$val['bctgl'].')' : '';
        $html .= "<tr>";
        $html .= "<td style='line-height: 13px;'>".$val['seri_barang'].'. '.$val['nama_barang']." # <span class='text-teal'>".$val['insno'].' '.$val['nobontr']."<br><span class='text-cyan'>".$ketbc."</span></span></td>";
        $html .= "<td>".$val['brg_id']."</td>";
        $html .= "<td>".$val['namasatuan']."</td>";
        $html .= "<td class='text-right'>".rupiah($val['pcs'],0)."</td>";
        $html .= "<td class='text-right'>".rupiah($val['kgs'],4)."</td>";
        $html .= "<td></td>";
        $html .= "</tr>";

        $pcs += $val['pcs'];
        $kgs += $val['kgs'];
       }
        $html .= "<tr>";
        $html .= "<td colspan='3' class='text-end'>TOTAL</td>";
        $html .= "<td class='text-right font-bold'>".rupiah($pcs,0)."</td>";
        $html .= "<td class='text-right font-bold'>".rupiah($kgs,4)."</td>";
        $html .= "<td></td>";
        $html .= "</tr>";
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
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
    public function addspecbarang()
    {
        $this->load->view('out/addspecbarang');
    }
    public function simpandetailbarang()
    {
        $hasil = $this->out_model->simpandetailbarang();
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'out/dataout/' . $kode;
            redirect($url);
        }
    }
    public function simpandetailbarangx()
    {
        $data = [
            'id_header' => $_POST['id_header'],
            'id_barang' => $_POST['id_barang'],
            'id_satuan' => $_POST['id_satuan'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->out_model->simpandetailbarangx($data);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'out/dataout/' . $kode;
            redirect($url);
        }
    }
    public function editcustomer()
    {
        $this->load->view('out/editcustomer');
    }
    public function getcustomerbyname()
    {
        $nama = $_POST['data'];
        $hasil = '';
        $query = $this->customermodel->getdatabyname($nama);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                $hasil .= "<tr>";
                $hasil .= "<td class='text-primary'>" . $data['nama_customer'] . "</td>";
                $hasil .= "<td>" . substr($data['alamat'], 0, 35) . "</td>";
                $hasil .= "<td>" . $data['port']. "</td>";
                $hasil .= "<td>" . $data['country'] . "</td>";
                $hasil .= "<td><a href='#' class='btn btn-sm btn-success' rel='" . $data['id'] . "' id='pilihcustomer'>Pilih</a></td></tr>";
            }
        } else {
            $hasil .= "<tr>";
            $hasil .= '<td colspan="3" class="text-center">No Data / Cari dahulu data</td></tr>';
        }
        $cocok = array('datagroup' => $hasil);
        echo json_encode($cocok);
    }
    public function updatecustomer(){
        $data = [
            'id' => $_POST['id'],
            'id_buyer' => $_POST['rel']
        ];
        $hasil = $this->out_model->updatecustomer($data);
        echo $hasil;
    }
    function cetakqr2($isi,$id){
		$tempdir = "temp/";
		$namafile = $id;
		$codeContents = $isi;
        $iconpath = "assets/image/BigLogo.png";
		QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_H, 4,1);
        $filepath = $tempdir.$namafile.'.png';
        $QR = imagecreatefrompng($filepath);

        $logo = imagecreatefromstring(file_get_contents($iconpath));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);
    
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);
    
        //besar logo
        $logo_qr_width = $QR_width/4.3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;
    
        //posisi logo
        imagecopyresampled($QR, $logo, $QR_width/2.7, $QR_height/2.7, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    
        imagepng($QR,$filepath);
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
        $header = $this->out_model->getdatabyid($id)->row_array();
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
            $pdf->Cell(33,6,$det['keterangan'],'LBR',1);
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato','',8);
        $pdf->Cell(15,5,'Catatan : ',0);
        $pdf->Cell(19,5,'Dokumen ini sudah ditanda tangani secara digital',0);
        $pdf->Output('I','FM-GD-05.pdf');
    }
}