<div class="container-xl">
    <div class="card card-lg p-2">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-3 text-center">
                    <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                    <path d="M12 8v4" />
                    <path d="M12 16h.01" />
                    </svg>
                    <h5 class="mb-1">Anda akan menerima Barang ?</h5>
                </div>
                <div class="col-9">
                    <input type="text" name="id_header" id="id_header" class="hilang" value="<?= $header['xid'] ?>">
                    <!-- <span class="mb-3">Yakin akan Menyimpan Penerimaan ?</span> -->
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label text-primary font-kecil font-bold">Tanggal</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" name="tglib" id="tglib" placeholder="Tgl Penerimaan" value="<?= tglmysql($tglib) ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label text-primary font-kecil font-bold">Nomor</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" name="nomorib" id="nomorib" placeholder="Nomor Bon Penerimaan" value="<?= $nomorib ?>" disabled>
                        </div>
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
    $(document).ready(function(){
        $("#tglib").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true,
        });
    })
    $("#tomboliya").click(function(){
        // var tombolnya = $("nomorib").val();

        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('in/simpaningm') ?>',
            data: {
                id: $("#id_header").val(),
                nomor: $("#nomorib").val(),
                tgl: $("#tglib").val(),
            },
            success: function(data) {
                // alert(data);
                // console.log(data); // Log data yang diterima
                location.replace(base_url+'in');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    })
</script>