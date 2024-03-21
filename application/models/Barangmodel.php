<?php 
class Barangmodel extends CI_Model{
    public function getdata(){
        $query = $this->db->query("Select barang.*,satuan.namasatuan,kategori.nama_kategori,
        (select count(*) from bom_barang where id_barang = barang.id) as jmbom
        from barang
        left join kategori on kategori.kategori_id = barang.id_kategori
        left join satuan on satuan.id = barang.id_satuan");
        return $query;
    }
    public function getdatabyid($id){
        $query = $this->db->query("Select barang.*,
        (SELECT SUM(persen) FROM bom_barang WHERE id_barang = barang.id) AS persenbom
        from barang where id =".$id);
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
        $querye = $this->db->query("Delete from bom_barang where id_barang =".$id);
        $query = $this->db->query("Delete from barang where id =".$id);
        return $query;
    }
    public function getdatabom($id){
        $query = $this->db->query("Select bom_barang.*,barang.nama_barang, barang.kode
        from bom_barang
        left join barang on barang.id = bom_barang.id_barang_bom
        where bom_barang.id_barang = ".$id);
        return $query;
    }
    public function getdatabombyid($id){
        $query = $this->db->query("Select * from bom_barang where id = ".$id);
        return $query;
    }
    public function simpanbombarang($data){
        $query = $this->db->insert('bom_barang',$data);
        return $query;
    }
    public function updatebombarang($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('bom_barang',$data);
        return $query;
    }
    public function hapusbombarang($id){
        $query = $this->db->query("Delete from bom_barang where id =".$id);
        return $query;
    }
}