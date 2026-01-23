<?php
class Userappsmodel extends CI_Model
{
    public function getdata()
    {
        $this->db->select('user.*, level_user.level, dept.departemen');
        $this->db->from('user');
        $this->db->join('level_user', 'level_user.id = user.id_level_user', 'left');
        $this->db->join('dept', 'dept.dept_id = user.id_dept', 'left');

        return $this->db->order_by('user.id', 'DESC')->get()->result_array();
    }

    public function dept_Stok_Opname()
    {
        $this->db->select("dept.*");
        $this->db->from('dept');
        $this->db->where_in('dept_id', ['AM', 'AN', 'AR', 'MD', 'NU', 'GF', 'FN', 'FG', 'GP', 'GM', 'NT', 'DL', 'TN', 'RR', 'ST', 'GS', 'SP', 'GW']);
        $this->db->order_by('departemen', 'ASC');
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
        $this->db->where('id', $id);
        $query = $this->db->delete('user');
        // $query = $this->db->query("Delete from user where id = " . $id);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    public function simpandata()
    {
        $data = $_POST;
        $data['aktif'] = isset($data['aktif']) ? 1 : 0;
        $data['cekpo'] = isset($data['cekpo']) ? 1 : 0;
        $data['cekpc'] = isset($data['cekpc']) ? 1 : 0;
        $data['cekadj'] = isset($data['cekadj']) ? 1 : 0;
        $data['cekpp'] = isset($data['cekpp']) ? 1 : 0;
        $data['cekut'] = isset($data['cekut']) ? 1 : 0;
        $data['cekbatalstok'] = isset($data['cekbatalstok']) ? 1 : 0;
        $data['cekbbl'] = isset($data['cekbbl']) ? 1 : 0;
        $data['view_harga'] = isset($data['view_harga']) ? 1 : 0;
        $data['cekpakaibc'] = isset($data['cekpakaibc']) ? 1 : 0;
        $data['cekrd'] = isset($data['cekrd']) ? 1 : 0;
        $data['cekenv'] = isset($data['cekenv']) ? 1 : 0;
        $data['hakveri_env'] = isset($data['hakveri_env']) ? 1 : 0;
        $data['cek_so'] = isset($data['cek_so']) ? 1 : 0;
        $data['cek_saw'] = isset($data['cek_saw']) ? 1 : 0;
        $data['cekdowntime'] = isset($data['cekdowntime']) ? 1 : 0;
        $data['password'] = encrypto(trim($data['password']));
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
        // Set modul hakprogram
        $hakprogram = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['hakprogram' . $x])) {
                $hakprogram = substr_replace($hakprogram, '10', ($x * 2) - 2, 2);
                unset($data['hakprogram' . $x]);
                if ($x == 4) {
                    $data['hakeventrahasia'] = isset($data['hakeventrahasia']) ? 1 : 0;
                }
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
        // Set modul setting
        $setting = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['setting' . $x])) {
                $setting = substr_replace($setting, '10', ($x * 2) - 2, 2);
                unset($data['setting' . $x]);
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
        // Set hak tandatangan PB
        $cekpb = '';
        $datdept = $this->deptmodel->getdata_dept_pb();
        foreach ($datdept as $dept) {
            if (isset($data['X' . $dept['dept_id']])) {
                $cekpb .= $dept['dept_id'];
                unset($data['X' . $dept['dept_id']]);
            }
        }
        // Set hak RFID
        $rfid = str_repeat('0', 00);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['rfid' . $x])) {
                $rfid = substr_replace($rfid, '10', ($x * 2) - 2, 2);
                unset($data['rfid' . $x]);
            }
        }
        // set hakdowntime
        $hakdowntime = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['hakdowntime' . $x])) {
                $hakdowntime = substr_replace($hakdowntime, '10', ($x * 2) - 2, 2);
                unset($data['hakdowntime' . $x]);
            }
        }
        // Set hak departemen STOK OPNAME
        $hakstokopname = '';
        if (isset($data['stokopname'])) {
            foreach ($data['stokopname'] as $deptid) {
                $hakstokopname .= $deptid;
            }
            unset($data['stokopname']);
        }

        $data['master'] = $master;
        $data['transaksi'] = $transaksi;
        $data['hakprogram'] = $hakprogram;
        $data['manajemen'] = $manajemen;
        $data['setting'] = $setting;
        $data['hakdepartemen'] = $hakdepartemen;
        $data['hakstokopname'] = $hakstokopname;
        $data['rfid'] = $rfid;
        $data['hakdowntime'] = $hakdowntime;
        $data['cekpb'] = $cekpb;
        $datdept = $this->deptmodel->getdata();
        $cekmng = '';
        foreach ($datdept as $dept) {
            if (isset($data['cekmng'])) {
                if (isset($data['cekmng' . $dept['dept_id']])) {
                    $cekmng .= $dept['dept_id'];
                }
            }
            unset($data['cekmng' . $dept['dept_id']]);
        }
        $ceksgm = '';
        foreach ($datdept as $dept) {
            if (isset($data['ceksgm'])) {
                if (isset($data['ceksgm' . $dept['dept_id']])) {
                    $ceksgm .= $dept['dept_id'];
                }
            }
            unset($data['ceksgm' . $dept['dept_id']]);
        }
        unset($data['cekmng']);
        unset($data['ceksgm']);
        $data['bbl_cekmng'] = $cekmng;
        $data['bbl_ceksgm'] = $ceksgm;
        $hasil = $this->db->insert('user', $data);
        return $hasil;
    }
    public function updatedata()
    {
        $data = $_POST;
        $data['aktif'] = isset($data['aktif']) ? 1 : 0;
        $data['cekpo'] = isset($data['cekpo']) ? 1 : 0;
        $data['cekpc'] = isset($data['cekpc']) ? 1 : 0;
        $data['cekadj'] = isset($data['cekadj']) ? 1 : 0;
        $data['cekpp'] = isset($data['cekpp']) ? 1 : 0;
        $data['cekut'] = isset($data['cekut']) ? 1 : 0;
        $data['cekbatalstok'] = isset($data['cekbatalstok']) ? 1 : 0;
        $data['cekbbl'] = isset($data['cekbbl']) ? 1 : 0;
        $data['view_harga'] = isset($data['view_harga']) ? 1 : 0;
        $data['cekpakaibc'] = isset($data['cekpakaibc']) ? 1 : 0;
        $data['cekrd'] = isset($data['cekrd']) ? 1 : 0;
        $data['cekenv'] = isset($data['cekenv']) ? 1 : 0;
        $data['hakveri_env'] = isset($data['hakveri_env']) ? 1 : 0;
        $data['cek_so'] = isset($data['cek_so']) ? 1 : 0;
        $data['cek_saw'] = isset($data['cek_saw']) ? 1 : 0;
        $data['cekdowntime'] = isset($data['cekdowntime']) ? 1 : 0;
        $data['password'] = encrypto(trim($data['password']));
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

        // Set modul hakprogram
        $hakprogram = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['hakprogram' . $x])) {
                $hakprogram = substr_replace($hakprogram, '10', ($x * 2) - 2, 2);
                unset($data['hakprogram' . $x]);
                if ($x == 4) {
                    $data['hakeventrahasia'] = isset($data['hakeventrahasia']) ? 1 : 0;
                }
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

        // Set modul setting
        $setting = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['setting' . $x])) {
                $setting = substr_replace($setting, '10', ($x * 2) - 2, 2);
                unset($data['setting' . $x]);
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
        // Set hak departemen STOK OPNAME
        $hakstokopname = '';
        if (isset($data['stokopname'])) {
            foreach ($data['stokopname'] as $deptid) {
                $hakstokopname .= $deptid;
            }
            unset($data['stokopname']);
        }
        // Set hak tandatangan PB
        $cekpb = '';
        $datdept = $this->deptmodel->getdata_dept_pb();
        foreach ($datdept as $dept) {
            if (isset($data['X' . $dept['dept_id']])) {
                $cekpb .= $dept['dept_id'];
                unset($data['X' . $dept['dept_id']]);
            }
        }
        // Set hak RFID
        $rfid = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['rfid' . $x])) {
                $rfid = substr_replace($rfid, '10', ($x * 2) - 2, 2);
                unset($data['rfid' . $x]);
            }
        }

        // Set modul hakdowntime
        $hakdowntime = str_repeat('0', 100);
        for ($x = 1; $x <= 50; $x++) {
            if (isset($data['hakdowntime' . $x])) {
                $hakdowntime = substr_replace($hakdowntime, '10', ($x * 2) - 2, 2);
                unset($data['hakdowntime' . $x]);
            }
        }
        // if(str_contains($rfid,'10')){
        //     $rfid = '10'.$rfid;
        // }

        $data['master'] = $master;
        $data['hakprogram'] = $hakprogram;
        $data['transaksi'] = $transaksi;
        $data['other'] = $other;
        $data['manajemen'] = $manajemen;
        $data['setting'] = $setting;
        $data['rfid'] = $rfid;
        $data['hakdowntime'] = $hakdowntime;
        $data['hakdepartemen'] = $hakdepartemen;
        $data['hakstokopname'] = $hakstokopname;
        $data['cekpb'] = $cekpb;
        // $data['cekpc'] = $cekpc;
        $datdept = $this->deptmodel->getdata();
        $cekmng = '';
        foreach ($datdept as $dept) {
            if (isset($data['cekmng'])) {
                if (isset($data['cekmng' . $dept['dept_id']])) {
                    $cekmng .= $dept['dept_id'];
                }
            }
            unset($data['cekmng' . $dept['dept_id']]);
        }
        $ceksgm = '';
        foreach ($datdept as $dept) {
            if (isset($data['ceksgm'])) {
                if (isset($data['ceksgm' . $dept['dept_id']])) {
                    $ceksgm .= $dept['dept_id'];
                }
            }
            unset($data['ceksgm' . $dept['dept_id']]);
        }
        unset($data['cekmng']);
        unset($data['ceksgm']);
        $data['bbl_cekmng'] = $cekmng;
        $data['bbl_ceksgm'] = $ceksgm;

        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('user', $data);
        $this->helpermodel->isilog($this->db->last_query());
        if ($data['id'] == $this->session->userdata('id')) {
            $cek = $this->getdatabyid($data['id'])->row_array();
            $this->session->set_userdata('master', $cek['master']);
            $this->session->set_userdata('transaksi', $cek['transaksi']);
            $this->session->set_userdata('hakprogram', $cek['hakprogram']);
            $this->session->set_userdata('other', $cek['other']);
            $this->session->set_userdata('manajemen', $cek['manajemen']);
            $this->session->set_userdata('setting', $cek['setting']);
            $this->session->set_userdata('rfid', $cek['rfid']);
            $this->session->set_userdata('hakdowntime', $cek['hakdowntime']);
            $this->session->set_userdata('hakdepartemen', $cek['hakdepartemen']);
            $this->session->set_userdata('hakstokopname', $cek['hakstokopname']);
            $this->session->set_userdata('arrdep', arrdep($cek['hakdepartemen']));
            $this->session->set_userdata('hak_ttd_pb', arrdep($cek['cekpb']));
            $this->session->set_userdata('ttd', $cek['ttd']);
            $this->session->set_userdata('viewharga', $cek['view_harga']);
            $this->session->set_userdata('cek_so', $cek['cek_so']);
            $this->session->set_userdata('sess_cekbbl', $cek['cekbbl']);
            $this->session->set_userdata('sess_ceksaw', $cek['cek_saw']);
        }

        return $hasil;
    }
    public function getdatalevel()
    {
        $query = $this->db->get('level_user')->result_array();
        return $query;
    }
    public function refreshsess($id)
    {
        $cek = $this->getdatabyid($id)->row_array();
        $this->session->set_userdata('master', $cek['master']);
        $this->session->set_userdata('transaksi', $cek['transaksi']);
        $this->session->set_userdata('other', $cek['other']);
        $this->session->set_userdata('manajemen', $cek['manajemen']);
        $this->session->set_userdata('setting', $cek['setting']);
        $this->session->set_userdata('rfid', $cek['rfid']);
        $this->session->set_userdata('hakdepartemen', $cek['hakdepartemen']);
        $this->session->set_userdata('arrdep', arrdep($cek['hakdepartemen']));
        $this->session->set_userdata('hak_ttd_pb', arrdep($cek['cekpb']));
        $this->session->set_userdata('ttd', $cek['ttd']);
        $this->session->set_userdata('viewharga', $cek['view_harga']);
        $this->session->set_userdata('cekadj', $cek['cekadj']);
        $this->session->set_userdata('cekpo', $cek['cekpo']);
        $this->session->set_userdata('cek_so', $cek['cek_so']);
        $this->session->set_userdata('sess_cekbbl', $cek['cekbbl']);
        $this->session->set_userdata('sess_ceksaw', $cek['cek_saw']);
        return 1;
    }
    public function cekusername($data)
    {
        return $this->db->get_where('user', ['username' => $data])->num_rows();
    }
}
