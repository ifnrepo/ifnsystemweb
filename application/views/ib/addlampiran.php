<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Jenis Dokumen</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil font-bold" name="kode_dokumen" id="kode_dokumen">
                <option value="">Pilih Dokumen</option>
                <?php foreach ($lampiran->result_array() as $lampir) { ?>
                    <option value="<?= $lampir['kode']; ?>" <?php if($lampir['kode']==$datheader['kd_kemasan']){ echo "selected"; } ?>><?= $lampir['kode'].' # '.$lampir['nama_dokumen']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Nomor Dokumen</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="nomor_dokumen" name="nomor_dokumen" value="" aria-describedby="emailHelp" placeholder="Nomor Dokumen">
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Tgl Dokumen</label>
        <div class="col">
            <input type="text" class="form-control font-kecil tgl" id="tgl_dokumen" name="tgl_dokumen" value="" aria-describedby="emailHelp" placeholder="Tgl Dokumen">
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Keterangan</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="keterangan" name="keterangan" value="" aria-describedby="emailHelp" placeholder="Keterangan">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
    <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
    <a class="btn btn-sm btn-primary" style="color: white;" id="simpanlampiran">Simpan</a>
</div>
<script>
    $(document).ready(function(){
    $(".tgl").datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
        });
    })
    $("#simpanlampiran").click(function(){
        if($("#kode_dokumen").val()==''){
            pesan('Pilih Kode Dokumen','error');
            return false;
        }
        if($("#nomor_dokumen").val()==''){
            pesan('Isi Nomor Dokumen','error');
            return false;
        }
        if($("#tgl-dokumen").val()==''){
            pesan('Isi Tanggal Dokumen','error');
            return false;
        }   
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/tambahlampiran",
            data: {
                id: $("#id_header").val(),
                kode: $("#kode_dokumen").val(),
                nomor: $("#nomor_dokumen").val(),
                tgl: $("#tgl_dokumen").val(),
                ket: $("#keterangan").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>