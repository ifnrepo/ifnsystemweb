<div class="container-xl">
    <!-- <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
        <path d="M12 8v4" />
        <path d="M12 16h.01" />
    </svg>
    <div>Anda Yakin ?</div> -->
    <div class="row">
        <div class="col-3 text-center font-kecil p-3">
            <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                <path d="M12 8v4" />
                <path d="M12 16h.01" />
            </svg>
            <div class="font-bold">Add Kurs BI Rate</div>
        </div>
        <div class="col-9">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bulan</label>
                <div class="col">
                    <select class="form-control form-select font-kecil font-bold mr-1" id="bulankurs" name="bulankurs">
                        <?php for ($x = 1; $x <= 12; $x++) : ?>
                        <option value="<?= $x; ?>" <?php if (date('m') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tahun</label>
                <div class="col">
                    <select class="form-control form-select font-kecil font-bold mr-1" id="tahunkurs" name="tahunkurs">
                        <?php for ($x=-1; $x <= 1 ; $x++) { ?> 
                            <option value="<?= date('Y')-$x; ?>" <?php if(date('Y')==date('Y')-$x) echo "selected"; ?>><?= date('Y')-$x; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <hr class="m-1">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Kurs USD</label>
                <div class="col">
                    <input type="text" id="kurs_usd" class="form-control form-input font-kecil text-right inputangka">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Kurs JPY</label>
                <div class="col">
                    <input type="text" id="kurs_jpy" class="form-control form-input font-kecil text-right inputangka">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Kurs EUR</label>
                <div class="col">
                    <input type="text" id="kurs_eur" class="form-control form-input font-kecil text-right inputangka">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="buatkurs">Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $(".inputangka").on("change click keyup input paste", function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/(?!\.)\D/g, "")
                    .replace(/(?<=\..*)\./g, "")
                    .replace(/(?<=\.\d\d\d\d\d\d\d).*/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    })
    $("#buatkurs").click(function() {
        // alert($("#bulanlock").val());
        // alert($("#tahunlock").val());
        if($("#kurs_usd").val().trim() == '' || $("#kurs_usd").val().trim() == '-'){
            alert('Kurs USD harus di isi !');
            return false;
        }
        if($("#kurs_jpy").val() == '' || $("#kurs_jpy").val().trim() == '-'){
            alert('Kurs JPY harus di isi !');
            return false;
        }
        if($("#kurs_eur").val() == '' || $("#kurs_eur").val().trim() == '-'){
            alert('Kurs EUR harus di isi !');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"kurs/tambah",
            data: {
                bulan: $("#bulankurs").val(),
                tahun: $("#tahunkurs").val(),
                usd: $("#kurs_usd").val(),
                jpy: $("#kurs_jpy").val(),
                eur: $("#kurs_eur").val(),
            },
            success: function(data){
                // alert('berhasil');
                window.location.href = base_url+"kurs";
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
			    console.log(thrownError);
                pesan('Data sudah ada, cek Data !','info');
                $("#butbatal").click();
            }
        })
    })
</script>