<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader; ?>">
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Jenis</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil" name="kode_entitas" id="kode_entitas" placeholder="Pilih Entitas" >
                <option value="">Pilih Entitas</option>
                <option value="7">Pemilik</option>
                <option value="5">Pemasok</option>
            </select>
        </div>
    </div>
    <div class="mb-1 mt-0 row" id="dividentitas">
        <label class="col-3 col-form-label font-kecil">Nomor Identitas</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="no_identitas" name="no_identitas" value="" aria-describedby="emailHelp" placeholder="Nomor Identitas">
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Nama</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="nama" name="nama" value="" aria-describedby="emailHelp" placeholder="Nama">
        </div>
    </div>
    <div class="mb-1 mt-0 row">
        <label class="col-3 col-form-label font-kecil">Alamat</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="nama" name="nama" value="" aria-describedby="emailHelp" placeholder="Nama"> -->
            <textarea class="form-control font-kecil" id="alamat" name="alamat"></textarea>
        </div>
    </div>
    <div class="mb-1 mt-0 row" id="divnegara">
        <label class="col-3 col-form-label font-kecil">Negara</label>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil" name="kode_negara" id="kode_negara" placeholder="Pilih Negara" >
                <option value="">Kode Negara</option>
                <?php foreach ($negara->result_array() as $key) { ?>
                    <option value="<?= $key['id']; ?>"><?= $key['kode_negara'].' - '.$key['uraian_negara']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
    <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
    <a class="btn btn-sm btn-primary" style="color: white;" id="simpanentitas">Simpan</a>
</div>
<script>
    $(document).ready(function(){
        // $(".tgl").datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     todayHighlight: true,
        // });
        $("#kode_entitas").change();
    })
    $("#kode_entitas").change(function(){
        $("#divnegara").addClass('hilang');
        $("#dividentitas").addClass('hilang');
        var xx = $(this).val();
        if(xx == 7){
            $("#dividentitas").removeClass('hilang');
        }
        if(xx == 5){
            $("#divnegara").removeClass('hilang');
        }
    })
    $("#simpanentitas").click(function(){
        if($("#kode_entitas").val()==''){
            pesan('Pilih Kode Entitas','error');
            return false;
        }
        if($("#nama").val()==''){
            pesan('Isi Nama','error');
            return false;
        }
        if($("#alamat").val()==''){
            pesan('Isi Alamat','error');
            return false;
        }  
        if($("#kode_entitas").val() == 7 && $("#no_identitas").val() == ''){
            pesan('Isi Nomor Identitas','error');
            return false;
        }
        if($("#kode_entitas").val() == 5 && $("#kode_negara").val() == ''){
            pesan('Negara Harus di Isi','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/tambahentitas",
            data: {
                id: $("#id_header").val(),
                kode: $("#kode_entitas").val(),
                no: $("#no_identitas").val(),
                nama: $("#nama").val(),
                alamat: $("#alamat").val(),
                negara: $("#kode_negara").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table-entitas").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>