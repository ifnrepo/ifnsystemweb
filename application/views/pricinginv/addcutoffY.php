<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Keterangan Cancel</label>
                <div class="col"> 
                    <input type="text" id="idcancel" value="" class="hilang">
                    <input type="text" class="form-control font-kecil" name="ketcancel" id="ketcancel" placeholder="Ket Cancel BON" value="">
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
        if($("#ketcancel").val() == ''){
            pesan('Isi Keterangan cancel BON','error');
            return;
        }
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+"pb/simpancancelpb",
            data: {
                id: $("#idcancel").val(),
                ketcancel: $("#ketcancel").val()
            },
            success: function(data){
                // alert('berhasil');
                window.location.reload();
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    })
</script>