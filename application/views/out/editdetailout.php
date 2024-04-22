<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="id" class="btn btn-sm btn-danger hilang" value="<?= $data['id']; ?>">
            <input id="id_header" class="btn btn-sm btn-danger hilang" value="<?= $data['id_header']; ?>">
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Spec Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $data['nama_barang']; ?>" placeholder="Spec Barang">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">SKU</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $data['brg_id']; ?>" placeholder="Spec Barang">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $data['namasatuan']; ?>" placeholder="Spec Barang">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Qty Minta</label>
                    <input type="text" class="form-control font-kecil mt-1 text-right font-bold" id="pcsminta" placeholder="Pcs Minta" value="<?= $data['pcsminta']; ?>" disabled>
                </div>
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Qty Real</label>
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right" id="pcsreal" placeholder="Input placeholder" value="<?= $data['pcs']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Kgs Minta</label>
                    <input type="text" class="form-control font-kecil mt-1 text-right font-bold" id="kgsminta" placeholder="Input placeholder" value="<?= rupiah($data['kgsminta'],0); ?>" disabled>
                </div>
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Kgs Real</label>
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right" id="kgsreal" placeholder="Input placeholder" value="<?= rupiah($data['kgs'],0); ?>">
                </div>
            </div>
            <hr class="m-1">
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="updatedetail" >Simpan Data</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
    $("#updatedetail").click(function(){
        // alert($("#pcsminta").val());
        var pcs1 = parseFloat($("#pcsminta").val());
        var pcs2 = parseFloat($("#pcsreal").val());
        var kgs1 = parseFloat($("#kgsminta").val());
        var kgs2 = parseFloat($("#kgsreal").val());
        if(pcs1 < pcs2){
            pesan('Pcs Real tidak boleh lebih besar dari Pcs minta','error');
            return false;
        }
        if(kgs1 < kgs2){
            pesan('Kgs Real tidak boleh lebih besar dari Kgs minta','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/updatedetail",
            data: {
                id: $("#id").val(),
                pcs: $("#pcsreal").val(),
                kgs: $("#kgsreal").val()
            },
            success: function (data) {
                // alert(data.jmlrek);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
	    });
    })
</script>