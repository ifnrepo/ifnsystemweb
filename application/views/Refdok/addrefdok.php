<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Ins</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="ins" id="ins" placeholder="ins">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Dokumen</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_dokumen" id="nama_dokumen" placeholder="Nama Dokumen">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpanrefdok">Simpan</button>
</div>
<script>
    $("#simpanrefdok").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'ref_dokumen/simpanrefdok',
            data: {
                kode: $("#kode").val(),
                ins: $("#ins").val(),
                nama_dokumen: $("#nama_dokumen").val(),
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