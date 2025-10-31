<div class="container-xl">
    <div class="card card-lg p-2">
        <div class="card-body p-2">
            <div class="row">
                <input type="text" name="id_header" id="id_header" class="hilang" value="<?= $header['idx'] ?>">
                <span class="mb-3">Yakin akan validasi pengeluaran ?</span>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Nomor Pengeluaran</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="nomorib" id="nomorib" placeholder="Nomor Bukti Pengeluaran" value="<?= $header['nomor_sj'] ?>" disabled>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Tanggal Pengeluaran</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil tgl" name="tglib" id="tglib" placeholder="Tanggal Bukti Pengeluaran" value="<?= tglmysql($header['tgl_sj']) ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer p-2">
            <div class="text-center">
                <a href="#" class="btn btn-sm btn-primary btn-flat" id="tomboliya" style="min-width: 70px !important">Ya</a>
                <a href="#" class="btn btn-sm btn-danger btn-flat" style="min-width: 70px !important" data-bs-dismiss="modal">Tidak</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".tgl").datepicker({
            showButtonPanel: true,
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            todayBtn: "linked",
            // clearBtn: true,
        });
    });
    $("#tomboliya").click(function(){
        // var tombolnya = $("nomorib").val();

        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('out/simpanout2') ?>',
            data: {
                id: $("#id_header").val(),
                tglib: $("#tglib").val()
            },
            success: function(data) {
                // alert(data);
                // console.log(data); // Log data yang diterima
                // location.replace(base_url+'out');
                window.location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    })
</script>