<div class="container-xl"> 
    <div class="row mb-1">
        <div class="col-4 font-bold">
        <span class="text-primary">Inventory per Tanggal</span>
        <h4 class="mb-1 text-teal-green"><?= tgl_indo(tglmysql($this->session->userdata('tglawal')),1); ?></h4>
        </div>
        <div class="col-8 text-primary font-bold">
        <span>SKU/Spesifikasi Barang</span>
        <h4 class="mb-1 text-teal-green"><?= $header['idd']." # ".$header['nama_barang']; ?></h4>
        </div>
        <!-- <div class="col-4 text-primary font-bold">
        <span>Dibuat Oleh</span>
        <h4 class="mb-1"></h4>
        </div> -->
    </div>
    <hr class='m-1'>
    <div class="card card-lg">
        <div class="card-body p-2">
            <table class="table datatable6 table-hover table-bordered" id="cobasisip">
                <thead style="background-color: blue !important">
                    <tr class="text-center">
                        <th rowspan="2">Tanggal</th>
                        <th colspan="2">Awal</th>
                        <th colspan="2">In</th>
                        <th colspan="2">Out</th>
                        <th colspan="2">Saldo</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th >Pcs</th>
                        <th >Kgs</th>
                        <th >Pcs</th>
                        <th >Kgs</th>
                        <th >Pcs</th>
                        <th >Kgs</th>
                        <th >Pcs</th>
                        <th >Kgs</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                    <?php $saldoawal=0; $saldo=0; foreach ($detail->result_array() as $det) { $saldo += $det['pcs']+$det['pcsin']-$det['pcsout']; 
                        if($det['nome']==1){
                            $saldoawal = $det['pcs']+$det['pcsin']-$det['pcsout'];
                        }else{
                            $saldoawal = $saldo;
                        }
                        ?>
                        <tr>
                            <td class="font-italic text-primary"><?= tgl_indo($det['tgl'],1); ?></td>
                            <td><?= rupiah($saldoawal,0); ?></td>
                            <td><?= rupiah($det['kgs'],2); ?></td>
                            <td><?= rupiah($det['pcsin'],0); ?></td>
                            <td><?= rupiah($det['kgsin'],2); ?></td>
                            <td><?= rupiah($det['pcsout'],0); ?></td>
                            <td><?= rupiah($det['kgsout'],2); ?></td>
                            <td class="font-bold text-primary"><?= rupiah($saldo,0); ?></td>
                            <td><?= rupiah($det['kgs']+$det['kgsin']-$det['kgsout'],2); ?></td>
                            <td><?= $det['nomor_dok']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr class="m-1">
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
        </div>
        <div class="col-4 text-primary font-bold">
            
        </div>
        <div class="col-4 font-bold">
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