<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <div class="page-pretitle pl-2">
                    Entry Data
                </div>
                <h2 class="page-title px-2">
                    Tambah Sublokasi
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/entrydata'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-4">
                        <div class="card card-active mb-2">
                            <div class="card-body p-2">
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Dept</label>
                                    <div class="col mb-1">
                                        <select name="deptsublok" id="deptsublok" style="height: 32px;" class="form-control form-select font-kecil py-1">
                                            <option value="">All</option>
                                            <?php 
                                                $dpt = $this->session->userdata('hakstokopname');
                                                $akses_so = str_split($dpt, 2);
                                                ?>
                                            <?php foreach ($datadept->result_array() as $dep) : ?>
                                                <?php if (in_array($dep['dept_id'], $akses_so)) : ?>
                                                    <option value="<?= $dep['dept_id'] ?>" <?php if($this->session->userdata('deptsublok')==$dep['dept_id']){ echo "selected"; } ?>>
                                                        <?= $dep['departemen'] ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Kode</label>
                                    <div class="col mb-1">
                                        <input type="text" id="idsublok" name="idsublok" class="hilang">
                                        <input type="text" name="kode_lokasi" id="kode_lokasi" class="form-control font-kecil" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Sublokasi</label>
                                    <div class="col mb-1">
                                        <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control font-kecil">
                                    </div>
                                </div>
                                <hr class="m-1">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-ghost-danger" id="batalsublok">Batal</a>
                                    <a href="#" class="btn btn-sm btn-success" id="tambahsublok">Tambah Sublok</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table table-bordered m-0 table-hover">
                            <thead class="bg-primary-lt">
                                <tr>
                                    <th class="text-center text-black">Departemen</th>
                                    <th class="text-center text-black">Kode</th>
                                    <th class="text-center text-black">Sublok</th>
                                    <th class="text-center text-black">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                <?php if($data->num_rows() > 0): ?>
                                    <?php foreach($data->result_array() as $dt): ?>
                                        <tr>
                                            <td class="font-kecil"><?= $dt['departemen'] ?></td>
                                            <td class="font-kecil"><?= $dt['kode_lokasi'] ?></td>
                                            <td class="font-kecil"><?= $dt['nama_lokasi'] ?></td>
                                            <td class="text-center">
                                                <a href="#" id="editsublok" rel="<?= $dt['id'] ?>" class="btn btn-sm btn-info" style="padding: 2px 6px !important">Edit</a>
                                                <a href="#" data-href="<?= base_url().'opname/hapussublok/'.$dt['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan hapus data <span class='font-bold'><?= $dt['nama_lokasi'] ?></span>" class="btn btn-sm btn-danger <?php if(isset($dt['pakai'])){ echo "disabled"; }?>" style="padding: 2px 6px !important">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">-- Pilih Departemen --</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>