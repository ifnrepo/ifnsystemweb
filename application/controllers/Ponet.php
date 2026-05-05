<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ponet extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Ponet_model','ponetmodel');
        $this->load->model('Helper_model','helpermodel');
        $this->load->helper('ifn_helper');
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['data'] = $this->ponetmodel->getdata();
        $data['maxrek'] = $this->ponetmodel->getmaxminidpo();
        $data['futoito'] = $this->ponetmodel->getfutoito($data['data']['id']);
        $data['sidemark'] = $this->ponetmodel->getsidemark($data['data']['id']);
        $data['shipmark'] = $this->ponetmodel->getshipmark($data['data']['id']);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ponet';
        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index',$data);
        $this->load->view('layouts/footer',$footer);
    }

    public function view($id)
    {
        $header['header'] = 'other';
        $data['data'] = $this->ponetmodel->getdata($id);
        $data['maxrek'] = $this->ponetmodel->getmaxminidpo();
        $data['futoito'] = $this->ponetmodel->getfutoito($data['data']['id']);
        $data['sidemark'] = $this->ponetmodel->getsidemark($data['data']['id']);
        $data['shipmark'] = $this->ponetmodel->getshipmark($data['data']['id']);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ponet';
        $this->load->view('layouts/header', $header);
        $this->load->view('ponet/index',$data);
        $this->load->view('layouts/footer',$footer);
    }
    public function prevrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->prevrec($id);
        echo $hasil['idpo'];
    }
    public function nextrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->nextrec($id);
        echo $hasil['idpo'];
    }
    public function currentrec(){
        $id = $_POST['id'];
        $hasil = $this->ponetmodel->currentrec($id);
        echo $hasil['idpo'];
    }

    public function caripoid($po)
    {
        $data['data'] = slashganti($po); 
        $this->load->view('ponet/caripo', $data);
    }
    public function caripo()
    {
        $this->load->view('ponet/caripo');
    }
    public function isinotes($id)
    {
        $data['data'] = $this->ponetmodel->getdata($id);
        $this->load->view('ponet/isinotes',$data);
    }
    public function simpannotes(){
        // $data = [
        //     'id' => $_POST['id'],
        //     'ppic_notes' => trim($_POST['notes'])
        // ];
        // $hasil = $this->ponetmodel->simpannotes($data);
        // echo $hasil;
        $this->ponetmodel->updatedok();
    }
    public function caridatapo(){
        $data = [
            'po' => trim($_POST['po']),
            'item' => trim($_POST['item'])
        ];
        $hasil = $this->ponetmodel->caridatapo($data);
        $html = '';
        if($hasil->num_rows() > 0){
            foreach($hasil->result_array() as $hsl){
                $warna = trim($hsl['spek'])=='CANCELED'? 'text-danger' : '';
                $html .= '<tr>';
                $html .= '<td>'.viewsku($hsl['po'],$hsl['item'],$hsl['dis']).'</td>';
                $html .= '<td class="'.$warna.'">'.spekpo($hsl['po'],$hsl['item'],$hsl['dis']).'</td>';
                $html .= '<td>'.$hsl['nama_customer'].'</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="'.base_url('ponet/view/'.$hsl['id']).'" class="btn btn-sm btn-success font-kecil" style="padding: 0px 2px !important;">Pilih</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        }else{
            $html .= '<tr><td colspan="4" class="text-center">Data tidak ditemukan <a href="#" id="resetcari">Cari Ulang ?</a></td></tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function viewfoto($gbr='')
    {   
        $data['gbr']= trim($gbr)=='' ? '' : urldecode($gbr);
        $this->load->view('ponet/viewfoto',$data);
    }
    public function loadnetting(){
        $id = $_POST['id'];
        $html = '';
        $html2 = '';
        $html3 = '';
        $html4 = '';
        $htmltot = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadnetting($id);
        $jmlrow = ceil($data->num_rows()/15);
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcstotal'];
            $jmlkgs += $dt['kgstotal'];
            if($jml <= 15){
                $html .= '<tr>';
                $html .= '<td>'.$dt['insno'].'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html .= '</tr>';
            }else if($jml > 15 && $jml <= 30){
                $html2 .= '<tr>';
                $html2 .= '<td>'.$dt['insno'].'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html2 .= '</tr>';
            }else if($jml > 30 && $jml <= 45){
                $html3 .= '<tr>';
                $html3 .= '<td>'.$dt['insno'].'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html3 .= '</tr>';
            }else if($jml > 45 && $jml <= 60){
                $html4 .= '<tr>';
                $html4 .= '<td>'.$dt['insno'].'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html4 .= '</tr>';
            } 
        }
        if($data->num_rows() > 0){
            $bagi = $dt['jmlpiece']==0 ? 1 : $dt['jmlpiece'];
            $htmltot .= '<tr>';
            $htmltot .= '<td class="text-center text-danger font-bold" style="font-size: 16px;">'.rupiah(($jmlpcs/$dt['jmlpiece'])*100,2).' %</td>';
            $htmltot .= '<td class="text-right font-bold">TOTAL '.$jml.' Instruksi</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlpcs,0).' Pcs</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlkgs,2).' Kgs</td>';
            $htmltot .= '</tr>';
        }
        $cocok = array('jml' => $jml,'rowsatu' => $html,'rowdua' => $html2,'rowtiga' => $html3,'rowempat' => $html4,'rowtotal' => $htmltot);
        echo json_encode($cocok);
    }
    public function loadsenshoku(){
        $id = $_POST['id'];
        $html = '';
        $html2 = '';
        $html3 = '';
        $html4 = '';
        $htmltot = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadsenshoku($id);
        $jmlrow = ceil($data->num_rows()/15);
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcstotal'];
            $jmlkgs += $dt['kgstotal'];
            if($jml <= 15){
                $html .= '<tr>';
                $html .= '<td>'.$dt['insno'].'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html .= '</tr>';
            }else if($jml > 15 && $jml <= 30){
                $html2 .= '<tr>';
                $html2 .= '<td>'.$dt['insno'].'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html2 .= '</tr>';
            }else if($jml > 30 && $jml <= 45){
                $html3 .= '<tr>';
                $html3 .= '<td>'.$dt['insno'].'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html3 .= '</tr>';
            }else if($jml > 45 && $jml <= 60){
                $html4 .= '<tr>';
                $html4 .= '<td>'.$dt['insno'].'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html4 .= '</tr>';
            } 
        }
        if($data->num_rows() > 0){
            $bagi = $dt['jmlpiece']==0 ? 1 : $dt['jmlpiece'];
            $htmltot .= '<tr>';
            $htmltot .= '<td class="text-center text-danger font-bold" style="font-size: 16px;">'.rupiah(($jmlpcs/$dt['jmlpiece'])*100,2).' %</td>';
            $htmltot .= '<td class="text-right font-bold">TOTAL '.$jml.' Instruksi</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlpcs,0).' Pcs</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlkgs,2).' Kgs</td>';
            $htmltot .= '</tr>';
        }
        $cocok = array('jml' => $jml,'rowsatu' => $html,'rowdua' => $html2,'rowtiga' => $html3,'rowempat' => $html4,'rowtotal' => $htmltot);
        echo json_encode($cocok);
    }
    public function loadgaichu(){
        $id = $_POST['id'];
        $html = '';
        $html2 = '';
        $html3 = '';
        $html4 = '';
        $htmltot = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadgaichu($id);
        $jmlrow = ceil($data->num_rows()/15);
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcstotal'];
            $jmlkgs += $dt['kgstotal'];
            if($jml <= 15){
                $html .= '<tr>';
                $html .= '<td>'.$dt['insno'].'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html .= '</tr>';
            }else if($jml > 15 && $jml <= 30){
                $html2 .= '<tr>';
                $html2 .= '<td>'.$dt['insno'].'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html2 .= '</tr>';
            }else if($jml > 30 && $jml <= 45){
                $html3 .= '<tr>';
                $html3 .= '<td>'.$dt['insno'].'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html3 .= '</tr>';
            }else if($jml > 45 && $jml <= 60){
                $html4 .= '<tr>';
                $html4 .= '<td>'.$dt['insno'].'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html4 .= '</tr>';
            } 
        }
        if($data->num_rows() > 0){
            $bagi = $dt['jmlpiece']==0 ? 1 : $dt['jmlpiece'];
            $htmltot .= '<tr>';
            $htmltot .= '<td class="text-center text-danger font-bold" style="font-size: 16px;">'.rupiah(($jmlpcs/$dt['jmlpiece'])*100,2).' %</td>';
            $htmltot .= '<td class="text-right font-bold">TOTAL '.$jml.' Instruksi</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlpcs,0).' Pcs</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlkgs,2).' Kgs</td>';
            $htmltot .= '</tr>';
        }
        $cocok = array('jml' => $jml,'rowsatu' => $html,'rowdua' => $html2,'rowtiga' => $html3,'rowempat' => $html4,'rowtotal' => $htmltot);
        echo json_encode($cocok);
    }
    public function loadfinishing(){
        $id = $_POST['id'];
        $html = '';
        $html2 = '';
        $html3 = '';
        $html4 = '';
        $htmltot = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadfinishing($id);
        if($data->num_rows() <= 5){
            $jmlrow = 5;
        }else{
            $jmlrow = ceil($data->num_rows()/4);
        }
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcstotal'];
            $jmlkgs += $dt['kgstotal'];
            if($jml <= $jmlrow){
                $html .= '<tr>';
                $html .= '<td>'.$dt['nobale'].'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html .= '</tr>';
            }else if($jml > $jmlrow && $jml <= ($jmlrow*2)){
                $html2 .= '<tr>';
                $html2 .= '<td>'.$dt['nobale'].'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html2 .= '</tr>';
            }else if($jml > ($jmlrow*2) && $jml <= ($jmlrow*3)){
                $html3 .= '<tr>';
                $html3 .= '<td>'.$dt['nobale'].'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html3 .= '</tr>';
            }else if($jml > ($jmlrow*3) && $jml <= ($jmlrow*4)){
                $html4 .= '<tr>';
                $html4 .= '<td>'.$dt['nobale'].'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['pcstotal'],0).'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['kgstotal'],2).'</td>';
                $html4 .= '</tr>';
            } 
        }
        if($data->num_rows() > 0){
            $bagi = $dt['jmlpiece']==0 ? 1 : $dt['jmlpiece'];
            $htmltot .= '<tr>';
            $htmltot .= '<td class="text-center text-danger font-bold" style="font-size: 16px;">'.rupiah(($jmlpcs/$dt['jmlpiece'])*100,2).' %</td>';
            $htmltot .= '<td class="text-right font-bold">TOTAL '.$jml.' Bale</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlpcs,0).' Pcs</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlkgs,2).' Kgs</td>';
            $htmltot .= '</tr>';
        }
        $cocok = array('jml' => $jml,'rowsatu' => $html,'rowdua' => $html2,'rowtiga' => $html3,'rowempat' => $html4,'rowtotal' => $htmltot);
        echo json_encode($cocok);
    }
    public function loadfingoods(){
        $id = $_POST['id'];
        $html = '';
        $html2 = '';
        $html3 = '';
        $html4 = '';
        $htmltot = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadfinishedgoods($id);
        if($data->num_rows() <= 5){
            $jmlrow = 5;
        }else{
            $jmlrow = ceil($data->num_rows()/4);
        }
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcs'];
            $jmlkgs += $dt['kgs'];
            if($jml <= $jmlrow){
                $html .= '<tr>';
                $html .= '<td>'.$dt['nobale'].'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['pcs'],0).'</td>';
                $html .= '<td class="text-right">'.rupiah($dt['kgs'],2).'</td>';
                $html .= '</tr>';
            }else if($jml > $jmlrow && $jml <= ($jmlrow*2)){
                $html2 .= '<tr>';
                $html2 .= '<td>'.$dt['nobale'].'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['pcs'],0).'</td>';
                $html2 .= '<td class="text-right">'.rupiah($dt['kgs'],2).'</td>';
                $html2 .= '</tr>';
            }else if($jml > ($jmlrow*2) && $jml <= ($jmlrow*3)){
                $html3 .= '<tr>';
                $html3 .= '<td>'.$dt['nobale'].'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['pcs'],0).'</td>';
                $html3 .= '<td class="text-right">'.rupiah($dt['kgs'],2).'</td>';
                $html3 .= '</tr>';
            }else if($jml > ($jmlrow*3) && $jml <= ($jmlrow*4)){
                $html4 .= '<tr>';
                $html4 .= '<td>'.$dt['nobale'].'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['pcs'],0).'</td>';
                $html4 .= '<td class="text-right">'.rupiah($dt['kgs'],2).'</td>';
                $html4 .= '</tr>';
            } 
        }
        if($data->num_rows() > 0){
            $bagi = $dt['jmlpiece']==0 ? 1 : $dt['jmlpiece'];
            $htmltot .= '<tr>';
            $htmltot .= '<td class="text-center text-danger font-bold" style="font-size: 16px;">'.rupiah(($jmlpcs/$dt['jmlpiece'])*100,2).' %</td>';
            $htmltot .= '<td class="text-right font-bold">TOTAL '.$jml.' Bale</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlpcs,0).' Pcs</td>';
            $htmltot .= '<td class="text-right">'.rupiah($jmlkgs,2).' Kgs</td>';
            $htmltot .= '</tr>';
        }
        $cocok = array('jml' => $jml,'rowsatu' => $html,'rowdua' => $html2,'rowtiga' => $html3,'rowempat' => $html4,'rowtotal' => $htmltot);
        echo json_encode($cocok);
    }
    public function loadship(){
        $id = $_POST['id'];
        $html = '';
        $jml = 0;
        $jmlpcs = 0; $jmlkgs = 0;
        $data = $this->ponetmodel->loadship($id);
        foreach($data->result_array() as $dt){
            $jml++;
            $jmlpcs += $dt['pcstotal'];
            $jmlkgs += $dt['kgstotal'];
            $html .= '<tr>';
            $html .= '<td class="text-center font-bold">'.$jml.'</td>';
            $html .= '<td class="text-center">'.tglmysql($dt['tgl']).'</td>';
            $html .= '<td class="">'.$dt['nomor_dok'].'</td>';
            $html .= '<td>'.$dt['nama_customer'].'</td>';
            $html .= '<td>'.$dt['uraian_negara'].'</td>';
            $html .= '<td class="text-right font-bold">'.rupiah($dt['pcstotal'],0).'</td>';
            $html .= '<td class="text-right font-bold">'.rupiah($dt['kgstotal'],2).'</td>';
            $html .= '<td>-</td>';
            $html .= '</tr>';
        }
        $html .= '<tr>';
        $html .= '<td class="text-right font-bold" colspan="5">TOTAL '.$jml.' Pengiriman</td>';
        $html .= '<td class="text-right font-bold">'.rupiah($jmlpcs,0).'</td>';
        $html .= '<td class="text-right font-bold">'.rupiah($jmlkgs,2).'</td>';
        $html .= '<td>-</td>';
        $html .= '</tr>';
        $cocok = array('jml' => $jml,'datagroup' => $html);
        echo json_encode($cocok);
    }
}
