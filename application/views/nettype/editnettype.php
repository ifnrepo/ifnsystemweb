<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Net Type</label>
                <div class="col">
                    <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="name_nettype" id="name_nettype" value="<?= $data['name_nettype']; ?>">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col">
                    <select name="id_kategori" id="id_kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori as $a) : ?>
                            <?php if ($a['kategori_id'] == $data['id_kategori']) : ?>
                                <option value="<?= $a['kategori_id']; ?>" selected><?= $a['nama_kategori']; ?></option>
                            <?php else : ?>
                                <option value="<?= $a['kategori_id']; ?>"><?= $a['nama_kategori']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label requered">Grup</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="grup" id="grup" value="<?= $data['grup']; ?>">
                </div>
            </div>

            <div class="mb-1 row">
                <label for="label" class="col-3 col-form-label required">Kode Grup</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode_grup" id="kode_grup" value="<?= $data['kode_grup']; ?>">
                </div>
            </div>

            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="nommsq" name="nommsq" type="checkbox" <?php if ($data['nommsq'] == 1) echo 'checked'; ?>>
                        <span class="form-check-label">NOMMSQ</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="nopack" name="nopack" type="checkbox" <?php if ($data['nopack'] == 1) echo 'checked'; ?>>
                        <span class="form-check-label">NOPACK</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="xmin" name="xmin" type="checkbox" <?php if ($data['xmin'] == 1) echo 'checked'; ?>>
                        <span class="form-check-label">XMIN</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="isimmsq" name="isimmsq" type="checkbox" <?php if ($data['isimmsq'] == 1) echo 'checked'; ?>>
                        <span class="form-check-label">ISIMMSQ</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatenettype">Update</button>
</div>
<script>
    $("#updatenettype").click(function() {
        var nommsq = $("#nommsq").prop('checked') ? 1 : 0;
        var nopack = $("#nopack").prop('checked') ? 1 : 0;
        var xmin = $("#xmin").prop('checked') ? 1 : 0;
        var isimmsq = $("#isimmsq").prop('checked') ? 1 : 0;
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'nettype/updatenettype',
            data: {
                name_nettype: $("#name_nettype").val(),
                id_kategori: $("#id_kategori").val(),
                grup: $("#grup").val(),
                kode_grup: $("#kode_grup").val(),
                nommsq: nommsq,
                nopack: nopack,
                xmin: xmin,
                isimmsq: isimmsq,
                id: $("#id").val()
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