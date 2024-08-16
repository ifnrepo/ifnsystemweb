<?php
class Helper_model extends CI_Model
{
    public function cekkolom($id,$kolom,$nilai,$tabel){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get($tabel);
        return $hasil;
    }
    public function getterms($kode){
        $this->db->where('lokal',$kode);
        $hasil = $this->db->get('term_payment');
        return $hasil;
    }
    public function getdatasublok(){
        $dp = $this->session->userdata('deptsekarang');
        switch ($dp) {
            case 'FG':
                $this->db->where('kode',1);
                break;
            default:
                # code...
                break;
        }
        $hasil = $this->db->get('tb_sublok');
        return $hasil;
    }
    public function riwayatdok($id){
        $this->db->where('id',$id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if($cek['data_ok']==1){
            $kata = 'Dokumen dibuat oleh '.datauser($cek['user_ok'],'name').' on '.tglmysql2($cek['tgl_ok']);
            array_push($hasil,$kata);
        }
        if($cek['ok_valid']==1){
            $kata = 'Dokumen disetujui oleh '.datauser($cek['user_valid'],'name').' on '.tglmysql2($cek['tgl_valid']);
            array_push($hasil,$kata);
        }
        // Cek detail barang 
        $this->db->where('id_header',$id);
        $detail = $this->db->get('tb_detail');
        foreach($detail->result_array() as $det){
            
        }
        return $hasil;
    }
    public function dataproduksi(){
        $bulan = 'janfebmaraprmeijunjulagtsepoktnopdes';
        $fieldd = substr($bulan,((int)date('m')*3)-3,3);
        $fielde = substr($bulan,(((int)date('m')-1)*3)-3,3);
        $array1 = [];
        $array2 = [];
        $this->db->select("SUM(jan) AS jan,SUM(feb) AS feb,SUM(mar) AS mar,SUM(apr) AS apr,SUM(mei) AS mei,SUM(jun) AS jun,SUM(jul) AS jul,SUM(agt) AS agt,SUM(sep) AS sep,SUM(okt) AS okt,SUM(nop) AS nop,SUM(des) AS des");
        $this->db->where('tahun',date('Y'));
        $cek = $this->db->get('monitoringprd')->row_array();
        for($x=0;$x<12;$x++){
            $field = substr($bulan,(($x+1)*3)-3,3);
            $cik = $x+1;
            $cok = $field;
            array_push($array1,$field.' - '.date('Y'));
            array_push($array2,$cek[$field]);
        }
        // foreach ($cek as $kec) {
        //     array_push($array1,$kec['tgl']);
        //     array_push($array2,$kec[$field]);
        // }
        return array('data_tgl' => $array1, 'data_isi' => $array2,'data_prod_bulan_ini' => $cek[$fieldd],'data_prod_bulan_lalu' => $cek[$fielde]);
    }
    public function isilog($isilog){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        $data = [
            'activitylog' => str_replace('`','',$isilog),
            'userlog' => datauser($this->session->userdata('id'),'name'),
            'iduserlog' => $this->session->userdata('id'),
            'devicelog' => get_client_ip().' on '.$useragent
        ];
        $this->db->insert('tb_logactivity',$data);
    }
}