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
            $kata = 'Dokumen DIBUAT oleh '.datauser($cek['user_ok'],'name').' on '.tglmysql2($cek['tgl_ok']);
            array_push($hasil,$kata);
        }
        if($cek['ok_valid']==1){
            $kata = 'Dokumen DISETUJUI oleh '.datauser($cek['user_valid'],'name').' on '.tglmysql2($cek['tgl_valid']);
            array_push($hasil,$kata);
        }
        // Cek detail barang 
        $this->db->where('id_header',$id);
        $detail = $this->db->get('tb_detail');
        $hasil2 = [];
        foreach($detail->result_array() as $det){
            $barang = $this->db->get_where('barang',['id'=>$det['id_barang']])->row_array();
            $kata = $barang['nama_barang'];
            array_push($hasil2,$kata);
            $hasil3 = [];
            $kepalanya = 0;
            for($ke=0;$ke <= 3;$ke++){
                // 0 : cek data BBL
                // 1 : cek data PO
                // 2 : cek data IB
                // 3 : cek data OUT
                switch ($ke) {
                    case 0:
                        $fid = 'id_bbl';
                        $fod = 'id_po';
                        $fed = 'BBL No. ';
                        break;
                    case 1:
                        $fid = 'id_po';
                        $fod = 'id_ib';
                        $fed = 'PO No. ';
                        break;
                    case 2:
                        $fid = 'id_ib';
                        $fod = 'id_out';
                        $fed = 'IB No. ';
                        break;
                    case 3:
                        $fid = 'id_out';
                        $fod = 'id';
                        $fed = 'OUT No. ';
                        break;
                }
                if($kepalanya == 1){
                    $cekisi = $this->db->get_where('tb_detail',['id'=>$idisinya]);
                    if($cekisi->num_rows() > 0){
                        $rekisi = $cekisi->row_array();
                        $det[$fid] = $rekisi['id'];
                    }else{
                        $det[$fid] = 0;
                    }
                }
                $selesai = $ke==3 ? ' (SELESAI)' : '';
                if($det[$fid]!=0){
                    $isifield = $det[$fid];
                    $this->db->select('tb_header.*,tb_detail.id_bbl,tb_detail.id_po,tb_detail.id_ib,tb_detail.id_out,tb_detail.id_minta');
                    $this->db->from('tb_header');
                    $this->db->join('tb_detail','tb_detail.id_header = tb_header.id','left');
                    $this->db->where('tb_detail.id',$isifield);
                    $isinya = $this->db->get()->row_array();
                    $kepalanya = 1;
                    $idisinya = $isinya[$fod];
                    array_push($hasil3,$fed.$isinya['nomor_dok'].$selesai);
                }else{
                    $kepalanya = 0;
                    // array_push($hasil3,$fed.'-');
                }
            }
            array_push($hasil2,$hasil3);
        }
        array_push($hasil,$hasil2);
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
            array_push($array1,strtoupper($field).' - '.date('Y'));
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
            'devicelog' => get_client_ip().' on '.$useragent,
            'modul' => strtoupper($this->uri->segment(1))
        ];
        $this->db->insert('tb_logactivity',$data);
    }
    public function cekclosebook($periode){
        $this->db->where('periode',$periode);
        $hasil = $this->db->get('tb_lockinv')->num_rows();
        return $hasil;
    }
    public function cekdetout($header){
        $this->db->where('id_out',0);
        $this->db->where('id_header',$header);
        $hasil = $this->db->get('tb_detail')->num_rows();
        return $hasil;
    }
}