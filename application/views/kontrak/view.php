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
                    <div class=" mt-2 col-md-4 font-bold font-kecil text-dark">
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
                    <div class=" mt-2 col-md-4 col-12 text-dark font-bold font-kecil">
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
                    <hr class='m-1'>
                    <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                    <div class="card card-lg">
                        <div id="table-default" class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <!-- <th class="text-dark text-center">No</th> -->
                                        <!-- <th class="text-danger text-center">Kode</th>
                                        <th class="text-danger text-center">Kode Kategori</th>
                                        <th class="text-danger text-center">Kategori</th>
                                        <th class="text-danger text-center">Uraian</th>
                                        <th class="text-danger text-center">HsCode</th>
                                        <th class="text-danger text-center">Pcs</th>
                                        <th class="text-danger text-center">Kgs</th> -->
                                        <th class="text-primary">Seri Barang</th>
                                        <th class="text-primary">PO</th>
                                        <th class="text-primary">Item</th>
                                        <th class="text-primary">Nama Barang</th>
                                        <th class="text-primary">Satuan</th>
                                        <th class="text-primary">Kgs</th>
                                        <th class="text-primary">Pcs</th>

                                    </tr>
                                </thead>
                                <tbody class=" table-tbody" style="font-size: 13px !important;">
                                    <?php $no = 0;
                                    if (!empty($detail)) {
                                        foreach ($detail as $key) : $no++; ?>
                                            <tr>
                                                <td class="text-primary"><?= trim($key['seri_barang']) !== '' ? $key['seri_barang'] : '-'; ?></td>
                                                <td class="text-primary" style="text-align: center;"><?= trim($key['po']) !== '' ? trim($key['po']) : '-'; ?></td>
                                                <td class="text-primary" style="text-align: center;"><?= trim($key['item']) !== '' ? trim($key['item']) : '-'; ?></td>
                                                <td class="text-primary"><?= trim($key['nama_barang']) !== '' ? trim($key['nama_barang']) : '-'; ?></td>
                                                <td class="text-primary"><?= trim($key['kodesatuan']) !== '' ? $key['kodesatuan'] : '-'; ?> </td>
                                                <td class="text-primary"><?= trim($key['kgs']) !== '' ? $key['kgs'] : '-'; ?></td>
                                                <td class="text-primary"><?= trim($key['pcs']) !== '' ? $key['pcs'] : '-'; ?></td>
                                            </tr>
                                        <?php endforeach;
                                    } else { ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-danger">--- Data Belum Terlampir ---</td>
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