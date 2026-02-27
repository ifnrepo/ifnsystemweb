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
                  Data alur barang
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
                    <div class="row mb-1 d-flex align-items-between">
                        <div class="col-sm-6 col-12 mt-1">
                            <div class="mb-0 d-flex">
                                <span class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Dept</label>
                                    <div class="col mr-1">
                                        <select class="form-select form-control form-sm font-kecil font-bold mr-1" id="deptsublok" name="deptsublok">
                                            <option value="">-- Pilih Dept --</option>
                                            <?php foreach($deptlokasi->result_array() as $dept): $selek = $this->session->userdata('deptsublok')==$dept['dept_id'] ? 'selected' : ''; ?>
                                                <option value="<?= $dept['dept_id'] ?>" <?= $selek ?>><?= $dept['departemen'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </span>
                                <a href="#" class="btn btn-primary btn-sm" id="butgo" style="height: 38px;min-width:45px;"><span class="ml-0">Go</span></a>
                                <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 mt-1">
                            <div class="d-flex flex-row-reverse">
                                <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="thsublok" name="thsublok" style="width: 75px;" value="<?= $this->session->userdata('thsublok') ?>">
                                <select class="form-select form-control form-sm font-kecil font-bold mr-1" id="blsublok" name="blsublok" style="width: 100px;" <?= $levnow; ?>>
                                    <?php for ($x = 1; $x <= 12; $x++) : ?>
                                    <option value="<?= $x; ?>" <?php if ($this->session->userdata('blsublok') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card card-active" style="clear:both;">
                        <div class="card-body p-2 font-kecil">
                            <div class="row">
                                <div class="col-sm-3 col-12">
                                    <h4 class="mb-1 font-kecil">Sub-lokasi <?= $this->session->userdata('sublokasi') ?></h4>
                                    <span class="font-kecil">
                                        <div class="font-kecil">
                                        <select class="form-select form-control form-sm font-kecil font-bold" id="sublokasi" name="sublokasi">
                                            <option value="">-- Pilih sublokasi --</option>
                                            <?php foreach ($lokasi->result_array() as $lok): ?>
                                                <option value="<?= $lok['id']; ?>" <?php if($this->session->userdata('sublokasi') == $lok['id']){ echo "selected"; } ?>><?= $lok['kode_lokasi'].'-'.$lok['nama_lokasi'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-1 font-kecil" style="color: #FFFFFF">.</h4>
                                    <span class="font-kecil">
                                        <a href="<?= base_url().'sublok/adddata' ?>" class="btn btn-sm btn-info" style="height: 38px;min-width:45px;" id="adddata"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                                    </span>
                                </div>
                                    <!-- <div class="col-3" style="font-size: 13px;">
                                    <div class="text-blue font-bold mt-2 ">Jumlah Rec : </div>
                                    <div class="text-blue font-bold">Jumlah Pcs : </div>
                                    <div class="text-blue font-bold">Jumlah Kgs : </div> -->
                                </div>
                                <div class="col-2">
                                    <!-- <h4 class="mb-1">
                                        <small class="text-pink text-center">Tekan <b>GO</b> untuk mengaktifkan Tombol Tambah Data dan Load Data</small>
                                    </h4> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2" style="overflow: auto;">
                        <table id="pbtabel" class="table nowrap order-column table-hover table-bordered" style="width: 100% !important;">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl</th>
                                <th>Nomor</th>
                                <th>Jumlah Item</th>
                                <th>Dibuat Oleh</th>
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
                                            <td><?= $dt['nomor'] ?></td>
                                            <td class="text-pink"><?= rupiah($dt['pcs'],0).' Pcs, '.rupiah($dt['kgs'],2).' Kgs' ?></td>
                                            <td class="line-12 font-kecil text-azure"><span><?= datauser($dt['dibuat_oleh'],'name') ?></span><br><span><?= tglmysql2($dt['tgl_buat']) ?></span></td>
                                            <td></td>
                                            <td class="text-center">
                                                AKSI
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center"> Data Kosong</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>