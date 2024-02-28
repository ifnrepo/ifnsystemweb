<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" placeholder="Id Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" placeholder="Departemen">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpandept">Simpan</button>
</div>
<script>
    $("#simpandept").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'dept/simpandept',
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