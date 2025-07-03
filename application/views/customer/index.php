<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Customer
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'customer/tambahdata' ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data Customer"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <?= $pesan = $this->session->flashdata('pesan'); ?>
        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1 d-flex justify-content-between">
                        <div class="row flex-fill">
                            <div class="col-4">
                                <div class="row ">
                                    <label class="col-5 col-form-label font-kecil font-bold px-4">Exdo</label>
                                    <div class="col">
                                        <select class="form-select font-kecil btn-flat" name="exdo" id="exdo">
                                            <option value="export">Export</option>
                                            <option value="domestik">Domestik</option>
                                        </select>
                                        <a href="" class="btn btn-sm btn-flat">Update</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        <div>
                            <a href="<?= base_url() . 'customer/excel'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                            <a href="<?= base_url() . 'customer/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                        </div>
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Customer</th>
                                <th>Nama Customer</th>
                                <th>Buyer/Alias</th>
                                <th>Exdo</th>
                                <th>Port</th>
                                <th>Country</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($customer as $key) : $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['kode_customer']; ?></td>
                                    <td><?= $key['nama_customer']; ?></td>
                                    <td><?= $key['buyer']; ?></td>
                                    <td><?= $key['exdo']; ?></td>
                                    <td><?= $key['port']; ?></td>
                                    <td><?= $key['country']; ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </label>
                                            <div class="dropdown-menu">
                                                <label class="dropdown-item p-1">
                                                    <a href="<?= base_url() . 'customer/editcustomer/' . $key['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data Customer" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="<?= $key['id']; ?>" title="Edit data">
                                                        <i class="fa fa-edit pr-1"></i> Edit Data
                                                    </a>
                                                </label>
                                                <label class="dropdown-item p-1">
                                                    <a class="btn btn-sm btn-danger btn-icon text-white w-100" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'customer/hapuscustomer/' . $key['id']; ?>" title="Hapus data">
                                                        <i class="fa fa-trash-o pr-1"></i> Hapus Data
                                                    </a>
                                                </label>
                                                <label class="dropdown-item p-1">
                                                    <a href="<?= base_url() . 'customer/viewcustomer/' . $key['id']; ?>" class="btn btn-sm btn-teal btn-icon w-100" id="edituser" rel="<?= $key['id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View customer">
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