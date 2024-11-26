<?php
class Logactmodel extends CI_Model
{
    public function getdata()
    {
        $this->db->where('datetimelog <= ', $this->session->userdata('tglakhirlog'));
        $this->db->where('datetimelog >= ', $this->session->userdata('tglawallog'));
        if ($this->session->userdata('userlogact') != null || $this->session->userdata('userlogact') != '') {
            $this->db->where('iduserlog', $this->session->userdata('userlogact'));
        }
        $this->db->order_by('datetimelog', 'DESC');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get("tb_logactivity");
        return $query;
    }
    public function getdatauser()
    {
        // $this->db->select('iduserlog,userlog');
        // $this->db->where('datetimelog <= ', $this->session->userdata('tglakhirlog'));
        // $this->db->where('datetimelog >= ', $this->session->userdata('tglawallog'));
        // $this->db->group_by('iduserlog');
        // $this->db->order_by('userlog', 'ASC');
        // $query = $this->db->get("tb_logactivity");
        $this->db->select('id as iduserlog,name as userlog');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('user');
        return $query;
    }

    public function getFilteredData($tglawal, $tglakhir, $userlog)
    {
        $this->db->where('datetimelog >=', $tglawal);
        $this->db->where('datetimelog <=', $tglakhir);

        if (!empty($userlog)) {
            $this->db->where('iduserlog', $userlog);
        }

        return $this->db->get('tb_logactivity')->result_array();
    }

    public function getdatabyid($id)
    {
        $query = $this->db->query("Select * from satuan where id =" . $id);
        return $query;
    }
    public function simpansatuan($data)
    {
        $query = $this->db->insert('satuan', $data);
        return $query;
    }
    public function updatesatuan($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('satuan', $data);
        return $query;
    }
    public function hapussatuan($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('satuan');
        return $query;
    }
}
