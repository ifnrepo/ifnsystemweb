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
                            <input type="text" class="form-control font-kecil btn-flat text-center iniinput" style="max-width: 65px !important; height: 20px;"   rel="<?= $hasil['id']; ?>" id="inputkgs<?= $no; ?>" value="<?= round($hasil['kgs'],2) ?>" aria-describedby="emailHelp" placeholder="Kgs">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <hr class="small m-1">
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Jumlah Kgs</label>
                <div class="col">
                    <input type="text" name="pcsasli" id="pcsasli" class="hilang">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="inikgs" value="<?= rupiah($jmlkgs,2) ?>" aria-describedby="emailHelp" placeholder="Jumlah Kgs">
                </div>
            </div>
        </div>
    </div>
    <hr class="small m-1">
    <div class="text-center mb-3">
        <a href="#" id="simpankedb" class="btn btn-sm btn-flat btn-primary">Simpan Perubahan</a>
        <a href="#" id="hitungcif" class="btn btn-sm btn-flat btn-primary hilang">Hitung</a>
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
    $(document).on('change','.iniinput',function(){
        $("#hitungcif").click();
    })
    $("#hitungcif").click(function(){
        var kgs = 0;
        for (let i = 1; i < 1000; i++) {
            if($("#inputkgs"+i).length > 0){
                kgs += parseFloat($("#inputkgs"+i).val());
            }
        }
        $("#inikgs").val(Math.round(kgs*100)/100);
    })

    $("#simpankedb").click(function(){
        var text = [];
        var text2 = [];
        for (let i = 1; i < 1000; i++) {
            if($("#inputkgs"+i).length > 0){
                text.push($("#inputkgs"+i).val());
                text2.push($("#inputkgs"+i).attr('rel'));
            }
        }
        var iddetail = $("#id_detail").val();
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "ib/simpaneditkgsbcasal",
                data: {
                    jmlbaru: text,
                    idasal: text2
                },
                success: function (data) {
                    $('#modal-large-loading').modal('hide');
                    $("#kgss"+iddetail).text($("#inikgs").val());
                    // window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
    })
</script>