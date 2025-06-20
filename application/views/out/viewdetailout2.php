<div class="container-xl"> 
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
        <span>Nomor</span>
        <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
        </div>
        <div class="col-4 text-primary font-bold">
        <span>Tanggal</span>
        <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
        </div>
        <div class="col-4 text-primary font-bold">
        <!-- <span>Dibuat Oleh</span>
        <h4 class="mb-1"><?= datauser($header['user_ok'],'name').' ('.$header['tgl_ok'].')' ?></h4> -->
        </div>
    </div>
    <hr class="m-0">
    <div class="bg-cyan-lt p-1 font-bold">
        -
    </div>
    <hr class='m-1'>
    <div class="card card-lg">
        <div class="card-body p-2">
            <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                    <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Kgs</th>
                    <th>Kgs</th>
                    <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                <?php $jmlbarang=0; $pcs=0;$kgs=0; foreach ($detail as $val) { $jmlbarang++; $pcs += $val['pcs']; $kgs +=  $val['kgs']; 
                    $namabarang = trim($val['po'])=='' ? $val['nama_barang'] : spekpo($val['po'],$val['item'],$val['dis']);  
                    $sku = trim($val['po'])=='' ? $val['brg_id'] : formatsku($val['po'],$val['item'],$val['dis'],$val['id_barang']);
                    $nmsatuan = trim($val['po'])=='' ? $val['namasatuan'] : 'PCS';
                    $xnet = $val['exnet']==0 ? '' : 'Y';
                    ?>
                    <tr>
                        <td style="line-height: 12px;"><?= $namabarang.' <br><span class="text-teal" style="font-style: italic; font-size: 12px;">'.$val['insno'].' '.$val['nobontr'].'</span>'; ?></td>
                        <td><?= $sku ?></td>
                        <td><?= $nmsatuan; ?></td>
                        <td class="text-end"><?= rupiah($val['pcs'],0); ?></td>
                        <td class="text-end"><?= rupiah($val['kgs'],4); ?></td>
                        <td><?= $val['nodok']; ?></td>
                    </tr>
                <?php } ?>
                <tr class="bg-info-lt">
                    <td colspan="3" class="font-bold text-right">TOTAL</td>
                    <td class="font-bold text-right"><?= rupiah($pcs,0); ?></td>
                    <td class="font-bold text-right"><?= rupiah($kgs,2); ?></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $jmlbarang; ?></div>
        </div>
    </div>
    <hr class="m-1">
</div>
<script>
    $(document).ready(function(){
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
    })
    // $("#keyw").on('keyup',function(e){
    //     if(e.key == 'Enter' || e.keycode === 13){
    //         $("#getbarang").click();
    //     }
    // })
    // $("#getbarang").click(function(){
    //     if($("#keyw").val() == ''){
    //         pesan('Isi dahulu keyword pencarian barang','info');
    //         return;
    //     }
    //     $.ajax({
    //         dataType: "json",
    //         type: "POST",
    //         url: base_url+'pb/getspecbarang',
    //         data: {
    //             mode: $("#cari_by").val(),
    //             data: $("#keyw").val(),
    //         },
    //         success: function(data){
    //             $("#body-table").html(data.datagroup).show();
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //         }
    //     })
    // })
    // $(document).on('click','.pilihbarang',function(){
    //     var x = $(this).attr('rel1');
    //     var y = $(this).attr('rel2');
    //     var z = $(this).attr('rel3');
    //     $("#nama_barang").val(x);
    //     $("#id_barang").val(y);
    //     $("#id_satuan").val(z)
    //     $("#modal-scroll").modal('hide');
    // })
    // $("#simpanbarang").click(function(){
        // if($("#id_barang_bom").val() == ''){
        //     pesan('Nama Barang harus di isi !','error');
        //     return;
        // }
        // if($("#persen").val() == '' || $("#persen").val()==0){
        //     pesan('Persem harus di isi !','error');
        //     return;
        // }
        // $.ajax({
        //     dataType: "json",
        //     type: "POST",
        //     url: base_url+'barang/simpanbombarang',
        //     data: {
        //         id_barang: $("#id_barang").val(),
        //         id_bbom: $("#id_barang_bom").val(),
        //         psn: toAngka($("#persen").val())
        //     },
        //     success: function(data){
        //         window.location.reload();
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr.status);
        //         console.log(thrownError);
        //     }
        // })
    // })
</script>