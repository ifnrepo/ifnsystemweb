<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen Asal</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_idx" id="dept_idx" placeholder="Id Departemen" disabled>
                    <input type="text" class="form-control font-kecil hilang" name="dept_idy" id="dept_idy" >
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen Tujuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="id_deptx" id="id_deptx" placeholder="Departemen" disabled>
                    <input type="text" class="form-control font-kecil hilang" name="id_depty" id="id_depty">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tgl Transaksi</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="tgl" id="tgl" placeholder="Tgl Transaksi" value="<?= date('d-m-Y'); ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jenis</label>
                <div class="col">
                    <select class="form-control form-select font-kecil" id="jn_pb" name="jn_pb">
                        <option value="0">BIASA</option>
                        <option value="1">SERVICE</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="buatpb">Buat Transaksi</button>
</div>
<script>
    $(document).ready(function(){
        $("#dept_idx").val($("#dept_kirim option:selected").attr('rel'));
        $("#dept_idy").val($("#dept_kirim").val());
        $("#id_deptx").val($("#dept_tuju option:selected").attr('rel'));
        $("#id_depty").val($("#dept_tuju").val());
        $("#tgl").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy"
        });
    })
    $("#buatpb").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"pb/tambahpb",
            data: {
                dept_id: $("#dept_idy").val(),
                dept_tuju: $("#id_depty").val(), 
                tgl: $("#tgl").val(),
                jn: $("#jn_pb").val(),
            },
            success: function(data){
                // alert('berhasil');
                if(data==0){
                    window.location.href = base_url+"pb";
                    $("#butbatal").click();
                }else{
                    window.location.href = base_url+"pb/datapb/"+data;
                    $("#butbatal").click();
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    })
</script>