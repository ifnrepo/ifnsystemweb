<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card-body">
            <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
            <div class="card card-lg">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th class="text-primary">Tgl Terima</th>
                            <th class="text-primary">SKU</th>
                            <th class="text-primary">Nama Barang</th>
                            <th class="text-primary">Nomor BC</th>
                            <th class="text-primary">Satuan</th>
                            <th class="text-primary">Pcs</th>
                            <th class="text-primary">Kgs</th>
                        </tr>
                    </thead>
                    <tbody class=" table-tbody" style="font-size: 13px !important;">
                     <?php 
                        $no=0;
                        foreach($transaksi->result_array() as $transaksi){ 
                            $no++;
                            $sku = trim($transaksi['po'])=='' ? $transaksi['id_barang'] : viewsku($transaksi['po'],$transaksi['item'],$transaksi['dis']);
                            // $spekbarang = trim($transaksi['po'])=='' ? namaspekbarang($transaksi['id_barang']) : spekpo($transaksi['po'],$transaksi['item'],$transaksi['dis']);
                    ?>
                        <tr>
                            <td><?= $no.' # '.$transaksi['seri_urut_akb'] ?></td>
                            <td><?= $sku ?></td>
                            <td><?= $transaksi['pcs'] ?></td>
                            <td><?= $transaksi['kgs'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr class="m-0">