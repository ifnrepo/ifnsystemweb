<div class="container-xl">
    <div class="row mb-1">
        <div class="col-3 font-bold">
            <span class="text-primary">Inventory per Tanggal</span>
            <h4 class="mb-1 text-teal-green"><?= tgl_indo($this->session->userdata('tglawalbcgf')); ?> s/d <?= tgl_indo($this->session->userdata('tglakhirbcgf')); ?></h4>
            <div class="line-10"><span class="text-pink font-11">No Bale</span><br><h2><?= $header['nobale'] ?></h2></div>
        </div>
        <div class="col-7 text-primary font-bold">
            <span>SKU/Spesifikasi Barang</span>
            <?php $spekbarang = trim($header['po']) == '' ? namaspekbarang($header['id_barang']) : spekpo($header['po'],$header['item'],$header['dis']); ?>
            <?php $sku = trim($header['po']) == '' ? namaspekbarang($header['id_barang'],'kode') : viewsku($header['po'],$header['item'],$header['dis']); ?>
            <h4 class="mb-0 text-teal-green"><?= '('.$sku . ") # " . $spekbarang; ?></h4>
            <h4 class="mb-1" style="color: #723f00;">-</h4>
            <hr class="m-0">
            <span class="font-12 text-red mr-4">KATEGORI : </span>
            <?php if($header['safety_stock']>0): ?>
            <span class="font-12 text-teal">( SAFETY STOCK :  )</span>
            <?php endif; ?>
            <br>
        </div>
        <div class="col-2">
        </div>
        <!-- <div class="col-4 text-primary font-bold">
        <span>Dibuat Oleh</span>
        <h4 class="mb-1"></h4>
        </div> -->
    </div>
    <hr class='m-1'>
    <div class="card card-lg" id="cekkolape">
        <div class="card-body p-2">
            <table class="table datatable6 table-hover table-bordered mb-0" id="cobasisip">
                <thead style="background-color: blue !important">
                    <tr class="text-center">
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Nomor IB</th>
                        <th colspan="2">Awal</th>
                        <th colspan="2">In</th>
                        <th colspan="2">Out</th>
                        <th colspan="2">ADJ</th>
                        <th colspan="2">Saldo</th>
                        <?php if($this->session->userdata('invharga')): ?>
                        <th rowspan="2">Harga</th>
                        <th rowspan="2">Total</th>
                        <?php endif; ?>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                    <?php 
                    $jmpcin = 0;
                    $jmkgin = 0;
                    $jmpcout = 0;
                    $jmkgout = 0;
                    $jmpcadj = 0;
                    $jmkgadj = 0;
                    $saldoawal = 0;
                    $saldoawalkgs = 0;
                    $saldo = 0;
                    $saldokgs = 0;
                    $saldo_akhirkgs = 0;
                    $saldo_akhirpcs = 0;
                    $init = 0;
                    $xsaldo=0;$xsaldokgs=0;
                    foreach ($detail->result_array() as $det) {
                        $init++;
                        if ($init == 1) {
                            $saldoawal = $det['saldopcs'] + $det['inpcs'] - $det['outpcs'] + $det['adjpcs'];
                            $saldoawalkgs = $det['saldokgs'] + $det['inkgs'] - $det['outkgs'] + $det['adjkgs'];
                        } else {
                            $saldoawal = $saldo;
                            $saldoawalkgs = $saldokgs;
                        }
                        if($init==1 && $det['nomor_dok']=='SALDO'){
                            $xsaldo = $saldoawal;
                            $xsaldokgs = $saldoawalkgs;
                        }
                        $saldo += $det['saldopcs'] + $det['inpcs'] - $det['outpcs'] + $det['adjpcs'];
                        $saldokgs += $det['saldokgs'] + $det['inkgs'] - $det['outkgs'] + $det['adjkgs'];
                        $pilihtampil = $saldo==0 ? $saldokgs : $saldo;
                        $depnobontr = ['GM','SP'];
                        $boninsno = '';
                        $adjpcsplus = 0;$adjkgsplus = 0;
                        $adjpcsmin = 0;$adjkgsmin = 0;
                        if($det['kodeinv']==3){
                            if($det['adjpcs'] > 0){
                                $adjpcsplus = $det['adjpcs'];
                            }else{
                                $adjpcsmin = $det['adjpcs']*-1;
                            }
                            if($det['adjkgs'] > 0){
                                $adjkgsplus = $det['adjkgs'];
                            }else{
                                $adjkgsmin = $det['adjkgs']*-1;
                            }
                        }
                        $saldo_akhirkgs += $saldokgs;
                        $saldo_akhirpcs += $saldo;
                        $warnatek = $det['kodeinv']==3 ? '' : '';
                        $jmpcin += $det['inpcs']+$adjpcsplus;
                        $jmkgin += $det['inkgs']+$adjkgsplus;
                        $jmpcout += $det['outpcs']+$adjpcsmin;
                        $jmkgout += $det['outkgs']+$adjkgsmin;
                        $jmpcadj += 0;
                        $jmkgadj += 0;
                       
                    ?>
                        <tr>
                            <td class="font-italic text-primary <?= $warnatek; ?>"><?= tgl_indo($det['tgl'], 0); ?></td>
                            <td><?= $boninsno; ?></td>
                            <td class="text-right"><?= rupiah($saldoawal, 0); ?></td>
                            <td class="text-right"><?= rupiah($saldoawalkgs, 2); ?></td>
                            <td class="text-right"><?= rupiah($det['inpcs']+$adjpcsplus, 0); ?></td>
                            <td class="text-right"><?= rupiah($det['inkgs']+$adjkgsplus, 2); ?></td>
                            <td class="text-right"><?= rupiah($det['outpcs']+$adjpcsmin, 0); ?></td>
                            <td class="text-right"><?= rupiah($det['outkgs']+$adjkgsmin, 2); ?></td>
                            <td class="text-right text-pink" ><?= rupiah(0, 0); ?></td>
                            <td class="text-right text-pink" ><?= rupiah(0, 2); ?></td>
                            <td class="text-right" class="font-bold text-primary"><?= rupiah($saldo, 0); ?></td>
                            <td class="text-right"><?= rupiah($saldokgs, 2); ?></td>
                            <?php if($this->session->userdata('invharga')): ?>
                            <td class="text-right"><?= rupiah($det['harga'], 2); ?></td>
                            <td class="text-right"><?= rupiah($det['harga']*$pilihtampil, 2); ?></td>
                            <?php endif; ?>
                            <td><?= $det['nomor_dok'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="bg-dark-lt">
                        <td colspan="2" class="text-center font-bold">TOTAL</td>
                        <td class="text-right font-bold"><?= rupiah($xsaldo,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($xsaldokgs,2); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmpcin,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmkgin,2); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmpcout,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmkgout,2); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmpcadj,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($jmkgadj,2); ?></td>
                        <td class="text-right font-bold"><?= rupiah($xsaldo+$jmpcin+$jmpcadj-$jmpcout,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($xsaldokgs+$jmkgin+$jmkgadj-$jmkgout,2); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center m-0 p-0 font-bold">
                Saldo Barang Saat Ini 
                <br> <span class="text-primary ml-1"><?= rupiah($saldokgs, 2).' Kgs'; ?></span>
                <br> <span class="text-primary ml-1"><?= rupiah($saldo, 2).' Pcs'; ?></span>
            </div>
             
        </div>
    </div>
    <div class="card hilang" id="dokfile">
      <div class="card-body pt-1 pb-1" style="overflow: auto;">
        <?php if(isset($dok['filedok']) || isset($dok2)){ if($dok['filedok']!='' || $dok['filedok']!=NULL || $dok2!='' || $dok2!=NULL){ ?>
            <iframe src="<?= base_url().LOK_UPLOAD_DOKHAMAT.$dok['filedok']; ?>" style="width:100%;height:700px;" alt="Tidak ditemukan"></iframe>
        <?php }else{ ?>
            <div class="text-center font-bold m-0"><h3>BELUM ADA DOKUMEN</h3></div>
        <?php } }else{ ?>
            <div class="text-center font-bold m-0"><h3>BELUM ADA DOKUMEN</h3></div>
        <?php } ?>
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
    $(document).ready(function() {
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
    })
    $("#viewdokhamat").click(function(){
        if($("#cekkolape").hasClass('hilang')){
            $("#cekkolape").removeClass('hilang');
            $("#dokfile").addClass('hilang');
        }else{
            $("#cekkolape").addClass('hilang');
            $("#dokfile").removeClass('hilang');
        }
    });
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