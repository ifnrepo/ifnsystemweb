<?php 
class inv_model extends CI_Model{
    public function getdata(){
        if($this->session->userdata('tglawal')!=null){
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal')); 
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $period = substr($tglx,5,2).substr($tglx,0,4);
                $hasil = $this->db->query("SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,stokdept.dis,
                                            stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'".$tglx."' AS tgl,barang.nama_barang,stokdept.pcs_awal AS pcs,stokdept.kgs_awal AS kgs,
                                            satuan.kodesatuan,1 as nome
                                            FROM stokdept
                                            LEFT JOIN barang ON barang.id = stokdept.id_barang
                                            LEFT JOIN satuan ON satuan.id = barang.id_satuan
                                            WHERE periode = '".$period."' AND dept_id = '".$dpt."'
                                            UNION ALL 
                                            SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis,
                                            tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,tb_detail.pcs,tb_detail.kgs,
                                            satuan.kodesatuan,3 as nome
                                            FROM tb_detail 
                                            LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header
                                            LEFT JOIN barang ON barang.id = tb_detail.id_barang
                                            LEFT JOIN satuan ON satuan.id = barang.id_satuan
                                            WHERE tb_header.tgl BETWEEN '".$tglawal."' AND '".$tglakhir."' AND (tb_header.dept_id='".$dpt."') AND tb_header.data_ok = 1
                                            UNION ALL 
                                            SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis,
                                            tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,tb_detail.pcs,tb_detail.kgs,
                                            satuan.kodesatuan,2 as nome
                                            FROM tb_detail 
                                            LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header
                                            LEFT JOIN barang ON barang.id = tb_detail.id_barang
                                            LEFT JOIN satuan ON satuan.id = barang.id_satuan
                                            WHERE tb_header.tgl BETWEEN '".$tglawal."' AND '".$tglakhir."' AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='".$dpt."' AND tb_header.data_ok = 1
                                            ORDER BY nama_barang,tgl,nome");
                return $hasil;
        }
    }
}