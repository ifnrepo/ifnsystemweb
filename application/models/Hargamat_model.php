<?php
class Hargamat_model extends CI_Model
{
    public function getdata(){
        $this->db->select('*');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang','barang.id = tb_hargamaterial.id_barang','left');
        return $this->db->get();
    }
    public function getbarang(){
        $this->db->select("*,tb_detail.id as idx");
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->join('supplier','supplier.id = tb_header.id_pemasok','left');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->join('kategori','kategori.kategori_id = barang.id_kategori','left');
        $this->db->where(['tb_header.kode_dok'=>'IB','tb_header.data_ok'=>1,'tb_header.ok_valid'=>1]);
        return $this->db->get();
    }
    public function simpanbarang($kode){
        $jumlah = count($kode['data']);
        for($x=0;$x<$jumlah;$x++){
            $arrdat = $kode['data'];
            $this->db->select("*");
            $this->db->from('tb_detail');
            $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
            $this->db->where('tb_detail.id',$arrdat[$x]);
            $databarang = $this->db->get()->row_array();
            $datafield = [
                'id_barang' => $databarang['id_barang'],
                'nobontr' => $databarang['nobontr'],
                'price' => $databarang['harga'],
                'id_supplier' => $databarang['id_pemasok'],
                'jns_bc' => $databarang['jns_bc'],
                'tgl_bc' => $databarang['tgl_bc'],
                'nomor_bc' => $databarang['nomor_bc'],
                'qty' => $databarang['pcs'],
                'weight' => $databarang['kgs'],
                'id_satuan' => $databarang['id_satuan'],
                'tgl' => $databarang['tgl']
            ];

            $this->db->insert('tb_hargamaterial',$datafield);
        }
        return true;
    }
}
