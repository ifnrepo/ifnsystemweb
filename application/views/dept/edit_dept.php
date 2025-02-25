<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Dept</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" value="<?= $data['dept_id']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Dept</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" value="<?= $data['departemen']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori Dept</label>
                <div class="col">
                  <select name="katedept_id" id="katedept_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($katedept as $a) : $selek = $a['id']==$data['katedept_id'] ? 'Selected' : ''; ?>
                      <option value="<?= $a['id']; ?>" <?= $selek; ?>><?= $a['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="hr m-0"></div>
            <div class="mt-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="pb" id="pb" type="checkbox" <?php if($data['pb']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Permintaan Barang / <strong>PB</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="bbl" id="bbl" type="checkbox" <?php if($data['bbl']=='1'){ echo "checked"; } ?>>
                        <span class="form-check-label">Bon Pembelian Barang / <strong>BBL</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="adj" id="adj" type="checkbox" <?php if($data['adj']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="amb" id="amb" type="checkbox" <?php if($data['amb']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="akb" id="akb" type="checkbox" <?php if($data['akb']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatedept">Update</button>
</div>
<script>
    $("#updatedept").click(function() {
        var cekpb = $("#pb").prop('checked') ? '1' : '0';
        var cekbbl = $("#bbl").prop('checked') ? '1' : '0';
        var cekadj = $("#adj").prop('checked') ? '1' : '0';
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'dept/updatedept',
            data: {
                dept_id: $("#dept_id").val(),
                departemen: $("#departemen").val(),
                kat: $("#katedept_id").val(),
                pb: cekpb,
                bbl: cekbbl,
                adj: cekadj
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>