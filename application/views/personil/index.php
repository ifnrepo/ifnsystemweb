<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Personil
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'personil/tambahdata'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                                <th>Nama </th>
                                <th>Nip</th>
                                <th>Bagian</th>
                                <th>Jabatan</th>
                                <th>Status Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($personil as $key) : $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $key['nama_personil']; ?></td>
                                    <td><?= $key['nip']; ?></td>
                                    <td><?= $key['departemen']; ?></td>
                                    <td><?= $key['nama_jabatan']; ?></td>
                                    <td style="text-align: center;"><?php if ($key['status_aktif'] == 1) : ?>
                                            <i class="fa fa-check text-success"></i>
                                        <?php else : ?>
                                            <i class="fa fa-times text-danger"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url() . 'personil/edit/' . $key['personil_id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="edituser" rel="<?= $key['personil_id']; ?>" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'personil/hapusdata/' . $key['personil_id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <a href="<?= base_url() . 'personil/view/' . $key['personil_id']; ?>" class="btn btn-sm btn-teal btn-icon" id="edituser" rel="<?= $key['personil_id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View User">
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