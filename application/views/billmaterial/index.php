<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Master Data Bill Of Material
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'billmaterial/tambahdata'; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                        <div class="text-left float-left">
                            <div class="row">
                                <label class="col-3 col-form-label font-kecil font-bold">Cari SKU</label>
                                <div class="col mb-1">
                                    <div class="input-group mb-0">
                                        <?php $textcari = $this->session->userdata('katcari') != null ? $this->session->userdata('katcari') : ''; ?>
                                        <input type="text" class="form-control form-sm font-kecil" placeholder="Cari…" value="<?= $textcari; ?>" id="textcari" style="text-transform: uppercase; height: 38px;">
                                        <button class="btn btn-primary text-center font-kecil" type="button" id="buttoncari" style="height: 38px;">
                                        Cari
                                        </button>
                                        <a href="#" class="btn btn-sm btn-danger" id="kosongkankatcari">Kosongkan</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="text-right float-right">
                        <a href="<?= base_url() . 'kategori/excel'; ?>" class="btn btn-success btn-sm hilang"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                        <a href="<?= base_url() . 'kategori/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm hilang"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                        </div>
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table datatableaslitanpasearch">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Spesifikasi</th>
                                <th>Insno</th>
                                <th>Nobontr</th>
                                <th>Bale</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                                foreach ($material->result_array() as $key) : $no++; 
                                $sku = trim($key['po'])=='' ? $key['kode'] : viewsku($key['po'],$key['item'],$key['dis'],$key['id_barang']);
                                $namaspek = trim($key['po'])=='' ? namaspekbarang($key['id_barang']) : spekpo($key['po'],$key['item'],$key['dis']);
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td class="text-primary"><a href="<?= base_url() . 'billmaterial/view/' . $key['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View Data" rel="<?= $key['id']; ?>" title="Edit data"><?= $sku; ?></a></td>
                                    <td><?= $namaspek; ?></td>
                                    <td><?= $key['insno']; ?></td>
                                    <td><?= $key['nobontr']; ?></td>
                                    <td><?= $key['nobale']; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url() . 'billmaterial/edit/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white m-0 mr-0" id="editkategori" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white m-0" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'billmaterial/hapus/' . $key['id']; ?>" title="Hapus data">
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
    </div>
</div>