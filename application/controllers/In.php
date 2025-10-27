<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class In extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('out_model');
        $this->load->model('in_model','inmodel');
        $this->load->model('ib_model','ibmodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model','deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel','usermodel');
        $this->load->model('helper_model','helpermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index(){
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $data['data'] = $this->inmodel->getdata(['dept_id'=>$this->session->userdata('curdept'),'dept_tuju'=>$this->session->userdata('todept'),'katedept' => datadepartemen($this->session->userdata('curdept'),'katedept_id')]);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'in';
		$this->load->view('layouts/header',$header);
		$this->load->view('in/in',$data);
		$this->load->view('layouts/footer',$footer);
    }
    public function clear(){
        $this->session->set_userdata('bl',date('m'));
        $this->session->set_userdata('th',date('Y'));
        $this->session->unset_userdata('curdept');
        $this->session->unset_userdata('todept');
        $url = base_url().'in';
        redirect($url);
    }
    public function depttuju(){
        $kode = $_POST['kode'];
        $this->session->set_userdata('curdept',$kode);
        $query = $this->inmodel->getdepttuju($kode);
        $hasil = '';
        foreach ($query->result_array() as $que) {
            $selek = $this->session->userdata('todept')==$que['dept_id'] ? 'selected' : '';
            $hasil .= "<option value='".$que['dept_id']."' rel='".$que['departemen']."' ".$selek.">".$que['departemen']."</option>";
        }
        echo $hasil;
    }
    public function ubahperiode(){
        // $this->session->unset_userdata('curdept');
        // $this->session->unset_userdata('todept');
        $this->session->set_userdata('bl',$_POST['bl']);
        $this->session->set_userdata('th',$_POST['th']);
        echo 1;
    }
    public function getdata(){
        $hasil = '';
        $katedept = datadepartemen($_POST['dept_id'],'katedept_id');
        $kode = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'katedept' => $katedept
        ];
        $this->session->set_userdata('todept',$_POST['dept_tuju']);
        echo 1;
    }
    public function cekkonfirmasi($id,$mode=0){
        $header['header'] = 'transaksi';
        $data['header'] = $this->inmodel->getdatabyid($id);
        $data['detail'] = $this->inmodel->getdatadetail($id,$mode);
        $data['mode'] = $mode;
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'in';
        $this->load->view('layouts/header',$header);
        $this->load->view('in/cekkonfirmasi',$data);
        $this->load->view('layouts/footer',$footer);
    }
    public function resetin($id){
        $hasil = $this->inmodel->resetin($id);
        if($hasil){
            $url = base_url().'in/cekkonfirmasi/'.$id;
            redirect($url);
        }
    }
    public function verifikasirekord(){
        $id = $_POST['id'];
        $hasil = $this->inmodel->verifikasirekord($id);
        if($hasil){
            echo json_encode($hasil); 
        }else{
            $url = base_url().'in/cekkonfirmasi/'.$id;
            redirect($url);
        }
    }
    public function simpanin($id,$mode=0){
        $hasil = $this->inmodel->simpanin($id,$mode);
        if($hasil){
            $url = base_url().'in';
            redirect($url);
        }
    }
    public function simpaningm(){
        $id = $_POST['id'];
        $mode = 0;
        $databaru = [
            'nomor_dok' => trim(strtoupper($_POST['nomor'])),
            'tgl' => date('Y-m-d')
        ];
        // $nomor = trim(strtoupper($_POST['nomor']));
        $hasil = $this->inmodel->simpanin($id,$mode,$databaru);
        if($hasil){
            // $url = base_url().'in';
            // redirect($url);
            $simpankehamat = $simpankehargamaterial = $this->ibmodel->simpankehargamaterial($id);
            if($simpankehamat){
                echo 1;
            }
        }
    }
    public function viewdetailin($id,$mode=0){
        $data['header'] = $this->inmodel->getdatabyid($id);
        $data['detail'] = $this->inmodel->getdatadetail($id,$mode);
        $this->load->view('in/viewdetailin',$data);
    }
    public function konfirmasinobon($id){
        $data['header'] = $this->inmodel->getdatabyid($id);
        $data['nomorib'] = nomorib();
        $this->load->view('in/konfirmasinomor',$data);
    }
    // End In Controller
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

    // public function konfirmasi($id){
    //     $data = [
    //         'id' => $id,
    //         'ok_tuju' => 1,
    //         'tgl_tuju' => date('Y-m-d H:i:s'),
    //         'user_tuju' => $this->session->userdata('id')
    //     ];
    //     $hasil = $this->in_model->konfirmasi($data);
    //     if($hasil){
    //         $url = base_url().'in';
    //         redirect($url);
    //     }
    // }
    
    function cetakqr2($isi,$id)
	{
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
        $header = $this->out_model->getdatabyid($id);
        $isi = 'Nobon '.$header['nomor_dok']."\r\n".'Dikeluarkan Oleh : '.datauser($header['user_ok'],'name').'@'."\r\n".tglmysql2($header['tgl_ok']);
        $isi .= "\r\n".'Diterima Oleh : '.datauser($header['user_valid'],'name').'@'."\r\n".tglmysql2($header['tgl_valid']);
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