<div class="container-xl">
    <!-- <div class="card p-1">
        <div class="card-body p-1">
            XX
        </div>
    </div> -->
    <table class="table table-bordered m-0">
        <thead class="bg-primary-lt">
            <tr>
                <th class="text-center text-black">Tgl/Kode</th>
                <th class="text-center text-black">Nomor</th>
                <th class="text-center text-black">Customer</th>
                <th class="text-center text-black">Perihal</th>
                <th class="text-center text-black">Status</th>
            </tr>
        </thead>
        <tbody class="table-tbody">
            <?php 
                switch ($data['status_hikiai']) {
                    case 0:
                        $strstat = 'Input Data';
                        $badgestat = 'badge badge-outline text-dark';
                        break;
                    case 1:
                        $strstat = 'Selesai Input';
                        $badgestat = 'badge bg-blue text-blue-fg';
                        break;
                    case 2:
                        $strstat = 'Kirim PPIC';
                        $badgestat = 'badge badge-outline text-pink';
                        break;
                    case 3:
                        $strstat = 'Hitung PPIC';
                        $badgestat = 'badge bg-pink text-pink-fg';
                        break;
                    case 4:
                        $strstat = 'Limit Diterima';
                        $badgestat = 'badge bg-green text-green-fg';
                        break;
                    case 5:
                        $strstat = 'Closed';
                        $badgestat = 'badge';
                        break;
                    case 6:
                        $strstat = 'Cancel';
                        $badgestat = 'badge bg-red text-red-fg';
                        break;
                    default:
                        # code...
                        break;
                }
            ?>
            <tr>
                <td class="font-kecil line-11"><span class="font-10 text-pink"><?= tglmysql($data['tgl_hikiai']) ?></span><br><?= $data['kode'] ?></td>
                <td class="font-kecil font-bold"><?= $data['nomor'] ?></td>
                <td class="font-kecil"><?= $data['nama_customer'] ?></td>
                <td class="font-kecil"><?= $data['perihal'] ?></td>
                <td class="font-kecil text-center"><span class="<?= $badgestat ?>"><?= $strstat ?></span></td>
            </tr>
        </tbody>
    </table>

    <div class="card mt-2">
        <div class="card-body p-1">
            <h5 class="text-dark bg-danger-lt p-1 mb-1">Data Detail Hikiai</h5>
            <table class="table table-bordered m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-center text-black">Item</th>
                        <th class="text-center text-black">Spesifikasi</th>
                        <th class="text-center text-black">Unit</th>
                        <th class="text-center text-black">Pcs</th>
                        <th class="text-center text-black">Kgs</th>
                        <th class="text-center text-black">Delivery Time</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php $jmlrek = 0; $jmlpcs=0; $jmlkgs=0; foreach($datadetail->result_array() as $det): $jmlrek++; $jmlpcs += $det['pcs']; $jmlkgs += $det['kgs']; ?>
                        <tr>
                            <td class="font-kecil text-center font-bold">#<?= $det['item'] ?></td>
                            <td class="font-kecil"><?= $det['spesifikasi'] ?></td>
                            <td class="font-kecil"><?= $det['kodesatuan'] ?></td>
                            <td class="font-kecil text-end"><?= rupiah($det['pcs'],0) ?></td>
                            <td class="font-kecil text-end"><?= rupiah($det['kgs'],2) ?></td>
                            <td class="font-kecil text-red">-</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="font-kecil"> Total Item : <?= $jmlrek ?></td>
                        <td colspan="2" class="font-kecil font-bold text-end">Total</td>
                        <td class="font-kecil text-end"><?= rupiah($jmlpcs,0) ?></td>
                        <td class="font-kecil text-end"><?= rupiah($jmlkgs,2) ?></td>
                        <td class="font-kecil"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    
</script>