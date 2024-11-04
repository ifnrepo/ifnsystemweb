<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Footer Caption</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="footer_caption" id="footer_caption" placeholder="Footer Caption">
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label required">Url Caption</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="url_caption" id="url_caption" placeholder="Url Caption">
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label required">Url</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="url" id="url" placeholder="Url">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpandata">Simpan</button>
</div>
<script>
    $("#simpandata").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'footer/simpandata',
            data: {
                footer_caption: $("#footer_caption").val(),
                url_caption: $("#url_caption").val(),
                url: $("#url").val(),
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