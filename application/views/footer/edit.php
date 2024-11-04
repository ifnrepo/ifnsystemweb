<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Footer Caption</label>
                <div class="col">
                    <input type="text" class="hilang" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="footer_caption" id="footer_caption" placeholder="Footer Caption" value="<?= $data['footer_caption']; ?>">
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label required">Url Caption</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="url_caption" id="url_caption" placeholder="Url Caption" value="<?= $data['url_caption']; ?>">
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label required">Url</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="url" id="url" placeholder="Url" value="<?= $data['url']; ?>">
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
            url: base_url + 'footer/update',
            data: {
                footer_caption: $("#footer_caption").val(),
                url_caption: $("#url_caption").val(),
                url: $("#url").val(),
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