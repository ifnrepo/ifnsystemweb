<?php
class Supplier_model extends CI_Model
{

    public function getdata()
    {
        $this->db->select('supplier.*, ref_negara.kode_negara');
        $this->db->from('supplier');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = supplier.kode_negara', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getdatabyid($id)
    {
        $this->db->select('supplier.*, ref_negara.kode_negara');
        $this->db->from('supplier');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = supplier.kode_negara', 'left');
        $this->db->where('supplier.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function getdatabyname($nama)
    {
        $this->db->like('nama_supplier', $nama);
        return $this->db->get('supplier');
    }
    public function simpansupplier($data)
    {
        // $query = $this->db->insert('kategori', $data);
        // return $query;
        return $this->db->insert('supplier', $data);
    }
    public function updatesupplier($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('supplier', $data);
        return $query;
    }
    public function hapussupplier($id)
    {
        $query = $this->db->query("Delete from supplier where id =" . $id);
        return $query;
    }
}
