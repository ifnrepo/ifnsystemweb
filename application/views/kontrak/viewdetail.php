<div class="page-body mt-0">
    <div class="container-xl">
        <div class="row font-kecil">
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Nomor/Tgl Kontrak</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= $header['nomor'] . ' Tgl.' . tglmysql($header['tgl']) ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i>Tgl Berlaku</i> </label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= tglmysql($header['tgl_awal']) . ' s/d ' . tglmysql($header['tgl_akhir']) ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label"><i></i> </label>
                <div class="col">
                    <div class="row">
                        <div class="mb-1 row pr-0">
                            <label class="col-3 col-form-label"><i>Qty</i> </label>
                            <div class="col pr-0">
                                <input type="text" class="form-control font-kecil text-right btn-flat" value="<?= rupiah($header['pcs'], 0) ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row pr-0">
                            <label class="col-3 col-form-label"><i>Kgs</i> </label>
                            <div class="col pr-0">
                                <input type="text" class="form-control font-kecil text-right btn-flat" value="<?= rupiah($header['kgs'], 2) ?>" disabled>
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
                    <th class="text-primary text-center">Saldo Pcs</th>
                    <th class="text-primary text-center">Saldo Kgs</th>
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
        <div class="row">
            <div class="col-md-6">
                <ul class="nav nav-tabs card-header-tabs font-kecil" data-bs-toggle="tabs">
                    <li class="nav-item">
                        <a href="#tabs-rekap" class="nav-link bg-primary-lt active btn-flat text-black" data-bs-toggle="tab">Rekap Monitoring</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-jamin" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Perhitungan Jaminan</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'kontrak/excel_detail'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To Excel</span></a>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-rekap">
                <div class="card-body">
                    <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                    <div class="card card-lg">
                        <table class="table datatable table-hover">
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
                                $no = 0;
                                $jumkgskirim = 0;
                                $jumpcskirim = 0;
                                $jumkgsterima = 0;
                                $jumpcsterima = 0;
                                $kodmas = '';
                                $saldokgs = 0;
                                $saldopcs = 0;
                                $warnawarni = '';
                                $arrno = [];
                                foreach ($transaksi->result_array() as $transaksix) {
                                    $no++;
                                    $indexkode = $transaksix['po'] . $transaksix['item'] . $transaksix['dis'] . $transaksix['id_barang']; //.$transaksi['insno'];
                                    if ($kodmas != $indexkode) {
                                        array_push($arrno, $no - 1);
                                    }
                                    $kodmas = $indexkode;
                                }
                                array_push($arrno, $no);
                                $kodmas = '';
                                $no = 0;
                                foreach ($transaksi->result_array() as $transaksi) {
                                    $no++;
                                    if ($transaksi['kirter'] == 0) {
                                        $jumkgskirim += round($transaksi['kgsx'], 2);
                                        $jumpcskirim += $transaksi['pcsx'];
                                    } else {
                                        $jumkgsterima += round($transaksi['kgsx'], 2);
                                        $jumpcsterima += $transaksi['pcsx'];
                                    }
                                    $indexkode = $transaksi['po'] . $transaksi['item'] . $transaksi['dis'] . $transaksi['id_barang']; //.$transaksi['insno'];
                                    $bold = in_array($no, $arrno) ? 'font-bold text-pink' : '';
                                    if ($kodmas == $indexkode) {
                                        if ($transaksi['kirter'] == 0) {
                                            $saldokgs += round($transaksi['kgsx'], 2);
                                            $saldopcs += $transaksi['pcsx'];
                                        } else {
                                            $saldokgs -= round($transaksi['kgsx'], 2);
                                            $saldopcs -= $transaksi['pcsx'];
                                        }
                                    } else {
                                        $saldokgs = round($transaksi['kgsx'], 2);
                                        $saldopcs = $transaksi['pcsx'];
                                        // $bold = 'font-bold';
                                        $warnawarni = $warnawarni == '' ? 'bg-primary-lt' : '';
                                    }
                                    $kodmas = $indexkode;
                                    $kirter = $transaksi['kirter'] == 0 ? 'OUT' : 'IN';
                                    $warnakirter = $transaksi['kirter'] == 0 ? 'text-teal' : 'text-pink';
                                    $sku = trim($transaksi['po']) == '' ? $transaksi['kode'] : viewsku($transaksi['po'], $transaksi['item'], $transaksi['dis']);
                                    $spekbarang = trim($transaksi['po']) == '' ? namaspekbarang($transaksi['id_barang']) : spekpo($transaksi['po'], $transaksi['item'], $transaksi['dis']);
                                ?>
                                    <tr class="<?= $warnawarni ?> text-primary font-kecil">
                                        <td class="<?= $warnakirter ?>"><?= $kirter ?></td>
                                        <td><?= $sku ?></td>
                                        <td class="line-12"><?= $spekbarang ?><br><span class="text-teal font-11"><?= $transaksi['insno'] ?></span></td>
                                        <td></td>
                                        <?php if ($transaksi['kirter'] == 0) { ?>
                                            <td class="text-right"><?= rupiah($transaksi['pcsx'], 0) ?></td>
                                            <td class="text-right"><?= rupiah($transaksi['kgsx'], 2) ?></td>
                                            <td class="text-right"><?= rupiah(0, 0) ?></td>
                                            <td class="text-right"><?= rupiah(0, 2) ?></td>
                                        <?php } else { ?>
                                            <td class="text-right"><?= rupiah(0, 0) ?></td>
                                            <td class="text-right"><?= rupiah(0, 2) ?></td>
                                            <td class="text-right"><?= rupiah($transaksi['pcsx'], 0) ?></td>
                                            <td class="text-right"><?= rupiah($transaksi['kgsx'], 2) ?></td>
                                        <?php } ?>
                                        <td class="text-right <?= $bold ?>"><?= rupiah($saldopcs, 0) ?></td>
                                        <td class="text-right <?= $bold ?>"><?= rupiah($saldokgs, 2) ?></td>
                                    </tr>
                                <?php  } ?>
                                <tr>
                                    <td colspan="4" class="font-bold text-center">TOTAL</td>
                                    <td class="text-right font-bold text-teal" id="outpcsx"><?= rupiah($jumpcskirim, 0) ?></td>
                                    <td class="text-right font-bold text-teal" id="outkgsx"><?= rupiah($jumkgskirim, 2) ?></td>
                                    <td class="text-right font-bold text-pink" id="inpcsx"><?= rupiah($jumpcsterima, 0) ?></td>
                                    <td class="text-right font-bold text-pink" id="inkgsx"><?= rupiah($jumkgsterima, 2) ?></td>
                                    <td class="text-right font-bold" id="saldopcsx"><?= rupiah($jumpcskirim - $jumpcsterima, 0) ?></td>
                                    <td class="text-right font-bold" id="saldokgsx"><?= rupiah($jumkgskirim - $jumkgsterima, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade active p-2" id="tabs-jamin">
                <div class="font-kecil font-bold bg-red-lt p-1">PERHITUNGAN</div>
                <div class="card card-lg">
                    <table class="table datatable table-bordered">
                        <thead>
                            <tr>
                                <th class="text-primary">NILAI PADA DOKUMEN 261</th>
                                <th class="text-primary text-center">PCS</th>
                                <th class="text-primary text-center">KGS</th>
                                <th class="text-primary text-center">CIF (IDR)</th>
                                <th class="text-primary text-center">CIF (USD)</th>
                            </tr>
                        </thead>
                        <tbody class=" table-tbody" style="font-size: 12px !important;">
                            <tr>
                                <td class="font-bold"><?= $totaljaminan['nomor_bc'] . ' Tgl.' . tglmysql($totaljaminan['tgl_bc']) ?></td>
                                <td class="text-right" id="pcskirim"></td>
                                <td class="text-right" id="kgskirim"></td>
                                <td class="text-right"><?= rupiah($totaljaminan['cifrupiah'], 2); ?></td>
                                <?php $ndpbm = isset($totaljaminan['ndpbm']) ? $totaljaminan['ndpbm'] : 1;  ?>
                                <td class="text-right" id="cifrup"><?= rupiah($totaljaminan['cifrupiah'] / $ndpbm, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table datatable table-bordered">
                        <thead>
                            <tr>
                                <th class="text-primary">NILAI PADA DOKUMEN 262</th>
                                <th class="text-primary text-center">PCS</th>
                                <th class="text-primary text-center">KGS</th>
                                <th class="text-primary text-center">CIF (IDR)</th>
                                <th class="text-primary text-center">CIF (USD)</th>
                            </tr>
                        </thead>
                        <tbody class=" table-tbody" style="font-size: 12px !important;">
                            <?php
                            $cifterima = 0;
                            foreach ($terima->result_array() as $terima) {
                                $cifterima += $terima['cifnya'];
                                $ket = $terima['tgl_bc'] == '' ? '' : ' Tgl.' . tglmysql($terima['tgl_bc']);
                            ?>
                                <tr>
                                    <td><?= $terima['nomor_bc'] . $ket; ?></td>
                                    <td class="text-right"><?= $terima['pcs']; ?></td>
                                    <td class="text-right"><?= $terima['kgs']; ?></td>
                                    <td class="text-right"><?= rupiah($terima['cifnya'] * $terima['exbc_ndpbm'], 2); ?></td>
                                    <td class="text-right"><?= rupiah($terima['cifnya'], 2); ?></td>
                                </tr>
                            <?php }; ?>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center font-bold">SISA CIF</td>
                                <td id="sisanya" class="font-bold text-right"><?= rupiah(($totaljaminan['cifrupiah'] / $ndpbm) - $cifterima, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="m-0">

<script>
    $(document).ready(function() {
        $("#outpcs").text($("#outpcsx").text());
        $("#outkgs").text($("#outkgsx").text());
        $("#inpcs").text($("#inpcsx").text());
        $("#inkgs").text($("#inkgsx").text());
        $("#saldopcs").text($("#saldopcsx").text());
        $("#saldokgs").text($("#saldokgsx").text());
        $("#pcskirim").text($("#outpcsx").text());
        $("#kgskirim").text($("#outkgsx").text());
    })
</script>