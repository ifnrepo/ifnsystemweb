<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Id Kategori</label>
                <div class="col">
                    <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="kategori_id" id="kategori_id" value="<?= $data['kategori_id']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Kategori</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_kategori" id="nama_kategori" value="<?= $data['nama_kategori']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">No Urut</label>
                <div class="col">
                    <input type="number" class="form-control font-kecil" name="urut" id="urut" value="<?= $data['urut']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" value="<?= $data['kode']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Keterangan</label>
                <div class="col">
                    <textarea class="form-control font-kecil" name="ket" id="ket"><?= $data['ket']; ?></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jns</label>
                <div class="col">
                    <select class="form-select" name="jns" id="jns" aria-label="Default select example">
                        <option value="0" <?= ($data['jns'] == '0') ? 'selected' : ''; ?>>0</option>
                        <option value="1" <?= ($data['jns'] == '1') ? 'selected' : ''; ?>>1</option>
                        <option value="2" <?= ($data['jns'] == '2') ? 'selected' : ''; ?>>2</option>
                        <option value="3" <?= ($data['jns'] == '3') ? 'selected' : ''; ?>>3</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Net</label>
                <div class="col">
                    <select class="form-select" name="net" id="net" aria-label="Default select example">
                        <option value="0" <?= ($data['net'] == '0') ? 'selected' : ''; ?>>0</option>
                        <option value="1" <?= ($data['net'] == '1') ? 'selected' : ''; ?>>1</option>
                        <option value="2" <?= ($data['net'] == '2') ? 'selected' : ''; ?>>2</option>
                        <option value="3" <?= ($data['net'] == '3') ? 'selected' : ''; ?>>3</option>
                    </select>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatekategori">Update</button>
</div>
<script>
    $("#updatekategori").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'kategori/updatekategori',
            data: {
                kategori_id: $("#kategori_id").val(),
                nama_kategori: $("#nama_kategori").val(),
                urut: $("#urut").val(),
                kode: $("#kode").val(),
                ket: $("#ket").val(),
                jns: $("#jns").val(),
                net: $("#net").val(),
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