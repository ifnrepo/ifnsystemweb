<?php
class Billmaterial_cost_model extends CI_Model
{
    public function getdata()
    {
        $this->db->select('ref_bom_cost.*,barang.nama_barang,barang.kode');
        $this->db->from('ref_bom_cost');
        $this->db->join('barang', 'barang.id = ref_bom_cost.id_barang', 'left');
        $this->db->limit(1000, 0);
        if ($this->session->userdata('katcari') != '') {
            $this->db->like('po', $this->session->userdata('katcari'));
            $this->db->or_like('kode', $this->session->userdata('katcari'));
            $this->db->or_like('nama_barang', $this->session->userdata('katcari'));
            $this->db->or_like('insno', $this->session->userdata('katcari'));
            $this->db->or_like('nobontr', $this->session->userdata('katcari'));
        } else {
            $this->db->order_by('id Desc');
        }
        return $this->db->get();
    }
    public function getdatabyid($id)
    {
        $this->db->select('ref_bom_cost.*,barang.nama_barang,barang.kode');
        $this->db->from('ref_bom_cost');
        $this->db->join('barang', 'barang.id = ref_bom_cost.id_barang', 'left');
        $this->db->where('ref_bom_cost.id', $id);
        return $this->db->get()->row_array();
    }
    public function getdatadetailbyid($id)
    {
        $this->db->select('ref_bom_detail_cost.*,barang.nama_barang');
        $this->db->from('ref_bom_detail_cost');
        $this->db->join('barang', 'barang.id = ref_bom_detail_cost.id_barang', 'left');
        $this->db->where('id_bom', $id);
        $this->db->where('persen >', 0);
        return $this->db->get();
    }
    public function hapusdetail($id, $head)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $hapus = $this->db->delete('ref_bom_detail_cost');
        $this->helpermodel->isilog($this->db->last_query());

        //Update data ref_bom 
        $this->db->select('ROUND(SUM(persen),2) as persen');
        $this->db->from('ref_bom_detail_cost');
        $this->db->where('id_bom', $head);
        $hasil = $this->db->get()->row_array();

        if ($hasil['persen'] != 100.00) {
            $this->db->where('id', $head);
            $this->db->update('ref_bom_cost', ['data_ok' => 0]);
        } else {
            $this->db->where('id', $head);
            $this->db->update('ref_bom_cost', ['data_ok' => 1]);
        }
        $this->helpermodel->isilog($this->db->last_query());
        return $this->db->trans_complete();
    }
    public function simpandetail($data)
    {
        $this->db->trans_start();
        $this->db->insert('ref_bom_detail_cost', $data);
        $this->helpermodel->isilog($this->db->last_query());

        //Update data ref_bom 
        $this->db->select('ROUND(SUM(persen),2) as persen');
        $this->db->from('ref_bom_detail_cost');
        $this->db->where('id_bom', $data['id_bom']);
        $hasil = $this->db->get()->row_array();

        if ($hasil['persen'] != 100.00) {
            $this->db->where('id', $data['id_bom']);
            $this->db->update('ref_bom_cost', ['data_ok' => 0]);
        } else {
            $this->db->where('id', $data['id_bom']);
            $this->db->update('ref_bom_cost', ['data_ok' => 1]);
        }
        $this->helpermodel->isilog($this->db->last_query());
        return $this->db->trans_complete();
    }
    public function updatedetail($data)
    {
        $this->db->trans_start();
        $this->db->where('id', $data['id']);
        $this->db->update('ref_bom_detail_cost', $data);
        $this->helpermodel->isilog($this->db->last_query());

        //Update data ref_bom 
        $this->db->select('ROUND(SUM(persen),2) as persen');
        $this->db->from('ref_bom_detail_cost');
        $this->db->where('id_bom', $data['id_bom']);
        $hasil = $this->db->get()->row_array();

        if ($hasil['persen'] != 100.00) {
            $this->db->where('id', $data['id_bom']);
            $this->db->update('ref_bom_cost', ['data_ok' => 0]);
        } else {
            $this->db->where('id', $data['id_bom']);
            $this->db->update('ref_bom_cost', ['data_ok' => 1]);
        }
        $this->helpermodel->isilog($this->db->last_query());
        return $this->db->trans_complete();
    }
    public function simpandata($data)
    {
        $datakondisi = [
            'trim(po)' => trim($data['po']),
            'trim(item)' => trim($data['item']),
            'dis' => $data['dis'],
            'id_barang' => $data['id_barang'],
            'trim(nobale)' => trim($data['nobale']),
            'trim(insno)' => trim($data['insno']),
            'trim(nobontr)' => trim($data['nobontr']),
            'dl' => $data['dl'],
        ];
        $cekdata = $this->db->get_where('ref_bom_cost', $datakondisi);
        if ($cekdata->num_rows() > 0) {
            $query = 0;
        } else {
            if (trim($data['po']) != '') {
                $kondisipo = [
                    'trim(po)' => trim($data['po']),
                    'trim(item)' => trim($data['item']),
                    'dis' => $data['dis'],
                ];
                $datpo = $this->db->get_where('tb_po', $kondisipo);
                if ($datpo->num_rows() > 0) {
                    $hasildatapo = $datpo->row_array();
                    $data['po'] = $hasildatapo['po'];
                    $data['item'] = $hasildatapo['item'];
                    $data['dis'] = $hasildatapo['dis'];
                }
            }
            $this->db->insert('ref_bom_cost', $data);
            $query = $this->db->insert_id();
        }
        return $query;
    }
    public function hapus($id)
    {
        $this->db->trans_start();
        $this->db->where('id_bom', $id);
        $this->db->delete('ref_bom_detail_cost');

        $this->db->where('id', $id);
        $this->db->delete('ref_bom_cost');
        return $this->db->trans_complete();
    }
    public function simpantglprod($data){
        $this->db->where('id',$data['id']);
        return $this->db->update('ref_bom_cost',['prod_date' => $data['prod_date']]);
    }
}
