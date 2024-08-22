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
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Dibuat Oleh </th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($lock as $key) : $no++; ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td class="font-bold"><?= namabulan(substr($key['periode'],0,2)).' '.substr($key['periode'],2,4); ?></td>
                                    <td><?= $key['name']; ?></td>
                                    <td><?= tglmysql2($key['dibuat_pada']); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-danger btn-icon text-white font-kecil" style="padding: 3px 5px !important;" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'lockinv/hapusdata/' . $key['id']; ?>" title="Hapus data">
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
</div>