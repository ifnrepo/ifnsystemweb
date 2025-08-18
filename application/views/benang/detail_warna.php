<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Detail Benang <br>
                    Nomor Dokumen: <?= $nomordok['nomor_dok'] ?>
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'benang'; ?>" class="btn btn-warning btn-sm"><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row font-kecil">
                    <!-- <div class="col-md-3" style="overflow-y: auto; height:400px ;"> -->
                    <div class="col-md-12">
                        <div id="table-default" class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Spek Barang</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" style="font-size: 13px !important;">
                                    <?php $no = 0;
                                    foreach ($detail_warna as $key) : $no++; ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $key['nama_barang']; ?></td>
                                            <td><?= $key['kodesatuan']; ?></td>

                                            <td>
                                                <!-- <div class="dropdown">
                                                    <a class="btn btn-outline-primary dropdown-toggle font-kecil" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <a href="<?= base_url('benang/tambah_spek/' . $key['id']); ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple">
                                                                <i class="fa fa-plus"></i> <span class="ml-1">Tambah Spek Benang</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div> -->
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
    </div>
</div>