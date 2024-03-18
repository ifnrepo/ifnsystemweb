<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Departemen
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'dept/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Departemen"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                                <th>Nama Departemen</th>
                                <th>Kategori</th>
                                <th>Oth</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($dept as $key) : $no++; $oth = cekoth($key['pb'],$key['bbl'],$key['adj']); ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['dept_id']; ?></td>
                                    <td><?= $key['departemen']; ?></td>
                                    <td><?= strtoupper($key['nama']); ?></td>
                                    <td><?= $oth ?></td>
                                    <td>
                                        <a href="<?= base_url() . 'dept/editdept/' . $key['dept_id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editkategori" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit Data Departemen" rel="<?= $key['dept_id']; ?>" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusdept" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'dept/hapusdept/' . $key['dept_id']; ?>" title="Hapus data">
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