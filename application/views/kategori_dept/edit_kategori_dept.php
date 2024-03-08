<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Kategori</label>
                <div class="col">
                    <input type="hidden" class="form-control font-kecil" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="nama" id="nama" value="<?= $data['nama']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="update_kategdept">Update</button>
</div>
<script>
    $("#update_kategdept").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'kategori_dept/update_kategdept',
            data: {
                id: $("#id").val(),
                nama: $("#nama").val(),
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