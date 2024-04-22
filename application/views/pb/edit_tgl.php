<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Tgl Transaksi</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="tgl" id="tgl" placeholder="Tgl Transaksi" value="<?= date('d-m-Y'); ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Catatan</label>
                <div class="col">
                    <textarea class="form-control font-kecil" id="catatan" name="catatan"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm btn-flat" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm btn-flat text-black" id="buatpb">Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#tgl").val($("#tgldok").val());
        $("#catatan").val($("#catat").val());
        $("#tgl").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true
        });
    })
    $("#buatpb").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"pb/updatepb",
            data: {
                id: $("#id_header").val(),
                tgl: $("#tgl").val(), 
                ket: $("#catatan").val()
            },
            success: function(data){
                // alert('berhasil');
                window.location.href = base_url+"pb/datapb/"+$("#id_header").val();
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    })
</script>