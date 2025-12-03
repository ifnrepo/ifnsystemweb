<div class="modal-body text-center pt-4 pb-1">
    <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
        <path d="M12 8v4" />
        <path d="M12 16h.01" />
    </svg>
    <h3 class='andayakin'>Anda Yakin ?</h3>
    <div class="text-secondary" id="message">Akan membreakdown data</div>
</div>
<div class="modal-footer mt-1">
    <div class="w-100" id="kumbut">
        <div class="row">
            <div class="col"><a id="oke-verif" href="#" class="btn btn-info w-100">
                Ya
            </a></div>
            <div class="col"><a href="#" class="btn w-100" id="oke-batal" data-bs-dismiss="modal">
                Tidak
            </a></div>
        </div>
    </div>
    <div class="text-center w-100 hilang" id="iniload">
        <div class="loaderex mx-auto"></div>
        <span>Silahkan tunggu,..</span>
    </div>
</div>

<script>
    $("#oke-verif").click(function(){
        // alert($("#idrek").val());
        reko = $("#idrek").val();
        $("#kumbut").addClass('hilang');
        $("#iniload").removeClass('hilang');
        $(".modal-body .andayakin").text("Sedang Breakdown BOM");
        $(".modal-body .andayakin").addClass('text-cyan"');
        $(".modal-body #message").addClass('hilang');
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "pricinginv/breakdowninv",
            data: {
                // id: reko
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>