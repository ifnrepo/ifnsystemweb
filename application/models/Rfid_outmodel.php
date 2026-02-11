<?php
class Rfid_outmodel extends CI_Model
{
    public function getdata_pl()
    {
        $this->db->select("plno");
        $this->db->from('tb_balenumber');
        $this->db->group_by('plno');
        $this->db->order_by('plno', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getdata_ex($filter_pl)
    {

        $this->db->select('tb_balenumber.*');
        $this->db->from('tb_balenumber');

        if ($filter_pl !== 'all' && !empty($filter_pl)) {
            $this->db->where('tb_balenumber.plno', $filter_pl);
        }
        $this->db->order_by('tb_balenumber.id', 'DESC');
        return $this->db->get()->result_array();
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
