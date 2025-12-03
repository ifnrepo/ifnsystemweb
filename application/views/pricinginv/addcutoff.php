<div class="modal-body text-center pt-1 pb-1 mb-1">
    <div class="row">
        <div class="col-3">
            <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
            <path d="M12 8v4" />
            <path d="M12 16h.01" />
            </svg>
            <h5 class="mb-1">Masukan Tanggal Cut Off Inventory</h5>
        </div>
        <div class="col-9">
            <div class="container-xl font-kecil">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label">Tgl Cut Off</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" name="tglcut" id="tglcut" placeholder="Tgl Cut Off" value="<?= date('d-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing')); ?>">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label">Catatan</label>
                            <div class="col">
                                <textarea class="form-control font-kecil" id="catatan" name="catatan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer pt-1">
    <div class="w-100">
        <div class="row">
            <div class="col"><a href="#" class="btn w-100" id="oke-batal" data-bs-dismiss="modal">
                Batal
            </a></div>
            <div class="col"><a id="oke" href="#" class="btn btn-success w-100">
                Simpan
            </a></div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function(){
        // var fromDate = new Date();
        var cek = $("#thperiode").val()+'-'+($("#blperiode").val())+'-01';
        var fromDate = new Date(cek);
        var xminDate = new Date(fromDate.getFullYear(), fromDate.getMonth(),1);
        var xmaxDate = new Date(fromDate.getFullYear(), fromDate.getMonth()+1,0);
        $("#tglcut").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true,
            startDate: xminDate,
            endDate: xmaxDate
            // minDate: xminDate,
            // maxDate: xmaxDate
        });
    })

    $("#oke").click(function(){
        // alert($("#idrek").val());
        var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	    $("#loadview").html(isinya);
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "pricinginv/simpancutoff",
            data: {
                tgl: $("#tglcut").val(),
                cttn: $("#catatan").val()
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    });
</script>