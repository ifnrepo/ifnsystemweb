<div class="container-xl">
    <div class="row mb-1">
        <div class="col-3 font-bold">
            <span class="text-primary">Inventory per Tanggal</span>
            <h4 class="mb-1 text-teal-green"><?= tgl_indo(tglmysql($this->session->userdata('tglawal'))); ?> s/d <?= tgl_indo(tglmysql($this->session->userdata('tglakhir'))); ?></h4>
            <?php if($this->session->userdata('currdept')=='GF' || $this->session->userdata('currdept')=='GW'): ?>
            <?php if(trim($header['nobale']) != ''){ ?>
            <h3><?= 'Bale No #'.$header['nobale']; ?></h3>
            <?php } endif; ?>
        </div>
        <div class="col-7 text-primary font-bold">
            <span>SKU/Spesifikasi Barang</span>
            <?php $spekbarang = trim($header['po']) == '' ? $header['nama_barang'] : spekpo($header['po'],$header['item'],$header['dis']); ?>
            <?php $hilangtombol = $this->session->userdata('viewharga')==1 ? '' : 'hilang'; ?>
            <?php $nobc = trim($header['nomor_bc'])!='' ? 'BC.'.trim($header['jns_bc']).'-'.$header['nomor_bc'].'('.tglmysql($header['tgl_bc']).')<a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 '.$hilangtombol.'" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o"></i></a>' : ''; ?>
            <?php $nobcx = trim($header['nomor_bc'])!='' && trim($header['nomor_bc'])=='' ? 'No BC. '.$header['xbc'].'('.tglmysql($header['xtgl_bc']).')<a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 '.$hilangtombol.'" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o"></i></a>' : ''; ?>
            <?php $kode =  trim($header['po']) == '' ? $header['kode'] : viewsku($header['po'],$header['item'],$header['dis']); ?>
            <h4 class="mb-0 text-teal-green"><?= $header['id_barang'].' # '.$kode . " # " . $spekbarang; ?></h4>
            <h4 class="mb-1" style="color: #723f00;"><?= $nobc; ?><?= $nobcx; ?></h4>
            <hr class="m-0">
            <span class="font-12 text-red mr-4">KATEGORI : <?= $header['nama_kategori']; ?></span>
            <?php if($header['safety_stock']>0): ?>
            <span class="font-12 text-teal">( SAFETY STOCK : <?= rupiah($header['safety_stock'],0).' '.$header['kodesatuan']; ?> )</span>
            <?php endif; ?>
            <br>
        </div>
        <div class="col-2 m-auto">
            <a href="#kolap" class="btn btn-sm btn-info" id="cekkolap" data-toggle="collapse" aria-expanded="false">View BOM</a>
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
                        if ($det['mode'] == 'SALDO') {
                            $saldoawal = $det['saldopcs'] + $det['inpcs'] - $det['outpcs']-$det['adjpcs'];
                            $saldoawalkgs = $det['saldokgs'] + $det['inkgs'] - $det['outkgs']-$det['adjkgs'];
                        } else {
                            $saldoawal = $saldo;
                            $saldoawalkgs = $saldokgs;
                        }
                        if($init==1){
                            $xsaldo = $saldoawal;
                            $xsaldokgs = $saldoawalkgs;
                        }
                        $saldo += $det['saldopcs'] + $det['inpcs'] - $det['outpcs'] + $det['adjpcs'];
                        $saldokgs += $det['saldokgs'] + $det['inkgs'] - $det['outkgs']+ $det['adjkgs'];
                        $pilihtampil = $saldo==0 ? $saldokgs : $saldo;
                        $depnobontr = ['GM','SP'];
                        $boninsno = in_array($this->session->userdata('currdept'),$depnobontr) ? $det['nobontr'] : $det['insno'];
                        $saldo_akhirkgs += $saldokgs;
                        $saldo_akhirpcs += $saldo;
                        $warnatek = $det['mode']=='ADJ' ? '' : '';
                        $jmpcin += $det['inpcs'];
                        $jmkgin += $det['inkgs'];
                        $jmpcout += $det['outpcs'];
                        $jmkgout += $det['outkgs'];
                        $jmpcadj += $det['adjpcs'];
                        $jmkgadj += $det['adjkgs'];
                    ?>
                        <tr>
                            <td class="font-italic text-primary <?= $warnatek; ?>"><?= tgl_indo($det['tgl'], 0); ?></td>
                            <td><?= $boninsno; ?></td>
                            <td class="text-right"><?= rupiah($saldoawal, 0); ?></td>
                            <td class="text-right"><?= rupiah($saldoawalkgs, 2); ?></td>
                            <td class="text-right"><?= rupiah($det['inpcs'], 0); ?></td>
                            <td class="text-right"><?= rupiah($det['inkgs'], 2); ?></td>
                            <td class="text-right"><?= rupiah($det['outpcs'], 0); ?></td>
                            <td class="text-right"><?= rupiah($det['outkgs'], 2); ?></td>
                            <td class="text-right text-pink" ><?= rupiah($det['adjpcs'], 0); ?></td>
                            <td class="text-right text-pink" ><?= rupiah($det['adjkgs'], 2); ?></td>
                            <td class="text-right" class="font-bold text-primary"><?= rupiah($saldo, 0); ?></td>
                            <td class="text-right"><?= rupiah($saldokgs, 4); ?></td>
                            <?php if($this->session->userdata('invharga')): ?>
                            <td class="text-right"><?= rupiah($det['harga'], 2); ?></td>
                            <td class="text-right"><?= rupiah($det['harga']*$pilihtampil, 2); ?></td>
                            <?php endif; ?>
                            <td><?= $det['nomor_dok']; ?></td>
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
                        <td class="text-right font-bold"><?= rupiah($xsaldokgs+$jmkgin+$jmkgadj-$jmkgout,4); ?></td>
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
    <div class="collapse" id="kolap">
        <div class="text-cyan font-bold mb-1 w-100 bg-cyan-lt text-center">DETAIL BOM</div>
        <table class="table datatable6 table-hover" id="cobasisip">
            <thead style="background-color: blue !important">
                <tr>
                <!-- <th>No</th> -->
                <th>Specific</th>
                <th>SKU</th>
                <th>Satuan</th>
                <th>Persen</th>
                <th>Kgs</th>
                <th>Info BC</th>
                <th>Ket</th>
                </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                <?php $saldobom=0; if(isset($detailbom) && $detailbom->num_rows() > 0){ ?>
                <?php foreach($detailbom->result_array() as $detbom): ?>
                <?php 
                    $sku = kodeimdo($detbom['id_barang']);
                    $bomsm = $detbom['persen_sm'] > 0 ? 'text-orange' : '';
                    $saldobom += round($saldokgs*($detbom['persen']/100),3);
                    $persen = $detbom['persen']+$detbom['persen_sm'];
                ?>
                    <tr>
                        <td class="<?= $bomsm ?>"><?= $detbom['seri_barang'].'. '.$detbom['nama_barang']; ?></td>
                        <td class="<?= $bomsm ?>"><?= $sku; ?></td>
                        <td class="<?= $bomsm ?>"><?= $detbom['kodesatuan']; ?></td>
                        <td class="text-right <?= $bomsm ?>"><?= rupiah($persen,6) ?></td>
                        <td class="text-right <?= $bomsm ?>"><?= rupiah($saldokgs*($detbom['persen']/100),3); ?></td>
                        <?php $nomorbc = trim($detbom['xnomor_bc'])=='' ? '-' : 'BC. '.$detbom['xnomor_bc']; $tglbc = trim($detbom['xnomor_bc'])=='' ? '-' : '('.$detbom['xtgl_bc'].')';  ?>
                        <td style="line-height: 11px;" class="font-12"><?= $nomorbc ?><br><span class="text-teal"><?= $tglbc; ?></span></td>
                        <td class="line-11 font-11 text-muted"><span><?= $detbom['nobontr'] ?></span><br><span><?= 'ID Bom. '.$detbom['id_bom'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
                    <tr class="bg-dark-lt">
                        <td colspan="4" class="text-center font-bold">Total BOM</td>
                        <td class="text-right font-bold"><?= rupiah($saldobom,2) ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } else { ?>
                    <tr class="bg-dark-lt">
                        <td colspan="9" class="text-center">Data BOM tidak ditemukan</td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    <div>
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