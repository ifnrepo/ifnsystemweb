<div class="container-xl mb-2">
    <div class="row overflow-auto">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">SKU</label>
                <div class="col">
                    <?php $sku  = trim($header['po'])=='' ? $header['kode'] : $header['skupo']; ?>
                    <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" value="<?=  $sku ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Spesifikasi</label>
                <div class="col">
                    <?php $spek  = trim($header['po'])=='' ? $header['nama_barang'] : spekpo($header['po'],$header['item'],$header['dis']); ?>
                    <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" value="<?= htmlspecialchars($spek) ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Instruksi</label>
                <div class="col">
                    <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" value="<?= $header['insno'] ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Pcs</label>
                <div class="col">
                    <input type="email" class="form-control font-kecil text-right font-bold" aria-describedby="emailHelp" value="<?= rupiah($header['pcs'],1) ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-3 col-form-label font-kecil">Kgs</label>
                <div class="col">
                    <input type="email" class="form-control font-kecil text-right font-bold" aria-describedby="emailHelp" value="<?= rupiah($header['kgs'],2) ?>">
                </div>
            </div>
            <table class="table table-bordered table-hover m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-black">SKU</th>
                        <th class="text-black">Spek Barang</th>
                        <th class="text-black line-11">Insno<br><span class="text-pink">Nobontr</span></th>
                        <th class="text-black">Grd</th>
                        <th class="text-black">Exnet</th>
                        <th class="text-black">Kgs</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php $jmlkgs=0; foreach($detail->result_array() as $dt): ?>
                    <?php 
                        $stok = $dt['stok']==1 ? 'Grd A' : ($dt['stok']==2 ? 'Grd B' : '');
                        $exnet = $dt['exnet']==1 ? 'Y' : '';
                        $jmlkgs += $dt['kgs'];
                        $skudet = trim($dt['po'])!='' ? viewsku($dt['po'],$dt['item'],$dt['dis']) : $dt['kode'];
                        $spekdet = trim($dt['po'])!='' ? spekpo($dt['po'],$dt['item'],$dt['dis']) : $dt['nama_barang'];
                    ?>
                        <tr>
                            <td class="font-kecil"><?= $skudet ?></td>
                            <td class="font-kecil"><?= $spekdet ?></td>
                            <td class="font-kecil line-11"><?= $dt['insno'] ?><br><span class="font-10 text-pink"><?= $dt['nobontr'] ?></span></td>
                            <td class="font-kecil text-center"><?= $stok ?></td>
                            <td class="font-kecil text-center"><?= $exnet ?></td>
                            <td class="font-kecil text-right"><?= rupiah($dt['kgs'],2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" class="font-bold text-right">Jumlah</td>
                        <td class="text-right font-bold"><?= rupiah($jmlkgs,2) ?></td>
                    </tr>
                </tbody>
            </table>
            <hr class="m-1">
            <div class="text-right">
                <button type="button" id="tutup" class="btn btn-sm btn-danger me-auto" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>

<script>
   
</script>