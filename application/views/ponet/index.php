<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            PO NET
        </h2>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <input type="text" name="id" class="hilang" id="id" value="<?= $data['id'] ?>">
                    <input type="text" name="maxid" class="hilang" id="maxid" value="<?= $maxrek['maxid'] ?>">
                    <input type="text" name="minid" class="hilang" id="minid" value="<?= $maxrek['minid'] ?>">
                    <div class="col-3 p-2" style="border: 1px solid #eaeaea;border-radius:3px;">
                        <div style="position: relative">
                            <div class="mb-1 row">
                                <label class="col-4 col-form-label form-control-sm font-kecil">Tgl Dok PO</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm font-kecil btn-flat" id="netto" name="netto" value="<?= tgl_indo($data['tgl']) ?>" aria-describedby="emailHelp" placeholder="Tgl" readonly>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-4 col-form-label form-control-sm font-kecil">In Hikiai</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm font-kecil btn-flat" id="netto" name="netto" value="<?= tgl_indo($data['tglhik']) ?>" aria-describedby="emailHelp" placeholder="Hikiai" readonly>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-4 col-form-label form-control-sm font-kecil">Terima PO</label>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm font-kecil btn-flat" id="netto" name="netto" value="<?= tgl_indo($data['tglplan']) ?>" aria-describedby="emailHelp" placeholder="tgl PO" readonly>
                                </div>
                            </div>
                            <div class="text-center p-0 <?php if($data['outstand']!=0){ echo "hilang"; } ?>">
                                <img src="<?= base_url().'assets\image\delivered-stamp.png' ?>" alt="Stempel Closed" class="m-0" style="width:45%; height:auto;">
                            </div>
                        </div>
                        <hr class="m-1">    
                        <div style="position: relative;" class="mb-0">
                            <div class="font-kecil text-secondary d-flex justify-content-between">
                                <?php $hikiai = $data['stat_po']==1 ? 'PO' : ($data['stat_po']==2 ? 'HIKIAI' : ($data['stat_po']==3 ? 'KARI PO' : ($data['stat_po']==4 ? 'MIKOMI' : 'TEST'))) ?>
                                <span class="badge bg-secondary text-secondary-fg">Status : <?= $hikiai ?></span>
                                <span class="badge bg-dark text-black font-bold <?php if(trim($data['revisi'])==''){ echo "hilang"; } ?>" title="Revisi :"><span class="text-white"><?= $data['revisi'] ?></span></span>
                                <?php $owner = $data['dln']==0 ? 'PT. INDONEPTUNE NET' : 'PT. DEWA LAUTINDO' ?>
                                <span class="badge bg-yellow text-black"><?= $owner ?></span>
                            </div>
                            <div class="text-center" style="position: relative;">
                                <span class="" style="font-size: 30px; font-weight:600;"><?= viewsku($data['po'],$data['item'],$data['dis']) ?></span>
                                <span style="font-size: 30px;position: absolute;top:-10px;height:10px;cursor: pointer;" id="cekitem" rel="<?= $data['po'] ?>">
                                    <a href="<?= base_url().'ponet/caripoid/'.gantislash(trim($data['po'])) ?>" class="text-success" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Cari Data PO">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-circle-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10a10 10 0 1 1 0 -20m-2.293 8.293a1 1 0 0 0 -1.414 1.414l3 3a1 1 0 0 0 1.414 0l3 -3a1 1 0 0 0 0 -1.414l-.094 -.083a1 1 0 0 0 -1.32 .083l-2.294 2.292z" /></svg>
                                    </a>
                                </span>
                                <br>
                                <span class="text-secondary font-kecil font-bold" title="Hikiai Number">Hikiai Number : <?= viewsku($data['ord'],$data['ordno'],$data['ordis']) ?></span></div>
                            <hr class="m-0">
                            <div class="" style="padding:10px 0; text-align: center;">
                                <a href="<?= base_url().'ponet/viewfoto/'.urlencode($data['gbrlogo']) ?>" id="viewfoto" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View Foto">
                                    <?php $gambar = trim($data['gbrlogo'])=='' ? base_url().'assets/image/avatars/005f.jpg' : base_url().'assets/image/label/'.$data['gbrlogo'] ?>
                                    <img src="<?= $gambar ?>" alt="Belum ada Foto" style="height:auto; width:55%;">
                                </a>
                            </div>
                            <hr class="m-0">
                            <div class="bg-danger-lt px-2 py-1 font-kecil font-bold text-center"><span class="text-black">Hasil Pengecekan Lab</span></div>
                            <div class="mb-0 mt-1 row">
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-4 col-form-label font-kecil form-control-sm text-right">Dry</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm  font-kecil btn-flat text-right" id="bruto" name="bruto" value="" aria-describedby="emailHelp" placeholder="Dry Value" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-4 col-form-label form-control-sm font-kecil text-right">Std</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat text-right" id="netto" name="netto" value="" aria-describedby="emailHelp" placeholder="Std Dry" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0 row">
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-4 col-form-label form-control-sm font-kecil text-right">Wet</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat text-right" id="bruto" name="bruto" value="" aria-describedby="emailHelp" placeholder="Wet Value" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-4 col-form-label form-control-sm  font-kecil text-right">Std</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm  font-kecil btn-flat text-right" id="netto" name="netto" value="" aria-describedby="emailHelp" placeholder="Std Wet" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0">
                        <table class="table table-bordered m-0 mt-1 mb-1">
                            <thead class="bg-primary-lt">
                                <!-- <tr>
                                    <th class="text-center text-black" colspan="2"></th>
                                </tr> -->
                            </thead>
                            <tbody class="table-tbody">
                                <tr>
                                    <td class="font-kecil">Factory Limit</td>
                                    <td class="font-bold text-danger font-kecil" style="background-color: #ffff93;"><?= limitmp($data['lim']) ?></td>
                                </tr>
                                <tr class="<?php if($this->session->userdata('cek_limit')!=1){ echo "hilang"; } ?>">
                                    <td class="font-kecil">Dlv Time ( 納期 )</td>
                                    <td class="font-kecil font-bold"><?= limitmp($data['lim'],10) ?></td>
                                </tr>
                                <tr class="<?php if($this->session->userdata('cek_limit')!=1){ echo "hilang"; } ?>">
                                    <td class="font-kecil">Inquiry Limit</td>
                                    <td class="font-kecil"><?= limitmp($data['inqulim']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered m-0 mt-1 mb-1 <?php if($this->session->userdata('cek_price')!=1){ echo "hilang"; } ?>">
                            <thead class="bg-primary-lt">
                                <!-- <tr>
                                    <th class="text-center text-black" colspan="2"></th>
                                </tr> -->
                            </thead>
                            <tbody class="table-tbody">
                                <tr>
                                    <td class="font-kecil">Nilai <?= ucwords(strtolower($data['st_piece'])) ?></td>
                                    <td class="font-bold text-black font-kecil" style="background-color: #fad5d5;"><?= $data['mtuang'].' '.rupiah($data['nilaipcs'],2) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-kecil">Total</td>
                                    <td class="font-kecil font-bold"><?= $data['mtuang'].' '.rupiah($data['piece']*$data['nilaipcs'],2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <div class="text-center pt-2" style="border-top: 0.5px solid #eaeaea;">
                                <button class="btn btn-sm btn-primary" id="firstrec">First</button>
                                <button class="btn btn-sm btn-primary" id="prevrec">Prev</button>
                                <button class="btn btn-sm btn-primary" id="nextrec">Next</button>
                                <button class="btn btn-sm btn-primary" id="lastrec">Last</button>
                                <a href="<?= base_url().'ponet/caripo' ?>" class="btn btn-sm btn-teal text-white" id="caridatapo" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Cari Data PO">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                    Cari Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Kolom kedua -->
                    <div class="col-9">
                        <div class="container">
                            <div class="ponet-tabs">
                                <ul class="nav nav-tabs nav-fill" data-bs-toggle="tabs" style="border-bottom: transparent !important;">
                                    <li class="nav-item">
                                        <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle mr-1"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                        Informasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tabs-produksi-7" class="nav-link" data-bs-toggle="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-assembly mr-1"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1 -2.184 0l-6.75 -4.27a2.23 2.23 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98l-.033 0" /><path d="M15.5 9.422c.312 .18 .503 .515 .5 .876v3.277c0 .364 -.197 .7 -.515 .877l-3 1.922a1 1 0 0 1 -.97 0l-3 -1.922a1 1 0 0 1 -.515 -.876v-3.278c0 -.364 .197 -.7 .514 -.877l3 -1.79c.311 -.174 .69 -.174 1 0l3 1.79h-.014l0 .001" /></svg>
                                        Produksi</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#tabs-activity-7" class="nav-link" data-bs-toggle="tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                        Activity</a>
                                    </li> -->
                                </ul>
                                <hr class="m-1">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-7">
                                        <div class="row mb-1">
                                            <div class="col-9">
                                                <div class="mb-0 row">
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-yellow-lt"><span class="text-black">Buyer</span></label>
                                                                    <div class="col">
                                                                        <?php $port = trim($data['port'])!='' ? ' - '.trim($data['port']) : ''; $customer = trim($data['nama_customer']).$port; ?>
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $customer ?>" aria-describedby="emailHelp" placeholder="Buyer" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Kelompok</span></label>
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $data['engklp'] ?>" aria-describedby="emailHelp" placeholder="Kelompok PO" readonly>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="row">
                                                                                    <div class="col-5 font-kecil mt-1 text-right">HS Code</div>
                                                                                    <div class="col-7">
                                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $data['hs'] ?>" aria-describedby="emailHelp" placeholder="Nomor HS" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-0 row">
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <div class="col-12">
                                                                <div class="mb-1 row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Type</span></label>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= trim($data['ways']).' - '.trim($data['knot']).' - '.$data['jenis'] ?>" aria-describedby="emailHelp" placeholder="Type" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Meai ( 目合 )</span></label>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah((float) $data['meai'],2).' '.trim($data['st_meai']) ?>" aria-describedby="emailHelp" placeholder="Meai" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Kakesu ( 掛数 )</span></label>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah($data['kakesu'],2).' MD' ?>" aria-describedby="emailHelp" placeholder="Jml Kakesu" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Length</span></label>
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah((float) $data['leng'],2).' '.$data['st_length'] ?>" aria-describedby="emailHelp" placeholder="Jml Kakesu" readonly>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <span class="font-kecil text-blue"><?php if($data['st_length']!='MT'){ echo $data['mtr'].' Mtr'; } ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Color</span></label>
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $data['color'] ?>" aria-describedby="emailHelp" placeholder="Warna Jala" readonly>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="row">
                                                                                    <div class="col-5 font-kecil mt-1 text-right">Total</div>
                                                                                    <div class="col-7">
                                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat text-right" value="<?= rupiah($data['piece']*$data['weight'],2).' Kgs' ?>" aria-describedby="emailHelp" placeholder="Nomor HS" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Qty</span></label>
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-8">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah((float) $data['piece'],2).' '.$data['st_piece'] ?>" aria-describedby="emailHelp" placeholder="Qty Order" readonly>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <span class="font-kecil text-blue <?php if($data['pcshik']==0){ echo "hilang"; } ?>">Hikiai : <?= $data['pcshik'].' '.$data['st_piece'] ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Net Type</span></label>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $data['name_nettype'] ?>" aria-describedby="emailHelp" placeholder="Tipe Jala Order" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Category</span></label>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $data['nama_kategori'] ?>" aria-describedby="emailHelp" placeholder="Kategori" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-1 row">
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Spec</span></label>
                                                            <div class="col">
                                                                <input type="text" class="form-control form-control-sm  font-kecil btn-flat font-bold" style="color: #54300c !important;" value="<?= $data['spek'] ?>" aria-describedby="emailHelp" placeholder="Type" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Label Invoice</span></label>
                                                            <div class="col">
                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold" style="color: #54300c !important;" value="<?= $data['labdom'] ?>" aria-describedby="emailHelp" placeholder="Type" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Label Pack</span></label>
                                                            <div class="col">
                                                                <input type="text" class="form-control form-control-sm  font-kecil btn-flat" style="color: #54300c !important;" value="<?= $data['labdom'] ?>" aria-describedby="emailHelp" placeholder="Type" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Remark</span></label>
                                                            <div class="col">
                                                                <textarea name="remark" id="remark" class="form-control form-control-sm font-kecil btn-flat" rows="3" readonly><?= $data['remark'] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-1 row">
                                                            <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-secondary-lt"><span class="text-black">Selvage Info</span></label>
                                                            <div class="col">
                                                                <input type="text" class="form-control form-control-sm  font-kecil btn-flat" style="color: #54300c !important;" value="" aria-describedby="emailHelp" placeholder="-" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 bg-azure-lt" style="border: 1px solid #eaeaea;border-radius:3px;">
                                                <table class="table table-bordered m-0 table-hover mt-2">
                                                    <thead class="bg-primary-lt">
                                                        <!-- <tr>
                                                            <th class="text-center text-black" colspan="2"></th>
                                                        </tr> -->
                                                    </thead>
                                                    <tbody class="table-tbody">
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-bold">Mesin</td>
                                                            <td class="text-black text-center" style="font-size:14px;"><h3 class="p-0 m-0"><?= $data['machno'] ?></h3></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Kapasitas</td>
                                                            <td class="text-black"><?= $data['kap'].' X '.$data['lot'].' = '.$data['prd'].' Pcs' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Jumlah Lot</td>
                                                            <td class="text-black"><?= rupiah($data['lotday'],1).' lot/hari ' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Berat Jala</td>
                                                            <td class="text-black text-right"><?= rupiah($data['jala'],3).' Kgs' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Mimi</td>
                                                            <td class="text-black text-right"><?= rupiah($data['mimi'],3).' Kgs' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Other Weight</td>
                                                            <td class="text-black text-right"><?= rupiah($data['polytex']+$data['danline']+$data['kuchizuki']+$data['rope']+$data['mountline'],3).' Kgs' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Weight</td>
                                                            <td class="text-black text-right font-bold" style="font-size: 12px; color: #833C0C !important;"><?= rupiah($data['weight'],3).' Kgs' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Pengerjaan</td>
                                                            <td class="text-black text-right"><?= rupiah($data['hari'],0).' hari' ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered m-0 table-hover mt-1  <?php if($data['id_nettype']==0){ echo "hilang"; } ?>">
                                                    <thead class="bg-primary-lt">
                                                        <!-- <tr>
                                                            <th class="text-center text-black" colspan="2"></th>
                                                        </tr> -->
                                                    </thead>
                                                    <tbody class="table-tbody">
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Meai</td>
                                                            <td class="text-black"><?= rupiah($data['sukimeai'],0).' me = '.rupiah($data['sukioroshi'],0).' mm' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Sukioroshi Meai</td>
                                                            <td class="text-black"><?= rupiah($data['prc'],1).' % ' ?></td>
                                                        </tr>
                                                        <tr class="font-kecil">
                                                            <td class="text-black font-weight-bolder">Revolusi Mesin</td>
                                                            <td class="text-black text-right"><?= rupiah($data['planrev'],0).' rpm' ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- <div class="mb-3">
                                                    <label class="form-label font-kecil form-control-sm mb-1 pb-0">Keterangan</label>
                                                    <div class="bg-danger mt-1">
                                                        <textarea name="remark" id="remark" class="form-control form-control-sm font-kecil btn-flat" rows="3" readonly></textarea>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <!-- Tab Baru -->
                                         <div class="prod-tabs">
                                            <hr class="m-0">
                                                <ul class="nav nav-tabs" data-bs-toggle="tabs" style="border-bottom: transparent !important;">
                                                    <li class="nav-item">
                                                        <a href="#tabs-selvage" class="nav-link line-11 active" style="background-color: #FCE4D6;" data-bs-toggle="tab"><span class="text-center">FUTOITO ( 太糸 )</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-sujinawa" class="nav-link line-11" style="background-color: #EDEDED" data-bs-toggle="tab"><span>SUJINAWA ( 筋縄 )</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-shipmark" class="nav-link line-11" style="background-color: #FFF2CC" data-bs-toggle="tab"><span>SIDE/SHIP MARK</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-jushi" class="nav-link line-11" style="background-color: #D9E1F2" data-bs-toggle="tab"><span>JUSHI ( 樹脂 )</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-kemasan" class="nav-link line-11" style="background-color: #FFE699" data-bs-toggle="tab"><span>KEMASAN</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-deliv" class="nav-link line-11" style="background-color: #E2EFDA" data-bs-toggle="tab"><span>DELIVERY INFO</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tabs-info-ppic" class="nav-link line-11" style="background-color: #f7e6fa" data-bs-toggle="tab"><span>PPIC NOTES</span></a>
                                                    </li>
                                                </ul>
                                            <hr class="m-0 mb-1">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="tabs-selvage">
                                                    <table class="table table-bordered m-0 table-hover">
                                                        <thead class="bg-primary-lt">
                                                        <tr>
                                                            <th class="text-center text-black">Mimi</th>
                                                            <th class="text-center text-black">Kakesu</th>
                                                            <th class="text-center text-black">T/B</th>
                                                            <th class="text-center text-black">Ket</th>
                                                            <th class="text-center text-black">Kgs</th>
                                                            <th class="text-center text-black">Color</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="table-tbody" id="body-tabel-caripo">
                                                            <?php if($futoito->num_rows() > 0){ $jmlmimi=0; foreach($futoito->result_array() as $futo): $jmlmimi += $futo['weight']; ?>
                                                                <tr class="font-kecil">
                                                                    <td><?= $futo['jenis'] ?></td>
                                                                    <td class="text-right"><?= $futo['kakesu'] ?></td>
                                                                    <td class="text-center font-bold"><?= $futo['tob'] ?></td>
                                                                    <td></td>
                                                                    <td class="text-right font-bold"><?= rupiah($futo['weight'],3) ?></td>
                                                                    <td><?= $futo['color'] ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            <tr class="font-kecil bg-danger-lt">
                                                                <td colspan="4" class="text-right font-bold"><span class="text-black">TOTAL SELVAGE</span></td>
                                                                <td class="text-right font-bold"><span class="text-black"><?= rupiah($jmlmimi,3) ?></span></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php }else{ ?>
                                                                <tr>
                                                                    <td colspan="6" class="text-center font-kecil">-- Data Futoito Kosong --</td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tabs-sujinawa">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Kuchizuki</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $kuci1 = trim($data['kuchi1'])!='' ? trim($data['kuchi1']).' - ' : ''; 
                                                                                $kuci2 = trim($data['kuchi2'])!='' ? trim($data['kuchi2']).' - ' : ''; 
                                                                                $kuci3 = trim($data['kuchi3'])!='' ? trim($data['kuchi3']) : ''; 
                                                                                $kuci = $kuci1.$kuci2.$kuci3;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $kuci ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['kuchizuki']!=0){ echo rupiah((float) $data['kuchizuki'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Polytex</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $pol1 = trim($data['pol1'])!='' ? trim($data['pol1']).' - ' : ''; 
                                                                                $pol2 = trim($data['pol2'])!='' ? trim($data['pol2']).' - ' : ''; 
                                                                                $pol3 = trim($data['pol3'])!='' ? trim($data['pol3']) : ''; 
                                                                                $pol = $pol1.$pol2.$pol3;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $pol ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['polytex']!=0){ echo rupiah((float) $data['polytex'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['lpol']!=0){ echo rupiah((float) $data['lpol'],3).' Mtr'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Danline</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $dan1 = trim($data['dan1'])!='' ? trim($data['dan1']).' - ' : ''; 
                                                                                $dan2 = trim($data['dan1color'])!='' ? trim($data['dan1color']).' - ' : ''; 
                                                                                $dan3 = trim($data['dan2'])!='' ? trim($data['dan2']).' - ' : ''; 
                                                                                $dan4 = trim($data['dan2color'])!='' ? trim($data['dan2color']) : ''; 
                                                                                $dan = $dan1.$dan2.$dan3.$dan4;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $dan ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['danline']!=0){ echo rupiah((float) $data['danline'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['ldan']!=0){ echo rupiah((float) $data['ldan'],3).' Mtr'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Rope</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $rop1 = trim($data['rop1'])!='' ? trim($data['rop1']).' - ' : ''; 
                                                                                $rop2 = trim($data['rop2'])!='' ? trim($data['rop2']) : ''; 
                                                                                $rop = $rop1.$rop2;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $rop ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['rope']!=0){ echo rupiah((float) $data['rope'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['lrop']!=0){ echo rupiah((float) $data['lrop'],3).' Mtr'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Mtg Guide</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $mon1 = trim($data['mon1'])!='' ? trim($data['mon1']).' - ' : ''; 
                                                                                $mon2 = trim($data['mon2'])!='' ? trim($data['mon2']).' - ' : ''; 
                                                                                $mon3 = trim($data['mon3'])!='' ? trim($data['mon3']) : ''; 
                                                                                $mon = $mon1.$mon2.$mon3;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $mon ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['mountline']!=0){ echo rupiah((float) $data['mountline'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['lmon']!=0){ echo rupiah((float) $data['lmon'],3).' Mtr'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Guideline</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <?php 
                                                                                $gui1 = trim($data['gui1'])!='' ? trim($data['gui1']).' - ' : ''; 
                                                                                $gui2 = trim($data['gui2'])!='' ? trim($data['gui2']).' - ' : ''; 
                                                                                $gui3 = trim($data['gui3'])!='' ? trim($data['gui3']) : ''; 
                                                                                $gui = $gui1.$gui2.$gui3;
                                                                            ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= $gui ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['guiline']!=0){ echo rupiah((float) $data['guiline'],3).' Kgs'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold text-right" value="<?php IF($data['lgui']!=0){ echo rupiah((float) $data['lgui'],3).' Mtr'; } ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-shipmark">
                                                    <!-- Side/Ship mark Information is Under Construction ! -->
                                                    <div class="row">
                                                        <div class="col-6 text-center p-2 line-12">
                                                            <!-- Side mark Information is Under Construction ! -->
                                                             <div class="text-left mb-1 font-kecil font-bold text-blue">SIDE MARK</div>
                                                             <div style="border: 1px solid #eaeaea; border-radius: .25rem; min-height:120px;" class="p-3">
                                                                <?php if($sidemark->num_rows() > 0): ?>
                                                                    <?php $datasidemark = $sidemark->row_array(); ?>
                                                                    <span class="font-bold"><?= $datasidemark['side1'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datasidemark['side2'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datasidemark['side3'] ?></span><br>
                                                                    <span><?= $datasidemark['side4'] ?></span><br>
                                                                    <span><?= $datasidemark['side5'] ?></span><br>
                                                                    <span><?= $datasidemark['side6'] ?></span><br>
                                                                    <span><?= $datasidemark['side7'] ?></span>
                                                                <?php else: ?>
                                                                    <span class="text-center"><small class="text-secondary">Side Mark tidak Ditemukan</small></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-center p-2 line-12">
                                                            <!-- Ship mark Information is Under Construction ! -->
                                                             <div class="text-left mb-1 font-kecil font-bold text-pink">SHIPPING MARK</div>
                                                            <div style="border: 1px solid #eaeaea; border-radius: .25rem; min-height:120px;" class="p-3">
                                                                <?php if($shipmark->num_rows() > 0): ?>
                                                                    <?php $datashipmark = $shipmark->row_array(); ?>
                                                                    <span class="font-bold"><?= $datashipmark['ship1'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship2'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship3'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship4'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship5'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship6'] ?></span><br>
                                                                    <span class="font-kecil"><?= $datashipmark['ship7'] ?></span>
                                                                <?php else: ?>
                                                                    <span class="text-center pt-auto"><small class="text-secondary">Shipping Mark tidak Ditemukan</small></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-kemasan">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Kemasan</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <?php $kemas = $data['plastikpol']==1 ? 'Plastik Polos' : 'Plastik Berlabel'; ?>
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat font-bold" style="color: #492700 !important" value="<?= $kemas ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Pcs/Bale</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah($data['pcbale'],0) ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-deliv">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Delivery</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" style="color: #492700 !important" value="<?= rupiah($data['deliv'],0) ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Outstanding Order</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="<?= rupiah($data['outstand'],0) ?>" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-jushi">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black">Kode Jushi</span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <input type="text" class="form-control form-control-sm font-kecil btn-flat" value="" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        </div>
                                                                        <div class="col-4 row">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-2 col-form-label form-control-sm font-kecil font-bold bg-blue-lt"><span class="text-black"></span></label>
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <textarea name="remark" id="remark" class="form-control form-control-sm font-kecil btn-flat" rows="5" readonly><?= $data['isijushi'] ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-info-ppic">
                                                    <div class="row">
                                                        <div class="card">
                                                            <div class="card-body p-1">
                                                                <div class="col-12 bg-">
                                                                    <div class="row">
                                                                        <label class="col-2 col-form-label form-control-sm font-kecil font-bold"><span class="text-black">Keterangan</span></label>
                                                                        <div class="col">
                                                                            <textarea name="ppic_notes" id="ppic_notes" class="form-control form-control-sm font-kecil btn-flat" rows="4"><?= $data['ppic_notes'] ?></textarea>
                                                                            <div class="mt-1 d-flex justify-content-between">
                                                                                <div class="font-kecil" id="datafile">
                                                                                    <?php if(trim($data['file_name'])=='' || $data['file_name']==null){ ?>
                                                                                        <span class="text-secondary">
                                                                                            <i>Tidak ada file terlampir</i>
                                                                                        </span>
                                                                                    <?php }else{ ?>
                                                                                        <?php foreach(json_decode($data['file_name']) as $fl => $finame): ?>
                                                                                            <a href="<?= base_url().'assets/file/dokpo/'.trim($finame) ?>" target="_blank" title="Klik untuk melihat">
                                                                                                <span class="text-blue">
                                                                                                    <i><?= $finame ?></i>
                                                                                                </span>
                                                                                            </a><br>
                                                                                        <?php endforeach; ?>
                                                                                    <?php } ?>
                                                                                </div>
                                                                                <a href="<?= base_url().'ponet/isinotes/'.$data['id'] ?>" class="btn btn-sm btn-primary <?php if($this->session->userdata('cek_notes')==0){ echo "hilang"; } ?>" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Edit PPIC Notes">
                                                                                    <span>Edit PPIC Notes</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-produksi-7">
                                        <div class="h4 text-center"><u>Production Summary</u></div>
                                        <ul class="steps steps-counter steps-vertical">
                                            <li class="step-item steps-orange">
                                                <div class="h5 m-0">Netting</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !!  -->
                                                            <div id="prod-netting">
                                                                <span class="load-netting">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="row">
                                                                    <div class="col-3 hilang" id="kolom-prod-netting-1">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-netting-1">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-netting-2">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-netting-2">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-netting-3">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-netting-3">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-netting-4">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-netting-4">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="hilang" id="sum-prod-netting">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black" style="width: 10%;">Achievement</th>
                                                                                <th class="text-center text-black" style="border-bottom: 1px soild #eaeaea !important;">Summary Total</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-netting">
                                                                            <tr>
                                                                                <td class="text-right font-bold">XX</td>
                                                                                <td class="text-right font-bold">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step-item steps-yellow">
                                                <div class="h5 m-0">Senshoku</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !! -->
                                                             <div id="prod-senshoku">
                                                                <span class="load-senshoku">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="row">
                                                                    <div class="col-3 hilang" id="kolom-prod-senshoku-1">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-senshoku-1">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-senshoku-2">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-senshoku-2">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-senshoku-3">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-senshoku-3">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-senshoku-4">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-senshoku-4">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="hilang" id="sum-prod-senshoku">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black" style="width: 10%;">Achievement</th>
                                                                                <th class="text-center text-black" style="border-bottom: 1px soild #eaeaea !important;">Summary Total</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-senshoku">
                                                                            <tr>
                                                                                <td class="text-right font-bold">XX</td>
                                                                                <td class="text-right font-bold">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step-item steps-lime">
                                                <div class="h5 m-0">Shitate</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !! -->
                                                             <div id="prod-gaichu">
                                                                <span class="load-gaichu">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="row">
                                                                    <div class="col-3 hilang" id="kolom-prod-gaichu-1">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-gaichu-1">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-gaichu-2">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-gaichu-2">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-gaichu-3">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-gaichu-3">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-gaichu-4">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">Instruksi</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-gaichu-4">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="hilang" id="sum-prod-gaichu">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black" style="width: 10%;">Achievement</th>
                                                                                <th class="text-center text-black" style="border-bottom: 1px soild #eaeaea !important;">Summary Total</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-gaichu">
                                                                            <tr>
                                                                                <td class="text-right font-bold">XX</td>
                                                                                <td class="text-right font-bold">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step-item steps-green">
                                                <div class="h5 m-0">Finishing-Ready Goods</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !! -->
                                                             <div id="prod-finishing">
                                                                <span class="load-finishing">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="row">
                                                                    <div class="col-3 hilang" id="kolom-prod-finishing-1">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-finishing-1">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-finishing-2">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-finishing-2">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-finishing-3">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-finishing-3">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-finishing-4">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-finishing-4">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="hilang" id="sum-prod-finishing">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black" style="width: 10%;">Achievement</th>
                                                                                <th class="text-center text-black" style="border-bottom: 1px soild #eaeaea !important;">Summary Total</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-finishing">
                                                                            <tr>
                                                                                <td class="text-right font-bold">XX</td>
                                                                                <td class="text-right font-bold">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step-item steps-teal">
                                                <div class="h5 m-0">Finished Goods</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !! -->
                                                             <div id="prod-fingoods">
                                                                <span class="load-fingoods">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="row">
                                                                    <div class="col-3 hilang" id="kolom-prod-fingoods-1">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-fingoods-1">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-fingoods-2">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-fingoods-2">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-fingoods-3">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-fingoods-3">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-3 hilang" id="kolom-prod-fingoods-4">
                                                                        <table class="table table-bordered m-0 table-hover mt-1">
                                                                            <thead class="bg-primary-lt">
                                                                                <tr>
                                                                                    <th class="text-center text-black">No Bale</th>
                                                                                    <th class="text-center text-black">Pcs</th>
                                                                                    <th class="text-center text-black">Kgs</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table-tbody" id="detail-prod-fingoods-4">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="hilang" id="sum-prod-fingoods">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black" style="width: 10%;">Achievement</th>
                                                                                <th class="text-center text-black" style="border-bottom: 1px soild #eaeaea !important;">Summary Total</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-fingoods">
                                                                            <tr>
                                                                                <td class="text-right font-bold">XX</td>
                                                                                <td class="text-right font-bold">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step-item steps-cyan">
                                                <div class="h5 m-0">Shipped</div>
                                                <div class="text-secondary mt-1">
                                                    <div class="card">
                                                        <div class="card-body p-1 font-kecil">
                                                            <!-- Under Construction !! -->
                                                             <div id="prod-shipped">
                                                                <span class="load-shipped">
                                                                    <!-- Loading Data, Mohon tunggu ! -->
                                                                    <div class="card">
                                                                        <div class="card-body placeholder-glow">
                                                                            <div class="placeholder col-9"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                            <div class="placeholder placeholder-xs col-8"></div>
                                                                            <div class="placeholder placeholder-xs col-10"></div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                <div class="hilang" id="sum-prod-shipped">
                                                                    <table class="table table-bordered m-0 table-hover mt-1">
                                                                        <thead class="bg-primary-lt">
                                                                            <tr>
                                                                                <th class="text-center text-black">No</th>
                                                                                <th class="text-center text-black">Tgl</th>
                                                                                <th class="text-center text-black">Nomor PL</th>
                                                                                <th class="text-center text-black">Tujuan</th>
                                                                                <th class="text-center text-black">Negara</th>
                                                                                <th class="text-center text-black">Pcs</th>
                                                                                <th class="text-center text-black">Kgs</th>
                                                                                <th class="text-center text-black">Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-tbody" id="detail-sum-prod-shipped">
                                                                            <tr>
                                                                                <td class="text-center">XX</td>
                                                                                <td class="text-right">Total XX Instruksi</td>
                                                                                <td class="text-right">XX Pcs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                                <td class="text-right">XX Kgs</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" id="tabs-activity-7">
                                        <h4>Activity tab</h4>
                                        <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris accumsan nibh habitant senectus</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>