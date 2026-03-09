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
                  Input Data dengan QR CODE
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
                                    <span style="display:inline-block; width:100px;">Tgl buat</span> : <b><?= tglmysql2($header['tgl_buat']) ?></b><br>
                                    <span style="display:inline-block; width:100px;">Pcs</span> : <b><span class="text-pink"><?= rupiah($header['pcs'],0) ?></span></b><br>
                                    <span style="display:inline-block; width:100px;">Kgs</span> : <b><span class="text-pink"><?= rupiah($header['kgs'],2) ?></span></b><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mt-1">
                            <a href="<?= base_url() . 'sublok/scandata/'.$header['id']; ?>" class="btn btn-primary btn-square" style="height: 32px !important; font-size: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-computer-camera"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M8 16l-2.091 3.486a1 1 0 0 0 .857 1.514h10.468a1 1 0 0 0 .857 -1.514l-2.091 -3.486" /></svg>    
                            <span class="ml-0">Tambah Data</span></a>
                            <a href="#" data-href="<?= base_url() . 'sublok/simpandata/'.$header['id']; ?>" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Simpan transaksi ini"    ><i class="fa fa-save"></i><span class="ml-1">Simpan Data</span></a>
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
                                <th>Insno</th>
                                <th>Lot</th>
                                <th>Pcs</th>
                                <th>Kgs</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php if($data->num_rows() > 0): ?>
                                    <?php $no=1; foreach($data->result_array() as $dt): ?>
                                    <?php $sku = viewsku($dt['po'],$dt['item'],$dt['dis']); ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $sku ?></td>
                                            <td class="text-primary"><?= spekpo($dt['po'],$dt['item'],$dt['dis']); ?></td>
                                            <td><?= $dt['insno'] ?></td>
                                            <td class="text-center"><?= tambahnol($dt['lot'],2).'-'.tambahnol($dt['jalur'],2) ?></td>
                                            <td class="text-right"><?= rupiah($dt['pcs'],0) ?></td>
                                            <td class="text-right"><?= rupiah($dt['kgs'],2) ?></td>
                                            <td></td>
                                            <td class="text-center">
                                                <a href="#" data-href="<?= base_url().'sublok/hapusinputdata/'.$dt['id'].'/'.$dt['id_inputsublokasi'] ?>" class="btn btn-sm btn-danger" style="height: 28px !important" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini">Hapus Data</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>