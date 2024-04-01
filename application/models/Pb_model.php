<?php 
class Pb_model extends CI_Model{
    public function getdatabyid($id){
        $this->db->where('id',$id);
        return $this->db->get('tb_header')->row_array();
    }
    public function depttujupb($kode){
        $hasil = '';
        $cek = $this->db->get_where('dept',['dept_id' => $kode])->row_array();
        for($i=0;$i<=strlen($cek['penerimaan'])/2;$i++){
            $kodex = substr($cek['penerimaan'],($i*2)-2,2);
            $this->db->where('dept_id',$kodex);
            $this->db->where('katedept_id',1);
            $gudang = $this->db->get('dept')->row_array();
            if($gudang){
                $hasil .= "<option value='".$gudang['dept_id']."' rel='".$gudang['departemen']."'>".$gudang['departemen']."</option>";
            }
        }
        return $hasil;
    }
    public function tambahpb($data){
        $kode = $data['nomor_dok'];
        $query = $this->db->insert('tb_header',$data);
        if($query){
            $this->db->where('nomor_dok',$kode);
            $kodex = $this->db->get('tb_header')->row_array();
        }
        return $kodex;
    }
    public function getnomorpb($bl,$th,$asal,$tuju){
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,15,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'PB' AND MONTH(tgl)='".$bl."' AND YEAR(tgl)='".$th."' AND dept_id = '".$asal."' AND dept_tuju = '".$tuju."' ")->row_array();
        return $hasil;
    }
    public function getdatapb($data){
        $this->db->where('dept_id',$data['dept_id']);
        $this->db->where('dept_tuju',$data['dept_tuju']);
        return $this->db->get('tb_header')->result_array();
    }
    public function hapusdata($id){
        $this->db->trans_start();
        $this->db->where('id_header',$id);
        $this->db->delete('tb_detmaterial');
        $this->db->where('id_header',$id);
        $this->db->delete('tb_detail');
        $this->db->where('id',$id);
        $this->db->delete('tb_header');
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
}