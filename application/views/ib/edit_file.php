<form action="<?php echo base_url('ib/edit_upload/' . $id); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <span style="font-size: 11px; color:red;"> 📌 Ceklis <i class="bi bi-patch-check"></i> Untuk menghapus file.</span><br>
        <label class="form-label font-kecil">File Tersedia:</label><br>
        <?php
        if (!empty($detail['file'])) {
            $files = json_decode($detail['file'], true);
            foreach ($files as $index => $file) {
                echo '<div class="form-check mb-1">';
                echo '<input class="form-check-input" type="checkbox" name="hapus_file[]" value="' . htmlspecialchars($file) . '" id="hapusFile' . $index . '">';
                echo '<label class="form-check-label me-2" for="hapusFile' . $index . '">';
                echo '<a href="' . base_url('assets/image/akb/' . $file) . '" target="_blank">' . htmlspecialchars($file) . '</a>';
                echo '</label>';
                echo '<input type="text" name="rename_file[]" class="form-control form-control-sm d-inline-block" style="width: 350px; " placeholder="Rename File ..." />';
                echo '<input type="hidden" name="nama_file_asli[]" value="' . htmlspecialchars($file) . '">';
                echo '</div>';
            }
        } else {
            echo "<small>Tidak ada file.</small>";
        }
        ?>
    </div>

    <div class="col-12">
        <label for="file_upload" class="form-label font-kecil">Upload File Baru</label>
        <input type="file" name="file_upload[]" class="form-control font-kecil" id="file_upload" multiple>

    </div>

    <br>
    <div class="col-12" style="text-align: right;">
        <button class="btn btn-primary w-100" type="submit">Update</button>
    </div>
</form>