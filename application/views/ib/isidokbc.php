<div class="container-xl"> 
    <div class="m-2 font-bold">DATA BC - IB NO <span class="text-blue"><?= $datheader['nomor_dok']; ?></span></div>
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" style="background-color: #F6F8FB">
            <li class="nav-item">
             <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat font-bold" data-bs-toggle="tab">Data HEADER BC</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-barang-8" class="nav-link bg-cyan-lt btn-flat font-bold" data-bs-toggle="tab">Detail Barang</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Dokumen</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row">
                    <input type="hidden" name="errorsimpan" id="errorsimpan" value="<?= $this->session->flashdata('errorsimpan'); ?>">
                    <input type="hidden" name="pesanerror" id="pesanerror" value="<?= $this->session->flashdata('pesanerror'); ?>">
                    <div class="m-2 font-bold d-flex justify-content-between">Data HEADER BC 
                    <span>
                        <?php $hilang = $datheader['send_ceisa']==0 ? "hilang" : ""; ?>
                        <?php $hilang2 = $datheader['send_ceisa']==1 ? "hilang" : ""; ?>
                        <a href="<?= base_url().'ib/ceisa40excel/'.$datheader['id']; ?>" id="keexcel" class="btn btn-sm btn-success mr-0"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="<?= base_url().'ib/getresponhost/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-info <?= $hilang; ?>"><i class="fa fa-cloud mr-1"></i>Respon H2H</a><a href="#" id="cekdata" class="btn btn-sm btn-yellow <?= $hilang2; ?>"><i class="fa fa-cloud mr-1"></i>Kirim H2H</a><a href="<?= base_url().'ib/hosttohost/'.$datheader['id']; ?>" style="border-left: 1px solid black;" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> H2H Token</a>
                        <a href="<?= base_url().'ib'; ?>" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left mr-1"></i> Kembali</a></span></div>
                        <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
                        <input type="hidden" name="tgl" id="tgl" value="<?= $datheader['tgl']; ?>">
                        <hr class="m-0">
                        <div class="p-2 font-kecil">
                            Nama Pengirim : <?= $datheader['namasupplier']; ?><br>
                            Alamat Pengirim : <?= $datheader['alamat']; ?></br>
                            NPWP : <?= $datheader['npwp']; ?>
                            <button href="#" id="kirimkeceisa" data-href="<?= base_url().'ib/kirimdatakeceisa/'.$datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengirim data ini ke CIESA 40" style="border-right: 1px solid white;" class="btn btn-sm btn-yellow hilang"><i class="fa fa-cloud mr-1"></i>Kirim H2H</button>
                            <a id="kirimkeceisax" href="<?= base_url().'ib/getresponpdf/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o mr-1"></i>GET PDF</a>
                    </div>
                    <hr class="m-0">
                    <hr class="m-0">
                    <div class="col-sm-6">
                        <div class="bg-teal-lt px-2 py-1 mt-1">
                            <div class="mb-1 mt-3 row">
                                <?php $disab = $datheader['send_ceisa']==1 ? "disabled" : ""; ?>
                                <label class="col-3 col-form-label font-kecil">Jenis DOK BC</label>
                                <div class="col font-kecil">
                                    <select class="form-select font-kecil font-bold" name="jns_bc" id="jns_bc" <?= $disab; ?>>
                                        <option value="">Pilih Jenis BC</option>
                                        <?php foreach ($bcmasuk->result_array() as $bcmas) { ?>
                                            <?php $selek = $datheader['jns_bc']==$bcmas['jns_bc'] ? 'selected' : ''; ?>
                                            <option value="<?= $bcmas['jns_bc']; ?>" <?= $selek; ?>><?= $bcmas['ket_bc']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label font-kecil">No/Tgl AJU</label>
                                <div class="col">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="<?= $datheader['nomor_aju']; ?>"  placeholder="Nomor Aju" <?= $disab; ?>>
                                        <a href="#" class="btn font-kecil font-bold <?= $disab; ?>" id="getnomoraju">Get</a>
                                    </div>
                                    <!-- <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="" aria-describedby="emailHelp" placeholder="No AJU"> -->
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil tgl" id="tgl_aju" name="tgl_aju" value="<?= tglmysql($datheader['tgl_aju']); ?>" aria-describedby="emailHelp" placeholder="Tgl AJU" <?= $disab; ?>>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label font-kecil">No/Tgl BC</label>
                                <div class="col"> 
                                    <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" value="<?= $datheader['nomor_bc']; ?>" aria-describedby="emailHelp" placeholder="No BC" readonly>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" id="tgl_bc" name="tgl_bc" value="<?= tglmysql($datheader['tgl_bc']); ?>" aria-describedby="emailHelp" placeholder="Tgl BC" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="font-kecil text-secondary">
                            <?php
                                if($this->session->userdata('datatokenbeacukai')!=''){
                                    echo "DATA TOKEN SET ";
                                    // echo $this->session->userdata('datatokenbeacukai');
                                } else {
                                    echo "DATA TOKEN NOT SET";
                                }
                             ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-1 mt-1 row">
                            <label class="col-3 col-form-label font-kecil">Angkutan</label>
                            <div class="col font-kecil">
                                <select class="form-select font-kecil font-bold" name="jns_angkutan" id="jns_angkutan">
                                    <option value="">Pilih Angkutan</option>
                                    <?php foreach ($jnsangkutan->result_array() as $angkut) { ?>
                                        <option value="<?= $angkut['id']; ?>" <?php if($angkut['id']==$datheader['jns_angkutan']){ echo "selected"; } ?>><?= $angkut['angkutan']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label class="col-3 col-form-label font-kecil">Jenis Angkutan</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" id="angkutan" name="angkutan" value="<?= $datheader['angkutan']; ?>" aria-describedby="emailHelp" placeholder="Angkutan">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control font-kecil" id="no_kendaraan" name="no_kendaraan" value="<?= $datheader['no_kendaraan']; ?>" aria-describedby="emailHelp" placeholder="No Kendaraan">
                            </div>
                        </div>
                        <div class="mb-0 row">
                            <label class="col-3 col-form-label font-kecil">Kgs / Volume</label>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil">Bruto</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil inputangka text-right" id="bruto" name="bruto" value="<?= rupiah($datheader['bruto'],2); ?>" aria-describedby="emailHelp" placeholder="Bruto Kgs">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil">Netto</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil inputangka text-right" id="netto" name="netto" value="<?= rupiah($datheader['netto'],2); ?>" aria-describedby="emailHelp" placeholder="Netto Kgs">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 mt-0 row">
                            <label class="col-3 col-form-label font-kecil">Jumlah Kemas</label>
                            <div class="col">
                                <input type="text" class="form-control font-kecil inputangka text-right" id="jml_kemasan" name="jml_kemasan" value="<?= rupiah($datheader['jml_kemasan'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas">
                            </div>
                            <div class="col">
                                <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                                <select class="form-select font-kecil font-bold" name="kd_kemasan" id="kd_kemasan">
                                    <option value="">Pilih Kemasan</option>
                                    <?php foreach ($refkemas->result_array() as $kemas) { ?>
                                        <option value="<?= $kemas['kdkem']; ?>" <?php if($kemas['kdkem']==$datheader['kd_kemasan']){ echo "selected"; } ?>><?= $kemas['kdkem'].' # '.$kemas['kemasan']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="mb-1 mt-1 row">
                            <label class="col-3 col-form-label font-kecil">Nilai Pabean / CIF</label>
                            <div class="col">
                                <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                                <select class="form-select font-kecil font-bold" name="mtuang" id="mtuang">
                                    <option value="">Pilih</option>
                                    <?php foreach ($refmtuang->result_array() as $mtuang) { ?>
                                        <option value="<?= $mtuang['id']; ?>" <?php if($mtuang['id']==$datheader['mtuang']){ echo "selected"; } ?>><?= $mtuang['mt_uang']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control font-kecil inputangka text-right" id="totalharga" name="totalharga" value="<?= rupiah($datheader['totalharga'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas">
                            </div>
                        </div>
                        <div class="mb-1 pt-1 row bg-cyan-lt">
                            <label class="col-3 col-form-label font-kecil">NDPBM</label>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil">USD</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil inputangka text-right" id="kurs_usd" name="kurs_usd" value="<?= rupiah($datheader['kurs_usd'],0); ?>" aria-describedby="emailHelp" placeholder="Kurs USD">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil">IDR</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil inputangka text-right" id="kurs_idr" name="kurs_idr" value="<?= rupiah($datheader['kurs_idr'],0); ?>" aria-describedby="emailHelp" placeholder="Kurs IDR">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 pt-1 row bg-yellow-lt ">
                            <label class="col-3 col-form-label font-kecil text-black">Nilai DEVISA</label>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil text-black">USD</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil inputangka text-right" id="devisa_usd" name="devisa_usd" value="<?= rupiah($datheader['devisa_usd'],2); ?>" aria-describedby="emailHelp" placeholder="Devisa USD" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-1 row">
                                    <label class="col-3 col-form-label font-kecil text-black">IDR</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil text-right" id="devisa_idr" name="devisa_idr" value="<?= rupiah($datheader['devisa_idr'],2); ?>" aria-describedby="emailHelp" placeholder="Devisa IDR" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-cyan-lt" id="tabs-barang-8">
                <div class="m-2 font-bold d-flex justify-content-between">Detail Barang</div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table datatable8 w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-left">HS Code</th>
                                    <th>Satuan</th>
                                    <th>Pcs</th>
                                    <th>Kgs</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-tablee" style="font-size: 13px !important;" >
                                    <?php foreach ($header as $data) { ?>
                                    <tr>
                                        <td><?= $data['nama_barang']; ?></td>
                                        <td><?= $data['nama_kategori']; ?></td>
                                        <td class="text-left"><?= $data['nohs']; ?></td>
                                        <td><?= $data['namasatuan']; ?></td>
                                        <td><?= rupiah($data['pcs'],2); ?></td>
                                        <td><?= rupiah($data['kgs'],2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-red-lt" id="tabs-profile-8">
                <div class="m-2 font-bold d-flex justify-content-between">Lampiran Dokumen <span><a href="<?= base_url().'ib/addlampiran/'.$datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC" id="keexcel" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-1"></i> Tambah Data</a><span></div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table datatable8 w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Nomor Dokumen</th>
                                    <th>Tgl Dokumen</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="m-1"> 
    <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
        <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
        <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Simpan</a>
    </div>
    <div>
    </div>
</div>