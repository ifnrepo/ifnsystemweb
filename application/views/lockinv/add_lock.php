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
            <div class="font-bold">Anda Yakin akan mengunci data inventory ?</div>
            <?= var_dump($data) ?>
        </div>
        <div class="col-9">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen</label>
                <div class="col">
                    <select class="form-control form-select font-kecil font-bold mr-1" id="deptlock" name="deptlock">
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach($depart as $dp): ?>
                            <option value="<?= $dp['dept_id'] ?>"><?= $dp['dept_id'].' - '.$dp['departemen'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- <input type="text" class="form-control inputangka" id="tahunlock"> -->
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bulan</label>
                <div class="col">
                    <select class="form-control form-select font-kecil font-bold mr-1" id="bulanlock" name="bulanlock">
                        <?php for ($x = 1; $x <= 12; $x++) : ?>
                        <option value="<?= $x; ?>" <?php if (date('m') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tahun</label>
                <div class="col">
                    <select class="form-control form-select font-kecil font-bold mr-1" id="tahunlock" name="tahunlock">
                        <?php for ($x=-1; $x <= 1 ; $x++) { ?> 
                            <option value="<?= date('Y')-$x; ?>" <?php if(date('Y')==date('Y')-$x) echo "selected"; ?>><?= date('Y')-$x; ?></option>
                        <?php } ?>
                    </select>
                    <!-- <input type="text" class="form-control inputangka" id="tahunlock"> -->
                </div>
            </div>
            <hr class="m-1">
            <div class="text-center font-kecil">Anda tidak akan bisa menambah transaksi bila mengunci data inventory</div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="buatpb">Kunci Inventory</button>
</div>
<script>
    $(document).ready(function(){

    })
    $("#buatpb").click(function() {
        // alert($("#bulanlock").val());
        // alert($("#tahunlock").val());
        if($("#deptlock").val() == ''){
            alert('Isi Dulu Departemen !');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"lockinv/tambah",
            data: {
                dept: $("#deptlock").val(),
                bulan: $("#bulanlock").val(),
                tahun: $("#tahunlock").val(),
            },
            success: function(data){
                // alert('berhasil');
                window.location.href = base_url+"lockinv";
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