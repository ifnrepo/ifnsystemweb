<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Status</label>
                <div class="col">
                    <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="nama_status" id="nama_status" value="<?= $data['nama_status']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatedata">Update</button>
</div>
<script>
    $("#updatedata").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'status/update',
            data: {
                nama_status: $("#nama_status").val(),
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