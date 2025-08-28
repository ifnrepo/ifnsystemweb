<form action="<?php echo base_url('benang/simpandata'); ?>" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Tgl Transaksi</label>
            <div class="col">
                <input type="hidden" class="form-control font-kecil" name="dept_id" id="dept_id" value="<?= $dept_id ?>">
                <input type="text" class="form-control font-kecil" name="tgl" id="tgl" placeholder="Tgl Transaksi" value="<?= date('d-m-Y'); ?>" readonly>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Departemen Tujuan</label>
            <div class="col">
                <select class="form-control form-select font-kecil" id="dept_tuju" name="dept_tuju" re>
                    <option value="AR" <?= ($dept_tuju == "AR") ? "selected" : "" ?>>ARROZA</option>
                    <option value="FN" <?= ($dept_tuju == "FN") ? "selected" : "" ?>>FINISHING</option>
                </select>
            </div>
        </div>

    </div>
    <br>
    <div class="col-12" style="text-align: right;">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Buat Transaksi</button>
    </div>
</form>