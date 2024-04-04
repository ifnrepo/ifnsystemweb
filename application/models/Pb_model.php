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
                    $selek = $this->session->userdata('tujusekarang')==$gudang['dept_id'] ? 'selected' : '';
                    $hasil .= "<option value='".$gudang['dept_id']."' rel='".$gudang['departemen']."' ".$selek.">".$gudang['departemen']."</option>";
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
    public function updatepb($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        return $query;
    }
    public function simpanpb($data){
        $jmlrec = $this->db->query("Select count(id) as jml from tb_detail where id_header = ".$data['id'])->row_array();
        $data['jumlah_barang'] = $jmlrec['jml'];
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        return $query;
    }
    public function validasipb($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        return $query;
    }
    public function getnomorpb($bl,$th,$asal,$tuju){
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,15,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'PB' AND MONTH(tgl)='".$bl."' AND YEAR(tgl)='".$th."' AND dept_id = '".$asal."' AND dept_tuju = '".$tuju."' ")->row_array();
        return $hasil;
    }
    public function getdatapb($data){
        $this->db->select('tb_header.*,user.name,(select count(*) from tb_detail where id_header = tb_header.id) as jmlrex');
        $this->db->join('user','user.id=tb_header.user_ok','left');
        $this->db->where('dept_id',$data['dept_id']);
        $this->db->where('dept_tuju',$data['dept_tuju']);
        if($data['level']==2){
            $this->db->where('data_ok',1);
            $this->db->where('ok_tuju',0);
        }
        return $this->db->get('tb_header')->result_array();
    }
    public function getdatadetailpb($data){
        $this->db->select("tb_detail.*,satuan.namasatuan,barang.kode,barang.nama_barang,barang.kode as brg_id");
        $this->db->from('tb_detail');
        $this->db->join('satuan','satuan.id = tb_detail.id_satuan','left');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->where('id_header',$data);
        return $this->db->get()->result_array();
    }
    public function getdatadetailpbbyid($data){
        $this->db->select("tb_detail.*,satuan.namasatuan,barang.kode,barang.nama_barang,satuan.id as id_satuan");
        $this->db->from('tb_detail');
        $this->db->join('satuan','satuan.id = tb_detail.id_satuan','left');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->where('tb_detail.id',$data);
        return $this->db->get()->result();
    }
    public function getspecbarang($mode,$spec){
        if($mode==0){
            $this->db->like('nama_barang',$spec);
            $this->db->order_by('nama_barang','ASC');
            $query = $this->db->get_where('barang',array('act'=>1))->result_array();
        }else{
            $this->db->like('kode',$spec);
            $this->db->order_by('kode','ASC');
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
    public function updatedetailbarang(){
        $data = $_POST;
        unset($data['nama_barang']);
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_detail',$data);

        $idnya = $this->db->get_where('tb_detail',array('id_barang'=>$data['id_barang'],'id_header'=>$data['id_header']))->row_array();
        $this->db->where('id_header',$data['id_header']);
        $this->db->delete('tb_detmaterial');
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
        if($query){
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