<div class="modal-body text-center pt-4 pb-1">
    <svg class="icon mb-2 text-primary icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
    <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
    <path d="M12 9v4" />
    <path d="M12 17h.01" />
    </svg>
    <h3>Anda Yakin ?</h3>
    <div class="text-secondary" id="message">Akan memvalidasi data <br><?= $data['nomor_dok']; ?></div>
    <hr class="m-1">
    <div class="mb-1 row font-kecil">
        <label class="col-3 col-form-label font-bold">Noted</label>
        <div class="col">
            <textarea class="form-control font-kecil text-uppercase" id="ketvalid"><?= $data['pesan_bbl'] ?></textarea>
        </div>
    </div>
</div>
<input type="hidden" value="<?= $data['id']; ?>" id="idrek">
<input type="hidden" value="<?= $data['kode_dok']; ?>" id="kodedok">
<input type="hidden" value="<?= $ke; ?>" id="ke">
<div class="modal-footer mt-1">
    <div class="w-100">
        <div class="row">
            <div class="col"><a id="oke-valid" href="#" class="btn btn-primary w-100">
                Ya
            </a></div>
            <div class="col"><a href="#" class="btn w-100" id="oke-batal" data-bs-dismiss="modal">
                Tidak
            </a></div>
        </div>
    </div>
</div>

<script>
    $("#oke-valid").click(function(){
        if($("#kodedok").val()=='BBL'){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "task/validasibbltask",
                data: {
                    id: $("#idrek").val(),
                    ke: $("#ke").val(),
                    ketvalid: $("#ketvalid").val()
                },
                success: function (data) {
                    $("#oke-batal").click();
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
        if($("#kodedok").val()=='PO'){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "task/cancelpo",
                data: {
                    id: $("#idrek").val(),
                    ke: $("#ke").val(),
                    ketcancel: $("#ketcancel").val()
                },
                success: function (data) {
                    window.location.reload();
                    $("#oke-batal").click();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
        if($("#kodedok").val()=='ADJ'){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "task/canceladj",
                data: {
                    id: $("#idrek").val(),
                    ke: $("#ke").val(),
                    ketcancel: $("#ketcancel").val()
                },
                success: function (data) {
                    window.location.reload();
                    $("#oke-batal").click();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
    })
</script>