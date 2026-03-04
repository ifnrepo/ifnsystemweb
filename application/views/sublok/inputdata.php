<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- <style>
    .laser-area {
        height: 320px;
        width: 100%;
        border: solid gray 1px;
        /* padding:10px 10px;  */
        position: relative;
        overflow: hidden;
    }
</style> -->

<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-0">
                    <?= $title ?>
                </h2>
                <div class="page-pretitle">
                  Input Data
                </div>
            </div>
            <div class="col-md-6" style="text-align: right;">

            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div id="sisipkan" class="sticky-top bg-white">
                    <div class="card card-active" style="clear:both;">
                        <div class="card-body p-2 font-kecil">
                            <div class="row">
                                <div class="col-sm-4 col-12">
                                    <span style="display:inline-block; width:100px;">Tanggal</span> : <b><?= tgl_indo($header['tgl']) ?></b><br>
                                    <span style="display:inline-block; width:100px;">Nomor</span> : <b><?= $header['nomor'] ?></b><br>
                                    <span style="display:inline-block; width:100px;">Departemen</span> : <b><?= $header['departemen'] ?></b><br>
                                    <span style="display:inline-block; width:100px;">Sub Lokasi</span> : <b><?= $header['kode_lokasi'].'-'.$header['nama_lokasi'] ?></b><br>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <span style="display:inline-block; width:100px;">Dibuat</span> : <b><?= datauser($header['dibuat_oleh'],'name') ?></b><br>
                                    <span style="display:inline-block; width:100px;">Tgl buat</span> : <b><?= tgl_indo($header['tgl_buat']) ?></b><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mt-1">
                            <a href="<?= base_url() . 'sublok/scandata/'.$header['id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                        </div>
                        <div class="mt-1 text-right">
                            <a href="<?= base_url() . 'sublok' ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
                        </div>
                    </div>
                    <div class="mt-2" style="overflow: auto;">
                        <table id="pbtabel" class="table nowrap order-column table-hover table-bordered" style="width: 100% !important;">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Specific</th>
                                <th>Lot no</th>
                                <th>Pcs</th>
                                <th>Kgs</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php if($data->num_rows() > 0): ?>
                                    <?php $no=1; foreach($data->result_array() as $dt): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= tglmysql($dt['tgl']) ?></td>
                                            <td><a href="#" class="font-bold"><?= $dt['nomor'] ?></a></td>
                                            <td class="text-pink"><?= rupiah($dt['pcs'],0).' Pcs, '.rupiah($dt['kgs'],2).' Kgs' ?></td>
                                            <td class="line-12 font-kecil text-azure"><span><?= datauser($dt['dibuat_oleh'],'name') ?></span><br><span><?= tglmysql2($dt['tgl_buat']) ?></span></td>
                                            <td></td>
                                            <td class="text-center">
                                                <a href="<?= base_url().'sublok/inputdata/'.$dt['id'] ?>" class="btn btn-sm btn-blue">Lanjutkan Transaksi</a>
                                                <a href="#" data-href="<?= base_url().'sublok/hapusdata/'.$dt['id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini (<?= $dt['nomor'] ?>)">Hapus Data</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center"> Data Kosong</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>