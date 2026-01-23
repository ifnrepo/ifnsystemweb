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
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right" id="pcsreal" placeholder="Masukan Nilai" value="<?= $data['pcs']; ?>">
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right hilang" id="pcsreal2" placeholder="Masukan Nilai" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Kgs Minta</label>
                    <input type="text" class="form-control font-kecil mt-1 text-right font-bold" id="kgsminta" placeholder="Kgs Minta" value="<?= rupiah($data['kgsminta'],0); ?>" disabled>
                </div>
                <div class="col-sm-6 mb-1">
                    <label class="form-label mb-0 font-kecil">Kgs Real</label>
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right" id="kgsreal" placeholder="Masukan Nilai" value="<?= rupiah($data['kgs'],0); ?>">
                    <input type="text" class="form-control font-kecil mt-1 font-bold text-right hilang" id="kgsreal2" placeholder="Masukan Nilai" value="">
                </div>
            </div>
            <hr class="m-1">
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-check mb-1 font-bold text-info">
                        <input class="form-check-input" id="bagidua" name="bagidua" type="checkbox" title="Split Qty menjadi 2">
                        <span class="form-check-label">Bagi dua Permintaan</span>
                    </label>
                </div>
                <div class="col-sm-6">
                    <label class="form-check mb-1 font-bold text-danger">
                        <input class="form-check-input" id="tempbbl" name="tempbbl" type="checkbox" title="Sisa jadi BBL">
                        <span class="form-check-label">Sisanya Buat Bon Pembelian (BBL)</span>
                    </label>
                </div>
            </div>
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
    $("#bagidua").click(function(){
        var cek = $(this).prop('checked');
        $("#tempbbl").prop('checked',false);
        if(cek){
            $("#pcsreal2").removeClass('hilang');
            $("#kgsreal2").removeClass('hilang');
        }else{
            $("#pcsreal2").addClass('hilang');
            $("#kgsreal2").addClass('hilang');
        }
    })
    $("#updatedetail").click(function(){
        var cek = $("#bagidua").prop('checked');
        if(!cek){
            var pcs1 = parseFloat($("#pcsminta").val());
            var pcs2 = parseFloat($("#pcsreal").val());
            var kgs1 = parseFloat(toAngka($("#kgsminta").val()));
            var kgs2 = parseFloat(toAngka($("#kgsreal").val()));
            if(pcs1 < pcs2){
                pesan('Pcs Real tidak boleh lebih besar dari Pcs minta','error');
                return false;
            }
            if(kgs1 < kgs2){
                pesan('Kgs Real tidak boleh lebih besar dari Kgs minta','error');
                return false;
            }
            // var bbl = $("#tempbbl").is(':checked') ? 1 : null;
            var bbl = (pcs1!=pcs2 || kgs1!=kgs2) ? 1 : null;
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "out/updatedetail",
                data: {
                    id: $("#id").val(),
                    pcs: toAngka($("#pcsreal").val()),
                    kgs: toAngka($("#kgsreal").val()),
                    tempbbl: bbl
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
        }else{
            var pcstot = parseFloat($("#pcsminta").val());
            var kgstot = parseFloat(toAngka($("#kgsminta").val()));
            var pcs1 = parseFloat($("#pcsreal").val());
            var kgs1 = parseFloat(toAngka($("#kgsreal").val()));
            var pcs2 = parseFloat($("#pcsreal2").val());
            var kgs2 = parseFloat(toAngka($("#kgsreal2").val()));
            if(pcstot != (pcs1+pcs2)){
                pesan('Pcs Minta dan Jumlah Pcs Real tidak sama','error');
                return false;
            }
            if(kgstot != (kgs1+kgs2)){
                pesan('Kgs Minta dan Jumlah Kgs Real tidak sama','error');
                return false;
            }
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "out/bagi2permintaan",
                data: {
                    id: $("#id").val(),
                    pcs1: toAngka($("#pcsreal").val()),
                    kgs1: toAngka($("#kgsreal").val()),
                    pcs2: toAngka($("#pcsreal2").val()),
                    kgs2: toAngka($("#kgsreal2").val()),
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
        }
    })
    function toAngka(rp) {
        if (rp == "" || rp.trim() == "-") {
            return 0;
        } else {
            return rp.replace(/,*|\D/g, "");
        }
    }
</script>