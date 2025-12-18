<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Tahun</label>
                <div class="col">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="text" class="form-control font-kecil" name="tahun" id="tahun" placeholder="Isi Tahun" value="">
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-1 mt-2 row">
                <label class="col-3 col-form-label p-1 text-right">Aktif</label>
                <div class="col pt-1">
                    <label class="form-check form-check-single form-switch pl-1">
                        <input class="form-check-input" id="aktif" name="aktif" type="checkbox">
                    </label>
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body font-kecil p-1">
                <div class="bg-primary-lt p-1 font-bold text-black">Data Job Cost Division</div>
                <div class="p-2">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Spinning</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="sp" id="sp" placeholder="Cost Spinning" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">RingRope</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="rr" id="rr" placeholder="Cost Ringrope" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Netting</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="nt" id="nt" placeholder="Cost Netting" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Senshoku</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="sn" id="sn" placeholder="Cost SN" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Hoshu 1</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="h1" id="h1" placeholder="Cost Hoshu 1" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Koatsu</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="ko" id="ko" placeholder="Cost Koatsu" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Hoshu 2</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="h2" id="h2" placeholder="Cost Hoshu 2" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Packing</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="pa" id="pa" placeholder="Cost Packing" value="">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-bold">Shitate</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" name="sh" id="sh" placeholder="Cost Shitate" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-center">
        <button type="button" class="btn me-auto font-kecil btn-flat" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary font-kecil btn-flat" id="updatesupplier">Simpan</button>
    </div>
</div>
<script>
    $("#updatesupplier").click(function() {
        var aktif = $("#aktif").prop('checked') ? 1 : 0;
        if ($("#tahun").val() == '') {
            pesan('Tahun harus di isi !', 'error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'jobcostdiv/simpandata',
            data: {
                tahun: $("#tahun").val(),
                aktif: aktif,
                sp: $("#sp").val(),
                nt: $("#nt").val(),
                rr: $("#rr").val(),
                sn: $("#sn").val(),
                h1: $("#h1").val(),
                ko: $("#ko").val(),
                h2: $("#h2").val(),
                pa: $("#pa").val(),
                sh: $("#sh").val(),
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