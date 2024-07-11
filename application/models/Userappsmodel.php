<?php
class Userappsmodel extends CI_Model
{
    public function getdata()
    {
        $this->db->select('user.*, level_user.level, dept.departemen');
        $this->db->from('user');
        $this->db->join('level_user', 'level_user.id = user.id_level_user', 'left');
        $this->db->join('dept', 'dept.dept_id = user.id_dept', 'left');

        return $this->db->get()->result_array();
    }

    public function getdatabyid($id)
    {
        $query = $this->db->query("Select user.*,level_user.id as idlevel from user left join level_user on level_user.id = user.id_level_user where user.id = " . $id);
        return $query;
    }

    public function getdatabyuser($user)
    {
        $query = $this->db->query("Select user.*,level_user.id as idlevel from user left join level_user on level_user.id = user.id_level_user where user.username = '" . $user . "' ");
        return $query;
    }
    public function hapusdata($id)
    {
        $query = $this->db->query("Delete from user where id = " . $id);
        return $query;
    }
    public function simpandata()
    {
        $data = $_POST;
        $data['aktif'] = isset($data['aktif']) ? 1 : 0;
        $data['password'] = encrypto($data['password']);
        $data['bagian'] = strtoupper($data['bagian']);
        // Set modul master
        $master = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['master' . $x])) {
                $master = substr_replace($master, '10', ($x * 2) - 2, 2);
                unset($data['master' . $x]);
            }
        }
        // Set modul transaksi
        $transaksi = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['transaksi' . $x])) {
                $transaksi = substr_replace($transaksi, '10', ($x * 2) - 2, 2);
                unset($data['transaksi' . $x]);
            }
        }
        // Set modul manajemen
        $manajemen = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['manajemen' . $x])) {
                $manajemen = substr_replace($manajemen, '10', ($x * 2) - 2, 2);
                unset($data['manajemen' . $x]);
            }
        }
        // Set hak departemen
        $hakdepartemen = '';
        $datdept = $this->deptmodel->getdata();
        foreach ($datdept as $dept) {
            if (isset($data[$dept['dept_id']])) {
                $hakdepartemen .= $dept['dept_id'];
                unset($data[$dept['dept_id']]);
            }
        }
        $data['master'] = $master;
        $data['transaksi'] = $transaksi;
        $data['manajemen'] = $manajemen;
        $data['hakdepartemen'] = $hakdepartemen;
        $hasil = $this->db->insert('user', $data);
        return $hasil;
    }
    public function updatedata()
    {
        $data = $_POST;
        $data['aktif'] = isset($data['aktif']) ? 1 : 0;
        $data['password'] = encrypto($data['password']);
        $data['bagian'] = strtoupper($data['bagian']);
        // Set modul master
        $master = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['master' . $x])) {
                $master = substr_replace($master, '10', ($x * 2) - 2, 2);
                unset($data['master' . $x]);
            }
        }
        // Set modul transaksi
        $transaksi = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['transaksi' . $x])) {
                $transaksi = substr_replace($transaksi, '10', ($x * 2) - 2, 2);
                unset($data['transaksi' . $x]);
            }
        }

        // Set Modul Other
        $other = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['other' . $x])) {
                $other = substr_replace($other, '10', ($x * 2) - 2, 2);
                unset($data['other' . $x]);
            }
        }

        // Set modul manajemen
        $manajemen = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['manajemen' . $x])) {
                $manajemen = substr_replace($manajemen, '10', ($x * 2) - 2, 2);
                unset($data['manajemen' . $x]);
            }
        }
        // Set hak departemen
        $hakdepartemen = '';
        $datdept = $this->deptmodel->getdata();
        foreach ($datdept as $dept) {
            if (isset($data[$dept['dept_id']])) {
                $hakdepartemen .= $dept['dept_id'];
                unset($data[$dept['dept_id']]);
            }
        }

        $data['master'] = $master;
        $data['transaksi'] = $transaksi;
        $data['other'] = $other;
        $data['manajemen'] = $manajemen;
        $data['hakdepartemen'] = $hakdepartemen;

        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('user', $data);
        if ($data['id'] == $this->session->userdata('id')) {
            $cek = $this->getdatabyid($data['id'])->row_array();
            $this->session->set_userdata('master', $cek['master']);
            $this->session->set_userdata('transaksi', $cek['transaksi']);
            $this->session->set_userdata('other', $cek['other']);
            $this->session->set_userdata('manajemen', $cek['manajemen']);
            $this->session->set_userdata('hakdepartemen', $cek['hakdepartemen']);
            $this->session->set_userdata('arrdep', arrdep($cek['hakdepartemen']));
        }

        return $hasil;
    }
    public function getdatalevel()
    {
        $query = $this->db->get('level_user')->result_array();
        return $query;
    }
}
