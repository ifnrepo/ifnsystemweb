<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" placeholder="Id Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" placeholder="Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori Dept</label>
                <div class="col">
                  <select name="katedept_id" id="katedept_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($katedept as $a) : ?>
                      <option value="<?= $a['id']; ?>"><?= $a['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div class="hr m-0"></div>
            <div class="mt-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="pb" id="pb" type="checkbox" >
                        <span class="form-check-label">Bon Permintaan Barang / <strong>PB</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="bbl" id="bbl" type="checkbox" >
                        <span class="form-check-label">Bon Pembelian Barang / <strong>BBL</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="adj" id="adj" type="checkbox" >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpandept">Simpan</button>
</div>
<script>
    $("#simpandept").click(function() {
        var cekpb = $("#pb").prop('checked') ? '1' : '0';
        var cekbbl = $("#bbl").prop('checked') ? '1' : '0';
        var cekadj = $("#adj").prop('checked') ? '1' : '0';
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'dept/simpandept',
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