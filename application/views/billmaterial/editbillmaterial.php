<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Edit Data Bill Of Material
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'billmaterial'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                                    <div class="col">
                                        <?php $sku = trim($material['po'])=='' ? $material['kode'] : viewsku($material['po'],$material['item'],$material['dis']) ?>
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?= $sku ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Instruksi</label>
                                    <div class="col">
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?= $material['insno'] ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Nomor IB</label>
                                    <div class="col">
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?= $material['nobontr'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Spesific</label>
                                    <div class="col">
                                        <?php $nambar = trim($material['po'])=='' ? namaspekbarang($material['id_barang']) : spekpo($material['po'],$material['item'],$material['dis']) ?>
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?= $nambar ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">Nomor Bale</label>
                                    <div class="col-4">
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?=  $material['nobale'] ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil font-bold text-right">DLN</label>
                                    <div class="col-4">
                                        <?php $dl = $material['dl']==0 ? 'TIDAK' : 'YA'; ?>
                                        <input type="email" class="form-control input-sm font-kecil" aria-describedby="emailHelp" value="<?= $dl ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <h5 class="m-0">Add/Edit Data Detail</h5>
                                    <hr class="small m-1">
                                </div>
                                <div class="row font-kecil mb-0">
                                    <label class="col-2 col-form-label font-kecil">Spec</label>
                                    <div class="col input-group mb-1">  
                                        <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $material['id'] ?>">
                                        <input type="text" id="id_detail" name="id_detail" class="hilang" value="">
                                        <input type="text" id="id_barang" name="id_barang" class="hilang">
                                        <input type="text" class="form-control font-kecil" id="nama_barang" name="nama_barang" placeholder="Spec Barang">
                                        <a href="<?= base_url() . 'pb/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" class="btn font-kecil bg-success text-white" type="button">Cari!</a>
                                    </div>
                                </div>
                                <div class="row font-kecil mb-0 hilang" id="cont-spek">
                                    <label class="col-2 col-form-label font-kecil"></label>
                                    <div class="col input-group mb-1 text-teal" id="spekbarangnya"></div>
                                </div>
                                <div class="row font-kecil mb-1">
                                    <label class="col-2 col-form-label">Nobontr</label>
                                    <div class="col">
                                        <input type="text" id="nobontr" name="nobontr" class="form-control font-kecil">
                                    </div>
                                </div>
                                <div class="row font-kecil mb-1">
                                    <label class="col-2 col-form-label">Persen</label>
                                    <div class="col">
                                        <input type="text" id="persen" name="persen" class="form-control font-kecil inputangka text-right">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-sm btn-primary" style="width:100%" id="simpandetailbarang">Simpan Barang</a>
                                        <a href="#" class="btn btn-sm btn-success hilang" style="width:100%" id="updatedetailbarang">Update Barang</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-sm btn-danger" style="width:100%" id="resetdetailbarang">Reset Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div id="table-default" class="table-responsive">
                            <table class="table datatable6">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Nobontr</th>
                                        <th>Persen RM</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" style="font-size: 13px !important;">
                                    <?php $no=0; $jumlahpersen=0; foreach($detail->result_array() as $deta): $no++; $jumlahpersen += $deta['persen']; ?>
                                        <tr>
                                            <td><?= $deta['nama_barang'] ?></td>
                                            <td><?= $deta['nobontr'] ?></td>
                                            <td class="text-right"><?= rupiah($deta['persen'],6) ?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-primary btn-icon text-white" id="editdetailbillmaterial" rel="<?= $deta['id']; ?>" rel2="<?= $deta['id_barang']; ?>" rel3="<?= $deta['nobontr']; ?>" rel4="<?= $deta['persen']; ?>" rel5="<?= $deta['nama_barang']; ?>" title="Edit data">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusdetail" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'billmaterial/hapusdetail/'.$deta['id'].'/'.$material['id']  ?>" title="Hapus data">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <h4>Persentase <?= rupiah($jumlahpersen,2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>