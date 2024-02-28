<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Dept</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" value="<?= $data['dept_id']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Dept</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" value="<?= $data['departemen']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatedept">Update</button>
</div>
<script>
    $("#updatedept").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'dept/updatedept',
            data: {
                dept_id: $("#dept_id").val(),
                departemen: $("#departemen").val(),
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