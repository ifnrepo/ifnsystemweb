<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen Asal</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_idx" id="dept_idx" placeholder="Id Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen Tujuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" placeholder="Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tgl Transaksi</label>
                <div class="col">
                  <select name="katedept_id" id="katedept_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($katedept as $a) : ?>
                      <option value="<?= $a['id']; ?>"><?= $a['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success text-black" id="simpandept">Mulai Transaksi</button>
</div>
<script>
    $(document).ready(function(){
        $("#dept_idx").val($("#dept_kirim").attr('rel'));
        $("#departemen").val($("#id_dept").val());
    })
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