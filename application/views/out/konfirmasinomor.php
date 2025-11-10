<div class="container-xl">
    <div class="card card-lg p-2">
        <div class="card-body p-2">
            <div class="row">
                <input type="text" name="id_header" id="id_header" class="hilang" value="<?= $header['idx'] ?>">
                <span class="mb-3">Pastikan Nomor Surat Jalan dan Surat Pengantar sudah benar ?</span>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Nomor Surat Jalan</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="nomorsj" id="nomorsj" placeholder="Nomor Bukti Pengeluaran" value="<?= $header['nomor_sj'] ?>">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Tanggal Surat Jalan</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil tgl" name="tglib" id="tglib" placeholder="Tanggal Bukti Pengeluaran" value="<?= tglmysql($header['tgl_sj']) ?>">
                    </div>
                </div>
                <hr class="m-0 mb-1">
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Nomor Surat Pengantar</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="nomorsp" id="nomorsp" placeholder="Nomor Surat Pengantar" value="<?= $header['nomor_sp'] ?>">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label text-primary font-kecil font-bold">Tanggal Surat Pengantar</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil tgl" name="tglsp" id="tglsp" placeholder="Tanggal Surat Pengantar" value="<?= tglmysql($header['tgl_sp']) ?>">
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
        var nosp = $("#nomorsp").val();

        if(nosp.trim()==''){
            pesan('Nomor Surat Pengantar dan Tanggal Harus di isi !','info');
            return false;
        }

        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('out/simpanout2') ?>',
            data: {
                id: $("#id_header").val(),
                tglib: $("#tglib").val(),
                nomsj: $("#nomorsj").val(),
                tglsp: $("#tglsp").val(),
                nomsp: $("#nomorsp").val()
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