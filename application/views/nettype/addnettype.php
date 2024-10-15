<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Net Type</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="name_nettype" id="name_nettype" placeholder="Net Type">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col">
                    <select name="id_kategori" id="id_kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori as $a) : ?>
                            <option value="<?= $a['kategori_id']; ?>"><?= $a['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label requered">Grup</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="grup" id="grup" placeholder="Grup">
                </div>
            </div>

            <div class="mb-1 row">
                <label for="label" class="col-3 col-form-label required">Kode Grup</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode_grup" id="kode_grup" placeholder="Kode rup">
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="nommsq" name="nommsq" type="checkbox">
                        <span class="form-check-label">NOMMSQ</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="nopack" name="nopack" type="checkbox">
                        <span class="form-check-label">NOPACK</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="xmin" name="xmin" type="checkbox">
                        <span class="form-check-label">XMIN</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="isimmsq" name="isimmsq" type="checkbox">
                        <span class="form-check-label">ISIMMSQ</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpannettype">Simpan</button>
</div>
<script>
    $("#simpannettype").click(function() {
        var nommsq = $("#nommsq").prop('checked') ? 1 : 0;
        var nopack = $("#nopack").prop('checked') ? 1 : 0;
        var xmin = $("#xmin").prop('checked') ? 1 : 0;
        var isimmsq = $("#isimmsq").prop('checked') ? 1 : 0;
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'nettype/simpannettype',
            data: {
                name_nettype: $("#name_nettype").val(),
                id_kategori: $("#id_kategori").val(),
                grup: $("#grup").val(),
                kode_grup: $("#kode_grup").val(),
                nommsq: nommsq,
                nopack: nopack,
                xmin: xmin,
                isimmsq: isimmsq
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