<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Tambah Data Bill Of Material Cost
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'billmaterial_cost'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="card mb-2">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">PO</label>
                                    <div class="col">
                                        <input type="text" id="po" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Item</label>
                                    <div class="col">
                                        <input type="text" id="item" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Dis</label>
                                    <div class="col">
                                        <input type="text" id="dis" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row font-kecil mb-0">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Spec</label>
                                    <div class="col input-group mb-1">
                                        <input type="text" id="id_header" name="id_header" class="hilang" value="">
                                        <input type="text" id="id_detail" name="id_detail" class="hilang" value="">
                                        <input type="text" id="id_barang" name="id_barang" class="hilang">
                                        <input type="text" class="form-control font-kecil" id="nama_barang" name="nama_barang" placeholder="Spec Barang">
                                        <a href="<?= base_url() . 'pb/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" class="btn font-kecil bg-success text-white" type="button">Cari!</a>
                                    </div>
                                </div>
                                <div class="row font-kecil mb-0 hilang" id="cont-spek">
                                    <label class="col-3 col-form-label font-kecil"></label>
                                    <div class="col input-group mb-1 text-teal" id="spekbarangnya"></div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Nomor Bale</label>
                                    <div class="col-4">
                                        <input type="email" id="nobale" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Insno</label>
                                    <div class="col-4">
                                        <input type="email" id="insno" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Nobontr</label>
                                    <div class="col-4">
                                        <input type="email" id="nobontr" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">DLN</label>
                                    <div class="col-4">
                                        <select name="dl" id="dl" class="form-control input-sm font-kecil form-select">
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-sm btn-primary" id="simpanmaterial">Simpan Barang</a>
                    <a href="#" class="btn btn-sm btn-danger" id="resetdetailbarang">Reset</a>
                </div>
            </div>
        </div>
    </div>
</div>