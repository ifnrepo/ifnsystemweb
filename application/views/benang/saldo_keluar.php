<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    <a href="<?= base_url() . 'benang/tambahsaldo_keluar/' . $tb_detail_id . '/' . $id_barang; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Saldo Keluar"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                </h2>
                <br>
                <h2> <?= $judul; ?></h2>
                <br> SPEK BARANG <?= $header['nama_barang']; ?>
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
                    <div class="col-md-12">
                        <?= $this->session->flashdata('message'); ?>
                        <div id="table-default" class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Periode</th>
                                        <th style="text-align: center;">Eksport Data</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" style="font-size: 13px !important;">

                                    <?php if (!empty($keluar)) : ?>
                                        <?php $no = 0;
                                        foreach ($keluar as $key) : $no++; ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <?= $no; ?></td>
                                                </td>
                                                <td style="text-align: center;"><?= format_bulan_tahun($key['bulan_tahun']); ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('benang/excel/' . $key['bulan_tahun']); ?>" class="btn btn-success btn-sm "><i class="fa fa-file-excel-o"></i><span class="ml-1">To Excel</span></a>
                                                    <a href="<?= base_url('benang/pdf/' . $key['bulan_tahun']); ?>" target="_blank" class="btn btn-danger btn-sm "><i class="fa fa-file-pdf-o"></i> <span class="ml-1">To PDF</span></a>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url(); ?>benang/view_saldo_keluar/<?= $key['bulan_tahun']; ?>/<?= $tb_detail_id; ?>/<?= $id_barang; ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail' class="btn btn-info btn-sm ">
                                                        Views Data
                                                    </a>
                                                    <a href="<?= base_url(); ?>benang/logbook/<?= $key['bulan_tahun']; ?>/<?= $tb_detail_id; ?>/<?= $id_barang; ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='Logbook Saldo Keluar' class="btn btn-primary btn-sm ">
                                                        Logbook
                                                    </a>
                                                </td>




                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6">Data tidak tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>