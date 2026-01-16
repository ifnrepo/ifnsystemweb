<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Dashboard Stok Opname
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <div class="row">
                    <label class="col-4 col-form-label font-kecil">Periode</label>
                    <div class="col">
                        <select name="tgl_so" id="tgl_so" class="form-control form-select font-kecil btn-flat font-bold">
                            <option value="all">Pilih Periode Stok</option>
                            <?php foreach($periode->result_array() as $p): $selek = $this->session->userdata('periodeopname')==$p['tgl'] ? 'selected' : ''; ?>
                                <option value="<?= $p['tgl'] ?>" <?= $selek ?>><?= tglmysql($p['tgl']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <a href="#" style="height: 38px;" class="btn btn-yellow btn-sm ml-1" id="refreshperiode"><i class="fa fa-refresh"></i><span class=""></span></a>
                <a href="<?= base_url() . 'opname/addperiode'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add periode Stok Opname"><i class="fa fa-plus"></i><span class="ml-1">Tambah Periode </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1 text-right">
                       <br>
                       <br>
                       <br>
                       <br>
                    </div>
                </div>
                <div class="text-center">
                    <h1>HALAMAN DASHBOARD STOK OPNAME</h1>
                </div>
            </div>
        </div>
    </div>
</div>