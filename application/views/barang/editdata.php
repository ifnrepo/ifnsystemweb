<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Edit Barang
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'barang'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <!-- <div class="card-header font-bold text-primary">
                <?= $data['nama_barang']; ?><br>
                <?= $this->session->set_flashdata('ketlain'); ?>
                <?= $this->session->set_flashdata('msg'); ?>
            </div> -->
            <div class="card-body font-kecil">
                <div class="row">
                    <div class="col-4">
                        <div class="bg-blue-lt p-1">
                            <?php
                            $path = 'assets/image/dokbar/';
                            $foto = (empty(trim($data['filefoto'])) || !file_exists(FCPATH . $path . $data['filefoto']))
                                ? $path . 'image.jpg'
                                : $path . $data['filefoto'];
                            $foto_url = base_url($foto) . '?t=' . time();
                            ?>
                            <img src="<?= $foto_url; ?>" alt="Foto" style="width: 100%;" id="gbimage">
                        </div>
                        <div class="text-center">
                            <form name="formFoto" id="formFoto" action="<?= $actionfoto; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                                <hr class="m-1">
                                <div>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control group-control" id="file_path" name="file_path">
                                        <input type="file" class="hilang" accept="image/*" id="file" name="file" onchange="loadFile(event)">
                                        <input type="hidden" name="old_logo" value="<?= $data['filefoto'] ?>">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-info btn-flat" id="file_browser"><i class="fa fa-search mr-1"></i> Get Foto</button>
                                <button type="submit" class="btn btn-sm btn-danger btn-flat disabled" id="okesubmit"><i class="fa fa-check mr-1"></i> Update Foto</button>
                            </form>
                        </div>

                        <hr class="m-2">
                    </div>
                    <div class="col-8">
                        <form name="formkolom" id="formkolom" action="<?= $actionkolom; ?>" method="post">
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Kode</label>
                                <div class="col">
                                    <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                                    <input type="text" style="color: blue;" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Nama Barang</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?= $data['nama_barang']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Ukuran</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="ukuran" id="ukuran" placeholder="Ukuran" value="<?= $data['ukuran']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Tipe</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="tipe" id="tipe" placeholder="Tipe" value="<?= $data['tipe']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Merek</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="merek" id="merek" placeholder="Merek" value="<?= $data['merek']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Alias</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nama_alias" id="nama_alias" placeholder="Nama Alias" value="<?= $data['nama_alias']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Kategori</label>
                                <div class="col">
                                    <select class="form-select font-kecil" id="id_kategori" name="id_kategori">
                                        <option value="">--Pilih Kategori--</option>
                                        <?php foreach ($itemkategori as $kategori) {
                                            $selek = $kategori['kategori_id'] == $data['id_kategori'] ? 'selected' : ''; ?>
                                            <option value="<?= $kategori['kategori_id']; ?>" <?= $selek; ?>><?= '[' . $kategori['kategori_id'] . '] ' . $kategori['nama_kategori']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Safety Stock</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="safety_stock" id="safety_stock" value="<?= $data['safety_stock']; ?>">
                                </div>
                            </div>
                            <div class=" mb-1 row">
                                <label class="col-3 col-form-label required">Satuan</label>
                                <div class="col">
                                    <select class="form-select font-kecil" id="id_satuan" name="id_satuan">
                                        <option value="">--Pilih Satuan--</option>
                                        <?php foreach ($itemsatuan->result_array() as $satuan) {
                                            $selek = $satuan['id'] == $data['id_satuan'] ? 'selected' : ''; ?>
                                            <option value="<?= $satuan['id']; ?>" <?= $selek; ?>><?= '[' . $satuan['kodesatuan'] . '] ' . $satuan['namasatuan']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">No Hs</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nohs" id="nohs" value="<?= $data['nohs']; ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label class="col-3 col-form-label pt-0"></label>
                                <div class="col">
                                    <label class="form-check">
                                        <input class="form-check-input" id="dln" name="dln" type="checkbox" <?php if ($data['dln'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                        <span class="form-check-label">DLN</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label class="col-3 col-form-label pt-0"></label>
                                <div class="col">
                                    <label class="form-check">
                                        <input class="form-check-input" id="noinv" name="noinv" type="checkbox" <?php if ($data['noinv'] == 1) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                        <span class="form-check-label">No INV</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label class="col-3 col-form-label pt-0"></label>
                                <div class="col">
                                    <label class="form-check">
                                        <input class="form-check-input" id="act" name="act" type="checkbox" <?php if ($data['act'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                        <span class="form-check-label">Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <hr class="m-1">
            <div class="d-flex justify-content-beetwen p-3">
                <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">.</button>
                <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
                <a class="btn btn-sm btn-primary" style="color: white;" id="simpandata">Simpan Perubahan </a>
            </div>
        </div>
    </div>
</div>