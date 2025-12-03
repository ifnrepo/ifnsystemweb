<?php
class Helper_model extends CI_Model
{
    public function cekkolom($id, $kolom, $nilai, $tabel)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
        $hasil = $this->db->get($tabel);
        return $hasil;
    }
    public function getterms($kode)
    {
        $this->db->where('lokal', $kode);
        $hasil = $this->db->get('term_payment');
        return $hasil;
    }
    public function getdatasublok()
    {
        $dp = $this->session->userdata('deptsekarang');
        switch ($dp) {
            case 'FG':
                $this->db->where('kode', 1);
                break;
            default:
                # code...
                break;
        }
        $hasil = $this->db->get('tb_sublok');
        return $hasil;
    }
    public function riwayatdok($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $kata = 'Dokumen DIBUAT oleh ' . datauser($cek['user_ok'], 'name') . ' on ' . tglmysql2($cek['tgl_ok']);
            array_push($hasil, $kata);
        }
        if ($cek['ok_valid'] == 1) {
            $kata = 'Dokumen DISETUJUI oleh ' . datauser($cek['user_valid'], 'name') . ' on ' . tglmysql2($cek['tgl_valid']);
            array_push($hasil, $kata);
        }
        // Cek detail barang 
        $this->db->where('id_header', $id);
        $detail = $this->db->get('tb_detail');
        $hasil2 = [];
        foreach ($detail->result_array() as $det) {
            $barang = $this->db->get_where('barang', ['id' => $det['id_barang']])->row_array();
            if (trim($det['po']) == "") {
                $kata = $barang['nama_barang'];
            } else {
                $kata = spekpo($det['po'], $det['item'], $det['dis']);
            }
            array_push($hasil2, $kata);
            $hasil3 = [];
            $kepalanya = 0;
            for ($ke = 0; $ke <= 3; $ke++) {
                // 0 : cek data BBL
                // 1 : cek data PO
                // 2 : cek data IB
                // 3 : cek data OUT
                switch ($ke) {
                    case 0:
                        $fid = 'id_bbl';
                        $fod = 'id_po';
                        $fed = 'BBL No. ';
                        break;
                    case 1:
                        $fid = 'id_po';
                        $fod = 'id_ib';
                        $fed = 'PO No. ';
                        break;
                    case 2:
                        $fid = 'id_ib';
                        $fod = 'id_out';
                        $fed = 'IB No. ';
                        break;
                    case 3:
                        $fid = 'id_out';
                        $fod = 'id';
                        $fed = 'OUT No. ';
                        break;
                }
                if ($kepalanya == 1) {
                    $cekisi = $this->db->get_where('tb_detail', ['id' => $idisinya]);
                    if ($cekisi->num_rows() > 0) {
                        $rekisi = $cekisi->row_array();
                        $det[$fid] = $rekisi['id'];
                    } else {
                        $det[$fid] = 0;
                    }
                }
                $selesai = $ke == 3 ? ' (SELESAI)' : '';
                if ($det[$fid] != 0) {
                    $isifield = $det[$fid];
                    $this->db->select('tb_header.*,tb_detail.id_bbl,tb_detail.id_po,tb_detail.id_ib,tb_detail.id_out,tb_detail.id_minta');
                    $this->db->from('tb_header');
                    $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
                    $this->db->where('tb_detail.id', $isifield);
                    $isinya = $this->db->get()->row_array();
                    $kepalanya = 1;
                    $idisinya = $isinya[$fod];
                    array_push($hasil3, $fed . $isinya['nomor_dok'] . ' ; ' . tglmysql($isinya['tgl']) . $selesai);
                } else {
                    $kepalanya = 0;
                    // array_push($hasil3,$fed.'-');
                }
            }
            array_push($hasil2, $hasil3);
        }
        array_push($hasil, $hasil2);
        return $hasil;
    }
    public function riwayatbbl($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['ok_bb'] == 1) {
            $data_ok = 'Dokumen diinput Oleh : ' . datauser($cek['user_bb'], 'name') . ' on ' . $cek['tgl_bb'];
            array_push($hasil, $data_ok);
        } else {
            $data_ok = 'Dokumen belum selesai di input !';
            array_push($hasil, $data_ok);
        }
        if ($cek['data_ok'] == 1) {
            $ok_bb = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok_bb);
        } else {
            if ($cek['ok_bb'] == 1) {
                $ok_bb = 'Menunggu Approve kepala departemen ' . $cek['dept_id'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_pp'] == 1 && !is_null($cek['user_pp'])) {
            $ok_bb = 'Dokumen diapprove oleh : ' . datauser($cek['user_pp'], 'name') . ' on ' . $cek['tgl_pp'];
            array_push($hasil, $ok_bb);
        } else {
            if ($cek['ok_bb'] == 1 && $cek['ok_pp'] == 0) {
                $ok_bb = 'Menunggu Approve Manager PP ';
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $ok_valid = 'Dokumen divalidasi oleh : ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $ok_valid);
        } else {
            if ($cek['data_ok'] == 1 && $cek['ok_pp'] == 1) {
                $ok_bb = 'Menunggu Validasi Manager ' . $cek['dept_bbl'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_tuju'] == 1) {
            $ok_valid = 'Dokumen disetujui oleh : ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $ok_valid);
        } else {
            if ($cek['ok_valid'] == 1) {
                $ok_bb = 'Menunggu Validasi GM ' . $cek['dept_id'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_pc'] == 1) {
            $ok_valid = 'Dokumen Disetujui oleh : ' . datauser($cek['user_pc'], 'name') . ' on ' . $cek['tgl_pc'];
            array_push($hasil, $ok_valid);

            $this->db->select('tb_detail.*,barang.nama_barang');
            $this->db->from('tb_detail');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where('tb_detail.id_header', $id);
            $cek = $this->db->get();
            if ($cek->num_rows() > 0) {
                $hasil2 = [];
                foreach ($cek->result_array() as $det) {
                    array_push($hasil2, $det['nama_barang']);
                    $hasil3 = [];
                    $kepalanya = 0;
                    for ($ke = 0; $ke <= 3; $ke++) {
                        // 0 : cek data BBL
                        // 1 : cek data PO
                        // 2 : cek data IB
                        // 3 : cek data OUT
                        switch ($ke) {
                            case 0:
                                $fid = 'id_bbl';
                                $fod = 'id_po';
                                $fed = 'BBL No. ';
                                break;
                            case 1:
                                $fid = 'id_po';
                                $fod = 'id_ib';
                                $fed = 'PO No. ';
                                break;
                            case 2:
                                $fid = 'id_ib';
                                $fod = 'id_out';
                                $fed = 'IB No. ';
                                break;
                            case 3:
                                $fid = 'id_out';
                                $fod = 'id';
                                $fed = 'OUT No. ';
                                break;
                        }
                        if ($kepalanya == 1) {
                            $cekisi = $this->db->get_where('tb_detail', ['id' => $idisinya]);
                            if ($cekisi->num_rows() > 0) {
                                $rekisi = $cekisi->row_array();
                                $det[$fid] = $rekisi['id'];
                            } else {
                                $det[$fid] = 0;
                            }
                        }
                        $selesai = $ke == 3 ? ' (SELESAI)' : '';
                        if ($det[$fid] != 0) {
                            $isifield = $det[$fid];
                            $this->db->select('tb_header.*,tb_detail.id_bbl,tb_detail.id_po,tb_detail.id_ib,tb_detail.id_out,tb_detail.id_minta');
                            $this->db->from('tb_header');
                            $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
                            $this->db->where('tb_detail.id', $isifield);
                            $isinya = $this->db->get()->row_array();
                            $kepalanya = 1;
                            $idisinya = $isinya[$fod];
                            array_push($hasil3, $fed . $isinya['nomor_dok'] . ' ; ' . tglmysql($isinya['tgl']) . $selesai);
                        } else {
                            $kepalanya = 0;
                            // array_push($hasil3,$fed.'-');
                        }
                    }
                    array_push($hasil2, $hasil3);
                }
                array_push($hasil, $hasil2);
            }
        } else {
            if ($cek['ok_tuju'] == 1) {
                $ok_bb = 'Menunggu Validasi GM Purchasing';
                array_push($hasil, $ok_bb);
            }
        }
        return $hasil;
    }
    public function riwayatpo($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok);
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah disetujui ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu persetujuan';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function riwayatbcmasuk($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok);
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
        if ($cek['ok_tuju'] == 1) {
            $valid = 'Dokumen sudah diverifikasi ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu verifikasi BC';
                array_push($hasil, $valid);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah divalidasi ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu Validasi';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function riwayatbckeluar($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok);
            // array_push($hasil, '1' => $ok);
            // $hasil['dibuat'] = $cek['tgl'];
            // $hasil['tgldibuat'] = $ok;
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
        if ($cek['ok_tuju'] == 1) {
            $valid = 'Dokumen sudah diverifikasi ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu verifikasi BC';
                array_push($hasil, $valid);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah divalidasi ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu Validasi';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function dataproduksi()
    {
        $bulan = 'janfebmaraprmeijunjulagtsepoktnopdes';
        $fieldd = substr($bulan, ((int)date('m') * 3) - 3, 3);
        $fielde = substr($bulan, (((int)date('m') - 1) * 3) - 3, 3);
        $array1 = [];
        $array2 = [];
        $this->db->select("SUM(jan) AS jan,SUM(feb) AS feb,SUM(mar) AS mar,SUM(apr) AS apr,SUM(mei) AS mei,SUM(jun) AS jun,SUM(jul) AS jul,SUM(agt) AS agt,SUM(sep) AS sep,SUM(okt) AS okt,SUM(nop) AS nop,SUM(des) AS des");
        $this->db->where('tahun', date('Y'));
        $cek = $this->db->get('monitoringprd')->row_array();
        for ($x = 0; $x < 12; $x++) {
            $field = substr($bulan, (($x + 1) * 3) - 3, 3);
            $cik = $x + 1;
            $cok = $field;
            array_push($array1, strtoupper($field) . ' - ' . date('Y'));
            array_push($array2, $cek[$field]);
        }
        // foreach ($cek as $kec) {
        //     array_push($array1,$kec['tgl']);
        //     array_push($array2,$kec[$field]);
        // }
        return array('data_tgl' => $array1, 'data_isi' => $array2, 'data_prod_bulan_ini' => $cek[$fieldd], 'data_prod_bulan_lalu' => $cek[$fielde]);
    }

    public function isilog($isilog)
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $dapatkan_ip = get_client_ip();

        if ($this->isLocalIP($dapatkan_ip)) {
            $ip = 'Local IP';
        } else {
            $ip = 'Public IP';
        }

        $data = [
            'activitylog' => str_replace('`', '', $isilog),
            'userlog' => datauser($this->session->userdata('id'), 'name'),
            'iduserlog' => $this->session->userdata('id'),
            'devicelog' => $dapatkan_ip . ' (' . $ip . ') on ' . $useragent,
            'modul' => strtoupper($this->uri->segment(1))
        ];

        $this->db->insert('tb_logactivity', $data);
    }


    private function isLocalIP($ip)
    {
        return preg_match('/^10\..*/', $ip) ||
            preg_match('/^192\.168\..*/', $ip) ||
            preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\..*/', $ip);
    }

    public function cekclosebook($periode)
    {
        $this->db->where('periode', $periode);
        $hasil = $this->db->get('tb_lockinv')->num_rows();
        return $hasil;
    }
    public function cekdetout($header)
    {
        $this->db->where('id_out', 0);
        $this->db->where('id_header', $header);
        $hasil = $this->db->get('tb_detail')->num_rows();
        return $hasil;
    }
    public function getbctoken()
    {
        $this->db->where('id', 1);
        $hasil =  $this->db->get('token_bc')->row_array();
        return $hasil['token'];
    }
    public function getdatadepartemen($kode)
    {
        return $this->db->get_where('dept', ['dept_id' => $kode]);
    }
    public function getdatasupplier($kode)
    {
        return $this->db->get_where('supplier', ['id' => $kode]);
    }
    public function getdatacustomer($kode)
    {
        return $this->db->get_where('customer', ['id' => $kode]);
    }
    public function getdatafooter()
    {
        return $this->db->get('page_footer');
    }
    public function cekstokdeptraw($dept, $nobontr, $idbarang, $kgs, $pcs, $jns = 0)
    {
        $allowdept = ['SP', 'GM']; //Departemen Sementara yang diperbolehkan
        if (in_array($dept, $allowdept)) {
            $kondisi = [
                'dept_id' => $dept,
                'nobontr' => $nobontr,
                'id_barang' => $idbarang,
            ];
            $this->db->where($kondisi);
            $adaisi = $this->db->get('stokdeptraw');
            if ($adaisi->num_rows() == 0) {
                if ($jns == 0) {
                    $kondisiinput = [
                        'dept_id' => $dept,
                        'nobontr' => $nobontr,
                        'id_barang' => $idbarang,
                        'kgs' => $kgs,
                        'pcs' => $pcs
                    ];
                    $this->db->insert('stokdeptraw', $kondisiinput);
                }
            } else {
                if ($jns == 0) {
                    $this->db->set('pcs', 'pcs +' . $pcs, false);
                    $this->db->set('kgs', 'kgs +' . $kgs, false);
                } else {
                    $this->db->set('pcs', 'pcs -' . $pcs, false);
                    $this->db->set('kgs', 'kgs -' . $kgs, false);
                }
                $this->db->where('dept_id', $dept);
                $this->db->where('nobontr', $nobontr);
                $this->db->where('id_barang', $idbarang);
                $this->db->update('stokdeptraw');
            }
        }
    }
    public function spekpo($po, $item, $dis)
    {
        $nilai = '';
        $data = [
            'po' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis
        ];
        $hasil  = $this->db->get_where('tb_po', $data);
        if ($hasil->num_rows() == 0) {
            $nilai = '';
        } else {
            $hasilnya = $hasil->row_array();
            $nilai = $hasilnya['spek'];
        }
        return htmlspecialchars($nilai);
    }
    public function spekdom($po, $item, $dis)
    {
        $nilai = '';
        $data = [
            'po' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis
        ];
        $hasil  = $this->db->get_where('tb_po', $data);
        if ($hasil->num_rows() == 0) {
            $nilai = '';
        } else {
            $hasilnya = $hasil->row_array();
            $nilai = trim($hasilnya['labdom']) .' '. trim($hasilnya['color']) .' '. trim($hasilnya['ways']);
        }
        return htmlspecialchars_decode(htmlspecialchars($nilai));
    }
    public function getpros($kode)
    {
        if (trim($kode) == '') {
            $hasil = '';
        } else {
            $arrhasil = '';
            $pisah = explode(',', $kode);
            $jumlaharr = count($pisah);
            for ($x = 1; $x <= $jumlaharr; $x++) {
                $query = $this->db->get_where('tb_proses', ['kode' => $pisah[$x - 1]]);
                if ($query->num_rows() > 0) {
                    $xhasil = $query->row_array();
                    $spasi = $x > 1 ? ' ' : '';
                    $arrhasil .= $spasi . trim($xhasil['ket']);
                }
            }
            $hasil = ucwords(strtolower($arrhasil));
        }
        return $hasil;
    }
    public function getkontrakrekanan()
    {
        // $data = $this->db->get_where('apps_config', ['key' => 'tuju_kontrak'])->row_array();
        // $arrrekan = [];
        // $kali = strlen(trim($data['value'])) / 2;
        // for ($ke = 0; $ke < $kali; $ke++) {
        //     $hasil_dept = substr($data['value'], (($ke + 1) * 2) - 2, 2);
        //     $dept = $this->db->get_where('dept', ['dept_id' => $hasil_dept])->row_array();
        //     $arr = [
        //         'dept_id' => $dept['dept_id'],
        //         'departemen' => $dept['departemen'],
        //     ];
        //     array_push($arrrekan, $arr);
        // }
        $arrrekan = $this->db->get_where('dept',['katedept_id' => 3])->result_array();
        return $arrrekan;
    }
    public function getkettujuanout($kode)
    {
        $data = $this->db->get_where('ref_transaksi_tujuan', ['tujuan' => $kode]);
        return $data;
    }
    public function getquerytujuanout($kode, $val, $ke)
    {
        $data = $this->db->get_where('ref_transaksi_tujuan', ['tujuan' => $kode, 'value' => $val]);
        if ($data->num_rows() > 0) {
            $xdata = $data->row_array();
            if ($ke == 0) {
                $hasil = $xdata['kueri'];
            } else {
                $hasil = $xdata['isi'];
            }
        } else {
            $hasil = '';
        }
        return $hasil;
    }
    public function nomorkontrak()
    {
        $tahun = date('y');
        $this->db->select('MAX(LEFT(nomor,3)) AS maks');
        $this->db->from('tb_kontrak');
        $this->db->where('RIGHT(TRIM(nomor),2)', $tahun);
        $this->db->where('LEFT(nomor,3) != ', '000');
        $this->db->where('jns_bc', $this->session->userdata('jnsbckontrak'));
        return $this->db->get()->row_array();
    }
    public function stoksaatini($idbar, $dept)
    {
        $data = [
            'dept_id' => $dept,
            'periode' => date('m') . date('Y'),
            'trim(po)' => '',
            'trim(item)' => '',
            'dis' => 0,
            'id_barang' => $idbar
        ];
        $this->db->select('stokdept.*,barang.id_satuan');
        $this->db->from('stokdept');
        $this->db->where($data);
        $this->db->join('barang', 'barang.id = ' . $idbar, 'left');
        return $this->db->get();
    }
    public function getstokdept($data){
        $kondisi = [
            'dept_id' => $data['dept_id'],
            'trim(po)' => trim($data['po']),
            'trim(item)' => trim($data['item']),
            'dis' => $data['dis'],
            'trim(insno)' => trim($data['insno']),
            'trim(nobontr)' => trim($data['nobontr']),
            'trim(nomor_bc)' => trim($data['nomor_bc']),
            'stokdept.dln' => $data['dln'],
            'id_barang' => $data['id_barang'],
            'trim(nobale)' => trim($data['nobale']),
            'exnet' => 0,
            'periode' => $data['periode']
        ];
        $this->db->select('stokdept.*,barang.id_satuan,sum(kgs_akhir) as kgsstok,sum(pcs_akhir) as pcsstok');
        $this->db->from('stokdept');
        $this->db->where($kondisi);
        $this->db->join('barang', 'barang.id = stokdept.id_barang','left');
        return $this->db->get();
    }
    public function deptsubkon()
    {
        $arr = [];
        $this->db->select('dept.dept_id');
        $this->db->from('dept');
        $this->db->where('katedept_id', 3);
        $this->db->order_by('dept_id');
        $cek = $this->db->get();
        foreach ($cek->result_array() as $value) {
            array_push($arr, $value['dept_id']);
        }
        return $arr;
    }
    public function showbom($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs)
    {
        $data = [];
        $key = $idbarang . $nobontr;
        if ($idbarang > 0 && trim($po) == '' && trim($insno) == '') {
            $this->db->select('*');
            $this->db->from('barang');
            $this->db->join('bom_barang', 'bom_barang.id_barang = barang.id', 'left');
            $this->db->where('barang.id', $idbarang);
            $databom = $this->db->get();
            foreach ($databom->result_array() as $datbom) {
                if ($datbom['persen'] == null) {
                    $isi = [
                        'po' => $po,
                        'item' => $item,
                        'dis' => $dis,
                        'id_barang' => $idbarang,
                        'insno' => $insno,
                        'nobontr' => $nobontr,
                        'kgs' => $kgs,
                        'kgs_asli' => $kgs,
                        'pcs_asli' => $pcs,
                        'xinsno' => '',
                        'xinsnox' => '',
                        'cuy' => '',
                        'noe' => $noe,
                        'kunci' => $idbarang . trim($nobontr)
                    ];
                    array_push($data, $isi);
                } else {
                    $isi = [
                        'po' => $po,
                        'item' => $item,
                        'dis' => $dis,
                        'id_barang' => $datbom['id_barang_bom'],
                        'insno' => $insno,
                        'nobontr' => $nobontr,
                        'kgs' => $kgs * ($datbom['persen'] / 100),
                        'kgs_asli' => $kgs * ($datbom['persen'] / 100),
                        'pcs_asli' => $pcs,
                        'xinsno' => '',
                        'xinsnox' => '',
                        'cuy' => '',
                        'noe' => $noe,
                        'kunci' => $datbom['id_barang_bom'] . trim($nobontr)
                    ];
                    array_push($data, $isi);
                }
            }
        } else {
            if (str_contains($insno, '/SP')) {
                $datasp = $this->showbomsp($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs);
                foreach ($datasp as $simpansp) {
                    array_push($data, $simpansp);
                }
            } else {
                if (str_contains($insno, '/RR')) {
                    $datarr = $this->showbomrr($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $kgs);
                    foreach ($datarr as $simpanrr) {
                        if (getarrayindex($simpanrr['id_barang'] . trim($simpanrr['nobontr']), $data, 'kunci') != '') {
                            $index = getarrayindex($simpanrr['id_barang'] . trim($simpanrr['nobontr']), $data, 'kunci');
                            $data[$index]['kgs_asli'] = $data[$index]['kgs_asli'] + $simpanrr['kgs_asli'];
                        } else {
                            array_push($data, $simpanrr);
                        }
                    }
                } else {
                    $kondisinet = [
                        'trim(po)' => trim($po),
                        'trim(item)' => trim($item),
                        'dis' => $dis,
                        'trim(insno)' => trim($insno),
                        'trim(nobontr)' => trim($nobontr),
                        'dept_id' => 'NT'
                    ];
                    $this->db->select('tb_detail.*,tb_header.dept_id');
                    $this->db->from('tb_detail');
                    $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
                    $this->db->where($kondisinet);
                    $this->db->limit(1);
                    $datanet = $this->db->get();
                    foreach ($datanet->result_array() as $datnet) {
                        $this->db->select("po,item,dis,id_barang,insno,nobontr,sum(kgs) as kgs");
                        $this->db->from('tb_detailgen');
                        $this->db->where('id_header', $datnet['id_header']);
                        $this->db->where('seri_barang', $datnet['seri_barang']);
                        $this->db->group_by('po,item,dis,id_barang,insno,nobontr');
                        $dataraw = $this->db->get();

                        foreach ($dataraw->result_array() as $datraw) {
                            if (trim($datraw['insno']) == "" && trim($datraw['nobontr']) == "") {
                                $isi = [
                                    'po' => $po,
                                    'item' => $item,
                                    'dis' => $dis,
                                    'id_barang' => $idbarang,
                                    'insno' => $insno,
                                    'nobontr' => $nobontr,
                                    'kgs' => $kgs,
                                    'kgs_asli' => $kgs,
                                    'pcs_asli' => 0,
                                    'xinsno' => $po,
                                    'xinsnox' => '',
                                    'cuy' => formatsku($po, $item, $dis, $idbarang) . 'Ins.' . $insno . ' (BOM TIDAK DITEMUKAN)',
                                    'noe' => $noe,
                                    'kunci' => $idbarang . trim($nobontr)
                                ];
                                if (getarrayindex($idbarang . trim($nobontr), $data, 'kunci')) {
                                    $index = getarrayindex($idbarang . trim($nobontr), $data, 'kunci');
                                    $data[$index]['kgs_asli'] = $data[$index]['kgs_asli'] + $kgs;
                                } else {
                                    array_push($data, $isi);
                                }
                                // continue;
                            } else {
                                $persen = $datraw['kgs'] / $datnet['kgs'];
                                $kgsbagi = round($kgs * $persen, 2);
                                // $kgsbagi = $datraw['kgs']*$persen;
                                if (str_contains($datraw['insno'], '/SP')) {
                                    // Jika Insno Instruksi SPINNING
                                    $this->db->select("id_header,po,item,dis,id_barang,insno,nobontr,kgs");
                                    $this->db->from('tb_detail');
                                    $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
                                    $this->db->where('tb_header.dept_id', 'SP');
                                    $this->db->where('trim(tb_header.keterangan)', 'Produksi ' . trim($datraw['insno']));
                                    $dataspin = $this->db->get();

                                    foreach ($dataspin->result_array() as $spin) {
                                        $this->db->select("po,item,dis,id_barang,insno,nobontr,kgs,persen");
                                        $this->db->from('tb_detailgen');
                                        $this->db->where('id_header', $spin['id_header']);
                                        $dataxspin = $this->db->get();
                                        foreach ($dataxspin->result_array() as $xdataxspin) {
                                            // $xdataxspin['kgs_asli'] = $datraw['kgs'] * ($xdataxspin['persen']/100);
                                            if (getarrayindex($xdataxspin['id_barang'] . trim($xdataxspin['nobontr']), $data, 'kunci') != '') {
                                                $index = getarrayindex($xdataxspin['id_barang'] . trim($xdataxspin['nobontr']), $data, 'kunci');
                                                $data[$index]['kgs_asli'] = $data[$index]['kgs_asli'] + ($kgsbagi * ($xdataxspin['persen'] / 100));
                                            } else {
                                                $xdataxspin['kgs_asli'] = $kgsbagi * ($xdataxspin['persen'] / 100);
                                                $xdataxspin['xinsno'] = $datraw['insno'];
                                                $xdataxspin['xinsnox'] = $datraw['insno'];
                                                $xdataxspin['cuy'] = formatsku($po, $item, $dis, $idbarang);
                                                $xdataxspin['noe'] = $noe;
                                                $xdataxspin['kgs'] = $kgs;
                                                // $xdataxspin['nobontr'] = $xdataxspin['nobontr'];
                                                $xdataxspin['kunci'] = $xdataxspin['id_barang'] . trim($xdataxspin['nobontr']);
                                                $xdataxspin['pcs_asli'] = 0;
                                                array_push($data, $xdataxspin);
                                            }
                                        }
                                    }
                                } else {
                                    if (str_contains($datraw['insno'], '/RR')) {
                                        // Jika Insno Instruksi RINGROPE
                                        $datarr = $this->showbomrr($datraw['po'], $datraw['item'], $datraw['dis'], $datraw['id_barang'], $datraw['insno'], $datraw['nobontr'], $kgs * $persen, $noe, $kgs);
                                        foreach ($datarr as $simpanrr) {
                                            if (getarrayindex($simpanrr['id_barang'] . trim($simpanrr['nobontr']), $data, 'kunci') != '') {
                                                $index = getarrayindex($simpanrr['id_barang'] . trim($simpanrr['nobontr']), $data, 'kunci');
                                                $data[$index]['kgs_asli'] = $data[$index]['kgs_asli'] + $simpanrr['kgs_asli'];
                                            } else {
                                                array_push($data, $simpanrr);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
    public function showbomsp($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $xkgs)
    {
        // Jika Insno Instruksi SPINNING
        $xdata = [];
        $this->db->select("id_header,po,item,dis,id_barang,insno,nobontr,kgs");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->where('tb_header.dept_id', 'SP');
        $this->db->where('trim(tb_header.keterangan)', 'Produksi ' . trim($insno));
        $dataspin = $this->db->get();

        foreach ($dataspin->result_array() as $spin) {
            $this->db->select("po,item,dis,id_barang,insno,nobontr,kgs,persen");
            $this->db->from('tb_detailgen');
            $this->db->where('id_header', $spin['id_header']);
            $dataxspin = $this->db->get();
            foreach ($dataxspin->result_array() as $xdataxspin) {
                // $xdataxspin['kgs_asli'] = $datraw['kgs'] * ($xdataxspin['persen']/100);
                if (getarrayindex($xdataxspin['id_barang'] . trim($xdataxspin['nobontr']), $xdata, 'kunci') != '') {
                    $index = getarrayindex($xdataxspin['id_barang'] . trim($xdataxspin['nobontr']), $xdata, 'kunci');
                    $xdata[$index]['kgs_asli'] = $xdata[$index]['kgs_asli'] + ($kgs * ($xdataxspin['persen'] / 100));
                } else {
                    $xdataxspin['kgs_asli'] = $kgs * ($xdataxspin['persen'] / 100);
                    $xdataxspin['xinsno'] = $insno;
                    $xdataxspin['xinsnox'] = $insno;
                    $xdataxspin['cuy'] = formatsku($po, $item, $dis, $idbarang);
                    $xdataxspin['noe'] = $noe;
                    $xdataxspin['kgs'] = $kgs;
                    // $xdataxspin['nobontr'] = $xdataxspin['nobontr'];
                    $xdataxspin['kunci'] = $xdataxspin['id_barang'] . trim($xdataxspin['nobontr']);
                    $xdataxspin['pcs_asli'] = 0;
                    array_push($xdata, $xdataxspin);
                }
            }
        }
        return $xdata;
    }
    public function showbomrr($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $xkgs)
    {
        $key = $idbarang . $nobontr;
        $kondisirr = [
            'trim(po)' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis,
            'trim(insno)' => trim($insno),
            'trim(nobontr)' => trim($nobontr),
            // 'id_barang' => $idbarang,
            'dept_id' => 'RR',
            'dept_tuju' => 'GP'
        ];
        $this->db->select('tb_detail.*,tb_header.dept_id');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->where($kondisirr);
        $datarr = $this->db->get();

        foreach ($datarr->result_array() as $datrr) {
            $pembagi = $datrr['kgs'];
            $this->db->select('po,item,dis,id_barang,insno,nobontr,sum(kgs) as kgs');
            $this->db->from('tb_detailgen');
            $this->db->where('id_header', $datrr['id_header']);
            $this->db->where('seri_barang', $datrr['seri_barang']);
            $this->db->group_by('po,item,dis,id_barang,insno,nobontr');
            $rrbom = $this->db->get();
            $cekdatrr = $rrbom->row_array();
            if (trim($cekdatrr['insno']) == '' && trim($cekdatrr['nobontr']) == '') {
                continue;
            } else {
                $xdata = [];
                foreach ($rrbom->result_array() as $xdatrr) {
                    $persen = $xdatrr['kgs'] / $datrr['kgs'];
                    if ($xdatrr['nobontr'] != '') {
                        $xdatrr['kgs_asli'] = $kgs * $persen;
                        $xdatrr['xinsno'] = $insno;
                        $xdatrr['xinsnox'] = $xdatrr['insno'];
                        $xdatrr['cuy'] = formatsku($po, $item, $dis, $idbarang);
                        $xdatrr['noe'] = $noe;
                        $xdatrr['kgs'] = $xkgs;
                        $xdatrr['kunci'] = $xdatrr['id_barang'] . trim($xdatrr['nobontr']);
                        $xdatrr['pcs_asli'] = 0;

                        array_push($xdata, $xdatrr);
                    } else {
                        if (str_contains($xdatrr['insno'], '/SP')) {
                            // Jika Insno Instruksi SPINNING
                            $persen = $xdatrr['kgs'] / $datrr['kgs'];
                            $this->db->select("id_header,po,item,dis,id_barang,insno,nobontr,kgs");
                            $this->db->from('tb_detail');
                            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
                            $this->db->where('tb_header.dept_id', 'SP');
                            $this->db->where('trim(tb_header.keterangan)', 'Produksi ' . trim($xdatrr['insno']));
                            $dataspin = $this->db->get();

                            foreach ($dataspin->result_array() as $spin) {
                                $this->db->select("po,item,dis,id_barang,insno,nobontr,kgs,persen");
                                $this->db->from('tb_detailgen');
                                $this->db->where('id_header', $spin['id_header']);
                                $dataxspin = $this->db->get()->row_array();
                                // $dataxspin['kgs_asli'] = $xdatrr['kgs'] * ($dataxspin['persen']/100);
                                $dataxspin['kgs_asli'] = $kgs * $persen;
                                $dataxspin['xinsno'] = $insno;
                                $dataxspin['xinsnox'] = $xdatrr['insno'];
                                $dataxspin['cuy'] = formatsku($po, $item, $dis, $idbarang);
                                $dataxspin['noe'] = $noe;
                                $dataxspin['kgs'] = $xkgs;
                                $dataxspin['kunci'] = $dataxspin['id_barang'] . trim($dataxspin['nobontr']);
                                $dataxspin['pcs_asli'] = 0;

                                array_push($xdata, $dataxspin);
                            }
                        }
                    }
                }
                break;
            }
        }
        return $xdata;
    }
    public function showbomjf($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs)
    {
        $data = [];
        $datakondisi = [
            'trim(po)' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis,
            'id_barang' => $idbarang,
            'trim(insno)' => trim($insno),
            'trim(nobontr)' => trim($nobontr)
        ];
        $this->db->where($datakondisi);
        $hasil = $this->db->get('ref_bom');
        if ($hasil->num_rows() > 0) {
            $cekhasil = $hasil->row_array();
            $this->db->select("id_barang,nobontr,persen");
            $this->db->from('ref_bom_detail');
            $this->db->where('id_bom', $cekhasil['id']);
            $this->db->where('persen >', 0);
            $databom = $this->db->get();
            $jmlrekdet = $databom->num_rows();
            $nor = 0;
            $jmlkgsdet = 0;
            foreach ($databom->result_array() as $detbom) {
                $nor++;
                $jmlkgsdet += $kgs * ($detbom['persen'] / 100);
                $tambahnya = 0;
                if ($nor == $jmlrekdet) {
                    $tambahnya = $kgs - $jmlkgsdet;
                }
                $dataxspin['po'] = $po;
                $dataxspin['item'] = $item;
                $dataxspin['dis'] = $dis;
                $dataxspin['id_barang'] =  $detbom['id_barang'];
                $dataxspin['insno'] = $insno;
                $dataxspin['nobontr'] = $detbom['nobontr'];
                $dataxspin['persen'] = $detbom['persen'];
                $dataxspin['kgs_asli'] = ($kgs * ($detbom['persen'] / 100)) + $tambahnya;
                $dataxspin['xinsno'] = $insno;
                $dataxspin['xinsnox'] = $insno;
                $dataxspin['cuy'] = formatsku($po, $item, $dis, $idbarang);
                $dataxspin['noe'] = $noe;
                $dataxspin['kgs'] = $kgs;
                $dataxspin['kunci'] = $dataxspin['id_barang'] . trim($dataxspin['nobontr']);
                $dataxspin['pcs_asli'] = 0;

                array_push($data, $dataxspin);
            }
        }
        return $data;
    }
    public function showbomjfdom($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs)
    {
        $data = [];
        $datakondisi = [
            'trim(po)' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis,
            'id_barang' => $idbarang,
            'trim(insno)' => trim($insno),
            'trim(nobontr)' => trim($nobontr)
        ];
        $this->db->where($datakondisi);
        $hasil = $this->db->get('ref_bom_cost');
        if ($hasil->num_rows() > 0) {
            $cekhasil = $hasil->row_array();
            $this->db->select("id_barang,nobontr,persen");
            $this->db->from('ref_bom_detail_cost');
            $this->db->where('id_bom', $cekhasil['id']);
            $this->db->where('persen >', 0);
            $databom = $this->db->get();
            $jmlrekdet = $databom->num_rows();
            $nor = 0;
            $jmlkgsdet = 0;
            foreach ($databom->result_array() as $detbom) {
                $nor++;
                $jmlkgsdet += $kgs * ($detbom['persen'] / 100);
                $tambahnya = 0;
                if ($nor == $jmlrekdet) {
                    $tambahnya = $kgs - $jmlkgsdet;
                }
                $dataxspin['po'] = $po;
                $dataxspin['item'] = $item;
                $dataxspin['dis'] = $dis;
                $dataxspin['id_barang'] =  $detbom['id_barang'];
                $dataxspin['insno'] = $insno;
                $dataxspin['nobontr'] = $detbom['nobontr'];
                $dataxspin['persen'] = $detbom['persen'];
                $dataxspin['kgs_asli'] = ($kgs * ($detbom['persen'] / 100)) + $tambahnya;
                $dataxspin['xinsno'] = $insno;
                $dataxspin['xinsnox'] = $insno;
                $dataxspin['cuy'] = formatsku($po, $item, $dis, $idbarang);
                $dataxspin['noe'] = $noe;
                $dataxspin['kgs'] = $kgs;
                $dataxspin['kunci'] = $dataxspin['id_barang'] . trim($dataxspin['nobontr']);
                $dataxspin['pcs_asli'] = 0;

                array_push($data, $dataxspin);
            }
        }
        return $data;
    }
    public function ceknomorbc($data, $idbarang)
    {
        $datahasil = [];
        $xhasil2 = [];
        $hasil2 = $this->db->get_where('tb_hargamaterial', ['nobontr' => $data, 'id_barang' => $idbarang]);
        if ($hasil2->num_rows() > 0) {
            $xhasil2 = $hasil2->row_array();
        }
        return $xhasil2;
    }
    public function getjumlahcifbom($id, $no)
    {
        $this->db->select('tb_bombc.*,barang.nama_barang,barang.kode,barang.nohs,tb_header.nomor_bc,tb_header.jns_bc,satuan.kodesatuan,supplier.kode_negara,tb_header.mtuang');
        $this->db->select('tb_header.netto,tb_header.bruto,tb_header.kurs_yen,tb_header.kurs_usd,tb_header.totalharga,tb_hargamaterial.nomor_bc as hamat_nomorbc,tb_hargamaterial.jns_bc as hamat_jnsbc');
        $this->db->select('tb_hargamaterial.price as hamat_harga,tb_hargamaterial.weight as hamat_weight,tb_hargamaterial.qty as hamat_qty,satuan.kodebc,tb_hargamaterial.mt_uang as hamat_mtuang,tb_hargamaterial.seri_barang,tb_hargamaterial.nomor_aju,tb_hargamaterial.nomor_bc,tb_hargamaterial.jns_bc as jnsbchamat');
        $this->db->select('SUM(case when tb_header.jns_bc = "23" then if(mtuang=1,(tb_header.totalharga)/tb_header.kurs_usd,tb_header.totalharga)/tb_header.netto ELSE 0 END) OVER() sum_totalharga,SUM(case when tb_hargamaterial.jns_bc = "23" AND tb_header.totalharga IS NULL then tb_hargamaterial.price ELSE 0 END) OVER() sum_totalharga2');
        $this->db->from('tb_bombc');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.nomor_dok = tb_bombc.nobontr', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = supplier.kode_negara', 'left');
        $this->db->join('tb_hargamaterial', 'tb_hargamaterial.nobontr = tb_bombc.nobontr AND tb_hargamaterial.id_barang = tb_bombc.id_barang', 'left');
        // $this->db->where('tb_bombc.id',$id);
        $this->db->where('tb_bombc.id_header', $id);
        $this->db->where('tb_bombc.seri_barang', $no);
        return $this->db->get();
    }
    public function getdokumenbcbynomordaftar($nodaf, $mode = 0)
    {
        if ($mode == 0) {
            $this->db->select("nomor_bc,tgl_bc");
            $this->db->from('tb_header');
            $this->db->where('nomor_bc', $nodaf);
            return $this->db->get();
        } else {
            $this->db->select("nomor_bc,tgl_bc");
            $this->db->from('tb_hargamaterial');
            $this->db->where('nomor_bc', $nodaf);
            return $this->db->get();
        }
    }
    public function getnomoraju($kode)
    {
        $kondisi = [
            'month(tgl)' => date('m'),
            'year(tgl)' => date('Y'),
            'dept_id' => 'FG',
            'dept_tuju' => $kode,
            'left(nomor_dok,6)' => 'IFN-' . $kode
        ];
        $this->db->select('max(right(trim(nomor_dok),3)) as maxkode');
        $this->db->from('tb_header');
        $this->db->where($kondisi);
        return $this->db->get();
    }
    public function getkurssekarang($date)
    {
        if ($date == '' || $date == NULL) {
            $date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('tb_kurs');
        $this->db->where('tgl', $date);
        $this->db->limit(1);
        $query = $this->db->get();
        // $row = $query->row();

         return $query;
    }
    // public function getkurssekarang($date)
    // {
    //     if ($date == '' || $date == NULL) {
    //         $date = date('Y-m-d');
    //     }
    //     return $this->db->get_where('tb_kurs', ['tgl' => $date]);
    // }

    public function getkurs30hari($date = '')
    {
        if ($date == '' || $date == NULL) {
            $date = date('Y-m-d');
        }
        $new_date_timestamp = strtotime('-1 month', strtotime($date));
        $xdate = date('Y-m-d', $new_date_timestamp);
        // echo $xdate; // Output: 2025-08-23
        return $this->db->get_where('tb_kurs', ['tgl >=' => $xdate]);
    }
    public function getpersonloginpermonth($date = '')
    {
        if ($date == '' || $date == NULL) {
            $date = date('Y-m-d');
        }
        $new_date_timestamp = strtotime('-1 month', strtotime($date));
        $xdate = date('Y-m-d', $new_date_timestamp);
        $this->db->select('date(datetimelog) as tgllog,COUNT(DISTINCT iduserlog) personlog');
        $this->db->from('tb_logactivity');
        $this->db->where('DATE(datetimelog) >= ', $xdate);
        $this->db->like('activitylog', 'LOGIN');
        $this->db->group_by("1");
        return $this->db->get();
    }
    public function getdatabc2bulan($date='',$mode=0){
        if ($date == '' || $date == NULL) {
            $date = date('Y-m-d');
        }
        if($mode==1){
            $new_date_timestamp = strtotime($date);
            $new_date_timestamp2 = strtotime($date);
        }else{
            // $new_date_timestamp = strtotime('-2 month', strtotime($date));
            // $new_date_timestamp2 = strtotime('0 day', strtotime($date));

            $new_date_timestamp = $this->session->userdata('tglmonbcawal');
            $new_date_timestamp2 = $this->session->userdata('tglmonbcakhir');
        }
        $xdate = date('Y-m-d', $new_date_timestamp);
        $ydate = date('Y-m-d', $new_date_timestamp2);
        $this->db->select('tgl,jns_bc,keterangan,bc_makloon,COUNT(*) AS jmlbc');
        $this->db->from('tb_header');
        $this->db->where("jns_bc != '' ");
        $this->db->where("jns_bc != '0' ");
        if($mode==1){
            $this->db->where(' tgl = ', $xdate);
        }else{
            $this->db->where(' tgl >= ', $xdate);
            $this->db->where(' tgl <= ', $ydate);
        }
        $this->db->where('tb_header.send_ceisa',1);
        $this->db->where('trim(tb_header.nomor_bc) != ', "");
        $this->db->group_by("tgl,jns_bc,bc_makloon");
        return $this->db->get();
    }
    public function getdetailbcasal($exbc, $data)
    {
        $this->db->select('tb_detail.*,tb_header.nomor_aju');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->where('tb_header.nomor_bc', $exbc);
        $this->db->where($data);
        $this->db->limit(1);
        return $this->db->get();
    }
    public function getjumlahbcmasuk($nomorbc)
    {
        $this->db->select('SUM(round(tb_detail.kgs,2)) AS tot_kgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->where('tb_header.exnomor_bc', $nomorbc);
        $this->db->where('tb_header.send_ceisa = 1 and trim(tb_header.exnomor_bc) != "" ');
        return $this->db->get();
    }
    public function jmlkgs261($id,$jnsbc=''){
        $dataheader = $this->db->get_where('tb_header',['id_kontrak' => $id,'jns_bc' => $jnsbc]);
        $idheader = ['!@##'];
        foreach($dataheader->result_array() as $dathed){
            array_push($idheader,$dathed['id']);
        }
        $this->db->select('tb_detail.id,SUM(ROUND(kgs,2)) OVER() AS jmlkgs');
        $this->db->from('tb_detail');
        $this->db->where_in('tb_detail.id_akb',$idheader);
        return $this->db->get();
    }
    public function getnomorbcbykontrak($id){
        return $this->db->get_where('tb_header',['trim(keterangan)' => $id, 'jns_bc'=>261, 'trim(keterangan) != ' => '']);
    }
    public function kodeimdo($id){
        return $this->db->get_where('barang',['id' => $id]);
    }
    public function cekdeptinv($dept,$tgl){
        return $this->db->get_where('stokinv',['dept_id' => $dept,'tgl' => $tgl]);
    }
}
