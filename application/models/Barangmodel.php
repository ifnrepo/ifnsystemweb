<?php 
class Barangmodel extends CI_Model{
    var $column_search = array('nama_barang','kode','nama_kategori');
    var $column_order = array(null,'nama_barang','kode','nama_kategori');
    var $order = array('nama_barang'=>'asc');
    var $table = 'barang';
    public function getdatajson(){
        $query = $this->db->query("Select barang.*,satuan.namasatuan,kategori.nama_kategori,
        (select count(*) from bom_barang where id_barang = barang.id) as jmbom
        from barang
        left join kategori on kategori.kategori_id = barang.id_kategori
        left join satuan on satuan.id = barang.id_satuan");
        return $query;
    }
    public function getdata(){
        // $this->getdatajson();
        // $this->db->from($this->table);
        $this->db->select('barang.*,satuan.namasatuan,kategori.nama_kategori,(select count(*) from bom_barang where id_barang = barang.id) as jmbom',FALSE);
        $this->db->from($this->table);
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $i=0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like($item,$_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search)-1 == $i)
                $this->db->group_end();
            }
            $i++;
        }
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order),$order[key($order)]);
        }
    }
    public function get_datatables(){
        $this->getdata();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered(){
        $this->getdata();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all(){
        $this->db->from('barang');
        return $this->db->count_all_results();
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