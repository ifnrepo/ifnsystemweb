<div class="container-xl">
    <div class="row mb-1">
        <div class="col-3 font-bold">
            <span class="text-primary">Inventory per Tanggal</span>
            <h4 class="mb-1 text-teal-green"><?= tgl_indo(tglmysql($this->session->userdata('tglawal')), 1); ?></h4>
            <?php if($this->session->userdata('currdept')=='GF'): ?>
            <h3><?= 'Bale No #'.$header['nobale']; ?></h3>
            <?php endif; ?>
        </div>
        <div class="col-7 text-primary font-bold">
            <span>SKU/Spesifikasi Barang</span>
            <?php $spekbarang = $header['nama_barang'] == null ? $header['spek'] : $header['nama_barang']; ?>
            <?php $hilangtombol = $this->session->userdata('viewharga')==1 ? '' : 'hilang'; ?>
            <?php $nobc = trim($header['nomor_bc'])!='' ? 'BC.'.trim($header['jns_bc']).'-'.$header['nomor_bc'].'('.tglmysql($header['tgl_bc']).')<a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 '.$hilangtombol.'" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o"></i></a>' : ''; ?>
            <?php $nobcx = trim($header['xbc'])!='' && trim($header['nomor_bc'])=='' ? 'No BC. '.$header['xbc'].'('.tglmysql($header['xtgl_bc']).')<a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 '.$hilangtombol.'" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o"></i></a>' : ''; ?>
            <h4 class="mb-0 text-teal-green"><?= $header['idd'] . " # " . $spekbarang; ?></h4>
            <h4 class="mb-1" style="color: #723f00;"><?= $nobc; ?><?= $nobcx; ?></h4>
            <hr class="m-0">
            <span class="font-12 text-red mr-4">KATEGORI : <?= $header['name_kategori']; ?></span>
            <?php if($header['safety_stock']>0): ?>
            <span class="font-12 text-teal">( SAFETY STOCK : <?= rupiah($header['safety_stock'],0).' '.$header['kodesatuan']; ?> )</span>
            <?php endif; ?>
            <br>
        </div>
        <div class="col-2 <?php if($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='SP'){ echo "hilang"; } ?>">
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
            <table class="table datatable6 table-hover table-bordered" id="cobasisip">
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
                    <?php $saldoawal = 0;
                    $saldoawalkgs = 0;
                    $saldo = 0;
                    $saldokgs = 0;
                    foreach ($detail->result_array() as $det) {

                        if ($det['nome'] == 1) {
                            $saldoawal = $det['pcs'] + $det['pcsin'] - $det['pcsout']-$det['pcsadj'];
                            $saldoawalkgs = $det['kgs'] + $det['kgsin'] - $det['kgsout']-$det['kgsadj'];
                        } else {
                            $saldoawal = $saldo;
                            $saldoawalkgs = $saldokgs;
                        }
                        $saldo += $det['pcs'] + $det['pcsin'] - $det['pcsout'] - $det['pcsadj'];
                        $saldokgs += $det['kgs'] + $det['kgsin'] - $det['kgsout']- $det['kgsadj'];
                        $pilihtampil = $saldo==0 ? $saldokgs : $saldo;
                        $depnobontr = ['GM','SP'];
                        $boninsno = in_array($this->session->userdata('currdept'),$depnobontr) ? $det['nobontr'] : $det['insno'];
                    ?>
                        <tr>
                            <td class="font-italic text-primary"><?= tgl_indo($det['tgl'], 0); ?></td>
                            <td><?= $boninsno; ?></td>
                            <td><?= rupiah($saldoawal, 0); ?></td>
                            <td><?= rupiah($saldoawalkgs, 2); ?></td>
                            <td><?= rupiah($det['pcsin'], 0); ?></td>
                            <td><?= rupiah($det['kgsin'], 2); ?></td>
                            <td><?= rupiah($det['pcsout'], 0); ?></td>
                            <td><?= rupiah($det['kgsout'], 2); ?></td>
                            <td><?= rupiah($det['pcsadj'], 0); ?></td>
                            <td><?= rupiah($det['kgsadj'], 2); ?></td>
                            <td class="font-bold text-primary"><?= rupiah($saldo, 0); ?></td>
                            <td><?= rupiah($saldokgs, 2); ?></td>
                            <?php if($this->session->userdata('invharga')): ?>
                            <td class="text-right"><?= rupiah($det['harga'], 2); ?></td>
                            <td class="text-right"><?= rupiah($det['harga']*$pilihtampil, 2); ?></td>
                            <?php endif; ?>
                            <td><?= $det['nomor_dok']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
        <span class="text-orange font-bold mb-1">DETAIL BOM</span>
        <table class="table datatable6 table-hover" id="cobasisip">
            <thead style="background-color: blue !important">
                <tr>
                <!-- <th>No</th> -->
                <th>Specific</th>
                <th>SKU</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Kgs</th>
                <th>Info BC</th>
                </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                <?php if(isset($detailbom) && $detailbom->num_rows() > 0): ?>
                <?php foreach($detailbom->result_array() as $detbom): ?>
                <?php 
                    $sku = $detbom['kode'];
                ?>
                    <tr>
                        <td><?= $detbom['nama_barang']; ?></td>
                        <td><?= $sku; ?></td>
                        <td><?= $detbom['namasatuan']; ?></td>
                        <td class="text-right"></td>
                        <td class="text-right"><?= rupiah($saldokgs*($detbom['persen']/100),2); ?></td>
                        <td style="line-height: 14px;"><?= 'BC .'.$detbom['jns_bc'] ?><br><span class="text-teal"><?= $detbom['nomor_bc'].'('.$detbom['tgl_bc'].')'; ?></span></td>
                    </tr>
                <?php endforeach; endif; ?>
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