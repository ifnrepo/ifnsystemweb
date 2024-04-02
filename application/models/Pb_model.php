<?php 
class Pb_model extends CI_Model{
    public function getdatabyid($id){
        $this->db->where('id',$id);
        return $this->db->get('tb_header')->row_array();
    }
    public function depttujupb($kode){
        $hasil = '';
        $depo = '';
        if($kode=='GW'){
            $depo = 'GS,';
        }else{
            $depo = 'GM,GP,GF,GW,GS,';
            if($kode=='RR' || $kode=='FG'){
                $depo .= 'FN,';
            }
        }
        $cek = $this->db->get_where('dept',['dept_id' => $kode])->row_array();
        for($i=1;$i<=strlen($cek['penerimaan'])/2;$i++){
            $kodex = substr($cek['penerimaan'],($i*2)-2,2);
            $pos = strpos($depo,$kodex);
            if($pos !== false){
                $this->db->where('dept_id',$kodex);
                $gudang = $this->db->get('dept')->row_array();
                if($gudang){
                    $hasil .= "<option value='".$gudang['dept_id']."' rel='".$gudang['departemen']."'>".$gudang['departemen']."</option>";
                }
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
    public function getdatadetailpb($data){
        $this->db->select("tb_detail.*,satuan.namasatuan,barang.kode,barang.nama_barang");
        $this->db->from('tb_detail');
        $this->db->join('satuan','satuan.id = tb_detail.id_satuan','left');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->where('id_header',$data);
        return $this->db->get()->result_array();
    }
    public function getspecbarang($mode,$spec){
        if($mode==0){
            $this->db->like('nama_barang',$spec);
            $query = $this->db->get_where('barang',array('act'=>1))->result_array();
        }else{
            $this->db->like('kode',$spec);
            $query = $this->db->get_where('barang',array('act'=>1))->result_array();
        }
        return $query;
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
    public function simpandetailbarang(){
        $data = $_POST;
        unset($data['nama_barang']);
       $hasil =  $this->db->insert('tb_detail',$data);
       $idnya = $this->db->get_where('tb_detail',array('id_barang'=>$data['id_barang'],'id_header'=>$data['id_header']))->row_array();
        // Isi data detmaterial
        $cek = $this->db->get_where('bom_barang',array('id_barang'=>$data['id_barang']));
        if($cek->num_rows() > 0){
            foreach ($cek->result_array() as $kec) {
                $xdata = [
                    'id_header' => $data['id_header'],
                    'id_detail' => $idnya['id'],
                    'id_barang' => $kec['id_barang_bom'],
                    'persen' => $kec['persen'],
                    'kgs' => ($kec['persen']/100)*$data['kgs']
                ];
                $this->db->insert('tb_detmaterial',$xdata);
            }
        }
        if($hasil){
            $this->db->where('id',$data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function hapusdetailpb($id){
        $this->db->trans_start();
        $cek = $this->db->get_where('tb_detail',['id'=>$id])->row_array();
        $this->db->where('id_detail',$id);
        $hasil = $this->db->delete('tb_detmaterial');
        $this->db->where('id',$id);
        $this->db->delete('tb_detail');
        $hasil = $this->db->trans_complete();
        if($hasil){
            $this->db->where('id',$cek['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
}