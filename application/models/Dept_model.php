<?php
class Dept_model extends CI_Model
{
    public function getdata()
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');

        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function jmldept()
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');

        return $this->db->get()->num_rows();
    }
    public function getdatakatedept()
    {
        return $this->db->get('kategori_departemen')->result_array();
    }
    public function getdatabyid($dept_id)
    {
        return $this->db->get_where('dept', ['dept_id' => $dept_id])->row_array();
    }
    public function gethakdept($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function gethakdept_bbl($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where('bbl', '1');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function gethakdeptout($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->where('dept.katedept_id !=', 4);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }

    public function simpandept($data)
    {
        return $this->db->insert('dept', $data);
    }
    // public function updatedept($data)
    // {
    //     $this->db->where('dept_id', $data['dept_id']);
    //     return $this->db->update('dept', $data);
    // }

    public function updatedata()
    {
        $data = $_POST;
        $data['pb'] = isset($data['pb']) ? '1' : '0';
        $data['bbl'] = isset($data['bbl']) ? '1' : '0';
        $data['adj'] = isset($data['adj']) ? '1' : '0';

        $pengeluaran = '';
        $penerimaan = '';

        $datdept = $this->dept_model->getdata();

        foreach ($datdept as $dept) {
            if (isset($data['pengeluaran' . $dept['dept_id']])) {
                $pengeluaran .= $dept['dept_id'];
                unset($data['pengeluaran' . $dept['dept_id']]);
            }
            if (isset($data['penerimaan' . $dept['dept_id']])) {
                $penerimaan .= $dept['dept_id'];
                unset($data['penerimaan' . $dept['dept_id']]);
            }
            if (isset($data['permintaan' . $dept['dept_id']])) {
                $permintaan .= $dept['dept_id'];
                unset($data['permintaan' . $dept['dept_id']]);
            }
        }

        $data['pengeluaran'] = $pengeluaran;
        $data['penerimaan'] = $penerimaan;
        // $data['permintaan'] = $permintaan;

        $this->db->where('dept_id', $data['dept_id']);
        $hasil = $this->db->update('dept', $data);

        if ($data['dept_id'] == $this->session->userdata('dept_id')) {
            $cek = $this->getdatabyid($data['dept_id'])->row_array();
            $this->session->set_userdata('pengeluaran', $cek['pengeluaran']);
            $this->session->set_userdata('penerimaan', $cek['penerimaan']);
            $this->session->set_userdata('permintaan', $cek['permintaan']);
        }

        return $hasil;
    }


    public function hapusdept($dept_id)
    {
        $this->db->where('dept_id', $dept_id);
        return $this->db->delete('dept');
    }

    public function getdata_dept_bbl($mode=0)
    {
        if($mode==1){
            $this->db->select('dept_id');
        }else{
            $this->db->select('*');
        }
        $this->db->from('dept');
        $this->db->where('bbl', '1');
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function getdata_dept_pb()
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('pb', '1');
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function getdata_dept_adj($dept='')
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('adj', '1');
        if($dept != ''){
            $this->db->where_in('dept_id',$dept);
        }
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
}
