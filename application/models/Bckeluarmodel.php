<?php
class bckeluarmodel extends CI_Model
{
    public function getdata()
    {
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');
        $jnsbc = $this->session->userdata('jnsbc');

        $this->db->select('tb_header.*,customer.*,sum(tb_detail.pcs) as pcs,sum(tb_detail.kgs) as kgs,tb_header.id as idx,ref_kemas.kemasan,tb_header.mtuang as mt_uang');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
        $this->db->join('ref_kemas', 'ref_kemas.kdkem = tb_header.kd_kemasan', 'left');
        $this->db->where("tgl_bc between '" . tglmysql($tglawal) . "' AND '" . tglmysql($tglakhir) . "' ");
        $this->db->where('trim(nomor_bc) !=', '');
        if ($jnsbc != 'Y') {
            $this->db->where("jns_bc", $jnsbc);
        } else {
            $this->db->where_in("jns_bc", [25, 30, 261, 41]);
        }
        if ($this->session->userdata('nopen')) {
            $this->db->where("nomor_bc", $this->session->userdata('nopen'));
        }
        $this->db->where('data_ok', 1);
        $this->db->where('ok_tuju', 1);
        $this->db->where('ok_valid', 1);
        $this->db->group_by('nomor_bc');
        return $this->db->get('tb_header');
    }
    public function getdatabyid($id)
    {
        $this->db->select('tb_header.*,customer.*,sum(tb_detail.pcs) as pcs,sum(tb_detail.kgs) as kgs,tb_header.id as idx,ref_jns_angkutan.angkutan as xangkutan,ref_mt_uang.mt_uang as xmt_uang,ref_kemas.kemasan');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
        $this->db->join('ref_jns_angkutan', 'ref_jns_angkutan.id = tb_header.jns_angkutan', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id = tb_header.mtuang', 'left');
        $this->db->join('ref_kemas', 'ref_kemas.kdkem = tb_header.kd_kemasan', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header');
    }
    public function getdetailbyid($id)
    {
        $this->db->select('tb_detail.*,satuan.kodesatuan,barang.nama_barang,barang.kode,tb_po.spek,tb_klppo.engklp');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_po', 'tb_po.po = tb_detail.po and tb_po.item = tb_detail.item and tb_po.dis = tb_detail.dis', 'left');
        $this->db->join('tb_klppo', 'tb_klppo.id = tb_po.klppo', 'left');
        $this->db->where('tb_detail.id_header', $id);
        return $this->db->get('tb_detail');
    }


    public function getdata_export()
    {
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');

        $this->db->select('tb_detail.*, tb_header.*, barang.nama_barang, barang.nama_alias, barang.kode, satuan.kodesatuan, supplier.nama_supplier, ref_mt_uang.mt_uang as xmtuang');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id = tb_header.mtuang', 'left');
        $this->db->where("tb_header.tgl_bc between '" . tglmysql($tglawal) . "' AND '" . tglmysql($tglakhir) . "' ");
        $this->db->where('trim(tb_header.nomor_bc) !=', '');

        if ($this->session->userdata('jnsbc') != 'Y') {
            $this->db->where("tb_header.jns_bc", $this->session->userdata('jnsbc'));
        } else {
            $this->db->where_in("tb_header.jns_bc", [25, 30, 261, 41]);
        }

        $this->db->where('tb_header.data_ok', 1);
        $this->db->where('tb_header.ok_tuju', 1);
        $this->db->where('tb_header.ok_valid', 1);

        return $this->db->get('tb_detail');
    }
}
