<div class="page-body mt-0">
    <div class="container-xl">
        <div class="row font-kecil">
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Nomor/Tgl Kontrak</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= $header['nomor'].' Tgl.'.tglmysql($header['tgl']) ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Tgl Berlaku</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= tglmysql($header['tgl_awal']).' s/d '.tglmysql($header['tgl_akhir']) ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i></i> </label>
                <div class="col">
                    <div class="row">
                        <div class="mb-1 row pr-0">
                            <label class="col-3 col-form-label"><i>Qty</i> </label>
                            <div class="col pr-0">
                                <input type="text" class="form-control font-kecil text-right btn-flat" value="<?= rupiah($header['pcs'],0) ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row pr-0">
                            <label class="col-3 col-form-label"><i>Kgs</i> </label>
                            <div class="col pr-0">
                                <input type="text" class="form-control font-kecil text-right btn-flat" value="<?= rupiah($header['kgs'],2) ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table datatable table-bordered">
            <thead>
                <tr>
                    <th class="text-primary">Rekap IN/OUT</th>
                    <th class="text-primary text-center">Pcs OUT</th>
                    <th class="text-primary text-center">Kgs OUT</th>
                    <th class="text-primary text-center">Pcs IN</th>
                    <th class="text-primary text-center">Kgs IN</th>
                    <th class="text-primary text-center">Saldo</th>
                    <th class="text-primary text-center">Saldo</th>
                </tr>
            </thead>
            <tbody class=" table-tbody" style="font-size: 12px !important;">
                <tr>
                    <td>Rekap IN/OUT</td>
                    <td class="text-right" id="outpcs">...</td>
                    <td class="text-right" id="outkgs">...</td>
                    <td class="text-right" id="inpcs">...</td>
                    <td class="text-right" id="inkgs">...</td>
                    <td class="text-right" id="saldopcs">...</td>
                    <td class="text-right" id="saldokgs">...</td>
                    
                </tr>
            </tbody>
        </table>
        <hr class="m-1">
        <ul class="nav nav-tabs card-header-tabs font-kecil" data-bs-toggle="tabs">
            <li class="nav-item">
                <a href="#tabs-rekap" class="nav-link bg-primary-lt active btn-flat text-black" data-bs-toggle="tab">Rekap</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-jamin" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Jaminan</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-rekap">
                <div class="card-body">
                    <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                    <div class="card card-lg">
                        <table class="table datatable">
                            <thead class="sticky-top">
                                <tr>
                                    <th class="text-primary">X</th>
                                    <th class="text-primary">SKU</th>
                                    <th class="text-primary">Nama Barang</th>
                                    <th class="text-primary">Satuan</th>
                                    <th class="text-primary text-center">Pcs<br>Out</th>
                                    <th class="text-primary text-center">Kgs<br>Out</th>
                                    <th class="text-primary text-center">Pcs<br>In</th>
                                    <th class="text-primary text-center">Kgs<br>In</th>
                                    <th class="text-primary text-center">Saldo<br>Pcs</th>
                                    <th class="text-primary text-center">Saldo<br>Kgs</th>
                                </tr>
                            </thead>
                            <tbody class=" table-tbody" style="font-size: 13px !important;">
                            <?php 
                                $no=0;
                                $jumkgskirim =0;$jumpcskirim=0;
                                $jumkgsterima =0;$jumpcsterima=0;
                                $kodmas = '';
                                $saldokgs = 0;
                                $saldopcs = 0;
                                foreach($transaksi->result_array() as $transaksi){ 
                                    $no++;
                                    if($transaksi['kirter']==0){
                                        $jumkgskirim += round($transaksi['kgsx'],2);
                                        $jumpcskirim += $transaksi['pcsx'];
                                    }else{
                                        $jumkgsterima += round($transaksi['kgsx'],2);
                                        $jumpcsterima += $transaksi['pcsx'];
                                    }
                                    $indexkode = $transaksi['po'].$transaksi['item'].$transaksi['dis'].$transaksi['id_barang'].$transaksi['insno'];
                                    if($kodmas == $indexkode){
                                        if($transaksi['kirter']==0){
                                            $saldokgs += round($transaksi['kgsx'],2);
                                            $saldopcs += $transaksi['pcsx'];
                                        }else{
                                            $saldokgs -= round($transaksi['kgsx'],2);
                                            $saldopcs -= $transaksi['pcsx'];
                                        }
                                    }else{
                                        $saldokgs = round($transaksi['kgsx'],2);
                                        $saldopcs = $transaksi['pcsx'];
                                    }
                                    $kodmas = $indexkode;
                                    $kirter = $transaksi['kirter']==0 ? 'OUT' : 'IN';
                                    $warnakirter = $transaksi['kirter']==0 ? 'text-teal' : 'text-pink';
                                    // $jumkgskirim += round($transaksi['kgs'],2);
                                    $sku = trim($transaksi['po'])=='' ? $transaksi['kode'] : viewsku($transaksi['po'],$transaksi['item'],$transaksi['dis']);
                                    $spekbarang = trim($transaksi['po'])=='' ? namaspekbarang($transaksi['id_barang']) : spekpo($transaksi['po'],$transaksi['item'],$transaksi['dis']);
                            ?>
                                <tr>
                                    <td class="<?= $warnakirter ?>"><?= $kirter ?></td>
                                    <td><?= $sku ?></td>
                                    <td class="line-12"><?= $spekbarang ?><br><span class="text-teal font-11"><?= $transaksi['insno'] ?></span></td>
                                    <td><?= $transaksi['insno'] ?></td>
                                    <?php if($transaksi['kirter']==0){ ?>
                                        <td class="text-right"><?= rupiah($transaksi['pcsx'],0) ?></td>
                                        <td class="text-right"><?= rupiah($transaksi['kgsx'],2) ?></td>
                                        <td class="text-right"><?= rupiah(0,0) ?></td>
                                        <td class="text-right"><?= rupiah(0,2) ?></td>
                                    <?php }else{ ?>
                                        <td class="text-right"><?= rupiah(0,0) ?></td>
                                        <td class="text-right"><?= rupiah(0,2) ?></td>
                                        <td class="text-right"><?= rupiah($transaksi['pcsx'],0) ?></td>
                                        <td class="text-right"><?= rupiah($transaksi['kgsx'],2) ?></td>
                                    <?php } ?>
                                    <td class="text-right"><?= rupiah($saldopcs,0) ?></td>
                                    <td class="text-right"><?= rupiah($saldokgs,2) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="font-bold text-center">TOTAL</td>
                                <td class="text-right font-bold text-teal" id="outpcsx"><?= rupiah($jumpcskirim,0) ?></td>
                                <td class="text-right font-bold text-teal" id="outkgsx"><?= rupiah($jumkgskirim,2) ?></td>
                                <td class="text-right font-bold text-pink" id="inpcsx"><?= rupiah($jumpcsterima,0) ?></td>
                                <td class="text-right font-bold text-pink" id="inkgsx"><?= rupiah($jumkgsterima,2) ?></td>
                                <td class="text-right font-bold" id="saldopcsx"><?= rupiah($jumpcskirim-$jumpcsterima,0) ?></td>
                                <td class="text-right font-bold" id="saldokgsx"><?= rupiah($jumkgskirim-$jumkgsterima,2) ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade active p-2" id="tabs-jamin">
                <div class="font-kecil font-bold bg-red-lt p-1">PERHITUNGAN</div>
                <div class="card card-lg">
                    ON PROGRESS
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="m-0">

<script>
    $(document).ready(function(){
        $("#outpcs").text($("#outpcsx").text());
        $("#outkgs").text($("#outkgsx").text());
        $("#inpcs").text($("#inpcsx").text());
        $("#inkgs").text($("#inkgsx").text());
        $("#saldopcs").text($("#saldopcsx").text());
        $("#saldokgs").text($("#saldokgsx").text());
    })
</script>