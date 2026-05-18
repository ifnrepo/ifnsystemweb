<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <div class="page-pretitle pl-2">
                    Entry Data Periode <?= $this->session->userdata('periodeopname') ?>
                </div>
                <h2 class="page-title px-2">
                    Stok Taking
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/addstok'; ?>" id="tambahstok" style="height: 38px;" class="btn btn-blue btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add periode Stok Opname"><span class="ml-1">Add Data Stok </span></a>
                <a href="<?= base_url() . 'opname/addsublokclear'; ?>" style="height: 38px;" class="btn btn-info btn-sm ml-1"><span class="ml-1">Add Sublok </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="card card-active mb-2">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Status</label>
                                    <div class="col mb-1">
                                        <select name="statusstok" id="statusstok" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                                            <option value="all">All</option>
                                            <option value="0" <?php if($this->session->userdata('statusstok')=='0'){ echo "selected"; } ?>>On Progress</option>
                                            <option value="1" <?php if($this->session->userdata('statusstok')=='1'){ echo "selected"; } ?>>Selesai</option>
                                            <option value="2" <?php if($this->session->userdata('statusstok')=='2'){ echo "selected"; } ?>>Verifikasi 1</option>
                                            <option value="3" <?php if($this->session->userdata('statusstok')=='3'){ echo "selected"; } ?>>Verifikasi 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Dept</label>
                                    <div class="col mb-1">
                                        <select name="deptstok" id="deptstok" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                                            <option value="">All</option>
                                            <?php 
                                                $dpt = $this->session->userdata('hakstokopname');
                                                $akses_so = str_split($dpt, 2);
                                             ?>
                                            <?php foreach ($datadept->result_array() as $dep) : ?>
                                                <?php if (in_array($dep['dept_id'], $akses_so)) : ?>
                                                    <option value="<?= $dep['dept_id'] ?>" <?php if($this->session->userdata('deptstok')==$dep['dept_id']){ echo "selected"; } ?>>
                                                        <?= $dep['departemen'] ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-4">
                                <?= cekperiodedaritgl($this->session->userdata('periodeopname')) ?>
                                <span class="font-kecil text-pink <?php if($this->session->userdata('periodeopname')!=''){ echo "hilang"; } ?>">Periode Stok Opname belum dipilih !</span>
                                <input type="text" name="periode" id="periode" class="hilang" value="<?= $this->session->userdata('periodeopname') ?>">
                                <textarea name="carisublok" id="carisublok" class="form-control"></textarea>
                                <a href="#" class="btn btn-sm btn-success form-control mt-1" id="carikodesublok">Cari</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row">
                    <?php foreach($data->result_array() as $dt): ?>
                    <!-- Start Modul -->    
                    <div class="col-3">
                        <div class="card btn-flat" style="border-color: black !important; border-style: dashed;">
                            <div class="card-body p-2">
                                <div class="row no-gutters">
                                    <div class="col-2 text-center">
                                        <span><h2 class="m-0"><?= $dt['dept_id'] ?></h2></span><span class="m-0"><?= $dt['kode_lokasi'] ?></span>
                                    </div>
                                    <div class="col-10 pl-1" style="border-left: 1px solid #bac2cb;">
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-yellow text-black mb-1" style="font-size: 0.625rem;">Edit</span>
                                            <div class="mr-1 font-kecil text-right"><h5 class="m-0"><?= $dt['nama_lokasi'] ?></h5></div>
                                        </div>
                                        <div class="line-12 mb-1">
                                            <?php $pcs = $dt['pcs']==0 ? '0' : rupiah($dt['pcs'],2); $kgs = $dt['kgs']==0 ? '0' : rupiah($dt['kgs'],2); ?>
                                            <div><?= $pcs ?> Pcs</div>
                                            <div><?= $kgs ?> Kgs</div>
                                        </div>
                                        <div class="m-0"><?= rupiah($dt['item'],0) ?> Item</div>
                                        <div class="line-12">
                                            <div style="font-size: 0.625rem;"><?= 'Last Edit: '.tglmysql2($dt['tgl_edit']) ?></div>
                                            <div style="font-size: 0.625rem;">-</div>
                                        </div>
                                        <hr class="m-1">
                                        <div class="d-flex justify-content-between mr-1">
                                            <a href="#" data-href="<?= base_url().'opname/hapusstok/'.$dt['id'] ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini">Hapus</a>
                                            <a href="<?= base_url().'opname/entristok/0/'.$dt['id'] ?>" class="btn btn-sm btn-outline-primary">Edit Data</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modul -->
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>