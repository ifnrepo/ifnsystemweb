<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="id" id="id" placeholder="Kode">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Produk (English)</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="engklp" id="engklp" placeholder="Kelompok Produk (Englis)">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Produk (Indonesia)</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="indklp" id="indklp" placeholder="Kelompok Produk (Indonesia)">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">No HS</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="hs" id="hs" placeholder="No HS">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Merek</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="merek" id="merek" placeholder="Merek">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Certificate</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kelco" id="kelco" placeholder="Kelompok Certificate">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpandata">Simpan</button>
</div>
<!-- <script>
    $("#simpandata").click(function() {
        if ($("#id").val() == '') {
            pesan('Kode harus di isi !', 'error');
            return;
        }
        if ($("#engklp").val() == '') {
            pesan('Kelompok Produk (Englis) harus di isi!', 'error');
            return;
        }
        if ($("#indklp").val() == '') {
            pesan('Kelompok Produk (Indonesia) harus di isi!', 'error');
            return;
        }
        if ($("#hs").val() == '') {
            pesan('No Hs harus di isi !', 'error');
            return;
        }
        if ($("#merek").val() == '') {
            pesan('Merek harus di isi !', 'error');
            return;
        }
        if ($("#kelco").val() == '') {
            pesan('Kelompok Certificate harus di isi !', 'error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'kelompokpo/simpandata',
            data: {
                id: $("#id").val(),
                engklp: $("#engklp").val(),
                indklp: $("#indklp").val(),
                hs: $("#hs").val(),
                merek: $("#merek").val(),
                kelco: $("#kelco").val(),
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
</script> -->
<script>
    $("#simpandata").click(function() {
        if ($("#id").val() == '') {
            pesan('Kode harus di isi!', 'error');
            return;
        }
        if ($("#engklp").val() == '') {
            pesan('Kelompok Produk (Englis) harus di isi!', 'error');
            return;
        }
        if ($("#indklp").val() == '') {
            pesan('Kelompok Produk (Indonesia) harus di isi!', 'error');
            return;
        }
        if ($("#hs").val() == '') {
            pesan('No Hs harus di isi!', 'error');
            return;
        }
        if ($("#merek").val() == '') {
            pesan('Merek harus di isi!', 'error');
            return;
        }
        if ($("#kelco").val() == '') {
            pesan('Kelompok Certificate harus di isi!', 'error');
            return;
        }

        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'kelompokpo/simpandata',
            data: {
                id: $("#id").val(),
                engklp: $("#engklp").val(),
                indklp: $("#indklp").val(),
                hs: $("#hs").val(),
                merek: $("#merek").val(),
                kelco: $("#kelco").val()
            },
            success: function(response) {
                if (response === 'ID sudah ada, silakan gunakan ID lain') {
                    pesan(response, 'error');
                } else {
                    window.location.reload();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });
</script>