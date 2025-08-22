<div class="container-xl">
    <div class="row font-kecil">
        <input type="text" class="hilang" name="idheader" id="idheader" value="">
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-bold">PILIH SUBKON</label>
            <div class="col">
                <div class="input-group mb-2">
                    <select class="form-select form-control font-kecil font-bold" id="namasubkon">
                        <?php foreach ($datasubkon as $key => $value) { ?>
                            <option value="<?= $value; ?>"><?= datadepartemen($value,'departemen'); ?></option>
                        <?php } ?>
                    </select>
                    <button class="btn font-kecil btn-primary" id="submit-pilih" type="button">Pilih</button>
                </div>
                
            </div>
        </div>
        <div class="col-12 mb-5 text-center" style="min-height: 150px;">
            <hr class="small mt-0 mb-5">
            <span class="font-bold text-primary ">PILIH SUB KONTRAK PENERIMA MAKLOON</span>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    });
    $("#submit-pilih").click(function(){
        let subkon = $("#namasubkon").val();
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+'akb/tambahajusubkon',
            data: {
                id: subkon,
            },
            success: function(data){
                $('#modal-large').modal('hide');
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    
</script>