<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="iddetail" class="btn btn-sm btn-danger hilang" value="">
            <div class="mb-1 line-12 hilang"><h4 class="mb-1">XX</div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Sku</th>
                    <th class="text-center">Pilih</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-tablex" style="font-size: 13px !important;" >
                    <?php foreach($data->result_array() as $dt): $dis = $dt['dis']!=0 ? ' dis '.$dt['dis'] : ''; ?>
                        <tr>
                            <td class="font-bold"><?= trim($dt['po']).' # '.trim($dt['item']).$dis ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-success" id="pilihnya" rel="<?= $dt['po'].$dt['item'].$dt['dis'] ?>" style="height: 30px;" >Pilih PO<span class="text-black ml-1"><?= $dt['po'].'#'.$dt['item'].$dis ?></span></a>
                            </td>
                        </tr>
                    <?php endforeach;  ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
    <button type="button" class="btn btn-success btn-sm text-black" id="keluar" data-bs-dismiss="modal">Keluar</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
    $(document).off('click').on('click','#pilihnya',function(){
        let ind_po = $(this).attr('rel');
        $.ajax({
            dataType: 'json',
            type : "POST",
            url : base_url+"sublok/tambahketemp",
            data : {
                id: $("#idreal").val(),
                lot: $("#lotnya").val(),
                jlr: $("#jalurnya").val(),
                ins: $("#insnonya").val(),
                ind: ind_po
            },
            success : function(data){
                getdatatemp();
                if($("#input-manual").hasClass('hilang')){
                    $("#play").click();
                }
                $("#keluar").click();
            }
        })
    })
    function getdatatemp() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "sublok/getdatatemp",
            data: {
                id_header: $("#idreal").val(),
            },
            success: function (data) {
                $("#body-table").html(data.datagroup).show();
                kosongkanform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    }
    function kosongkanform(){
        $("#jalurnya").val('');
        $("#lotnya").val('');
        $("#insnonya").val('');
        $("#inputinsno").val('');
        $("#inputlot").val('');
        $("#inputjalur").val('');
    }
</script>