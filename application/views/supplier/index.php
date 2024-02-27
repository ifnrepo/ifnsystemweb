<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Supplier
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'supplier/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data Supplier"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($supplier as $key) : $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['kode']; ?></td>
                                    <td><?= $key['nama_supplier']; ?></td>
                                    <td><?= $key['alamat']; ?></td>
                                    <td><?= $key['kontak']; ?></td>
                                    <td>
                                        <a href="<?= base_url() . 'supplier/editsupplier/' . $key['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Master Supplier" class="btn btn-sm btn-primary btn-icon text-white" rel="<?= $key['id']; ?>" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'supplier/hapussupplier/' . $key['id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <a href="<?= base_url() . 'supplier/viewsupplier/' . $key['id']; ?>" class="btn btn-sm btn-teal btn-icon" id="edituser" rel="<?= $key['id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View Supplier">
                                            <i class="fa fa-eye"></i>
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
</div>