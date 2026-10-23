<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tanggal Produksi</label>
                <div class="col"> 
                    <input type="text" id="id" value="<?= $data['id'] ?>" class="hilang">
                    <input type="text" class="form-control font-kecil" name="tglprod" id="tglprod" placeholder="Tanggal Produksi" value="<?= tglmysql($data['prod_date']) ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="buatcancelpb">Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#tglprod").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true,
        });
    })
    $("#buatcancelpb").click(function() {
        if($("#tglprod").val() == ''){
            pesan('Isi Tanggal Produksi','error');
            return;
        }
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+"pricinginv/updatetglprod",
            data: {
                id: $("#id").val(),
                tglprod: $("#tglprod").val()
            },
            success: function(data){
                $("#"+$("#id").val()).text($("#tglprod").val());
                // alert('berhasil');
                // window.location.reload();
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    })
</script>