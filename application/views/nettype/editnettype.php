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
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatenettype">Update</button>
</div>
<script>
    $("#updatenettype").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'nettype/updatenettype',
            data: {
                name_nettype: $("#name_nettype").val(),
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