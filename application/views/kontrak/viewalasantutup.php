<div class="page-body mt-0">
    <div class="container-xl">
        <div class="row font-kecil">
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Alasan Tutup Kontrak</i> </label>
                <div class="col">
                    <textarea name="alasantutup" id="alasantutup" class="form-control font-kecil" rows="5"><?= $data['alasan_tutup'] ?></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Oleh</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= datauser($data['tutup_oleh'],'name') ?>" >
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Pada</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= $data['tutup_pada'] ?>" >
                </div>
            </div>
        </div>
        <hr class="m-0">
        <div class="text-end mt-1">
            <a href="#" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Keluar</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#outpcs").text($("#outpcsx").text());
        $("#outkgs").text($("#outkgsx").text());
        $("#inpcs").text($("#inpcsx").text());
        $("#inkgs").text($("#inkgsx").text());
        $("#saldopcs").text($("#saldopcsx").text());
        $("#saldokgs").text($("#saldokgsx").text());
        $("#pcskirim").text($("#outpcsx").text());
        $("#kgskirim").text($("#outkgsx").text());
    })
</script>