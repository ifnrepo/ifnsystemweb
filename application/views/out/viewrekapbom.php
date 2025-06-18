<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="iddetail" class="btn btn-sm btn-danger hilang" value="">
            <div class="mb-1"><h4 class="mb-1">Nomor Dokumen : <?= $header['nomor_dok']; ?></h4></div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Specific</th>
                    <th>Sku</th>
                    <th>Sat</th>
                    <th class='text-center'>No<br>bale</th>
                    <th class='text-center'>Ex<br>net</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Kgs</th>
                    <th class="text-center">Stok<br>Qty</th>
                    <th class="text-center">Stok<br>Kgs</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                    <?php $totpcs=0;$totkgs=0; foreach($data->result_array() as $detail): ?>
                    <?php
                        $sku = formatsku($detail['po'],$detail['item'],$detail['dis'],$detail['id_barang']);
                        $namabarang = trim($detail['po'])=='' ? $detail['nama_barang'] : spekpo($detail['po'],$detail['item'],$detail['dis']);
                        $totpcs += $detail['totpcs'];
                        $totkgs += $detail['totkgs'];
                        $cekkurang = $detail['totkgs'] > $detail['kgsstok'] ? 'text-danger' : '';
                        $xnet = $detail['exnet']==0 ? '' : 'Y';
                    ?>
                        <tr class="font-kecil">
                            <td class="line-12 <?= $cekkurang; ?>"><?= $namabarang.'<br><span class="text-success">'.$detail['insno'].$detail['nobontr'].'</span>' ?></td>
                            <td><?= $sku ?></td>
                            <td><?= $detail['kode']; ?></td>
                            <td class='text-center'><?= $detail['nobale']; ?></td>
                            <td class='text-center text-success font-bold'><?= $xnet; ?></td>
                            <td class="text-right"><?= rupiah($detail['totpcs'],0); ?></td>
                            <td class="text-right"><?= rupiah($detail['totkgs'],4); ?></td>
                            <td class="text-right"><?= rupiah($detail['pcsstok'],0); ?></td>
                            <td class="text-right"><?= rupiah($detail['kgsstok'],4); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="bg-info-lt">
                        <td colspan="3" class="font-black text-center font-bold">TOTAL</td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-bold"><?= rupiah($totpcs,0); ?></td>
                        <td class="text-right font-bold"><?= rupiah($totkgs,4); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
    <button type="button" class="btn btn-success btn-sm text-black" data-bs-dismiss="modal">Keluar</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
</script>