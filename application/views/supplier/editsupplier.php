<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Edit Data Supplier
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url('supplier'); ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body font-kecil">
                <form method="POST" action="<?= base_url('supplier/updatesupplier'); ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Kode</label>
                                <div class="col">
                                    <input type="hidden" class="form-control font-kecil hilang" name="id" id="id" value="<?= $data['id']; ?>">
                                    <input type="text" class="form-control font-kecil" name="kode" id="kode" value="<?= $data['kode']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Nama Supplier</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nama_supplier" id="nama_supplier" value="<?= $data['nama_supplier']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Alamat</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="alamat" id="alamat" value="<?= $data['alamat']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Desa</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="desa" id="desa" value="<?= $data['desa']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Kecamatan</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" value=" <?= $data['kecamatan']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">kab_kota</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" value=" <?= $data['kab_kota']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">provinsi</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" value=" <?= $data['propinsi']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">kodepos</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" value=" <?= $data['kodepos']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Npwp</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" value=" <?= $data['npwp']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">telp</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="telp" id="telp" value=" <?= $data['telp']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Email</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="email" id="email" value=" <?= $data['email']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Kontak</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" value=" <?= $data['kontak']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Jabatan</label>
                                <div class="col">
                                    <input type="text area" class="form-control font-kecil" name="jabatan" id="jabatan" value=" <?= $data['jabatan']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Keterangan</label>
                                <div class="col">
                                    <input type="text area" class="form-control font-kecil" name="keterangan" id="keterangan" value=" <?= $data['keterangan']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="hr mt-2 mb-1"></div>
                        <div class="card-body pt-2">
                            <div class="row">
                                <button type="submit" class="btn btn-primary btn-sm w-100 ">
                                    <i class="fa fa-save mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>