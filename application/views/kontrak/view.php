<div class="page-body mt-0">
    <div class="container-xl">

        <div class="card-body">
            <div class="card card-active bg-primary-lt">
                <div class="card-body p-2 font-kecil mb-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-0">
                                <h4 class="m-0">
                                    <label for="" class="m-0" style="width: 75px;">Rekanan</label>
                                    <label for="" class="m-0">:</label>
                                    <label for="" class="m-0"><?= $header['nama_subkon']; ?></label>
                                </h4>
                            </div>
                            <div class="p-0">
                                <h4 class="m-0">
                                    <label for="" class="m-0" style="width: 75px;">Alamat</label>
                                    <label for="" class="m-0">:</label>
                                    <label for="" class="m-0"><?= $header['alamat_subkon']; ?></label>
                                </h4>
                            </div>
                            <div class="p-0">
                                <h4 class="m-0">
                                    <label for="" class="m-0" style="width: 75px;">NPWP</label>
                                    <label for="" class="m-0">:</label>
                                    <label for="" class="m-0"><?= formatnpwp($header['npwp']); ?></label>
                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="col-3"></div>
                    <!-- <div class="hr m-1"></div> -->
                </div>
            </div>
            <div class="col-12 m-1">
                <div class="row ">
                    <div class="col-md-6 mt-3  text-dark font-bold font-kecil">
                        <div class="mb-1 row  ">
                            <label class="col-3 col-form-label required"><i>Nomor Kontrak</i> </label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil " value="<?= $header['nomor']; ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Tanggal Berlaku</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= tglmysql($header['tgl_awal']); ?> s/d <?= tglmysql($header['tgl_akhir']); ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Qty Kontrak</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat inputangka text-right loss-inputangka" name="pcs" id="pcs" title="Pcs" value="<?= rupiah($header['pcs'], 0); ?>" placeholder="Qty Kontrak" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label  required">Kgs Kontrak</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat inputangka text-right loss-inputangka" name="kgs" id="kgs" title="Kgs" value="<?= rupiah($header['kgs'], 2); ?>" placeholder="Kgs Kontrak" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Tgl Kontrak</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl" id="tgl" value="<?= tglmysql($header['tgl']); ?>" title="Tgl Kontrak" placeholder="Tanggal Kontrak" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Penjamin</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-input" name="penjamin" id="penjamin" title="Nama Penjamin" value="<?= $header['penjamin']; ?>" placeholder="Nama Penjamin" disabled>
                            </div>
                        </div>

                        <hr class="m-0">
                    </div>
                    <div class="col-md-6 mt-3 text-dark font-bold font-kecil">
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Nomor Surat</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['nomor_surat']; ?>" placeholder="Nomor Surat" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Tanggal Surat</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['tgl_surat']; ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>PIC IFN</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['pic']; ?>" placeholder="PIC Indoneptune" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Jabatan</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['jabatan']; ?>" placeholder="Jabatan" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Bahan</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['bahan']; ?>" title="Bahan Makloon" placeholder="Bahan Makloon" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Hasil Pekerjaan</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['hasil']; ?>" title="Hasil Pekerjaan" placeholder="Hasil Pekerjaan" disabled>
                            </div>
                        </div>
                        <hr class="m-0">
                    </div>
                </div>
                <div class="row">
                    <div class=" mt-2 col-md-3 font-bold font-kecil text-dark">
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">SSB</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl_ssb" id="tgl_ssb" value="<?= tglmysql($header['tgl_ssb']); ?>" title="Tgl SSB" placeholder="Tgl SSB" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">No SSB</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-input" name="nomor_ssb" id="nomor_ssb" value="<?= $header['nomor_ssb']; ?>" title="Nomor SSB" placeholder="Nomor SSB" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Jumlah SSB</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-inputangka" name="jml_ssb" id="jml_ssb" title="Jumlah SSB" value="<?= rupiah($header['jml_ssb'], 2); ?>" placeholder="Jumlah SSB" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required"><i>Jenis BC</i></label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" value="<?= $header['jns_bc']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class=" mt-2 col-md-4 col-12 text-dark font-bold font-kecil">
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Tgl BPJ</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl_bpj" id="tgl_bpj" value="<?= tglmysql($header['tgl_bpj']); ?>" title="Tgl BPJ" placeholder="Tgl BPJ" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">No BPJ</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-input" name="nomor_bpj" id="nomor_bpj" title="Nomor BPJ" value="<?= $header['nomor_bpj']; ?>" placeholder="Nomor BPJ" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Tgl Expired</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl_expired" id="tgl_expired" value="<?= tglmysql($header['tgl_expired']); ?>" title="Tgl Expired" placeholder="Tgl Expired" disabled>
                            </div>
                        </div>

                    </div>
                    <div class=" mt-2 col-md-5 col-12 text-dark font-bold font-kecil">
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Nilai</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat text-right inputangka loss-inputangka" name="bea_masuk" id="bea_masuk" title="Bea Masuk" value="<?= rupiah($header['bea_masuk'], 2); ?>" placeholder="Bea Masuk" disabled>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control font-kecil btn-flat text-right inputangka loss-inputangka" name="ppn" id="ppn" title="PPN" value="<?= rupiah($header['ppn'], 2); ?>" placeholder="PPN" disabled>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat text-right inputangka loss-inputangka" name="pph" id="pph" title="PPH" value="<?= rupiah($header['pph'], 2); ?>" placeholder="PPH" disabled>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label required">Surat keputusan</label>
                            <div class="col-3">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl_kep" id="tgl_kep" value="<?= tglmysql($header['tgl_kep']); ?>" title="Tgl Keputusan" placeholder="Tgl Keputusan" disabled>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-input" name="nomor_kep" id="nomor_kep" title="Nomor Keputusan" value="<?= $header['nomor_kep']; ?>" placeholder="Nomor Keputusan" disabled>
                            </div>
                        </div>
                        <div class="mb-0 row">
                            <label class="col-3 col-form-label required">Dokumen Lain</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat tglmode loss-inputtgl" name="tgl_dok_lain" id="tgl_dok_lain" title="Tgl Dokumen Lain" value="<?= tglmysql($header['tgl_dok_lain']); ?>" placeholder="Tgl Dokumen Lain" disabled>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control font-kecil btn-flat loss-input" name="nomor_dok_lain" id="nomor_dok_lain" title="Nomor Dokumen Lain" value="<?= $header['nomor_dok_lain']; ?>" placeholder="Nomor Dokumen Lain" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs card-header-tabs font-kecil" data-bs-toggle="tabs">
                            <li class="nav-item">
                                <a href="#tabs-realisasi" class="nav-link bg-primary-lt active btn-flat text-black" data-bs-toggle="tab">Realisasi (261)</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-penerimaan" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Pengembalian (262)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <a href="<?= base_url() . 'kontrak/excel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-excel-o"></i></i><span class="ml-1">Export Excel</span></a>
                        <a href="<?= base_url() . 'kontrak/pdf'; ?>" class="btn btn-danger btn-sm font-bold mr-1" target="_blank" id="topdf"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export PDF</span></a>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="row">
                    <div class="tab-content">
                        <div class="tab-pane fade active show p-2" id="tabs-realisasi">
                            <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                            <div class="card card-lg">
                                <div id="table-default" class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-primary">Seri</th>
                                                <th class="text-primary">SKU</th>
                                                <th class="text-primary">Nama Barang</th>
                                                <th class="text-primary">Satuan</th>
                                                <th class="text-primary">Pcs</th>
                                                <th class="text-primary">Kgs</th>

                                            </tr>
                                        </thead>
                                        <tbody class=" table-tbody" style="font-size: 13px !important;">
                                            <?php
                                            $no = 0;
                                            $total_kgs = 0;
                                            if (!empty($detail)) {
                                                foreach ($detail as $key) :
                                                    $total_kgs += $key['kgs'];
                                                    $no++;
                                                    $sku = trim($key['po']) == '' ? $key['kode'] : viewsku($key['po'], $key['item'], $key['dis']);
                                                    $spekbarang = trim($key['po']) == '' ? namaspekbarang($key['id_barang']) : spekpo($key['po'], $key['item'], $key['dis']);
                                            ?>
                                                    <tr>
                                                        <td class="text-primary"><?= trim($key['seri_urut_akb']) !== '' ? $key['seri_urut_akb'] : '-'; ?></td>
                                                        <td class="text-primary"><?= $sku ?></td>
                                                        <td class="text-primary"><?= $spekbarang ?></td>
                                                        <td class="text-primary"><?= trim($key['kodesatuan']) !== '' ? $key['kodesatuan'] : '-'; ?> </td>
                                                        <td class="text-primary text-right"><?= trim($key['pcs']) !== '' ? rupiah($key['pcs'], 0) : '-'; ?></td>
                                                        <td class="text-primary text-right"><?= trim($key['kgs']) !== '' ? rupiah($key['kgs'], 2) : '-'; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="4" class="text-center fw-bold text-danger">Total Kgs</td>
                                                    <td></td>

                                                    <td class="font-bold text-danger text-right"><?= rupiah($total_kgs, 2) ?></td>
                                                </tr>

                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="7" class="text-center text-danger">--- Data Belum Terlampir ---</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show p-2" id="tabs-penerimaan">
                            <div class="font-kecil font-bold bg-red-lt p-1">DETAIL BARANG</div>
                            <div class="card card-lg">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Tgl Terima</th>
                                            <th class="text-primary">Nomor BC</th>
                                            <th class="text-primary">SKU</th>
                                            <th class="text-primary">Nama Barang</th>
                                            <th class="text-primary">Satuan</th>
                                            <th class="text-primary">Pcs</th>
                                            <th class="text-primary">Kgs</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" table-tbody" style="font-size: 13px !important;">
                                        <?php
                                        $no = 0;
                                        $jumlahkgs = 0;
                                        $jumlahpcs = 0;
                                        if ($terima->num_rows() > 0) {
                                            $tglx = '';
                                            $tglu = '';
                                            foreach ($terima->result_array() as $terima) {
                                                $sku = trim($terima['po']) == '' ? $terima['kode'] : viewsku($terima['po'], $terima['item'], $terima['dis']);
                                                $spekbarang = trim($terima['po']) == '' ? namaspekbarang($terima['id_barang']) : spekpo($terima['po'], $terima['item'], $terima['dis']);
                                                $jumlahkgs += $terima['kgs'];
                                                $jumlahpcs += $terima['pcs'];
                                                $tglu = $terima['tgl_bc'];
                                                if ($tglx != $tglu) {
                                                    $tg = $terima['tgl_bc'];
                                                    $nombc = $terima['nomor_bc'];
                                                } else {
                                                    $tg = '';
                                                    $nombc = '';
                                                }
                                                $tglx = $tglu;
                                        ?>
                                                <tr>
                                                    <td class="text-primary"><?= $tg ?></td>
                                                    <td class="text-primary"><?= $nombc ?></td>
                                                    <td class="text-primary line-12"><?= $sku ?><br><span class="font-11 text-teal"><?= $terima['insno'] ?></span></td>
                                                    <td class="text-primary"><?= $spekbarang ?></td>
                                                    <td class="text-primary"><?= $terima['kodesatuan'] ?></td>
                                                    <td class="text-primary text-right"><?= $terima['pcs'] ?></td>
                                                    <td class="text-primary text-right"><?= $terima['kgs'] ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr class="font-bold">
                                                <td colspan="5" class="text-center text-red">TOTAL</td>
                                                <td class="text-right text-red"><?= $jumlahpcs ?></td>
                                                <td class="text-right text-red"><?= $jumlahkgs ?></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="7" class="text-center">--- Belum ada Pengembalian Barang --</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>