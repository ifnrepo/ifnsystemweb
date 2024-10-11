<?php 
class mastermsn_model extends CI_Model{
    public function getdata(){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        if($this->session->userdata('lokasimesin')!=''){
            $this->db->where('lokasi',$this->session->userdata('lokasimesin'));
        }
        if($this->session->userdata('disposalmesin')!=0){
            $this->db->where('ok_disp',$this->session->userdata('disposalmesin'));
        }
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function getdatalokasi(){
        $this->db->select('lokasi');
        $this->db->from('tb_mesin');
        $query = $this->db->group_by('lokasi')->order_by('lokasi')->get();
        return $query;
    }
    public function getdatabyid($id){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        $this->db->where('tb_mesin.kode_fix',$id);
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function getdataby($id){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        $this->db->where('tb_mesin.id',$id);
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function simpansatuan($data){
        $query = $this->db->insert('satuan',$data);
        return $query;
    }
    public function updatesatuan($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('satuan',$data);
        return $query;
    }
    public function hapussatuan($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('satuan');
        return $query;
    }
}