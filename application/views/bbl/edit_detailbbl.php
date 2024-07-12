<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    BBL (BON PEMBELIAN BARANG) # <?= $header['nomor_dok']; ?>
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'bbl'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div id="sisipkan">
                    <div class="mb-1">
                    </div>
                    <div class="card card-active" style="clear:both;">
                        <div class="card-body p-2 font-kecil">
                            <div class="row">
                                <div class="col-2 ">
                                    <h4 class="mb-0 font-kecil">Tgl</h4>
                                    <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($header['tgl']); ?>">
                                    <input type="text" id="id_header" class="hilang" value="<?= $header['id']; ?>">
                                    <input type="text" id="numdetail" class="hilang" value="<?= $numdetail; ?>">
                                    <span class="font-bold" style="font-size:15px;">
                                        <?= tglmysql($header['tgl']); ?>
                                        <a href="<?= base_url() . 'bbl/edittgl'; ?>" title="Edit tanggal" id="tglbbl" name="tglbbl" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </span>
                                </div>  
                                <div class="col-4">
                                    <h4 class="mb-0 font-kecil">Catatan</h4>
                                    <input type="text" id="catat" class="hilang" value="<?= $header['keterangan']; ?>">
                                    <span class="font-bold" style="font-size:15px;">
                                        <?= $header['keterangan']; ?>
                                        <a href="<?= base_url() . 'bbl/edittgl'; ?>" title="Edit Catatan" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1 <?php if($header['jn_bbl']==1){ echo "hilang"; } ?>">
                                        <div class="row">
                                        <div class="col-3 pt-2">Dept BBL</div>
                                        <div class="col-9">
                                            <select class="form-control form-select font-kecil" id="xdeptselect" <?php if((int)$numdetail > 0){echo "disabled"; } ?>>
                                            <option value="">Asal departemen</option>
                                            <?php foreach ($departemen as $dept) { $selek = $header['dept_bbl']==$dept['dept_id'] ? 'selected' : ''; ?>
                                                <option value="<?= $dept['dept_id']; ?>" <?= $selek; ?>><?= $dept['departemen']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <label class="form-check mb-0 <?php if($header['jn_bbl']==1){ echo "hilang"; } ?>">
                                        <input class="form-check-input" id="bbl_pp" type="checkbox" <?php if($header['bbl_pp']==1){echo "checked";} ?> <?php if($header['dept_id']=='GM'){echo "disabled"; } ?>>
                                        <span class="form-check-label">
                                        BBL Produksi (Persetujuan PPIC)
                                        </span>
                                    </label>
                                </div>
                                <div class="col-3">
                                    <?php if($header['jn_bbl']==0){  if($header['dept_bbl']!=''): ?>
                                        <a href="<?= base_url() . 'bbl/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" title="Cari Nomor PB" class="btn font-kecil bg-success text-white float-right" type="button">Get Permintaan !</a>
                                    <?php endif; }else{ ?>
                                        <a href="<?= base_url() . 'bbl/addbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" title="Cari Nomor PB" class="btn font-kecil bg-info text-white float-right" type="button">Get Barang !</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="text" id="id" name="id" value="" class="hilang">
                    <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $header['id']; ?>">
                    <div class="col-sm-12">
                        <div id="table-default" class="table-responsive font-kecil">
                            <table class="table datatable6 table-hover" id="cobasisip">
                                <thead style="background-color: blue !important">
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Nama Barang</th>
                                        <th class="text-left">Satuan</th>
                                        <th class="text-left">Jumlah</th>
                                        <th class="text-left">Kgs</th>
                                        <th class="text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                                    <?php $no = 0;
                                    foreach ($detail->result_array() as $key) : $no++; ?>
                                        <tr>
                                            <td class="text-left"><?= $no; ?></td>
                                            <td class="text-left" style="line-height:12px;"><?= $key['nama_barang']; ?><br><span style="font-size: 10px" class="text-primary"><?= $key['id_pb']; ?></span></td>
                                            <td class="text-left"><?= $key['namasatuan']; ?></td>
                                            <td class="text-right"><?= rupiah($key['pcs'], 0); ?></td>
                                            <td class="text-right"><?= rupiah($key['kgs'], 2); ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url() . 'bbl/editone_detail/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="Edit detail Bbl" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit detail Bbl" rel="<?= $key['id']; ?>" title="Edit data">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'bbl/hapusedit/' . $key['id']; ?>" title="Hapus data">
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
                <hr class="m-1">
                <div class="form-tombol mt-1 text-right">
                    <input type="text" id="jmlrek" class="hilang">
                    <a href="#" class="btn btn-sm btn-primary <?php if((int)$numdetail == 0){echo "disabled"; } ?>" id="simpanbbl" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'bbl/simpanbbl/' . $header['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>