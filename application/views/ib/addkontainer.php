<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Jenis Kontainer</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil" name="jenis_kontainer" id="jenis_kontainer" placeholder="Pilih Kontainer" >
                <option value="">Pilih Jenis Kontainer</option>
                <option value="4">Empty</option>
                <option value="8">FCL</option>
                <option value="7">LCL</option>
            </select>
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Ukuran Kontainer</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil" name="ukuran_kontainer" id="ukuran_kontainer" placeholder="Pilih Kontainer" >
                <option value="">Pilih Ukuran Kontainer</option>
                <option value="20">20 Feet</option>
                <option value="40">40 Feet</option>
                <option value="45">45 Feet</option>
                <option value="60">60 Feet</option>
            </select>
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Nomor Kontainer</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="nomor_kontainer" name="nomor_kontainer" value="" aria-describedby="emailHelp" placeholder="Nomor Kontainer">
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
            url: base_url + "ib/tambahkontainer",
            data: {
                id: $("#id_header").val(),
                jenis: $("#jenis_kontainer").val(),
                ukuran: $("#ukuran_kontainer").val(),
                nomor: $("#nomor_kontainer").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table-kontainer").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>