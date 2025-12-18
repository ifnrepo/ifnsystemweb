<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Price Division
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'jobcostdiv/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data Supplier"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1 text-right font-kecil">
                        <a href="<?= base_url() . 'jobcostdiv/cetakexcel'; ?>" class="btn btn-success btn-sm ml-2"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                        <a href="<?= base_url() . 'jobcostdiv/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm hilang"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                    </div>
                </div>
                <div id="table-default">
                    <table class="table datatable table-hover" class="w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Aktif</th>
                                <th>Spinning</th>
                                <th>Ringrope</th>
                                <th>Netting</th>
                                <th>Senshoku</th>
                                <th>Hoshu1</th>
                                <th>Koatsu</th>
                                <th>Hoshu2</th>
                                <th>Packing</th>
                                <th>Shitate</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($data->result_array() as $key) : $no++;
                            $warna = $key['aktif']==0 ? 'bg-red-lt' : '';
                            ?>
                                <tr class="<?= $warna ?>">
                                    <td class="text-black"><?= $no; ?></td>
                                    <td class="text-black"><?= $key['tahun']; ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($key['aktif'] == 1) : ?>
                                            <i class="fa fa-check text-success"></i>
                                        <?php else : ?>
                                            <i class="fa fa-times text-danger"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="font-kecil text-right text-black"><?= $key['sp']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['nt']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['rr']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['sn']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['h1']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['ko']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['h2']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['pa']; ?></td>
                                    <td class="font-kecil text-right text-black"><?= $key['sh']; ?></td>
                                    <td>
                                        <div class="btn-group font-kecil" role="group">
                                            <label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </label>
                                            <div class="dropdown-menu">
                                                <label class="dropdown-item p-1">
                                                    <a href="<?= base_url() . 'jobcostdiv/editdata/' . $key['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Cost Div" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="<?= $key['id']; ?>" title="Edit data">
                                                        <i class="fa fa-edit pr-1"></i> Edit Data
                                                    </a>
                                                </label>
                                                <label class="dropdown-item p-1">
                                                    <a class="btn btn-sm btn-danger btn-icon text-white w-100" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'jobcostdiv/hapusdata/' . $key['id']; ?>" title="Hapus data">
                                                        <i class="fa fa-trash-o pr-1"></i> Hapus Data
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
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