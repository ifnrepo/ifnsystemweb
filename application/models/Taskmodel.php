<?php 
class Taskmodel extends CI_Model{
    public function getdatapb(){
        $this->db->where('id_perusahaan',IDPERUSAHAAN);
        $this->db->where('kode_dok','PB');
        $this->db->where('data_ok',1);
        $this->db->where('ok_valid',0);
        $this->db->where_in('dept_id',arrdep($this->session->userdata('hakdepartemen')));
        $query = $this->db->get('tb_header');
        return $query;
    }
    public function getdatabbl(){
        $this->db->where('id_perusahaan',IDPERUSAHAAN);
        $this->db->where('kode_dok','BBL');
        $this->db->where('data_ok',1);
        $this->db->where('ok_valid',0);
        $this->db->where_in('dept_id',arrdep($this->session->userdata('hakdepartemen')));
        $query = $this->db->get('tb_header');
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