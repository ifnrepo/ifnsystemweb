<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-header d-print-none m-2">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            Jawab Hikiai
        </h2>
        <div class="col-md-6" style="text-align: right;">
            <a href="<?= base_url().'ponet' ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="card card-active">
                    <div class="card-body p-2">
                        <span class="font-kecil">
                            Filter Disini
                        </span>
                    </div>
                </div>
                <table id="tabelnya" class="table table-hover table-bordered cell-border mt-2 mb-0" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor</th>
                            <th>Nomor Hikiai</th>
                            <th>Customer</th>
                            <th>Perihal</th>
                            <th>Pcs</th>
                            <th>Kgs</th>
                            <!-- <th>Status</th> -->
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
                        <?php if($data->num_rows() > 0): ?>
                            <?php $no= ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; foreach($data->result_array() as $dt): $no++; ?>
                            <?php 
                                switch ($dt['status_hikiai']) {
                                    case 0:
                                        $strstat = 'Input Data';
                                        $badgestat = 'badge badge-outline text-dark';
                                        break;
                                    case 1:
                                        $strstat = 'Selesai Input';
                                        $badgestat = 'badge bg-blue text-blue-fg';
                                        break;
                                    case 2:
                                        $strstat = 'Kirim PPIC';
                                        $badgestat = 'badge badge-outline text-pink';
                                        break;
                                    case 3:
                                        $strstat = 'Hitung PPIC';
                                        $badgestat = 'badge bg-pink text-pink-fg';
                                        break;
                                    case 4:
                                        $strstat = 'Limit Diterima';
                                        $badgestat = 'badge bg-green text-green-fg';
                                        break;
                                    case 5:
                                        $strstat = 'Closed';
                                        $badgestat = 'badge';
                                        break;
                                    case 6:
                                        $strstat = 'Cancel';
                                        $badgestat = 'badge bg-red text-red-fg';
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                             ?>
                                <tr>
                                    <td class="text-center">#<?= $no ?></td>
                                    <td class="font-kecil line-11"><span class="text-pink font-10"><?= tglmysql($dt['tgl_hikiai']) ?></span><br><?= $dt['kode'] ?></td>
                                    <?php if($dt['status_hikiai']!=0): ?>
                                        <td class="font-kecil"><a href="<?= base_url().'ponet/viewdetailhikiai/'.$dt['id'] ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Hikiai"><?= $dt['nomor'] ?></a></td>
                                    <?php else: ?>
                                        <td class="font-kecil"><?= $dt['nomor'] ?></td>
                                    <?php endif; ?>
                                    <td class="font-kecil"><?= $dt['nama_customer'] ?></td>
                                    <td class="font-kecil"><?= $dt['perihal'] ?></td>
                                    <td class="text-end"><?= rupiah($dt['pcs'],0) ?></td>
                                    <td class="text-end"><?= rupiah($dt['kgs'],2) ?></td>
                                    <td class="font-kecil text-center">
                                        <?php if($dt['status_hikiai']==2): ?>
                                            <a href="#" data-href="<?= base_url().'ponet/terimahikiai/'.$dt['id'] ?>" class="btn btn-sm btn-success font-kecil" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menerima Hikiai Ini (data tidak bisa diubah Marketing)">Terima Hikiai</a>
                                        <?php else: ?>
                                            <a href="#" data-href="<?= base_url().'ponet/isiperkiraanhikiai/'.$dt['id'] ?>" class="btn btn-sm btn-primary font-kecil">Isi Hikiai</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center font-kecil">-- Tidak Ada Data --</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>