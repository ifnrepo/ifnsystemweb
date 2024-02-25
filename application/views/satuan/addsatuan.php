<div class="container-xl"> 
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kodesatuan" id="kodesatuan" placeholder="Kode Satuan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="namasatuan" id="namasatuan" placeholder="Nama Satuan">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpansatuan" >Simpan</button>
</div>
<script>
    $("#simpansatuan").click(function(){
        if($("#kodesatuan").val() == ''){
            pesan('Kode Satuan harus di isi !','error');
            return;
        }
        if($("#namasatuan").val() == ''){
            pesan('Nama Satuan harus di isi !','error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'satuan/simpansatuan',
            data: {
                kode: $("#kodesatuan").val(),
                nama: $("#namasatuan").val()
            },
            success: function(data){
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>