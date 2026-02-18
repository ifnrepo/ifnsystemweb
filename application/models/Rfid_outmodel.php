<?php
class Rfid_outmodel extends CI_Model
{
    public function getdata_pl()
    {
        $this->db->select("plno");
        $this->db->from('tb_balenumber');
        $this->db->group_by('plno');
        $this->db->order_by('plno', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getdata_ex($filter_pl, $filter_exdo, $filter_cekmasuk, $filter_selesai)
    {

        $this->db->select('tb_balenumber.*, tb_packfin.nw, tb_packfin.pcs, tb_packfin.meas , tb_po.spek');
        $this->db->from('tb_balenumber');

        $this->db->join(
            'tb_packfin',
            'tb_packfin.po = tb_balenumber.po 
         AND tb_packfin.item = tb_balenumber.item
         AND tb_packfin.nobale = tb_balenumber.nobale',
            'left'
        );

        $this->db->join(
            'tb_po',
            'tb_po.po = tb_balenumber.po AND tb_po.item = tb_balenumber.item',
            'left'
        );


        if ($filter_pl !== 'all' && !empty($filter_pl)) {
            $this->db->where('tb_balenumber.plno', $filter_pl);
        }
        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }
        $this->db->order_by('tb_balenumber.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function verifikasi_data($id)
    {
        $this->db->set('masuk', 1);
        $this->db->set('user_ok', $this->session->userdata('username'));
        $this->db->set('waktu_ok', date('Y-m-d H:i'));
        $this->db->where('id', $id);
        return $this->db->update('tb_balenumber');
    }
    public function verifikasi_batal($id)
    {
        $this->db->set('masuk', '0');
        $this->db->set('user_ok', '');
        $this->db->set('waktu_ok', '');
        $this->db->where('id', $id);
        return $this->db->update('tb_balenumber');
    }
    public function verifikasi_selesai($id)
    {
        $this->db->set('selesai', 1);
        // $this->db->set('user_ok', $this->session->userdata('username'));
        // $this->db->set('waktu_ok', date('Y-m-d H:i'));
        $this->db->where('id', $id);
        return $this->db->update('tb_balenumber');
    }
    public function verifikasi_selesaiopen($id)
    {
        $this->db->set('selesai', 0);
        // $this->db->set('user_ok', $this->session->userdata('username'));
        // $this->db->set('waktu_ok', date('Y-m-d H:i'));
        $this->db->where('id', $id);
        return $this->db->update('tb_balenumber');
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_agama', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('tb_agama', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_agama', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_agama');
    }
}
