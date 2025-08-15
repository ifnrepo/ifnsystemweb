<form action="<?php echo base_url('benang/simpandata'); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Nama Rak</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="lokasi_rak" id="lokasi_rak" placeholder="Nama Rak">
            </div>
        </div>
    </div>
    <br>
    <div class="col-5">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>