<div class="container-xl">
    <div class="card">
        <div class="col-12 m-1">
            <div class="row">
                <div class="col-md-6 text-primary font-bold font-kecil">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Nomor Kontrak</i> </label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['nomor']; ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Tanggal Berlaku</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= tglmysql($header['tgl_awal']); ?> s/d <?= tglmysql($header['tgl_akhir']); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>PIC-IFN</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['pic']; ?>">
                        </div>
                    </div>
                    <hr class="m-0">
                </div>
                <div class="col-md-6 text-primary font-bold font-kecil">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Nomor Surat</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['nomor_surat']; ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Tanggal Surat</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['tgl_surat']; ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Jabatan</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['jabatan']; ?>">
                        </div>
                    </div>
                    <hr class="m-0">
                </div>
            </div>
            <div class="row">
                <div class=" mt-2 col-md-4 font-bold font-kecil text-primary">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Proses</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['proses']; ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>No Jaminan</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['nomor_ssb']; ?>">
                        </div>
                    </div>
                </div>
                <div class=" mt-2 col-md-4 col-12 text-primary font-bold font-kecil">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>No BPJ</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['nomor_bpj']; ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Jenis BC</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['jns_bc']; ?>">
                        </div>
                    </div>
                </div>
                <div class=" mt-2 col-md-4 col-12 text-primary font-bold font-kecil">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>Nilai Kontrak</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" value="<?= rupiah($header['jml_ssb'],2); ?>">
                        </div>
                    </div>
                    <!-- <div class="mb-1 row">
                        <label class="col-3 col-form-label required"><i>KGS</i></label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" value="<?= $header['kgs']; ?>">
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="row">
                <hr class='m-1'>
                <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                <div class="card card-lg">
                    <div id="table-default" class="table-responsive  ">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-danger text-center">No</th>
                                    <!-- <th class="text-danger text-center">Kode</th> -->
                                    <!-- <th class="text-danger text-center">Kode Kategori</th> -->
                                    <th class="text-danger text-center">Kategori</th>
                                    <th class="text-danger text-center">Uraian</th>
                                    <th class="text-danger text-center">HsCode</th>
                                    <th class="text-danger text-center">Pcs</th>
                                    <th class="text-danger text-center">Kgs</th>

                                </tr>
                            </thead>
                            <tbody class=" table-tbody" style="font-size: 13px !important;">
                                <?php $no = 0; if($mode==0){
                                foreach ($detail as $key) : $no++; ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="text-align: center;"><?= $key['kategori']; ?></td>
                                        <td style="text-align: center;"><?= $key['uraian']; ?></td>
                                        <td style="text-align: center;"><?= $key['hscode']; ?></td>
                                        <td style="text-align: right;"><?= $key['pcs']; ?></td>
                                        <td style="text-align: right;"><?= $key['kgs']; ?></td>
                                    </tr>
                                <?php endforeach; }else{ ?>
                                    <tr>
                                        <td colspan="6" class="text-center">--- Data Detail Terlampir ---</td>
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