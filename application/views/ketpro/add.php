<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode">
                </div>
            </div>
            <div class=" mb-1 row">
                <label class="col-3 col-form-label required">Keterangan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="ket" id="ket" placeholder="Keterangan">
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
            url: base_url + 'ket_proses/simpandata',
            data: {
                kode: $("#kode").val(),
                ket: $("#ket").val(),
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