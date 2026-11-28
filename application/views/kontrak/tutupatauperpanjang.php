<div class="page-body mt-0 mb-1">
    <div class="container-xl">
        <input type="text" class="hilang" name="idkontraktutup" id="idkontraktutup" value="<?= $data['id'] ?>">
        <input type="text" class="hilang" name="modekontrak" id="modekontrak" value="<?= $mode ?>">
        <div id="section-alasan">
            <div class="my-3 row">
                <label class="col-3 col-form-label">Alasan tutup</label>
                <div class="col">
                    <textarea name="alasan_tutup" id="alasan_tutup" class="form-control"></textarea>
                </div>
            </div>  
            <hr class="m-0">
            <div class="d-flex justify-content-between mt-2">
                <a href="#" class="btn btn-sm" data-bs-dismiss="modal">Batal</a>
                <div class="text-primary">
                <a href="#" class="btn btn-sm btn-success text-black" id="perpanjangkontrak">Perpanjang Kontrak <?= $data['nomor'] ?></a>
                <a href="#" class="btn btn-sm btn-danger" id="tutupkontrak">Tutup Kontrak <?= $data['nomor'] ?></a>
                </div>
            </div>
        </div>
        <div id="section-konfirmasi" class="hilang">
            <div id="kontent-alasan" class="my-2"><h4>Apakah yakin akan menutup data ini dengan alasan XXXX</h4></div>
            <hr class="m-0">
            <div class="d-flex justify-content-between mt-2">
                <a href="#" class="btn btn-sm" id="batalkonfirmasipanjang">Batal</a>
                <div>
                <a href="#" class="btn btn-sm btn-danger" id="konfirmasitutupkontrak">Ya, lanjutkan tutup Kontrak</a>
                </div>
            </div>
        </div>
        <div id="section-perpanjangkontrak" class="hilang">
            <h4 class="my-1">- Perpanjang Kontrak -</h4>
            <hr class="m-0">
            <div class="my-3 row">
                <label class="col-3 col-form-label font-kecil">Pilih Kontrak</label>
                <div class="col">
                    <select name="kontrakid" id="kontrakid" class="form-control font-kecil">
                        <option value="">-- Pilih Kontrak --</option>
                        <?php foreach($nomorkontrak->result_array() as $kontrak): ?>
                            <option value="<?= $kontrak['id'] ?>"><?= $kontrak['nomor'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>  
            <hr class="m-0">
            <div class="d-flex justify-content-between mt-2">
                <a href="#" class="btn btn-sm" id="batalkonfirmasi">Batal</a>
                <div class="text-primary">
                <a href="#" class="btn btn-sm btn-danger" id="konfirmasiperpanjang">Lanjut perpanjang kontrak</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
      
    })
    $("#tutupkontrak").click(function(){
        var alasan = $("#alasan_tutup").val().trim();
        if(alasan==''){
            pesan("Alasan tutup harus di isi !",'error');
            return false;
        }
        $("#kontent-alasan").html('Apakah yakin akan menutup data ini dengan alasan <b>'+alasan+'</b>');
        $("#section-alasan").addClass('hilang');
        $("#section-konfirmasi").removeClass('hilang');
        var kontrakid = $("#idkontraktutup").val();
        var url = base_url+'kontrak/tutupkontrak/'+kontrakid;
        // $("#konfirmasitutupkontrak").attr('href',url);
    });
    $("#batalkonfirmasi").click(function(){
        $("#section-alasan").removeClass('hilang');
        $("#section-konfirmasi").addClass('hilang');
        $("#section-perpanjangkontrak").addClass('hilang');
    });
    $("#batalkonfirmasipanjang").click(function(){
        $("#batalkonfirmasi").click();
    });
    $("#konfirmasitutupkontrak").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "kontrak/tutupkontrak/",
            data: {
                id: $("#idkontraktutup").val(),
                alasan: $("#alasan_tutup").val(),
                mode: $("#modekontrak").val(),
            },
            beforeSend: function(){
                $("#konfirmasitutupkontrak").html('Loading ...');
            },
            success: function (data) {
                // alert(data);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#konfirmasitutupkontrak").html('Ya, lanjutkan tutup Kontrak');
            },
        });
    });
    $("#perpanjangkontrak").click(function(){
        $("#section-alasan").addClass('hilang');
        $("#section-perpanjangkontrak").removeClass('hilang');
    });
    $("#konfirmasiperpanjang").click(function(){
        if($("#kontrakid").val()==''){
            pesan('Pilih Nomor kontrak !','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "kontrak/perpanjangkontrak/",
            data: {
                id: $("#idkontraktutup").val(),
                idpanjang: $("#kontrakid").val(),
                // alasan: $("#alasan_tutup").val(),
                mode: $("#modekontrak").val(),
            },
            beforeSend: function(){
                $("#konfirmasiperpanjang").html('Loading ...');
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $("#konfirmasitutupkontrak").html('Lanjut perpanjang kontrak');
            },
        });
    });
</script>