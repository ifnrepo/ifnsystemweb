<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6 line-12">
                <h2 class="page-title p-2">
                    Lacak Barang / PO
                </h2>
                <small class="pl-2">Periode <?= tglmysql($this->session->userdata('periodeopname')) ?></small>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row mb-1 d-flex align-items-between">
                    <div class="col-sm-6 d-flex">
                        
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                        <a href="<?= base_url() . 'opname/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1 <?php if ($this->session->userdata('currdeptopname') == '') {
                                                                                                                                echo "disabled";
                                                                                                                            } ?>" id="toexcel">
                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M4 15l4 6" /><path d="M4 21l4 -6" /><path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" /><path d="M11 15v6h3" /></svg><span class="ml-1">Excel</span></a>
                    </div>
                </div>
                <div class="card card-active mb-2">
                    <div class="card-body p-2 font-kecil">
                        <div class="row">
                            <div class="col-4">
                                <span>Jumlah Record</span><br>
                                <span>Qty</span><br>
                                <span>Pcs</span>
                            </div>
                            <div class="col-5">
                            </div>
                            <div class="col-3">
                                <div class="mb-0 pb-0">
                                    <label class="font-bold">
                                        <!-- Cari Barang / SKU : -->
                                        <div class="d-flex justify-content-between m-0">
                                            <label class="form-check form-check-inline mb-0 line-11">
                                                <input class="form-check-input" type="radio" value="cariidbarang" name="radios-filter"  <?php if($this->session->userdata('sel-carilacakpo')=='barang'){ echo "checked"; } ?>>
                                                <span class="form-check-label font-kecil font-bold">ID Barang</span>
                                            </label>
                                            <label class="form-check form-check-inline mb-0 line-11">
                                                <input class="form-check-input" type="radio" value="caripo" name="radios-filter" <?php if($this->session->userdata('sel-carilacakpo')=='insnopo'){ echo "checked"; } ?>>
                                                <span class="form-check-label font-kecil font-bold">PO / Insno</span>
                                            </label>
                                            <label class="form-check form-check-inline mb-0 line-11">
                                                <input class="form-check-input" type="radio" value="carispek" name="radios-filter" <?php if($this->session->userdata('sel-carilacakpo')=='spekbar'){ echo "checked"; } ?>>
                                                <span class="form-check-label font-kecil font-bold">Spek Barang</span>
                                            </label>
                                        </div>
                                    </label>
                                </div>
                                <div class="mt-0">
                                    <div class="">
                                        <textarea class="form form-control p-2 m-0 font-kecil" id='textcarirekapopname' style="text-transform: uppercase;" placeholder="Cari PO, Insno, Kode Barang.."><?= $this->session->userdata('cari-rekapopname') ?></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="buttoncarirekapopname" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                                        <button type="button" id="buttonresetrekapopname" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1" id="div-page">
                    <div class="col-md-3 col-12">
                        <div class="row">
                        <label class="col-3 col-form-label font-kecil">Per Page</label>
                        <div class="col mb-1">
                            <select name="lacakpo-perpage" id="lacakpo-perpage" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1 w-50">
                                <option value="10" <?php if($this->session->userdata('perpage-lacakpo')==10){ echo "selected"; } ?>>10</option>
                                <option value="25" <?php if($this->session->userdata('perpage-lacakpo')==25){ echo "selected"; } ?>>25</option>
                                <option value="50" <?php if($this->session->userdata('perpage-lacakpo')==50){ echo "selected"; } ?>>50</option>
                                <option value="100" <?php if($this->session->userdata('perpage-lacakpo')==100){ echo "selected"; } ?>>100</option>
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
                <table id="tabelnyau" class="table order-column table-hover table-bordered mt-1" style="width: 100% !important; border-collapse: collapse;">
                    <thead>
                        <tr class="text-left">
                            <th class="text-center">No</th>
                            <th class="text-center">Dept</th>
                            <th class="text-left line-11"><span class="text-blue">Sku</span><br>Spesifikasi</th>
                            <th class="text-center">Grd</th>
                            <th>Sat</th>
                            <th class="line-11">Insno/Nobontr<br><span class="text-pink">Nomor BC</span></th>
                            <th>Sublok</th>
                            <th>Nobale</th>
                            <th>Exnet</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Kgs</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <tr>
                            <td colspan="12" class="text-center">Cari data Barang / PO</td>
                        </tr>
                        <?php $jmlpcs=0; $jmlkgs=0; $no= (int) $this->uri->segment(3) + 1; foreach($data->result_array() as $dt): ?>
                        <?php 
                            $spek = trim($dt['po'])=='' ? $dt['nama_barang'] : $dt['spek'];
                            $sku = trim($dt['po'])=='' ? $dt['kode'] : $dt['skupo'];
                            $grade = $dt['stok']==1 ? 'Grd A' : ($dt['stok']==2 ? 'Grd B' : '');
                            $exnet = $dt['exnet']==1 ? 'Y' : '';
                            $jmlpcs = $dt['totalpcs'];
                            $jmlkgs = $dt['totalkgs'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="font-kecil"><?= $dt['dept_id'] ?></td> 
                                <td class="font-kecil line-11"><span class="text-blue"><?= $sku ?></span><br><a title="View Detail"><?= $spek ?></a></td>
                                <td class="font-kecil"><?= $grade ?></td> 
                                <td class="font-kecil"><?= $dt['kodesatuan'] ?></td> 
                                <?php $nobc = trim($dt['nomor_bc'])!='' ? 'BC No. '.trim($dt['nomor_bc']) : ''; ?>
                                <td class="font-kecil line-11"><?= $dt['insno'].$dt['nobontr'] ?><br><span class="text-pink"><?= $nobc ?></span></td>
                                <td class="font-kecil"><?= $dt['kode_lokasi'].'-'.$dt['nama_lokasi'] ?></td> 
                                <td class="font-kecil"><?= $dt['nobale'] ?></td> 
                                <td class="font-kecil text-center"><?= $exnet ?></td> 
                                <td class="font-kecil text-right"><?= rupiah($dt['pcs'],0) ?></td> 
                                <td class="font-kecil text-right"><?= rupiah($dt['kgs'],2) ?></td> 
                                <td class="font-kecil text-right">
                                    <a href="<?= base_url().'opname/editrekapopname/'.$dt['id'] ?>" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data Stok Opname" style="padding:0 3px !important">Edit</a>
                                    <a href="#" data-href="<?= base_url().'opname/hapusrekapopname/'.$dt['id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data '+spec+' ('+sku.trim()+')" style="padding:0 3px !important">Hapus</a>
                                </td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-1 font-kecil">
                    <div class="mt-1">
                        Jumlah Record <?= rupiah($jumlahrek,0) ?>
                    </div>
                    <div>
                        <?= $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>