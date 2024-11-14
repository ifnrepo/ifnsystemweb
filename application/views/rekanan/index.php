<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Rekanan
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'rekanan/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data Rekanan"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                        Export Data To :
                        <a href="<?= base_url() . 'rekanan/excel'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                        <a href="<?= base_url() . 'rekanan/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Inisial</th>
                                <th>Nama Rekanan</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($rekanan as $key) : $no++
                            ?>

                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['inisial']; ?></td>
                                    <td><?= $key['nama_rekanan']; ?></td>
                                    <td><?= $key['alamat_rekanan']; ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </label>
                                            <div class="dropdown-menu">
                                                <label class="dropdown-item p-1">
                                                    <a href="<?= base_url() . 'rekanan/edit/' . $key['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Master Supplier" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="<?= $key['id']; ?>" title="Edit data">
                                                        <i class="fa fa-edit pr-1"></i> Edit Data
                                                    </a>
                                                </label>
                                                <label class="dropdown-item p-1">
                                                    <a class="btn btn-sm btn-danger btn-icon text-white w-100" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'rekanan/hapus/' . $key['id']; ?>" title="Hapus data">
                                                        <i class="fa fa-trash-o pr-1"></i> Hapus Data
                                                    </a>
                                                </label>
                                                <label class="dropdown-item p-1">
                                                    <a href="<?= base_url() . 'rekanan/view/' . $key['id']; ?>" class="btn btn-sm btn-teal btn-icon w-100" id="edituser" rel="<?= $key['id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View Supplier">
                                                        <i class="fa fa-eye pr-1"></i> View Data
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>