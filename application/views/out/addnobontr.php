<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="iddetail" class="btn btn-sm btn-danger hilang" value="<?= $iddetail; ?>">
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Spec Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $header['nama_barang']; ?>" placeholder="Spec Barang">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">SKU</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $header['kode']; ?>" placeholder="SKU Barang">
                </div>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable6" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Nobontr</th>
                    <th>Pcs</th>
                    <th>Kgs</th>
                    <th>Pilih</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                    <?php if($data->num_rows() > 0){ ?>
                    <?php foreach ($data->result_array() as $detail) { ?>
                        <tr>
                            <td><?= $detail['nobontr']; ?></td>
                            <td><?= rupiah($detail['pcs_akhir'],2); ?></td>
                            <td class="text-right"><?= rupiah($detail['kgs_akhir'],2); ?></td>
                            <td class="text-center"><a href='#' class="bg-success btn btn-sm" rel="<?= $detail['id']; ?>" rel2="<?= $detail['nobontr']; ?>" title="<?= $detail['id']; ?>" id="pilihnobontr">Pilih</a></td>
                        </tr>
                    <?php } }else{?>
                        <tr>
                            <td colspan="4" class="text-center">No Data / Data tidak Ada</td>
                        </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
    <button type="button" class="btn btn-success btn-sm text-black" data-bs-dismiss="modal">Batal Pilih</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
    $(document).on('click','#pilihnobontr',function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/editnobontr",
            data: {
                id: $(this).attr('rel'),
                bon: $(this).attr('rel2'),
                idd: $("#iddetail").val()
            },
            success: function (data) {
                // alert(data.jmlrek);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
	    });
    })
    $("#updatedetail").click(function(){
        var pcs1 = parseFloat($("#pcsminta").val());
        var pcs2 = parseFloat($("#pcsreal").val());
        var kgs1 = parseFloat($("#kgsminta").val());
        var kgs2 = parseFloat($("#kgsreal").val());
        var bbl = $("#tempbbl").is(':checked') ? 1 : null;
        if(pcs1 < pcs2){
            pesan('Pcs Real tidak boleh lebih besar dari Pcs minta','error');
            return false;
        }
        if(kgs1 < kgs2){
            pesan('Kgs Real tidak boleh lebih besar dari Kgs minta','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/updatedetail",
            data: {
                id: $("#id").val(),
                pcs: $("#pcsreal").val(),
                kgs: $("#kgsreal").val(),
                tempbbl: bbl
            },
            success: function (data) {
                // alert(data.jmlrek);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
	    });
    })
</script>