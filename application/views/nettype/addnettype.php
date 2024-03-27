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
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpannettype">Simpan</button>
</div>
<script>
    $("#simpannettype").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'nettype/simpannettype',
            data: {
                name_nettype: $("#name_nettype").val(),
                id_kategori: $("#id_kategori").val(),
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