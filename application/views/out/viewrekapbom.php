<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="iddetail" class="btn btn-sm btn-danger hilang" value="">
            <div class="mb-1 line-12"><h4 class="mb-1">Nomor Dokumen : <?= $header['nomor_dok']; ?></h4><span class="text-pink" style="font-style: italic;">Periode Inventory : "<?= tambahnol($this->session->userdata('blout')).'-'.$this->session->userdata('thout'); ?>"</span></div>
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
                        $xnet = $detail['exnet']==0 ? '' : 'Y';
                        $periode = tambahnol($this->session->userdata('blout')).$this->session->userdata('thout');
                        $stokdept = getstokdeptbaru(dept: $detail['dept_id'],po: $detail['po'],item: $detail['item'],dis: $detail['dis'],insno: $detail['insno'],nobontr: $detail['nobontr'],nomor_bc: $detail['nomor_bc'],dln: $detail['dln'],id_barang: $detail['id_barang'],nobale: $detail['nobale'],exnet: $detail['exnet'],periode: $periode)->row_array();
                        $kgsstok = $stokdept['kgsstok'];
                        $pcsstok = $stokdept['pcsstok'];
                        if($sku=='P6974831'){
                            $cekkurang =  '';
                            $cekkurangpcs =  '';
                        }else{
                            $cekkurang = $detail['totkgs'] > $kgsstok ? ' text-danger' : '';
                            $cekkurangpcs = $detail['totpcs'] > $pcsstok ? ' text-danger' : '';
                        }
                    ?>
                        <tr class="font-kecil">
                            <td class="line-12 <?= $cekkurang; ?><?= $cekkurangpcs; ?>"><?= $namabarang.'<br><span class="text-success">'.$detail['insno'].$detail['nobontr'].'</span>' ?></td>
                            <td class="line-12"><?= $sku ?><br><span class="text-pink"><?= $detail['nomor_bc'] ?></span></td>
                            <td><?= $detail['kode']; ?></td>
                            <td class='text-center'><?= $detail['nobale']; ?></td>
                            <td class='text-center text-success font-bold'><?= $xnet; ?></td>
                            <td class="text-right <?= $cekkurangpcs; ?>"><?= rupiah($detail['totpcs'],0); ?></td>
                            <td class="text-right <?= $cekkurang; ?>"><?= rupiah($detail['totkgs'],4); ?></td>
                            <td class="text-right <?= $cekkurangpcs; ?>"><?= rupiah($pcsstok,0); ?></td>
                            <td class="text-right <?= $cekkurang; ?>"><?= rupiah($kgsstok,4); ?></td>
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