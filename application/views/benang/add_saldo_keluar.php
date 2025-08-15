<form action="<?php echo base_url('benang/simpansaldo_keluar/' . $tb_detail_id . '/' . $id_barang); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Tanggal</label>
            <div class="col">
                <input type="date" class="form-control font-kecil" name="tanggal" id="tanggal" value="<?= $tgl_sekarang; ?>">
                <input type="hidden" class="form-control font-kecil" name="tb_detail_id" id="tb_detail_id" value="<?= $tb_detail_id; ?>">
                <input type="hidden" class="form-control font-kecil" name="id_barang" id="id_barang" value="<?= $id_barang; ?>">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Jam</label>
            <div class="col">
                <input type="time" class="form-control font-kecil" name="jam" id="jam" value="<?= $jam_sekarang; ?>">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Jumlah Berat Masuk (Kgs)</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="jumlah" id="jumlah" placeholder="Jumlah Berat (kgs)">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Keterangan</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Keterangan">
            </div>
        </div>
    </div>
    <br>
    <div class="col-5">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>