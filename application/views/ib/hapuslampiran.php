<div class="container-xl"> 
    <div class="modal-status bg-danger"></div>
        <input type="hidden" name="idd" id="idd" value="<?= $id; ?>">
        <input type="hidden" name="idx" id="idx" value="<?= $header; ?>">
        <div class="modal-body text-center py-4">
          <svg class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
            <path d="M12 9v4" />
            <path d="M12 17h.01" />
          </svg>
          <h3>Anda Yakin ?</h3>
          Yakin anda akan menghapus data ini
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
    <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
    <a class="btn btn-sm btn-danger" style="color: white; padding-left: 20px !important;padding-right: 20px !important;" id="hapuslampiran">Ya</a>
</div>
<script>
    $("#hapuslampiran").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/hapuslamp",
            data: {
                id: $("#idd").val(),
                head: $("#idx").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
        $("#canceltask").modal('hide');
    })
</script>