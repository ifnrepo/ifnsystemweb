<div class="modal-body text-center pt-4 pb-1">
    <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
        <path d="M12 8v4" />
        <path d="M12 16h.01" />
    </svg>
    <h3>Anda Yakin ?</h3>
    <div class="text-secondary" id="message">Akan memverifikasi data <br><?= $data['nama_barang']; ?><br><span class="font-bold">Saldo Saat ini : <?= rupiah($data['pcs_akhir'],0); ?> Pcs & <?= rupiah($data['kgs_akhir'],2); ?> Kgs</span></div>
</div>
<input type="hidden" value="<?= $data['idu']; ?>" id="idrek">
<div class="modal-footer mt-1">
    <div class="w-100">
        <div class="row">
            <div class="col"><a id="oke-verif" href="#" class="btn btn-info w-100">
                Ya
            </a></div>
            <div class="col"><a href="#" class="btn w-100" id="oke-batal" data-bs-dismiss="modal">
                Tidak
            </a></div>
        </div>
    </div>
</div>

<script>
    $("#oke-verif").click(function(){
        // alert($("#idrek").val());
        var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	    $("#loadview").html(isinya);
        reko = $("#idrek").val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "inv/verifikasidata",
            data: {
                id: reko
            },
            success: function (data) {
                // window.location.reload();
                // alert(data); 
                if($("#bukavalid")==1){
                    butto = '<a href="'+base_url+'inv/batalverifikasidata/'+data[2]+'" data-bs-toggle="modal" data-bs-target="#canceltask" data-tombol="Ya" data-message="Akan membatalkan verifikasi data <br> '+data[3]+'" style="padding: 2px 3px !important" id="verifrek'+data[2]+'" rel="'+data[2]+'" title="'+data[2]+'">';
                    butto2 = '</a>';
                }else{
                    butto = '';
                    butto2 = '';
                }
                $("#veriftask").modal('hide');
                $("#row"+reko).html(butto+'verified : '+data[0]+'<br><span class="font-10">'+data[1]+'</span>'+butto2);
                $("#loadview").html('');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
    $("#oke-cancel").click(function(){
        if($("#ketcancel").val() == ''){
            pesan("Isi dulu Alasan melakukan cancel !","info");
        }else{
            if($("#kodedok").val()=='PB'){
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "task/cancelpb",
                    data: {
                        id: $("#idrek").val(),
                        ketcancel: $("#ketcancel").val()
                    },
                    success: function (data) {
                        window.location.reload();
                        $("#oke-batal").click();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
            if($("#kodedok").val()=='BBL'){
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "task/cancelbbl",
                    data: {
                        id: $("#idrek").val(),
                        ke: $("#ke").val(),
                        ketcancel: $("#ketcancel").val()
                    },
                    success: function (data) {
                        window.location.reload();
                        $("#oke-batal").click();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
            if($("#kodedok").val()=='PO'){
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "task/cancelpo",
                    data: {
                        id: $("#idrek").val(),
                        ke: $("#ke").val(),
                        ketcancel: $("#ketcancel").val()
                    },
                    success: function (data) {
                        window.location.reload();
                        $("#oke-batal").click();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
            if($("#kodedok").val()=='ADJ'){
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "task/canceladj",
                    data: {
                        id: $("#idrek").val(),
                        ke: $("#ke").val(),
                        ketcancel: $("#ketcancel").val()
                    },
                    success: function (data) {
                        window.location.reload();
                        $("#oke-batal").click();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
        }
    })
</script>