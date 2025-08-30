<form action="<?php echo base_url('benang/update_in'); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Berat Terpakai</label>
            <div class="col">
                <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                <input type="text" name="id_barang" id="id_barang" class="hilang" value="<?= $data['id_barang']; ?>">
                <input type="text" name="id_header" id="id_header" class="hilang" value="<?= $data['id_header']; ?>">
                <input type="text" name="dept_id" id="dept_id" class="hilang" value="<?= $dept_id; ?>">
                <input type="text" name="tgl" id="tgl" class="hilang" value="<?= $tgl; ?>">
                <input type="text" class="form-control font-kecil" name="kgs" id="kgs">
            </div>
        </div>
    </div>
    <br>
    <div class="col-5">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form