<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $idheader; ?>">
    <input type="hidden" name="id_detail" id="id_detail" value="<?= $iddetail; ?>">
    <div id="table-default" class="table-responsive mb-1">
        <table class="table datatable6" id="cobasisip">
            <thead style="background-color: blue !important">
                <tr>
                    <th>Seri </th>
                    <th>SKU</th>
                    <th>Nama Barang / Uraian</th>
                    <th>PCS</th>
                    <th>KGS</th>
                </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                <?php 
                    $no=0;$jmlkgs=0;
                    foreach($arrayhasil->result_array() as $hasil){ 
                    $no++;
                    $sku = trim($hasil['po'])=='' ? $hasil['kode'] : viewsku($hasil['po'],$hasil['item'],$hasil['dis']);
                    $spekbarang = trim($hasil['po'])=='' ? namaspekbarang($hasil['id_barang']) : spekpo($hasil['po'],$hasil['item'],$hasil['dis']);
                    $jmlkgs += $hasil['kgs'];
                ?>
                    <tr>
                        <td><?= $hasil['id'] ?></td>
                        <td><?= $sku ?></td>
                        <td><?= $spekbarang ?></td>
                        <td class="text-center">
                            <input type="text" class="form-control font-kecil btn-flat text-center iniinput" style="max-width: 65px !important; height: 20px;"   rel="<?= $hasil['id']; ?>" id="inputpcs<?= $no; ?>" value="<?= round($hasil['pcs'],0) ?>" aria-describedby="emailHelp" placeholder="Pcs" readonly>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control font-kecil btn-flat text-center iniinput" style="max-width: 65px !important; height: 20px;"   rel="<?= $hasil['id']; ?>" id="inputkgs" value="<?= round($hasil['kgs'],2) ?>" aria-describedby="emailHelp" placeholder="Kgs">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <hr class="my-1">
    <div class="text-center mb-3">
        <a href="#" id="simpankedb" class="btn btn-sm btn-flat btn-primary">Simpan Perubahan</a>
        <a href="#" class="btn btn-sm btn-flat btn-danger" id="tutupmodal" data-bs-dismiss="modal">Batal</a>
        <!-- <div id="peringatan">0</div> -->
    </div>
</div>
<script>
    $(document).ready(function(){
        // $(".tgl").datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     todayHighlight: true,
        // });
        // $("#peringatan").text('');
    })

    $("#simpankedb").click(function(){
        var iddetail = $("#id_detail").val();   
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/simpaneditkgspo",
            data: {
                kgsbaru: $("#inputkgs").val(),
                id: $("#id_detail").val()
            },
            success: function (data) {
                $('#modal-large-loading').modal('hide');
                $("#kgss"+iddetail).text($("#inputkgs").val());
                // window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>