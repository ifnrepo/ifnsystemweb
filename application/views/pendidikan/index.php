<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Pendidikan
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'pendidikan/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Pendidikan"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                        <a href="<?= base_url() . 'pendidikan/excel'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                        <a href="<?= base_url() . 'pendidikan/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tingkat Pendidikan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($pendidikan as $key) : $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['tingkat_pendidikan']; ?></td>
                                    <td>
                                        <a href="<?= base_url() . 'pendidikan/edit/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editgrup" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit Data Pendidikan" rel="<?= $key['id']; ?>" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'pendidikan/hapus/' . $key['id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o"></i>
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