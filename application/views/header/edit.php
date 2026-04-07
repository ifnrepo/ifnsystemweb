<div class="container-xl">
    <div class="row m-0">
        <div class="col-12">
            <div class="mb-1 row">
                <input type="text" id="id" value="<?= $data['id'] ?>" class="hilang">
                <label class="col-3 col-form-label font-kecil">Kode</label>
                <div class="col">
                    <select name="kode" id="kode" class="form-control form-select font-kecil btn-flat font-bold">
                        <option value="greeting">Greeting</option>
                    </select>
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label font-kecil">Option</label>
                <div class="col">
                    <select name="mode" id="mode" class="form-control form-select font-kecil btn-flat font-bold">
                        <option value="pagi" <?= $data['mode']=='pagi' ? 'selected' : '' ?>>Pagi</option>
                        <option value="siang" <?= $data['mode']=='siang' ? 'selected' : '' ?>>Siang</option>
                        <option value="malam" <?= $data['mode']=='malam' ? 'selected' : '' ?>>Malam</option>
                    </select>
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label font-kecil">Pesan</label>
                <div class="col"> 
                    <textarea name="pesan" id="pesan" rows="5" class="form-control font-kecil"><?= trim($data['pesan']) ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-sm btn-primary" id="simpandata">Update Data</button>
</div>
<script>
    $("#simpandata").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'header/update',
            data: {
                kode: $("#kode").val(),
                mode: $("#mode").val(),
                pesan: $("#pesan").val(),
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