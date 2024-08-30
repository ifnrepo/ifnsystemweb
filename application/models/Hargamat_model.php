<?php
class Hargamat_model extends CI_Model
{
    public function getdata(){
        $this->db->select('*,tb_hargamaterial.id as idx');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang','barang.id = tb_hargamaterial.id_barang','left');
        $this->db->join('supplier','supplier.id = tb_hargamaterial.id_supplier','left');
        $this->db->join('satuan','satuan.id = tb_hargamaterial.id_satuan','left');
        if($this->session->flashdata('katehargamat')!=null){
            $this->db->where('barang.id_kategori',$this->session->flashdata('katehargamat'));
        }
        if($this->session->flashdata('artihargamat')!=null){
            $this->db->where('barang.id',$this->session->flashdata('artihargamat'));
        }
        return $this->db->get();
    }
    public function getdatabyid($id){
        $this->db->select('*,tb_hargamaterial.id as idx');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang','barang.id = tb_hargamaterial.id_barang','left');
        $this->db->join('supplier','supplier.id = tb_hargamaterial.id_supplier','left');
        $this->db->join('satuan','satuan.id = tb_hargamaterial.id_satuan','left');
        $this->db->join('kategori','kategori.kategori_id = barang.id_kategori','left');
        $this->db->where('tb_hargamaterial.id',$id);
        return $this->db->get();
    }
    public function getdatakategori(){
        $this->db->select('*');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang','barang.id = tb_hargamaterial.id_barang','left');
        $this->db->join('kategori','kategori.kategori_id = barang.id_kategori','left');
        $this->db->group_by('kategori.kategori_id');
        $this->db->order_by('kategori.nama_kategori','ASC');
        return $this->db->get();
    }
    public function getdataartikel(){
        $this->db->select('*');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang','barang.id = tb_hargamaterial.id_barang','left');
        $this->db->group_by('tb_hargamaterial.id_barang');
        $this->db->order_by('barang.nama_barang','ASC');
        return $this->db->get();
    }

    public function getbarang(){
        $this->db->select('id_detail');
        $this->db->from('tb_hargamaterial');
        $strkondisi = $this->db->get()->result_array();

        $this->db->select("*,tb_detail.id as idx");
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->join('supplier','supplier.id = tb_header.id_pemasok','left');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->join('kategori','kategori.kategori_id = barang.id_kategori','left');
        $this->db->where(['tb_header.kode_dok'=>'IB','tb_header.data_ok'=>1,'tb_header.ok_valid'=>1]);
        $this->db->where_not_in('tb_detail.id',array_column($strkondisi, 'id_detail'));
        return $this->db->get();
    }
    public function simpanbarang($kode){
        $jumlah = count($kode['data']);
        for($x=0;$x<$jumlah;$x++){
            $arrdat = $kode['data'];
            $this->db->select("tb_detail.*,tb_header.*,c.mt_uang as mtua");
            $this->db->from('tb_detail');
            $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
            $this->db->join('tb_detail b','b.id_ib = tb_detail.id','left');
            $this->db->join('tb_header c','c.id = b.id_header','left');
            $this->db->where('tb_detail.id',$arrdat[$x]);
            $databarang = $this->db->get()->row_array();
            if($databarang['mtua']=='IDR'){
                $othamount = $databarang['harga'];
            }else{
                $othamount = 0;
            }
            $datafield = [
                'id_barang' => $databarang['id_barang'],
                'nobontr' => $databarang['nomor_dok'],
                'price' => $databarang['harga'],
                'id_supplier' => $databarang['id_pemasok'],
                'jns_bc' => $databarang['jns_bc'],
                'tgl_bc' => $databarang['tgl_bc'],
                'nomor_bc' => $databarang['nomor_bc'],
                'qty' => $databarang['pcs'],
                'weight' => $databarang['kgs'],
                'id_satuan' => $databarang['id_satuan'],
                'tgl' => $databarang['tgl'],
                'mt_uang' => $databarang['mtua'],
                'id_detail' => $arrdat[$x],
                'oth_amount' => $othamount
            ];
            $this->db->insert('tb_hargamaterial',$datafield);
            $this->helpermodel->isilog($this->db->last_query());
        }
        return true;
    }
    public function updatehamat(){
        $data = $_POST;
        $data['kurs'] = toAngka($data['kurs']);
        $data['qty'] = toAngka($data['qty']);
        $data['weight'] = toAngka($data['weight']);
        $data['price'] = toAngka($data['price']);
        $data['oth_amount'] = toAngka($data['oth_amount']);

        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_hargamaterial',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
}
