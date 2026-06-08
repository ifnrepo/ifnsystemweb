<div class="container-xl mb-2">
    <div class="row overflow-auto">
        <div class="col-12">
            <input type="text" class="hilang" id="deptnya" value="<?= $dept ?>">
            <table class="table table-bordered table-hover m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-black">Aksi</th>
                        <th class="text-black">SKU</th>
                        <th class="text-black">Spek Barang</th>
                        <th class="text-black">Stok</th>
                        <?php if($dept=='GF' || $dept['GW']): ?>
                            <th class="text-black">Pcs</th>
                            <th class="text-black">Kgs</th>
                        <?php else: ?>
                            <th class="text-black">Insno/Nobontr</th>
                            <th class="text-black">Exnet</th>
                        <?php endif; ?>
                        <th class="text-black">Nobale</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php foreach($data->result_array() as $dt): ?>
                    <?php 
                        $sku = trim($dt['po'])=='' ? $dt['kode'] : viewsku($dt['po'],$dt['item'],$dt['dis']);
                        $spek = trim($dt['po'])=='' ? $dt['nama_barang'] : spekpo($dt['po'],$dt['item'],$dt['dis']);
                        $stok = $dt['stok']==0 ? '' : ($dt['stok']==1 ? 'Grade A' : 'Grade B');
                        $exnet = $dt['exnet']==0 ? '' : 'Y';
                     ?>
                        <tr>
                            <td class="font-kecil text-center">
                                <a href="#" 
                                    id="pilihbarang",
                                    class="btn btn-sm btn-success" 
                                    style="padding: 2px 4px !important;" 
                                    rel1="<?= $dt['po'] ?>"
                                    rel2="<?= $dt['item'] ?>"
                                    rel3="<?= $dt['dis'] ?>"
                                    rel4="<?= $dt['id_barang'] ?>"
                                    rel5="<?= $dt['insno'] ?>"
                                    rel6="<?= $dt['nobontr'] ?>"
                                    rel7="<?= $dt['stok'] ?>"
                                    rel8="<?= $dt['exnet'] ?>"
                                    rel9="<?= $spek ?>"
                                    rel10="<?= $sku ?>"
                                    rel11="<?= $dt['dln'] ?>"
                                    rel12="<?= $dt['nobale'] ?>"
                                    rel13="<?= $dt['kgs_akhir'] ?>"
                                    rel14="<?= $dt['pcs_akhir'] ?>"
                                >
                                    Pilih
                                </a>
                            </td>
                            <td class="font-kecil"><?= $sku ?></td>
                            <td class="font-kecil"><?= $spek ?></td>
                            <td class="font-kecil"><?= $stok ?></td>
                            <?php if($dept=='GF' || $dept['GW']): ?>
                                <td class="font-kecil text-right"><?= rupiah($dt['pcs_akhir'],2); ?></td>
                                <td class="font-kecil text-right"><?= rupiah($dt['kgs_akhir'],2); ?></td>
                            <?php else: ?>
                                <td class="font-kecil"><?= $exnet ?></td>
                                <td class="font-kecil"><?= $dt['insno'].$dt['nobontr'] ?></td>
                            <?php endif; ?>
                            <td class="font-kecil"><?= $dt['nobale'] ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr class="m-1">
            <div class="text-right">
                <button type="button" id="tutup" class="btn btn-sm bt-ghost-danger me-auto" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#katedept_id").change();
    })
    $(document).on('click','#pilihbarang',function(){
        $("#form-hasilcari").removeClass('hilang');
	    $("#form-cari").addClass('hilang');
        $("#po").val($(this).attr('rel1'));
        $("#item").val($(this).attr('rel2'));
        $("#dis").val($(this).attr('rel3'));
        $("#idbarang").val($(this).attr('rel4'));
        $("#insno").val($(this).attr('rel5'));
        $("#nobontr").val($(this).attr('rel6'));
        $("#stok").val($(this).attr('rel7'));
        $("#exnet").val($(this).attr('rel8'));
        $("#spek").val($(this).attr('rel9'));
        $("#sku").val($(this).attr('rel10'));
        $("#dln").val($(this).attr('rel11'));
        $("#nobale").val($(this).attr('rel12'));
        if($("#deptnya").val()=='GF' || $("#deptnya").val()=='GW' ){
            $("#kgs").val($(this).attr('rel13'));
            $("#pcs").val($(this).attr('rel14'));
            $("#satuan").val('PCS');
        }
        $("#po").change();
        $("#keywordinputstok").val('');
        $("#sku").focus();
        $("#tutup").click();
    })
</script>