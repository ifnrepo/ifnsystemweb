<?php 
class Satuanmodel extends CI_Model{
    public function getdata(){
        $query = $this->db->query("Select * from satuan");
        return $query;
    }
    public function getdatabyid($id){
        $query = $this->db->query("Select * from satuan where id =".$id);
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
        $query = $this->db->query("Delete from satuan where id =".$id);
        return $query;
    }
}