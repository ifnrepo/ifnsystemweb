<?php 
class Warnamodel extends CI_Model{
    public function getdata($limit=0,$start=0){
        if($this->session->userdata('pencarian-warna')!=''){
            $this->db->like('basecolor',$this->session->userdata('pencarian-warna'));
        }
        $this->db->group_by('basecolor');
        $this->db->order_by('basecolor');
        $q = $this->db->get_compiled_select('tb_color');
        $query = $this->db->query($q." limit ".$start.",".$limit);
        return $query;
    }
    public function countdata(){
        // $query = $this->db->query("Select * from tb_color group by basecolor order by basecolor")->num_rows();
        // return $query;
        if($this->session->userdata('pencarian-warna')!=''){
            $this->db->like('basecolor',$this->session->userdata('pencarian-warna'));
        }
        $this->db->group_by('basecolor');
        $this->db->order_by('basecolor');
        $q = $this->db->get_compiled_select('tb_color');
        $query = $this->db->query($q)->num_rows();
        return $query;
    }
    public function getcolor($id){
        $warna = $this->db->get_where('tb_color',['id' => $id])->row_array();

        $this->db->where('basecolor',$warna['basecolor']);
        $this->db->order_by('color');
        return $this->db->get('tb_color');
    }
    public function getbasecolor($id){
        return $this->db->get_where('tb_color',['id' => $id])->row_array();
    }
    public function getdyestuff($color){
        return $this->db->get_where('tb_color_dyestuff',['basecolor' => $color]);
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
        $this->db->where('id',$id);
        $query = $this->db->delete('satuan');
        return $query;
    }
}