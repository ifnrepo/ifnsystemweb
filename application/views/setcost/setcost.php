<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Setting Cost Departemen
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'setcost/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1 font-kecil">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex">
                                    <span class="px-1">
                                        <label class="form-label font-kecil mb-1 font-bold">Departemen</label>
                                        <div>
                                            <select class="form-select form-control form-sm font-kecil font-bold" id="dept" name="dept">
                                            <option value="">-- Semua --</option>
                                            <?php foreach($departemen->result_array() as $dept){ $selek = $this->session->userdata('currdeptcost')==$dept['dept_id'] ? 'selected' : ''; ?>
                                                <option value="<?= $dept['dept_id'] ?>" <?= $selek ?>><?= $dept['departemen'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </span>
                                    <span class="px-1">
                                        <label class="form-label font-kecil mb-1 font-bold">Kategori barang</label>
                                        <div>
                                            <select class="form-select form-control form-sm font-kecil font-bold" id="kategcost" name="kategcost">
                                            <option value="">-- Semua --</option>
                                            <?php foreach($kategori->result_array() as $dept){ $selek = $this->session->userdata('currkategcost')==$dept['kategori_id'] ? 'selected' : ''; ?>
                                                <option value="<?= $dept['kategori_id'] ?>" <?= $selek ?>><?= $dept['nama_kategori'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </span>
                                    <span class="px-1">
                                        <h4 class="mb-0 font-kecil" style="color: #FFFFFF">.</h4>
                                        <span class="font-kecil">
                                            <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                                        </span>
                                    </span>
                                    <span class="px-1"></span>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="d-flex justify-content-end my-auto">
                                    <span class="px-1 d-inline">
                                        <a href="<?= base_url() . 'setcost/cetakexcel'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                                        <a href="<?= base_url() . 'jobcostdiv/cetakpdf'; ?>" target="_blank" class="btn btn-danger btn-sm hilang"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="table-default">
                    <table class="table datatable table-hover table-bordered cell-border" style="width: 100% !important;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Departemen</th>
                                <?php if($this->session->userdata('currdeptcost')=='FN'){ ?>
                                    <th class="text-center">Sublok</th>
                                <?php }else if($this->session->userdata('currdeptcost')=='GW'){ ?>
                                    <th class="text-center">Asal Ws</th>
                                <?php } ?>
                                <th>Kategori</th>
                                <th>SP</th>
                                <th>RR</th>
                                <th>NT</th>
                                <th>SEN</th>
                                <th>HO1</th>
                                <th>KOA</th>
                                <th>HO2</th>
                                <th>PAK</th>
                                <th>SHI</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($data->result_array() as $key) : $no++;
                            ?>
                                <tr class="font-kecil">
                                    <td class="text-black"><?= $no; ?></td>
                                    <td class="text-black"><?= $key['departemen']; ?></td>
                                    <?php if($this->session->userdata('currdeptcost')=='FN'){ ?>
                                    <td class="text-black text-center"><?= $key['sublok']; ?></td>
                                    <?php }else if($this->session->userdata('currdeptcost')=='GW'){ ?>
                                        <td class="text-black text-center"><?= $key['asal']; ?></td>
                                    <?php } ?>
                                    <td class="font-kecil text-black"><?= $key['nama_kategori']; ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($key['sp'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['rr'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['nt'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['sn'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['h1'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;" title="KOATSU">
                                        <?php if ($key['ko'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['h2'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['pa'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($key['sh'] == 1) : ?>
                                            <i class="fa fa-check text-primary"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href='<?= base_url().'setcost/editdata/'.$key['id'] ?>' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Edit Data' style='padding: 2px 3px !important' title="Edit Data"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-href='<?= base_url().'setcost/hapusdata/'.$key['id'] ?>' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modal-danger' data-tombol='Ya' data-message='Akan menghapus data' style='padding: 2px 3px !important' title="Hapus Data"><i class="fa fa-trash-o"></i></a>
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