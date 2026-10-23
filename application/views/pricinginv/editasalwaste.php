<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Asal Waste</label>
                <div class="col"> 
                    <input type="text" id="id" value="<?= $data['id'] ?>" class="hilang">
                    <select name="asal_waste" id="asal_waste" class="form-control font-kecil form-select">
                        <option value="">-- Pilih Dept Asal Waste --</option>
                        <?php foreach($dept as $dpt): if($dpt['stokopname']==1): ?>
                            <option value="<?= $dpt['dept_id'] ?>"><?= $dpt['departemen'] ?></option>
                        <?php endif; endforeach; ?>
                    </select>
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

    })
    $("#buatcancelpb").click(function() {
        if($("#tglprod").val() == ''){
            pesan('Isi Tanggal Produksi','error');
            return;
        }
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+"pricinginv/updateasalwaste",
            data: {
                id: $("#id").val(),
                asal: $("#asal_waste").val()
            },
            beforeSend: function(){
                $("#buatcancelpb").text('Loading ..');
            },
            success: function(data){
                $("#"+$("#id").val()+'waste #spanasalwaste').text($("#asal_waste").val());
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