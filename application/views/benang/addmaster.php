<form action="<?php echo base_url('benang/simpan_master'); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kode</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $kode; ?>" readonly>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Nama Barang</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Alias</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="nama_alias" id="nama_alias" placeholder="Nama Alias">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Warna</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="warna" id="warna" placeholder="Warna Benang">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Lokasi Rak</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="lokasi_rak" id="lokasi_rak" placeholder="Lokasi Rak">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kategori</label>
            <div class="col">
                <select class="form-select font-kecil" id="id_kategori" name="id_kategori">
                    <option value="">--Pilih Kategori--</option>
                    <?php foreach ($itemkategori as $kategori) { ?>
                        <option value="<?= $kategori['kategori_id']; ?>"><?= '[' . $kategori['kategori_id'] . '] ' . $kategori['nama_kategori']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Satuan</label>
            <div class="col">
                <select class="form-select font-kecil" id="id_satuan" name="id_satuan">
                    <option value="">--Pilih Satuan--</option>
                    <?php foreach ($itemsatuan->result_array() as $satuan) { ?>
                        <option value="<?= $satuan['id']; ?>"><?= '[' . $satuan['kodesatuan'] . '] ' . $satuan['namasatuan']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    </div>
    <div class="col-5">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>