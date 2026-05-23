<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6 col-12">
                <h2 class="page-title p-2">
                    Dashboard Stok Opname
                </h2>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-end" style="text-align: right;">
                <div class="row">
                    <label class="col-4 col-form-label font-kecil">Periode</label>
                    <div class="col">
                        <select name="tgl_so" id="tgl_so" class="form-control form-select font-kecil btn-flat font-bold">
                            <option value="">Pilih Periode Stok</option>
                            <?php foreach($periode->result_array() as $p): $selek = $this->session->userdata('periodeopname')==$p['tgl'] ? 'selected' : ''; ?>
                                <option value="<?= $p['tgl'] ?>" <?= $selek ?>><?= tglmysql($p['tgl']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <a href="#" style="height: 38px;" class="btn btn-yellow btn-sm ml-1" id="refreshperiode"><i class="fa fa-refresh"></i><span class=""></span></a>
                <a href="<?= base_url() . 'opname/addperiode'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1 <?php if($this->session->userdata('rolestokopname')!=99){ echo "hilang"; } ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add periode Stok Opname"><i class="fa fa-plus"></i><span class="ml-1">Tambah Periode </span></a>
                <a href="<?= base_url() . 'opname/addpersenstok'; ?>" style="height: 38px;" class="btn btn-info btn-sm ml-1 <?php if($this->session->userdata('rolestokopname')!=99){ echo "hilang"; } ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data Persentase Verifikasi"><i class="fa fa-check"></i><span class="ml-1">Persentase Verifikasi </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <?php if($this->session->userdata('periodeopname')==''){ ?>
                    <div class="text-center">
                        <h1>PERIODE OPNAME BELUM DIPILIH</h1>
                    </div>
                <?php }else{ ?>
                    <div class="text-center mb-2">
                        <h1 class="mb-0 pb-0">HALAMAN DASHBOARD STOK OPNAME</h1>
                        <h3 class=" mt-0 mb-2"><?= 'Periode : '.tglmysql($this->session->userdata('periodeopname')).' ('.trim($detailperiode['keterangan']).')' ?></h3>
                    </div>
                <?php } ?>
                <div class="card card-active mb-2">
                    <div class="card-body p-1">
                        <div class="overflow-auto">
                            <table class="table table-bordered m-0 table-hover">
                                <thead class="bg-primary-lt">
                                    <tr>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">No<br>(1)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">Departemen<br>(2)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle" colspan="3"><span class="text-black">Sublok</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">Jumlah<br>Sublok<br>ter-Verifikasi<br>(6)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">%<br>(6/4)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">Jumlah<br>Record<br>(7)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">Jumlah<br>Record<br>ter-Verifikasi Data<br>(8)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">Jumlah<br>Record<br>ter-Verifikasi KAP<br>(9)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">%<br>(8/7)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11" rowspan="2"><span class="text-black">STATUS</span></th>
                                    </tr>
                                    <tr>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11"><span class="text-black">Jml<br>(3)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11"><span class="text-black">Input<br>(4)</span></th>
                                        <th class="text-black p-1 bg-yellow-lt text-center align-middle line-11"><span class="text-black">Selesai<br>(5)</span></th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    <?php 
                                        $jmlsublok = 0;
                                        $jmlinput = 0;
                                        $jmlselesai = 0;
                                        $jmlverifikasi = 0;
                                        $jmlrek = 0;
                                        $jmlverif = 0;
                                        $jmlrilis = 0;
                                        $jmlkgsrek = 0;
                                        $jmlkgsverif = 0;
                                        $jmlkgsrilis = 0;
                                    ?>
                                    <?php $no=0; foreach($datarekap->result_array() as $rekap): $no++; ?>
                                    <?php 
                                        $jmlsublok += $rekap['jml'];
                                        $jmlinput += $rekap['jmlinput'];
                                        $jmlselesai += $rekap['jmlselesai'];
                                        $jmlverifikasi += $rekap['jmlverifikasi'];
                                        $jmlrek += $rekap['jmlrek'];
                                        $jmlverif += $rekap['jmlverif'];
                                        $jmlrilis += $rekap['jmlrilis'];
                                        $jmlkgsrek += $rekap['jmlkgs'];
                                        $jmlkgsverif += $rekap['jmlverifkgs'];
                                        $jmlkgsrilis += $rekap['jmlriliskgs'];
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td class="font-kecil"><?= $rekap['departemen'] ?></td>
                                            <td class="text-right font-kecil"><?= rupiah($rekap['jml'],0) ?></td>
                                            <td class="text-right font-kecil"><?= rupiah($rekap['jmlinput'],0) ?></td>
                                            <td class="text-right font-kecil"><?= rupiah($rekap['jmlselesai'],0) ?></td>
                                            <td class="text-right font-kecil"><?= rupiah($rekap['jmlverifikasi'],0) ?></td>
                                            <?php $input = $rekap['jmlinput']==0 ? 1 : $rekap['jmlinput']; ?>
                                            <?php $po = ($rekap['jmlverifikasi']/$input)==0 ? '' : (($rekap['jmlverifikasi']/$input) <= 0.35 ? 'bg-red-lt' : (($rekap['jmlverifikasi']/$input) <= 0.75 ? 'bg-yellow-lt' : 'bg-green-lt'));  ?>
                                            <td class="text-right font-kecil <?= $po ?>"><span class="text-black"><?= rupiah(($rekap['jmlverifikasi']/$input)*100,2) ?></span></td>
                                            <?php $captkgs = $rekap['jmlkgs'] > 0 ? ' Kgs' : ''; ?>
                                            <?php $captverif = $rekap['jmlverifkgs'] > 0 ? ' Kgs' : ''; ?>
                                            <?php $captrilis = $rekap['jmlriliskgs'] > 0 ? ' Kgs' : ''; ?>
                                            <td class="text-right font-kecil line-11"><?= rupiah($rekap['jmlrek'],0) ?><br><span class="text-primary"><?= rupiah($rekap['jmlkgs'],2).$captkgs ?></span></td>
                                            <td class="text-right font-kecil line-11"><?= rupiah($rekap['jmlverif'],0) ?><br><span class="text-primary"><?= rupiah($rekap['jmlverifkgs'],2).$captverif ?></span></td>
                                            <td class="text-right font-kecil line-11"><?= rupiah($rekap['jmlrilis'],0) ?><br><span class="text-primary"><?= rupiah($rekap['jmlriliskgs'],2).$captrilis ?></span></td>
                                            <?php $inputx = $rekap['jmlrek']==0 ? 1 : $rekap['jmlrek']; ?>
                                            <?php $pox = ($rekap['jmlverif']/$inputx)==0 ? '' : (($rekap['jmlverif']/$inputx) <= 0.35 ? 'bg-red-lt' : (($rekap['jmlverif']/$inputx) <= 0.75 ? 'bg-yellow-lt' : 'bg-green-lt'));  ?>
                                            <td class="text-right font-kecil <?= $pox ?>"><span class="text-black"><?= rupiah(($rekap['jmlverif']/$inputx)*100,2) ?></span></td>
                                            <td class="text-right font-kecil"><span class="text-black"></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold" colspan="2" ><span class="text-black">TOTAL</span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold"><span class="text-black"><?= rupiah($jmlsublok,0) ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold"><span class="text-black"><?= rupiah($jmlinput,0) ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold"><span class="text-black"><?= rupiah($jmlselesai,0) ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold"><span class="text-black"><?= rupiah($jmlverifikasi,0) ?></span></td>
                                        <?php $pembagi = $jmlinput==0 ? 1 : $jmlinput; ?>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold"><span class="text-black"><?= rupiah(($jmlverifikasi/$pembagi)*100,2) ?></span></td>
                                        <?php $capt1 = $jmlkgsrek > 0 ? ' Kgs' : ''; ?>
                                        <?php $capt2 = $jmlkgsverif > 0 ? ' Kgs' : ''; ?>
                                        <?php $capt3 = $jmlkgsrilis > 0 ? ' Kgs' : ''; ?>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold line-11"><span class="text-black"><?= rupiah($jmlrek,0) ?><br><?= rupiah($jmlkgsrek,2).$capt1 ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold line-11"><span class="text-black"><?= rupiah($jmlverif,0) ?><br><?= rupiah($jmlkgsverif,2).$capt2 ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold line-11"><span class="text-black"><?= rupiah($jmlrilis,0) ?><br><?= rupiah($jmlkgsrilis,2).$capt3 ?></span></td>
                                        <?php $pembagi2 = $jmlrek==0 ? 1 : $jmlrek; ?>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold line-11"><span class="text-black"><?= rupiah(($jmlverif/$pembagi2)*100,2) ?></span></td>
                                        <td class="bg-orange-lt align-middle font-kecil text-right font-bold line-11"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>