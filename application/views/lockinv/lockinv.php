<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Close Book Inventory
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'lockinv/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Close Book Inventory"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div class="row mb-1 d-flex align-items-between">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                        <a href="#" class="btn btn-sm btn-primary" id="setperiode">SET</a>
                        <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('thlock') ?>">
                        <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;">
                            <option value="all"><span class="text-cyan">Semua Bulan</span></option>
                            <?php for($x=1;$x<=12;$x++): ?>
                                <option value="<?= $x; ?>" <?php if($this->session->userdata('bllock')==$x) echo "selected"; ?>><?= namabulan($x); ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="font-kecil font-bold mr-2 align-middle" style="padding-top: 11px;">Periode</div>
                    </div>
                </div>
                <table id="tabelnya" class="table table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Dept ID</th>
                        <th>Periode</th>
                        <th>Dibuat Oleh</th>
                        <th>Dibuat Tgl</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
                        <?php $no=1; foreach($lock as $l): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="font-bold"><?= $l['dept_id'] ?></td>
                                <td class="font-bold"><?= namabulan(substr($l['periode'],0,2)).' '.substr($l['periode'],2,4) ?></td>
                                <td><?= datauser($l['dibuat_oleh'],'name') ?></td>
                                <td class="text-teal"><?= tglmysql2($l['dibuat_pada']) ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger btn-icon text-white font-kecil" style="padding: 3px 5px !important;" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'lockinv/hapusdata/' . $l['id']; ?>" title="Hapus data">
                                        <i class="fa fa-trash-o mr-1"></i> Hapus Data
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>