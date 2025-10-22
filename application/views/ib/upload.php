<form action="<?php echo base_url('ib/simpan_upload/' . $id); ?>" method="post" enctype="multipart/form-data">
    <!-- <div class="col-12">
        <label for="nama_event" class="form-label font-kecil">Nama Event</label>
        <input type="hidden" name="id_rd_event" class="form-control font-kecil" value="<?= $id; ?>" required>
        <input type="text" name="nama_event" class="form-control font-kecil" id="nama_event" required>
    </div>
    -->
    <div class="col-12">
        <input type="hidden" name="id" id="id" class="form-control font-kecil" value="<?= $id; ?>">
        <label for="file_upload" class="form-label font-kecil">Upload File (Gambar, Foto, Video)</label>
        <input type="file" name="file_upload[]" class="form-control font-kecil" id="file_upload" accept=".pdf,.xls,.xlsx,.jpg,.jpeg,.png,.mp4" multiple>
    </div>



    <br>

    <div class="col-4">
        <button class="btn btn-success w-100" type="submit">Simpan</button>
    </div>

</form>