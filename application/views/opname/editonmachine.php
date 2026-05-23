<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <div class="page-pretitle pl-2">
                    Entry Data Periode <span class><?= tglmysql($detailperiode['tgl']) ?></span>
                </div>
                <h2 class="page-title px-2">
                    Edit On Machine
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/entristok/'.$this->uri->segment(3).'/'.$this->uri->segment(4); ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-body p-2">
                            <div class="card card-active">
                                <div class="card-body p-2">
                                    <h4 class="mb-2">Form Input On Machine</h4>
                                    <hr class="m-1">
                                    <div class="row mb-1">
                                        <label class="col-3 col-form-label font-kecil font-bold">No Mesin <?= $data['machno'] ?></label>
                                        <div class="col mb-1">
                                            <select name="machnoonmesin" id="machnoonmesin" class="form-control form-select btn-flat font-kecil" disabled>
                                                <option value="">-- Pilih Mesin --</option>
                                                <?php foreach($mesin->result_array() as $msn): ?>
                                                    <option value="<?= $msn['mach_no'] ?>" <?php if($msn['mach_no']==$data['machno']){ echo "selected"; } ?>><?= $msn['mach_no'].' - '.$msn['specifik'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="form-cari">
                                        <hr class="m-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-check form-check-inline hilang">
                                                <input class="form-check-input" type="radio" value="cariidbarang" name="radios-filter">
                                                <span class="form-check-label font-kecil font-bold">ID Barang</span>
                                            </label>
                                            <label class="form-check form-check-inline hilang">
                                                <input class="form-check-input" type="radio" value="caripo" name="radios-filter" checked>
                                                <span class="form-check-label font-kecil font-bold">PO / Insno</span>
                                            </label>
                                            <label class="form-check form-check-inline hilang">
                                                <input class="form-check-input" type="radio" value="carispek" name="radios-filter">
                                                <span class="form-check-label font-kecil font-bold">Spek Barang</span>
                                            </label>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="id" id="id" value="<?= $header['id'] ?>" class="hilang">
                                            <input type="text" name="deptid" id="deptid" value="<?= $header['dept_id'] ?>" class="hilang">
                                            <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="keywordinputmesin" placeholder="Cari PO atau Instruksi…">
                                            <button class="btn btn-blue btn-flat font-kecil" type="button" id="cariinputmesin">Cari !</button>
                                            <button href="#" class="hilang" id="caribarangdouble" data-bs-target="#modal-large" data-bs-toggle="modal" data-title="Pilih">caribarang</button>
                                        </div>
                                    </div>
                                    <div id="form-hasilcari">
                                        <hr class="m-1">
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                                            <div class="col mb-1">
                                                <input type="text" class="hilang" name="idbarang" id="idbarang" value="<?= $data['brg_id'] ?>">
                                                <input type="text" class="hilang" name="po" id="po" value="<?= $data['po'] ?>">
                                                <input type="text" class="hilang" name="item" id="item" value="<?= $data['item'] ?>">
                                                <input type="text" class="hilang" name="dis" id="dis" value="<?= $data['dis'] ?>">
                                                <input type="text" class="hilang" name="dln" id="dln">
                                                <input type="text" class="hilang" name="identristok" id="identristok" value="<?= $data['id'] ?>">
                                                <input type="text" class="hilang" name="idstokopname" id="idstokopname" value="<?= $data['id_stokopname'] ?>">
                                                <input type="text" name="sku" id="sku" class="form-control btn-flat font-bold font-kecil" value="<?= viewsku($data['po'],$data['item'],$data['dis']) ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil font-bold">Spek Barang</label>
                                            <div class="col mb-1">
                                                <!-- <input type="text" name="spek" id="spek" class="form-control btn-flat font-bold font-kecil" value=""> -->
                                                <textarea name="spek" id="spek" class="form-control btn-flat font-kecil" readonly><?= $data['spek'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil font-bold">Color</label>
                                            <div class="col mb-1">
                                                <input type="text" name="color" id="color" class="form-control btn-flat font-kecil" value="<?= $data['color'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil font-bold">Insno</label>
                                            <div class="col mb-1">
                                                <input type="text" name="insno" id="insno" class="form-control btn-flat font-kecil" value="<?= $data['insno'] ?>">
                                            </div>
                                        </div>
                                        <!-- <hr class="m-1">
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="btn btn-sm btn-ghost-danger btn-flat" data-dissmiss="modal" id="resetinputstok">Reset</a>
                                            <a href="#" class="btn btn-sm btn-success btn-flat" id="simpaninputstok">Simpan</a>
                                            <a href="#" class="btn btn-sm btn-info btn-flat hilang" id="updateinputstok">Update</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card m-2">
                            <div id="cardkosong" class="hilang">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-2" style="min-height: 329px !important;">
                                    <h2 class="text-secondary">Pilih PO/Instruksi</h2>
                                </div>
                            </div>
                            <div id="cardisi" class="">
                                <div class="card-body" style="min-height: 329px !important;">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h5 class="mb-1">Data Bunsen</h5>
                                            <hr class="m-1">
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Berat Bunsen Kosong (1)<br><span class="text-lime font-10">1 Pcs Bunsen</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bunko" id="bunko" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bunko'],2) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Jumlah Bunsen di Box (2)<br><span class="text-lime font-10">Jml Bunsen isi pada Box Cadangan</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bunjmlbox" id="bunjmlbox" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bunjmlbox'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Berat Bunsen di Box (3)<br><span class="text-lime font-10">Berat rata-rata 1 pcs Bunsen di Box</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bunbrtbox" id="bunbrtbox" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bunbrtbox'],3) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Jumlah Bunsen di Mesin (4)<br><span class="text-lime font-10">Jumlah Bunsen isi pada mesin</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bunjmlmsn" id="bunjmlmsn" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bunjmlmsn'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Berat Bunsen di Mesin (4)<br><span class="text-lime font-10">Berat rata-rata 1 pcs Bunsen di Mesin</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bunbrtmsn" id="bunbrtmsn" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bunbrtmsn'],3) ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h5 class="mb-1">Data Bobbin</h5>
                                            <hr class="m-1">
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Jumlah Bobbin di Mesin (6)<br><span class="text-lime font-10">Bobbin pada Mesin</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bobjmlmsn" id="bobjmlmsn" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bobjmlmsn'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Jumlah Sampling Bobbin di Mesin (7)<br><span class="text-lime font-10">20% dari Jumlah bobbin di Mesin</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="jmbobspl" id="jmbobspl" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['jmbobspl'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Jenis Bobbin (8)<br><span class="text-lime font-10">Jenis Bobbin pada Mesin</span></label>
                                                <div class="col mb-1">
                                                    <select name="jnsbob" id="jnsbob" class="form-control form-select font-kecil">
                                                        <option value="">-- Pilih Jenis Bobbin --</option>
                                                        <?php foreach($bobin->result_array() as $bob): ?>
                                                            <option value="<?= $bob['kodebob'] ?>" <?php if($bob['kodebob']==$data['jnsbob']){ echo "selected"; } ?>><?= $bob['kodebob'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Berat Bobbin Kosong (9)<br><span class="text-lime font-10">Berat kosong jenis Bobbin diatas</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bobko" id="bobko" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bobko'],2) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Berat isi Bobbin (10)<br><span class="text-lime font-10">20% Sampling Bobbin di Mesin</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="bobisi" id="bobisi" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['bobisi'],3) ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h5 class="mb-1 mt-2">Other</h5>
                                            <hr class="m-1">
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Lot di Mesin (11)<br><span class="text-lime font-10">Dari</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="lot_dari" id="lot_dari" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['lot_dari'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Lot di Mesin (12)<br><span class="text-lime font-10">Sampai</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="lot_sampai" id="lot_sampai" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['lot_sampai'],0) ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-7 col-form-label font-kecil line-11">Rpm Mesin (13)<br><span class="text-lime font-10">Jumlah Rpm yang tertera di Counter</span></label>
                                                <div class="col mb-1">
                                                    <input type="text" name="rpm" id="rpm" class="form-control btn-flat font-kecil text-right inputangka" value="<?= rupiah($data['rpm'],0) ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 d-flex flex-column justify-content-center align-items-center">
                                            <h5 class="text-secondary">
                                                Hati-hati saat mengisi data, pastikan perhitungan Benar !
                                            </h5>
                                        </div>
                                    </div>
                                    <hr class="m-1">
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-sm btn-danger" id="resetdataonmachine">Batal/Reset</a>
                                        <a href="#" class="btn btn-sm btn-primary" id="updatedataonmachine">Update Data</a>
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