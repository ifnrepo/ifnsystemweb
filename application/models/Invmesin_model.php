<?php
class Invmesin_model extends CI_Model
{
    public function getdata()
    {
        $tahun = $this->session->userdata('th');
        $bulan = $this->session->userdata('bl');
        if ($bulan == '') {
            $periode = $tahun;
            $loka = $this->session->userdata('lokasimesin') != '' ? ' AND lokasi = "' . trim($this->session->userdata('lokasimesin')) . '"' : '';
            $hasil = $this->db->query("SELECT *,sum(mesinsaw) as sawi,sum(mesinin) as ini,sum(mesinout) as outi,sum(mesinadj) as adji FROM (
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,1 AS mesinsaw,0 AS mesinout,0 as mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE YEAR(tglmasuk) < '" . $periode . "' AND (YEAR(tgl_disp) IS NULL OR YEAR(tgl_disp) >= '" . $periode . "')" . $loka . "
            UNION ALL 
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,0 AS mesinsaw,1 AS mesinout,0 as mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE YEAR(tgl_disp) = '" . $periode . "'" . $loka . "
            UNION ALL 
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,0 AS mesinsaw,0 AS mesinout,1 AS mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE YEAR(tglmasuk) = '" . $periode . "'" . $loka . "
            ) pt GROUP BY id_barang ORDER BY kode_fix");
        } else {
            $periode = $tahun . '-' . $bulan . '-01';
            $loka = $this->session->userdata('lokasimesin') != '' ? ' AND lokasi = "' . trim($this->session->userdata('lokasimesin')) . '"' : '';
            $hasil = $this->db->query("SELECT *,sum(mesinsaw) as sawi,sum(mesinin) as ini,sum(mesinout) as outi,sum(mesinadj) as adji FROM (
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,1 AS mesinsaw,0 AS mesinout,0 as mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE tglmasuk < '" . $periode . "' AND (tgl_disp IS NULL OR tgl_disp >= '" . $periode . "')" . $loka . "
            UNION ALL 
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,0 AS mesinsaw,1 AS mesinout,0 as mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE month(tgl_disp) = '" . $this->session->userdata('bl') . "' AND year(tgl_disp) = '" . $this->session->userdata('th') . "' " . $loka . "
            UNION ALL 
            SELECT tb_mesin.*,satuan.kodesatuan,barang.nama_barang,0 AS mesinsaw,0 AS mesinout,1 AS mesinin,0 AS mesinadj
            FROM tb_mesin 
            LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
            LEFT JOIN satuan ON satuan.id = barang.id_satuan
            WHERE month(tglmasuk) = '" . $this->session->userdata('bl') . "' AND year(tglmasuk) = '" . $this->session->userdata('th') . "' " . $loka . "
            ) pt GROUP BY id_barang ORDER BY kode_fix");
        }
        return $hasil;
    }
    public function getdatadetail($id)
    {
        $tahun = $this->session->userdata('th');
        $loka = $this->session->userdata('lokasimesin') != '' ? ' AND lokasi = "' . trim($this->session->userdata('lokasimesin')) . '"' : '';
        $hasil = $this->db->query("SELECT '" . $tahun . "-01-01' as tgl,'SALDO AWAL' as asal,tb_mesin.*,satuan.kodesatuan,barang.nama_barang,kategori.nama_kategori,1 AS mesinsaw,0 AS mesinout,0 as mesinin,0 AS mesinadj
        FROM tb_mesin 
        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
        LEFT JOIN satuan ON satuan.id = barang.id_satuan
        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
        WHERE YEAR(tglmasuk) < " . $tahun . " AND (YEAR(tgl_disp) IS NULL OR YEAR(tgl_disp) >= " . $tahun . ")" . $loka . " AND tb_mesin.id = " . $id . "
        UNION ALL 
        SELECT tgl_disp as tgl,'DISPOSAL' as asal,tb_mesin.*,satuan.kodesatuan,barang.nama_barang,kategori.nama_kategori,0 AS mesinsaw,1 AS mesinout,0 as mesinin,0 AS mesinadj
        FROM tb_mesin 
        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
        LEFT JOIN satuan ON satuan.id = barang.id_satuan
        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
        WHERE YEAR(tgl_disp) = " . $tahun . $loka . " AND tb_mesin.id = " . $id . "
        UNION ALL 
        SELECT tglmasuk as tgl,nomor_bc as asal,tb_mesin.*,satuan.kodesatuan,barang.nama_barang,kategori.nama_kategori,0 AS mesinsaw,0 AS mesinout,1 AS mesinin,0 AS mesinadj
        FROM tb_mesin 
        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
        LEFT JOIN satuan ON satuan.id = barang.id_satuan
        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
        WHERE YEAR(tglmasuk) = " . $tahun . $loka . " AND tb_mesin.id = " . $id);
        return $hasil;
    }
    public function getdatalokasi()
    {
        $this->db->select('lokasi');
        $this->db->from('tb_mesin');
        $query = $this->db->group_by('lokasi')->order_by('lokasi')->get();
        return $query;
    }
    public function getdatabyid($id)
    {
        $this->db->select('tb_mesin.*,barang.nama_barang,kategori.nama_kategori');
        $this->db->from('tb_mesin');
        $this->db->join('barang', 'barang.id = tb_mesin.id_barang', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->where('tb_mesin.id', $id);
        return $this->db->get();
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
    public function gethakdept_pb($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->where('dept.pb', '1');
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function getdata_dept_bbl($mode = 0)
    {
        if ($mode == 1) {
            $this->db->select('dept_id');
        } else {
            $this->db->select('*');
        }
        $this->db->from('dept');
        $this->db->where('bbl', '1');
        return $this->db->order_by('departemen', 'ASC')->get()->result_array();
    }
    public function getdata_dept_pb()
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('pb', '1');
        return $this->db->order_by('departemen', 'ASC')->get()->result_array();
    }
    public function getdata_dept_adj($dept = '')
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('adj', '1');
        if ($dept != '') {
            $this->db->where_in('dept_id', $dept);
        }
        return $this->db->order_by('departemen', 'ASC')->get()->result_array();
    }

    public function getdata_export($bl, $th, $lokasi)
    {
        $tahun = $this->session->userdata('th');
        $bulan = $this->session->userdata('bl');

        // Mengatur lokasi
        $loka = $this->session->userdata('lokasimesin') != '' ? ' AND lokasi = "' . trim($this->session->userdata('lokasimesin')) . '"' : '';

        if (empty($bulan)) {
            $periode = $tahun;
            // Query untuk semua lokasi
            $query = "SELECT *, SUM(mesinsaw) as sawi, SUM(mesinin) as ini, SUM(mesinout) as outi, SUM(mesinadj) as adji FROM (
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 1 AS mesinsaw, 0 AS mesinout, 0 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE YEAR(tglmasuk) < '$periode' AND (YEAR(tgl_disp) IS NULL OR YEAR(tgl_disp) >= '$periode') $loka
                        
                        UNION ALL 
                        
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 0 AS mesinsaw, 1 AS mesinout, 0 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE YEAR(tgl_disp) = '$periode' $loka
                        
                        UNION ALL 
                        
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 0 AS mesinsaw, 0 AS mesinout, 1 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE YEAR(tglmasuk) = '$periode' $loka
                    ) pt GROUP BY id_barang ORDER BY kode_fix";
        } else {
            $periode = "$tahun-$bulan-01";
            $query = "SELECT *, SUM(mesinsaw) as sawi, SUM(mesinin) as ini, SUM(mesinout) as outi, SUM(mesinadj) as adji FROM (
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 1 AS mesinsaw, 0 AS mesinout, 0 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE tglmasuk < '$periode' AND (tgl_disp IS NULL OR tgl_disp >= '$periode') $loka
                        
                        UNION ALL 
                        
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 0 AS mesinsaw, 1 AS mesinout, 0 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE MONTH(tgl_disp) = '{$this->session->userdata('bl')}' AND YEAR(tgl_disp) = '{$this->session->userdata('th')}' $loka
                        
                        UNION ALL 
                        
                        SELECT tb_mesin.*, satuan.kodesatuan, barang.nama_barang, 0 AS mesinsaw, 0 AS mesinout, 1 AS mesinin, 0 AS mesinadj
                        FROM tb_mesin 
                        LEFT JOIN barang ON tb_mesin.id_barang = barang.id 
                        LEFT JOIN satuan ON satuan.id = barang.id_satuan
                        WHERE MONTH(tglmasuk) = '{$this->session->userdata('bl')}' AND YEAR(tglmasuk) = '{$this->session->userdata('th')}' $loka
                    ) pt GROUP BY id_barang ORDER BY kode_fix";
        }

        // Eksekusi query
        $hasil = $this->db->query($query);
        return $hasil->result_array();
    }
}
