<?php
class bcwipmodel extends CI_Model
{
    public function getdata()
    {
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');
        $periode = cekperiodedaritgl($tglawal);
        $arrdept = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM'];

        // Query untuk CekSaldobarang
        $this->db->select("0 as kodeinv,stokdept.dept_id,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where_in('dept_id',$arrdept);
        $this->db->where('periode',$periode);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("1 as kodeinv,tb_header.dept_tuju,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where_in('tb_header.dept_tuju',$arrdept);
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("2 as kodeinv,tb_header.dept_id,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(pcs) as outpcs,sum(kgs) as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where_in('tb_header.dept_id',$arrdept);
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->group_by('po,item,dis,id_barang');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select dept_id,satuan.kodesatuan,barang.nama_barang,barang.kode,po,item,dis,id_barang,sum(saldopcs) as saldopcs,sum(saldokgs) as saldokgs,sum(inpcs) as inpcs,sum(inkgs) as inkgs,sum(outpcs) as outpcs,sum(outkgs) as outkgs from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " group by po,item,dis,id_barang";
        $kolom .= " order by dept_id,barang.nama_barang";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }

    public function getdatabyid($id)
    {
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');
        $periode = cekperiodedaritgl($tglawal);

        // Query untuk CekSaldobarang
        $this->db->select("'".$tglawal. "' as tgl,0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang,'SALDO' as nomor_dok");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where('dept_id','GM');
        $this->db->where('periode',$periode);
        $this->db->where('id_barang',$id);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("tb_header.tgl,1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_header.nomor_dok");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('pcs as inpcs,kgs as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_tuju','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->where('tb_detail.id_barang',$id);
        // $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("tb_header.tgl,2 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_header.nomor_dok");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('pcs as outpcs,kgs as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->where('tb_detail.id_barang',$id);
        // $this->db->group_by('po,item,dis,id_barang');
        $this->db->order_by('tgl');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select * from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " order by tgl,kodeinv";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }

    public function getdatakategori()
    {
        if ($this->session->userdata('tglawal') == null) {
            $tglawal = date('Y-m-01');
            $tglakhir = lastday($this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-01');
            $periode = cekperiodedaritgl(tglmysql($tglawal));
        }else{
            $tglawal = $this->session->userdata('tglawal');
            $tglakhir = $this->session->userdata('tglakhir');
            $periode = cekperiodedaritgl($tglawal);
        }

        // Query untuk CekSaldobarang
        $this->db->select("0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where('dept_id','GM');
        $this->db->where('periode',$periode);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_tuju','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("2 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(pcs) as outpcs,sum(kgs) as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->group_by('po,item,dis,id_barang');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select *,id_barang,barang.id_kategori,kategori.nama_kategori from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " left join kategori on kategori.kategori_id = barang.id_kategori ";
        $kolom .= " group by kategori.nama_kategori";
        $kolom .= " order by barang.nama_barang";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }


    public function getdetailbyid($id)
    {
        $header = $this->db->get_where('tb_header', ['id' => $id])->row_array();

        $this->db->select('tb_detail.*,satuan.kodesatuan,barang.nama_barang,barang.kode,tb_po.spek,tb_klppo.engklp');
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_po', 'tb_po.po = tb_detail.po AND tb_po.item = tb_detail.item AND tb_po.dis = tb_detail.dis', 'left');
        $this->db->join('tb_klppo', 'tb_klppo.id = tb_po.klppo', 'left');

        if ($header && $header['jns_bc'] == '261') {
            $this->db->where('tb_detail.id_akb', $id);
        } else {
            $this->db->where('tb_detail.id_header', $id);
        }

        return $this->db->get();
    }


    public function getdata_export()
    {
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');
        $jnsbc = $this->session->userdata('jnsbc');

        $this->db->select('tb_detail.*, tb_header.*, barang.nama_barang, barang.nama_alias, barang.kode, satuan.kodesatuan, supplier.nama_supplier, customer.nama_customer, ref_mt_uang.mt_uang as xmtuang, dept.departemen');
        if ($jnsbc == '261') {
            $this->db->join('tb_detail', 'tb_detail.id_akb = tb_header.id', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        } elseif ($jnsbc == 'Y') {
            $this->db->join('tb_detail', '(tb_detail.id_header = tb_header.id OR tb_detail.id_akb = tb_header.id)', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        } else {
            $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        }
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id = tb_header.mtuang', 'left');
        $this->db->where("tb_header.tgl_bc between '" . tglmysql($tglawal) . "' AND '" . tglmysql($tglakhir) . "' ");
        $this->db->where('trim(tb_header.nomor_bc) !=', '');



        if ($this->session->userdata('jnsbc') != 'Y') {
            $this->db->where("tb_header.jns_bc", $jnsbc);
        } else {
            $this->db->where_in("tb_header.jns_bc", [25, 30, 261, 41]);
        }

        $this->db->where('tb_header.data_ok', 1);
        $this->db->where('tb_header.ok_tuju', 1);
        // $this->db->where('tb_header.ok_valid', 1);

        return $this->db->get('tb_header');
    }
}
