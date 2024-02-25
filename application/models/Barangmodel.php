<?php 
class Barangmodel extends CI_Model{
    public function getdata(){
        $query = $this->db->query("Select barang.*,satuan.namasatuan 
        from barang
        left join satuan on satuan.id = barang.id_satuan");
        return $query;
    }
    public function getdatabyid($id){
        $query = $this->db->query("Select * from barang where id =".$id);
        return $query;
    }
    public function simpanbarang($data){
        $query = $this->db->insert('barang',$data);
        return $query;
    }
    public function updatebarang($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('barang',$data);
        return $query;
    }
    public function hapusbarang($id){
        $query = $this->db->query("Delete from barang where id =".$id);
        return $query;
    }
}