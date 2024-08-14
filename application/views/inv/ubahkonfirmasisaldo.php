<div class="modal-body text-center pt-4 pb-1">
    <svg class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
    <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
    <path d="M12 9v4" />
    <path d="M12 17h.01" />
    </svg>
    <h3>Anda Yakin ?</h3>
    <div class="text-secondary" id="message">Akan membatalkan verifikasi data <br><?= $data['nama_barang']; ?></div>
</div>
<input type="hidden" value="<?= $data['idu']; ?>" id="idrek">
<div class="modal-footer mt-1">
    <div class="w-100">
        <div class="row">
            <div class="col"><a id="oke-cancel" href="#" class="btn btn-danger w-100">
                Ya
            </a></div>
            <div class="col"><a href="#" class="btn w-100" id="oke-batal" data-bs-dismiss="modal">
                Tidak
            </a></div>
        </div>
    </div>
</div>

<script>
    $("#oke-cancel").click(function(){
        // alert($("#idrek").val());
        var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	    $("#loadview").html(isinya);
        reko = $("#idrek").val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "inv/cancelverifikasidata",
            data: {
                id: reko
            },
            success: function (data) {
                // window.location.reload();
                // alert(data);
                $("#canceltask").modal('hide');
                butto = '<a href="'+base_url +'inv/confirmverifikasidata/'+data[0]+'" class="btn btn-success btn-sm font-bold" data-bs-toggle="modal" data-bs-target="#veriftask" data-tombol="Ya" data-message="Akan memverifikasi data <br> '+data[1]+'" style="padding: 2px 3px !important" id="verifrek'+data[0]+'" rel="'+data[0]+'" title="'+data['0']+'"><span>Verify</span></a>';
                $("#row"+reko).html(butto);
                $("#loadview").html('');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    });
</script>