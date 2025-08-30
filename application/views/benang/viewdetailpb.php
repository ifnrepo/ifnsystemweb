<div class="container-xl p-0">
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row mb-1">
                    <div class="col-4 text-primary font-bold">
                        <span>Nomor</span>
                        <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
                    </div>
                    <div class="col-4 text-primary font-bold">
                        <span>Tanggal</span>
                        <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
                    </div>
                    <div class="col-4 text-primary font-bold">
                        <span>Dibuat Oleh</span>
                        <h4 class="mb-1"><?= datauser($header['user_ok'], 'name') . ' (' . $header['tgl_ok'] . ')' ?></h4>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="card card-lg">
                    <div class="card-body p-2">
                        <table class="table datatable6 table-hover" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Specific</th>
                                    <th>SKU</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                    <th>Kgs</th>
                                    <th>SBL</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php $no = 0;
                                foreach ($detail as $val) {
                                    $no++;
                                    $kode = formatsku($val['po'], $val['item'], $val['dis'], $val['id_barang']);
                                    $spek = $val['po'] == '' ? $val['nama_barang'] : spekpo($val['po'], $val['item'], $val['dis']);
                                ?>
                                    <tr>
                                        <td class="line-12"><?= $no . '. ' . $spek . '<br><span class="font-kecil text-teal">' . $val['insno'] . ' ' . $val['nobontr'] . '</span>'; ?></td>
                                        <td><?= $kode; ?></td>
                                        <td><?= $val['namasatuan']; ?></td>
                                        <td><?= rupiah($val['pcs'], 0); ?></td>
                                        <td><?= rupiah($val['kgs'], 2); ?></td>
                                        <td class="font-bold"><?= $val['sublok']; ?></td>
                                        <td><?= $val['keterangan']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Benanng : <?= $header['jumlah_barang']; ?></div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row mb-1">
                    <div class="col-4 text-primary font-bold">
                        <span>KETERANGAN :</span>
                        <h4 class="mb-1"><?= $header['keterangan']; ?></h4>
                    </div>

                </div>
                <hr class="m-1">
            </div>

        </div>
        <hr class="m-1">
    </div>
</div>
<script>
    $(document).ready(function() {})
</script>