<div class="container-xl">
    <div class="mx-2 font-bold">AJU MASUK BARANG</div>
    <div class="mx-2 mb-2 font-bold">DATA BC - IB NO <span class="text-blue"><?= $datheader['nomor_dok']; ?></span></div>
    <div class="col-md-3">
        <?= $this->session->flashdata('message'); ?>
    </div>
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" style="background-color: #F6F8FB">
            <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat font-bold" data-bs-toggle="tab">Header Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-barang-8" class="nav-link bg-cyan-lt btn-flat font-bold" data-bs-toggle="tab">Detail Barang</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-foto-8" class="nav-link bg-grey-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Foto & Video</a>
            </li>
        </ul>
        <span class="font-kecil text-teal" id="timetoexpired"></span>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row">
                    <input type="hidden" name="errorsimpan" id="errorsimpan" value="<?= $this->session->flashdata('errorsimpan'); ?>">
                    <input type="hidden" name="pesanerror" id="pesanerror" value="<?= $this->session->flashdata('pesanerror'); ?>">
                    <input type="hidden" id="namahalaman" value="ib">
                    <?php $date = date("Y-m-d H:i:s", strtotime("+2 hours", strtotime($datatoken['update_at']))); ?>
                    <input type="hidden" id="updateon" value="<?= $date; ?>">
                    <div class="m-2 font-bold d-flex justify-content-between">
                        <span class="mt-2 text-info" id="adaapadengantoken">

                        </span>
                        <span>
                            <?php $hilang = ($datheader['send_ceisa'] == 0  || $datheader['nomor_sppb'] != '') ? "hilang" : ""; ?>
                            <?php $hilang2 = $datheader['send_ceisa'] == 1 ? "hilang" : ""; ?>
                            <?php $hilang3 = $datheader['nomor_sppb'] == '' ? "hilang" : ""; ?>
                            <?php $nonaktif = $datheader['send_ceisa'] == 1 ? "readonly" : ""; ?>
                            <?php $hilangbc23 = $datheader['jns_bc'] == 23 ? "hilang" : ""; ?>
                            <?php $hilangbc40 = $datheader['jns_bc'] == 40 ? "hilang" : ""; ?>
                            <?php $hilangbc262 = $datheader['jns_bc'] == 262 ? "hilang" : ""; ?>
                            <?php $selectnonaktif = $datheader['send_ceisa'] == 1 ? "disabled" : ""; ?>
                            <a href="<?= base_url() . 'ib/ceisa40excel/' . $datheader['id']; ?>" id="keexcel" style="border-right: 1px solid black;" class="btn btn-sm btn-success mr-0"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="<?= base_url() . 'ib/getresponhost/' . $datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-info <?= $hilang; ?>"><i class="fa fa-cloud mr-1"></i>Respon H2H</a><a href="#" id="cekdata" class="btn btn-sm btn-yellow text-black <?= $hilang2; ?>"><i class="fa fa-cloud mr-1"></i>Kirim H2H</a><a id="kirimkeceisax" href="<?= base_url() . 'ib/getresponpdf/' . $datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-danger <?= $hilang3; ?>"><i class="fa fa-file-pdf-o mr-1"></i>GET PDF</a>
                            <!-- <a href="<?= base_url() . 'ib/hosttohost/' . $datheader['id']; ?>" style="border-left: 1px solid black;" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> H2H Token</a> -->
                            <?php if ($datheader['send_ceisa'] == 0 || $datheader['nomor_sppb'] == '') { ?>
                                <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Verifikasi Data</a>
                            <?php } else { ?>
                                <a class="btn btn-sm btn-yellow" href="<?= base_url() . 'ib/uploaddok/' . $datheader['id']; ?>" style="color: white;" id="uploaddok" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Upload Dokumen"><i class="fa fa-file-o mr-1"></i> Upload Dokumen</a>
                            <?php } ?>
                            <a href="<?= base_url() . 'ib'; ?>" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left mr-1"></i> Kembali</a></span>
                    </div>
                    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
                    <input type="hidden" name="tgl" id="tgl" value="<?= $datheader['tgl']; ?>">
                    <hr class="m-0">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 font-kecil">
                            <?php if ($mode == 0) { ?>
                                Nama Pengirim : <?= $datheader['namasupplier']; ?><br>
                                Alamat Pengirim : <?= $datheader['alamat']; ?></br>
                                NPWP : <?= $datheader['npwp']; ?>
                            <?php } else { ?>
                                Nama Subkontrak : <?= datadepartemen($datheader['dept_id'], 'nama_subkon'); ?><br>
                                Alamat : <?= datadepartemen($datheader['dept_id'], 'alamat_subkon'); ?></br>
                                NPWP : <?= datadepartemen($datheader['dept_id'], 'npwp'); ?>
                            <?php } ?>
                            <button href="#" id="kirimkeceisa" data-href="<?= base_url() . 'ib/kirimdatakeceisa' . $datheader['jns_bc'] . '/' . $datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengirim data ini ke CIESA 40" style="border-right: 1px solid white;" class="btn btn-sm btn-yellow hilang"><i class="fa fa-cloud mr-1"></i>Kirim H2H</button>
                        </div>
                    </div>
                    <hr class="m-0">
                    <hr class="m-0">
                    <div class="col-sm-6 d-flex justify-content-between">
                        <div class="bg-teal-lt px-2 py-1 mt-1">
                            <div class="mb-1 mt-2 row">
                                <label class="col-3 col-form-label font-kecil">Jenis DOK BC</label>
                                <div class="col font-kecil">
                                    <select class="form-select font-kecil font-bold" name="jns_bc" id="jns_bc" <?= $selectnonaktif; ?>>
                                        <option value="">Pilih Jenis BC</option>
                                        <?php foreach ($bcmasuk->result_array() as $bcmas) { ?>
                                            <?php $selek = $datheader['jns_bc'] == $bcmas['jns_bc'] ? 'selected' : ''; ?>
                                            <option value="<?= $bcmas['jns_bc']; ?>" <?= $selek; ?>><?= $bcmas['ket_bc']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3 col-form-label font-kecil">No/Tgl AJU</label>
                                <div class="col">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="<?= $datheader['nomor_aju']; ?>" placeholder="Nomor Aju" <?= $nonaktif; ?>>
                                        <a href="#" class="btn font-kecil font-bold <?= $selectnonaktif; ?>" id="getnomoraju">Get</a>
                                    </div>
                                    <!-- <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="" aria-describedby="emailHelp" placeholder="No AJU"> -->
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil tgl" id="tgl_aju" name="tgl_aju" value="<?= tglmysql($datheader['tgl_aju']); ?>" aria-describedby="emailHelp" placeholder="Tgl AJU" <?= $nonaktif; ?>>
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
                    </div>
                    <div class="row <?= $hilangbc40; ?><?= $hilangbc262; ?>">
                        <div class="col-sm-12">
                            <div class="card font-kecil mt-1">
                                <div class="bg-warning-lt px-2 py-1 font-bold"><span class="text-black">Entitas Dokumen</span><span style="float: right;"><a href="<?= base_url() . 'ib/addentitas/' . $datheader['id']; ?>" class="btn btn-success py-0 px-1 btn-flat" title="Add Entitas" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Entitas"><i class="fa fa-plus"></i></a></span></div>
                                <div class="card-body p-1">
                                    <table class="table table-bordered mb-0">
                                        <tr class="bg-info-lt">
                                            <td class="p-1 font-bold">Kode</td>
                                            <td class="p-1 font-bold">No Identitas</td>
                                            <td class="p-1 font-bold">Nama</td>
                                            <td class="p-1 font-bold">Alamat</td>
                                            <td class="p-1 font-bold">Negara</td>
                                            <td class="p-1 text-center font-bold">Act</td>
                                        </tr>
                                        <tbody class="table-tbody" id="body-table-entitas">
                                            <tr>
                                                <td colspan="6" class="text-center p-1">- Data tidak Ada -</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card font-kecil mt-1">
                                <div class="bg-info-lt px-2 py-1 font-bold">Dokumen Pelengkap Kepabeanan</div>
                                <div class="card-body p-1">
                                    <!-- Surat Jalan  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Surat Jalan</div>
                                    <div class="mb-1 row">
                                        <!-- <div class="col">
                                            <div>
                                                <label class="form-label font-kecil font-bold m-0">No SJ</label>
                                                <div>
                                                    <input type="text" class="form-control font-kecil btn-flat" aria-describedby="emailHelp" placeholder="Enter email">
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">No SJ</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_sj" name="nomor_sj" value="<?= $datheader['nomor_sj']; ?>" aria-describedby="emailHelp" placeholder="Nomor Surat Jalan" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_sj" name="tgl_sj" value="<?= tglmysql($datheader['tgl_sj']); ?>" aria-describedby="emailHelp" placeholder="Tgl Surat Jalan" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dok Lainnya  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Dokumen Lainnya</div>
                                    <div class="mb-1 row">
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">No Dok</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_dok" name="nomor_dok" value="<?= $datheader['nomor_dok']; ?>" aria-describedby="emailHelp" placeholder="Nomor Dokumen" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="tgl" name="tgl" value="<?= tglmysql($datheader['tgl']); ?>" aria-describedby="emailHelp" placeholder="Tanggal Dokumen" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PO  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Dokumen P/O</div>
                                    <div class="mb-1 row">
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">No PO</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_po" name="nomor_po" value="<?= $datheader['nomor_po']; ?>" aria-describedby="emailHelp" placeholder="Nomor PO" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_po" name="tgl_po" value="<?= tglmysql($datheader['tgl_po']); ?>" aria-describedby="emailHelp" placeholder="Tgl PO" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- INVOICE  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Invoice</div>
                                    <div class="mb-1 row">
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">No INV</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $datheader['nomor_inv']; ?>" aria-describedby="emailHelp" placeholder="Nomor Invoice" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_inv" name="tgl_inv" value="<?= tglmysql($datheader['tgl_inv']); ?>" aria-describedby="emailHelp" placeholder="Tgl Invoice" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PACKING LIST  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Packing List</div>
                                    <div class="mb-1 row">
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">No PL</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_pl" name="nomor_pl" value="<?= $datheader['nomor_pl']; ?>" aria-describedby="emailHelp" placeholder="Nomor Packing List" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_pl" name="tgl_pl" value="<?= tglmysql($datheader['tgl_pl']); ?>" aria-describedby="emailHelp" placeholder="Tanggal Packing List" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Ex BC  -->
                                    <div class="<?= $hilangbc23; ?><?= $hilangbc40; ?>">
                                        <div class="text-center bg-danger-lt mb-1 font-bold">Ex BC</div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">No Ex-BC</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat" id="exnomor_bc" name="exnomor_bc" value="<?= $datheader['exnomor_bc']; ?>" aria-describedby="emailHelp" placeholder="Ex Nomor BC" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat tgl" id="extgl_bc" name="extgl_bc" value="<?= tglmysql($datheader['extgl_bc']); ?>" aria-describedby="emailHelp" placeholder="Tgl Ex BC" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BL AWB  -->
                                    <div class="<?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <div class="text-center bg-primary-lt mb-1 font-bold">Nomor BL / AWB</div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Nomor</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat" id="nomor_blawb" name="nomor_blawb" value="<?= $datheader['nomor_blawb']; ?>" aria-describedby="emailHelp" placeholder="Nomor BL / AWB" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_blawb" name="tgl_blawb" value="<?= tglmysql($datheader['tgl_blawb']); ?>" aria-describedby="emailHelp" placeholder="Tgl BL / AWB" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-sm btn-success mb-1 font-bold" id="getblawb" style="width: 100%;">Get Data By Nomor BL</a>
                                        <hr class="m-1">
                                    </div>
                                    <!-- BL AWB  -->
                                    <div class="<?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <div class="text-center bg-danger-lt mb-1 font-bold"><span class="text-black">BC 1.1</span></div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Nomor</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat" id="bc11" name="bc11" value="<?= $datheader['bc11']; ?>" aria-describedby="emailHelp" placeholder="BC 1.1" <?= $nonaktif; ?> readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_bc11" name="tgl_bc11" value="<?= tglmysql($datheader['tgl_bc11']); ?>" aria-describedby="emailHelp" placeholder="Tgl BC 1.1" <?= $nonaktif; ?> readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil">Nomor Pos BC11</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-flat" id="nomor_posbc11" name="nomor_posbc11" value="<?= $datheader['nomor_posbc11']; ?>" aria-describedby="emailHelp" placeholder="Nomor Pos" <?= $nonaktif; ?> readonly>
                                            </div>
                                        </div>
                                        <div class="row mt-1 hilang">
                                            <label class="col-3 col-form-label font-kecil">Nomor Subpos BC11</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-flat" id="nomor_subposbc11" name="nomor_subposbc11" value="<?= $datheader['nomor_subposbc11']; ?>" aria-describedby="emailHelp" placeholder="Nomor Subpos" <?= $nonaktif; ?> readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card font-kecil mt-1">
                                <div class="bg-info-lt px-2 py-1 font-bold">Sarana Angkut & Kemasan</div>
                                <div class="card-body p-1">
                                    <!-- SARANA ANGKUT -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold <?= $hilangbc40; ?> <?= $hilangbc262; ?>">Pelabuhan & Tempat Penimbunan</div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <label class="col-3 col-form-label font-kecil">Pelabuhan Muat</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil font-bold btn-flat pelabuhan" name="pelabuhan_muat" data-placeholder="Pilih Pelabuhan" id="pelabuhan_muat" <?= $selectnonaktif; ?>>
                                                <!-- <option value="">Pilih Pelabuhan Muat</option> -->
                                                <option value="<?= $datheader['pelabuhan_muat']; ?>"><?= $datheader['pelabuhan_muat'] . ' - ' . $datheader['pelmuat']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <label class="col-3 col-form-label font-kecil">Pelabuhan Bongkar</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil btn-flat pelabuhan" name="pelabuhan_bongkar" data-placeholder="Pilih Pelabuhan" id="pelabuhan_bongkar" <?= $selectnonaktif; ?>>
                                                <option value="<?= $datheader['pelabuhan_bongkar']; ?>"><?= $datheader['pelabuhan_bongkar'] . ' - ' . $datheader['pelbongkar']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Sarana / Cara Angkutan</div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <label class="col-3 col-form-label font-kecil">No & Tipe Peti Kemas</label>
                                        <div class="col font-kecil">
                                            <!-- <select class="form-select font-kecil font-bold btn-flat" name="ukuran_kontainer" id="ukuran_kontainer" <?= $selectnonaktif; ?> >
                                                <option value="">-</option>
                                                <option value="20" <?php if ($datheader['ukuran_kontainer'] == '20') {
                                                                        echo "selected";
                                                                    } ?>>20 Feet</option>
                                                <option value="40" <?php if ($datheader['ukuran_kontainer'] == '40') {
                                                                        echo "selected";
                                                                    } ?>>40 Feet</option>
                                                <option value="60" <?php if ($datheader['ukuran_kontainer'] == '60') {
                                                                        echo "selected";
                                                                    } ?>>60 Feet</option>
                                            </select> -->
                                            <div class="mb-1 text-right">
                                                <a href="<?= base_url() . 'ib/addkontainer/' . $datheader['id']; ?>" class="btn btn-success py-0 px-1 btn-flat" title="Add Kontainer" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Kontainer"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <table class="table table-bordered mb-0">
                                                <tr class="bg-info-lt">
                                                    <td class="p-1 text-center font-bold">Jenis</td>
                                                    <td class="p-1 text-center font-bold">Nomor</td>
                                                    <td class="p-1 text-center font-bold">Ukuran</td>
                                                    <td class="p-1 text-center font-bold">Act</td>
                                                </tr>
                                                <tbody class="table-tbody" id="body-table-kontainer">
                                                    <tr>
                                                        <td colspan="4" class="text-center p-1">- Data tidak Ada -</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- <div class="col font-kecil">
                                            <input type="text" class="form-control font-kecil btn-flat" id="nomor_kontainer" name="nomor_kontainer" value="<?= $datheader['nomor_kontainer']; ?>" aria-describedby="emailHelp" placeholder="Nomor Kontainer" <?= $nonaktif; ?>>
                                        </div> -->
                                    </div>
                                    <div class="mb-1 mt-1 row">
                                        <label class="col-3 col-form-label font-kecil">Angkutan</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil font-bold btn-flat" name="jns_angkutan" id="jns_angkutan" <?= $selectnonaktif; ?>>
                                                <option value="">Pilih Angkutan</option>
                                                <?php foreach ($jnsangkutan->result_array() as $angkut) { ?>
                                                    <option value="<?= $angkut['id']; ?>" <?php if ($angkut['id'] == $datheader['jns_angkutan']) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $angkut['angkutan']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label font-kecil">Jenis Angkutan</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="angkutan" name="angkutan" value="<?= $datheader['angkutan']; ?>" aria-describedby="emailHelp" placeholder="Angkutan" <?= $nonaktif; ?>>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="no_kendaraan" name="no_kendaraan" value="<?= $datheader['no_kendaraan']; ?>" aria-describedby="emailHelp" placeholder="No Kendaraan" <?= $nonaktif; ?>>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?>">
                                        <label class="col-3 col-form-label font-kecil">Bendera</label>
                                        <div class="col">
                                            <select class="form-select font-kecil font-bold btn-flat" name="bendera_angkutan" id="bendera_angkutan" <?= $selectnonaktif; ?>>
                                                <option value="">Pilih Bendera Angkutan</option>
                                                <?php foreach ($refbendera->result_array() as $bendera) { ?>
                                                    <option value="<?= $bendera['id']; ?>" <?php if ($datheader['bendera_angkutan'] == $bendera['id']) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $bendera['kode_negara'] . '-' . $bendera['uraian_negara']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Kemasan -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Kemasan & Volume</div>
                                    <div class="mb-1 mt-0 row">
                                        <label class="col-3 col-form-label font-kecil mx-2">Jumlah Kemas</label>
                                        <div class="col-3">
                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="jml_kemasan" name="jml_kemasan" value="<?= rupiah($datheader['jml_kemasan'], 0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas" <?= $nonaktif; ?>>
                                        </div>
                                        <div class="col">
                                            <select class="form-select font-kecil font-bold btn-flat" name="kd_kemasan" id="kd_kemasan" <?= $selectnonaktif; ?>>
                                                <option value="">Pilih Kemasan</option>
                                                <?php foreach ($refkemas->result_array() as $kemas) { ?>
                                                    <option value="<?= $kemas['kdkem']; ?>" <?php if ($kemas['kdkem'] == $datheader['kd_kemasan']) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $kemas['kdkem'] . ' # ' . $kemas['kemasan']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-0 row">
                                        <label class="col-3 col-form-label font-kecil mx-2">Keterangan</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="ket_kemasan" name="ket_kemasan" value="<?= $datheader['ket_kemasan']; ?>" aria-describedby="emailHelp" title="Keterangan" placeholder="Keterangan" <?= $nonaktif; ?>>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="mb-0 mt-1 row">
                                        <label class="col-3 col-form-label font-kecil mx-2">Kgs / Volume</label>
                                        <div class="col">
                                            <div class="mb-1 row">
                                                <label class="col-3 col-form-label font-kecil">Bruto</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="bruto" name="bruto" value="<?= rupiah($datheader['bruto'], 2); ?>" aria-describedby="emailHelp" placeholder="Bruto Kgs" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-1 row">
                                                <label class="col-3 col-form-label font-kecil">Netto</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="netto" name="netto" value="<?= rupiah($datheader['netto'], 2); ?>" aria-describedby="emailHelp" placeholder="Netto Kgs" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card font-kecil mt-1">
                                <div class="bg-primary-lt px-2 py-1 font-bold">Nilai Penyerahan, Devisa</div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-1 mt-1 row">
                                                <label class="col-3 col-form-label font-kecil">Nilai Pabean / CIF</label>
                                                <div class="col">
                                                    <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                                                    <select class="form-select font-kecil font-bold btn-flat" name="mtuang" id="mtuang" <?= $selectnonaktif; ?>>
                                                        <option value="">Pilih</option>
                                                        <?php foreach ($refmtuang->result_array() as $mtuang) { ?>
                                                            <option value="<?= $mtuang['id']; ?>" <?php if ($mtuang['id'] == $datheader['mtuang']) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?= $mtuang['mt_uang']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="nilai_pab" name="nilai_pab" value="<?= rupiah($datheader['nilai_pab'], 2); ?>" aria-describedby="emailHelp" placeholder="Nilai Pabean" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                            <div class="mb-1 row">
                                                <?php 
                                                    $hilangtomboladdkontrak = $datheader['nomorkontrak']==NULL && $datheader['send_ceisa']==0 ? '' : 'hilang';  
                                                    $hilangtombolhapuskontrak = $datheader['nomorkontrak']!=NULL && $datheader['send_ceisa']==0  ? '' : 'hilang';  
                                                ?>
                                                <label class="col-3 col-form-label font-kecil">Nomor Kontrak</label>
                                                <div class="col">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control font-bold font-kecil btn-flat " id="nomorkontrak" value="<?= $datheader['nomorkontrak']; ?>" placeholder="Nomor Kontrak Kosong" disabled>
                                                        <a href="<?= base_url().'ib/addkontrak/'.$datheader['id'].'/'.$datheader['dept_tuju']; ?>" class="btn btn-info font-kecil btn-flat <?= $hilangtomboladdkontrak; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Pilih Kontrak" >Pilih</a>
                                                        <a data-href="<?= base_url().'ib/hapuskontrak/'.$datheader['id']; ?>" class="btn btn-danger font-kecil btn-flat text-white <?= $hilangtombolhapuskontrak; ?>" style="color: white !important;" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus Kontrak ini" data-title="Hapus Kontrak" >Hapus</a>
                                                        <a class="btn btn-success font-kecil btn-flat <?= $hilangtombolhapuskontrak; ?>" href="<?= base_url('kontrak/view/') . $datheader['idkontrak'].'/1'; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Kontrak" >View</a>
                                                        <a class="btn btn-primary font-kecil btn-flat <?= $hilangtombolhapuskontrak; ?>" id="addkontraktolampiran" href="#" data-title="Add To Lampiran" ><i class="fa fa-upload"></i></a>
                                                        <!-- <button class="btn font-kecil btn-flat" type="button">View</button> -->
                                                        <input type="text" class="form-control font-bold font-kecil btn-flat hilang" id="tglkontrak" value="<?= tglmysql($datheader['tglkontrak']); ?>" placeholder="Nomor Kontrak Kosong" >
                                                        <input type="text" class="form-control font-bold font-kecil btn-flat hilang" id="tgl_kep" value="<?= tglmysql($datheader['tgl_kep']); ?>" placeholder="Nomor Kontrak Kosong" >
                                                        <input type="text" class="form-control font-bold font-kecil btn-flat hilang" id="nomor_kep" value="<?= $datheader['nomor_kep']; ?>" placeholder="Nomor Kontrak Kosong" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-1 pt-1 row bg-cyan-lt">
                                                <label class="col-3 col-form-label font-kecil" style="cursor: pointer" id="cekndpbm">NDPBM</label>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil">USD</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="kurs_usd" name="kurs_usd" value="<?= rupiah($datheader['kurs_usd'], 2); ?>" aria-describedby="emailHelp" placeholder="Kurs USD" <?= $nonaktif; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil">IDR</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="kurs_idr" name="kurs_idr" value="<?= rupiah($datheader['kurs_idr'], 0); ?>" aria-describedby="emailHelp" placeholder="Kurs IDR" <?= $nonaktif; ?>>
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
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="devisa_usd" name="devisa_usd" value="<?= rupiah($datheader['devisa_usd'], 3); ?>" aria-describedby="emailHelp" placeholder="Devisa USD" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil text-black">IDR</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat text-right" id="devisa_idr" name="devisa_idr" value="<?= rupiah($datheader['devisa_idr'], 3); ?>" aria-describedby="emailHelp" placeholder="Devisa IDR" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card font-kecil mt-1">
                                <div class="bg-warning-lt px-2 py-1 font-bold"><span class="text-black">Penanggung Jawab</span></div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-1 mt-0 row">
                                                <label class="col-3 col-form-label font-kecil mx-2">Nama</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="tg_jawab" name="tg_jawab" value="<?= $datheader['tg_jawab']; ?>" aria-describedby="emailHelp" title="Nama Penanggung Jawab" placeholder="Nama Penanggung Jawab" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-1 mt-0 row">
                                                <label class="col-3 col-form-label font-kecil mx-2">Jabatan</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat" id="jabat_tg_jawab" name="jabat_tg_jawab" value="<?= $datheader['jabat_tg_jawab']; ?>" aria-describedby="emailHelp" title="Jabatan Penanggung Jawab" placeholder="Jabatan Penanggung Jawab" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-cyan-lt" id="tabs-barang-8">
                <div class="m-2 font-bold d-flex justify-content-between">
                    <div>Detail Barang</div>
                    <div>
                        <span class="font-kecil text-black">
                            Jumlah Pcs : <span id="jumlahpcsdetailbarang"></span><br>
                            Jumlah Kgs : <span id="jumlahkgsdetailbarang"></span>
                        </span>
                    </div>
                    <div>
                        <?php $hilangbc40kustom = $datheader['jns_bc'] == "40" && trim($datheader['nomor_bc']) != '' ? "" : "hilang" ?>
                        <a href="<?= base_url() . 'ib/getbcasal/' . $datheader['id'] . '/1'; ?>" id="tombolgetbcasal" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-message="Akan menghitung nilai BOM " data-title="BC Asal Default" class="btn btn-sm btn-primary hilang <?= $hilangbc23 . ' ' . $hilangbc40 ?>"><i class="fa fa-calculator mr-1"></i> BC Asal Default</a>
                        <a href="#" data-href="<?= base_url() . 'ib/simpankehargamaterial/' . $datheader['id'] . '/1'; ?>" id="tombolexpmaterial" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengexport data ke Harga Material" data-title="Export Harga Material" class="btn btn-sm btn-primary <?= $hilangbc40kustom ?>"><i class="fa fa-cloud mr-1"></i> Export ke Harga Material</a>
                    </div>
                </div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>Nama Barang</th>
                                    <?php if ($mode == 0) { ?>
                                        <th class="text-left">Kategori</th>
                                    <?php } else { ?>
                                        <th class="text-left">SKU</th>
                                    <?php } ?>
                                    <th class="text-left">HS Code</th>
                                    <th>Satuan</th>
                                    <th>Pcs</th>
                                    <th>Kgs</th>
                                    <th>Hrg/Satuan</th>
                                    <th>Total</th>
                                    <?php if ($mode == 1) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-tablee" style="font-size: 13px !important;">
                                <?php $no = 0;
                                $sumdetail = 0;
                                $sumpcs = 0;
                                $sumkgs = 0;
                                $sumcif = 0;
                                foreach ($header as $data) {
                                    $no++;
                                    $jumlah = $data['kodesatuan'] == 'KGS' ? $data['kgs'] : $data['pcs'];
                                    $sumdetail += $mode == 0 ? $data['harga'] * $jumlah : $data['xcif'] * $data['xndpbm'];
                                    $sumpcs += $mode == 0 ? $data['pcs'] : $data['pcsx'];
                                    $sumkgs += $mode == 0 ? $data['kgs'] : $data['kgsx'];
                                    $spekbarang = trim($data['po']) == '' ? $data['nama_barang'] : spekpo($data['po'], $data['item'], $data['dis']);
                                    $sku = $mode == 0 ? $data['kategori_id'] : (trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis']));
                                    $nohs = $mode == 0 ? $data['nohs'] : (trim($data['po']) == '' ? $data['nohs'] : $data['hsx']);
                                    $sumcif += $mode == 0 ? 0 : $data['xcif'];
                                ?>
                                    <tr>
                                        <td class="line-12">
                                            <?php if ($mode == 0 || $data['id_seri_exbc'] == 0) { ?>
                                                <?= $no . '. ' . $spekbarang; ?><br><span class="text-teal font-11"><?= $data['insno'] . $data['nobontr'] ?></span>
                                            <?php } else { ?>
                                                <a href="<?= base_url() . 'ib/viewbcasal/' . $data['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="View BC ASAL"><?= $no . '. ' . $spekbarang; ?></a><br><span class="text-teal font-11"><?= $data['insno'] . $data['nobontr'] ?></span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-left"><?= $sku ?></td>
                                        <td class="text-left"><?= $nohs; ?></td>
                                        <td><?= $data['kodesatuan']; ?></td>
                                        <?php if ($mode == 0) { ?>
                                            <td class="text-right"><?= rupiah($data['pcs'], 0); ?></td>
                                            <td class="text-right"><?= rupiah($data['kgs'], 2); ?></td>
                                            <td class="text-right"><?= rupiah($data['harga'], 2); ?></td>
                                            <td class="text-right"><?= rupiah($data['harga'] * $jumlah, 2); ?></td>
                                        <?php } else { ?>
                                            <?php $datkgs = $data['kgsx'] == 0 ? 1 : $data['kgsx']; ?>
                                            <td class="text-right"><?= rupiah($data['pcsx'], 0); ?></td>
                                            <td class="text-right" id="kgss<?= $data['id'] ?>"><?= rupiah($data['kgsx'], 2); ?></td>
                                            <td id="jumlahcif<?= $data['id'] ?>" class="text-right line-12"><?= rupiah(($data['xcif'] / $datkgs) * $data['xndpbm'], 2); ?><br><span class="font-11 text-pink"><?= rupiah($data['xcif'], 2) ?></span></td>
                                            <td class="text-right"><?= rupiah($data['xcif'] * $data['xndpbm'], 2); ?></td>
                                        <?php } ?>
                                        <?php if ($mode == 1) : ?>
                                            <td class="text-center">
                                                <a href="<?= base_url() . 'ib/editbcasal/' . $datheader['id'] . '/' . $data['id']; ?>" class="btn btn-sm btn-success font-bold" style="padding: 0px 2px !important;" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Edit Data BC ASAL 261">EDIT</a>
                                                <a href="#" data-href="<?= base_url() . 'ib/resetbcasal/' . $datheader['id'] . '/' . $data['id']; ?>" class="btn btn-sm btn-danger font-bold" style="padding: 0px 2px !important;" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Me-reset BC ASAL 261">RESET</a>
                                                <a href="<?= base_url() . 'ib/editkgsbcasal/' . $datheader['id'] . '/' . $data['id']; ?>" class="btn btn-sm btn-info font-bold" style="padding: 0px 2px !important;" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Edit Data BC KGS ASAL 261">EDIT KGS</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-primary-lt">
                                    <td class="text-black text-center font-bold" colspan="4">TOTAL</td>
                                    <td class="text-black text-right font-bold" id="pcssum"><?= rupiah($sumpcs, 0); ?></td>
                                    <td class="text-black text-right font-bold" id="txtsum"><?= rupiah($sumkgs, 2); ?></td>
                                    <td></td>
                                    <td class="text-black text-right font-bold line-12"><?= rupiah($sumdetail, 2); ?>
                                        <?php if ($mode == 1) : ?>
                                            <br><span class="text-pink font-12"><?= rupiah($sumcif, 2) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" id="sumdetail" class="hilang" value="<?= rupiah($sumdetail, 2); ?>">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-red-lt" id="tabs-profile-8">
                <div class="m-2 font-bold d-flex justify-content-between">Lampiran Dokumen
                    <span>
                        <a href="#" data-href="<?= base_url() . 'ib/autolampiran/' . $datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengisi lampiran secara otomatis" data-title="Lampiran" class="btn btn-sm btn-yellow text-black"><i class="fa fa-plus mr-1 <?= $hilangbc23 . ' ' . $hilangbc40 ?>"></i> Auto</a>
                        <a href="<?= base_url() . 'ib/addlampiran/' . $datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Lampiran" id="keexcel" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-1"></i> Tambah Data</a>
                        <span>
                </div>
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
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                            </tbody>
                        </table>
                        <input type="text" id="jmllampiran" class="hilang">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-grey-lt" id="tabs-foto-8">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mt-2 font-bold d-flex justify-content-between">Lampiran Foto & Video Aju Masuk Barang <br>

                        </div>
                    </div>
                    <div class="col-md-5">
                        <?php if (empty($datheader['file'])) : ?>
                            <a href="<?= base_url('ib/upload/') . $datheader['id']; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File">
                                <i class="fa fa-plus"></i>
                                <span class="ml-1">Upload</span>
                            </a>
                        <?php else : ?>
                            <a href="<?= base_url('ib/edit_file/') . $datheader['id']; ?>" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File"><i class="fa fa-gear"></i><span class="ml-1">Setting</span></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="text-muted fw-semibold mb-2"></div>

                    <?php
                    $path_files = json_decode($datheader['path_file'], true);
                    $file_names = json_decode($datheader['file'], true);


                    if (!empty($path_files)) {
                    ?>

                        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="30000">

                            <div class="carousel-indicators">
                                <?php foreach ($path_files as $index => $path) { ?>
                                    <button type="button" data-bs-target="#mediaCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo ($index == 0) ? 'active' : ''; ?>" aria-current="<?php echo ($index == 0) ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>">
                                    </button>
                                <?php } ?>
                            </div>

                            <div class="carousel-inner rounded shadow-sm">
                                <?php foreach ($path_files as $index => $path) {
                                    $filename = isset($file_names[$index]) ? $file_names[$index] : basename($path);
                                    $is_image = preg_match('/\.(jpe?g|png|gif|webp)$/i', $path);
                                    $is_video = preg_match('/\.(mp4|webm|ogg)$/i', $path);
                                ?>
                                    <div class="carousel-item <?php echo ($index == 0) ? 'active' : ''; ?>">

                                        <?php
                                        if ($is_image) { ?>
                                            <a href="<?php echo base_url($path); ?>" target="_blank" title="Lihat: <?php echo htmlspecialchars($filename); ?>">
                                                <img src="<?php echo base_url($path); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($filename); ?>" style="max-height: 400px; object-fit: contain; background-color: #f8f9fa;">
                                            </a>
                                        <?php } else if ($is_video) { ?>
                                            <video class="d-block w-100" controls autoplay muted playsinline style="max-height: 400px; background-color: #000;">
                                                <source src="<?php echo base_url($path); ?>" type="video/<?php echo pathinfo($path, PATHINFO_EXTENSION); ?>">
                                                Browser Anda tidak mendukung tag video.
                                            </video>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url($path); ?>" target="_blank" title="Lihat: <?php echo htmlspecialchars($filename); ?>">
                                                <div class="d-flex align-items-center justify-content-center w-100 bg-light text-secondary" style="height: 300px;">
                                                    <span class="fs-4">📎 File: <?php echo htmlspecialchars($filename); ?> (Klik untuk lihat)</span>
                                                </div>
                                            </a>
                                        <?php } ?>

                                        <div class="carousel-caption d-none d-md-block text-start bg-dark bg-opacity-75 p-2 rounded">
                                            <p class="mb-0 text-white" style="font-size: 0.9em;">
                                                <?php echo htmlspecialchars($filename); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php if (count($path_files) > 1) { ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            <?php } ?>
                        </div>

                    <?php
                    } else {
                        echo '<span style="color: gray;">Tidak ada file foto/video yang dilampirkan.</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr class="m-1">
    <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary me-auto hilang" data-bs-dismiss="modal">Batal</button>
        <div class="text-red" style="font-size: 12px !important;" id="keteranganerr"></div>
        <!-- <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Verifikasi Data</a> -->
    </div>
    <div>
    </div>
</div>