<?php
class Bbl_model extends CI_Model
{
    public function getdatabbl($data)
    {
        $this->db->select('tb_header.,user.name,(select count() from tb_detail where id_header = tb_header.id) as jmlrex');
        $this->db->join('user', 'user.id=tb_header.user_ok', 'left');
        $this->db->where('dept_id', $data['dept_id']);
        $this->db->where('dept_tuju', $data['dept_tuju']);
        if ($data['level'] == 2) {
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }
        $this->db->where('month(tgl)', $this->session->userdata('bl'));
        $this->db->where('year(tgl)', $this->session->userdata('th'));
        return $this->db->get('tb_header')->result_array();
    }

    public function tambah_bbl($data)
    {
        $kode = $data['nomor_dok'];
        $query = $this->db->insert('tb_header', $data);
        if ($query) {
            $this->db->where('nomor_dok', $kode);
            $kodex = $this->db->get('tb_header')->row_array();
        }
        return $kodex;
    }


    public function getnomorbbl($bl, $th, $asal, $tuju)
    {
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,15,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'BBL' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND dept_id = '" . $asal . "' AND dept_tuju = '" . $tuju . "' ")->row_array();
        return $hasil;
    }

    public function update_bbl($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }

    public function getdatapb()
    {
        $this->db->where('kode_dok', 'PB');
        $this->db->where('id_keluar', NULL);
        $query = $this->db->get('tb_header')->result_array();
        return  $query;
    }


    public function getspecbarang($spec)
    {

        $this->db->select('*');
        $this->db->from('tb_header');
        $this->db->join('tb_detail', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'tb_detail.id_barang = barang.id', 'left');
        $this->db->join('satuan', 'tb_detail.id_satuan = satuan.id', 'left');
        $this->db->like('tb_header.nomor_dok', $spec);
        $this->db->order_by('tb_header.nomor_dok', 'ASC');
        $this->db->where('tb_header.kode_dok', 'PB');
        $this->db->where('tb_header.id_keluar IS NULL');
        $query = $this->db->get()->result_array();

        return $query;
    }
    public function getdetailpbbyid()
    {
        $data = $_POST['id'];
        $hasil = $this->pb_model->getdatadetailpbbyid($data);
        echo json_encode($hasil);
    }
    public function simpandetailbarang()
    {
        $data = $this->input->post();
        unset($data['nomor_dok']);
        $hasil =  $this->db->insert('tb_detail', $data);
        if ($hasil) {
            $this->db->where('id', $data['id_header']);
            $query = $this->db->get('tb_header')->row_array();
            return $query;
        }
        return false;
    }

    public function getdatabyid($id)
    {
        $this->db->select('tb_header.*,dept.departemen');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header')->row_array();
    }

    public function getdatadetail_bbl($data)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,satuan.kodesatuan,barang.kode,barang.nama_barang,barang.kode as brg_id");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('id_header', $data);
        return $this->db->get()->result_array();
    }

    public function hapusdetailbbl($id)
    {
        $this->db->trans_start();
        $cek = $this->db->get_where('tb_detail', ['id' => $id])->row_array();
        $this->db->where('id_detail', $id);
        $hasil = $this->db->delete('tb_detmaterial');
        $this->db->where('id', $id);
        $this->db->delete('tb_detail');
        $hasil = $this->db->trans_complete();
        if ($hasil) {
            $this->db->where('id', $cek['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }

    public function get_data_by_id($id)
    {
        $query = $this->db->get_where('td_detail', array('id' => $id));
        return $query->result_array();
    }
}
