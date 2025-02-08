<div class="container-xl"> 
    <div class="m-2 font-bold">DATA BC - IB NO <span class="text-blue"><?= $datheader['nomor_dok']; ?></span></div>
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
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row">
                    <input type="hidden" name="errorsimpan" id="errorsimpan" value="<?= $this->session->flashdata('errorsimpan'); ?>">
                    <input type="hidden" name="pesanerror" id="pesanerror" value="<?= $this->session->flashdata('pesanerror'); ?>">
                    <div class="m-2 font-bold d-flex justify-content-between">
                    <span class="mt-2 text-info">
                        <?php
                            if($this->session->userdata('datatokenbeacukai')!=''){
                                echo "DATA TOKEN ALREADY SET ";
                                // echo $this->session->userdata('datatokenbeacukai');
                            } else {
                                echo "DATA TOKEN NOT SET";
                            }
                        ?>
                    </span>
                    <span>
                        <?php $hilang = ($datheader['send_ceisa']==0  || $datheader['nomor_sppb']!='') ? "hilang" : ""; ?>
                        <?php $hilang2 = $datheader['send_ceisa']==1 ? "hilang" : ""; ?>
                        <?php $hilang3 = $datheader['nomor_sppb']=='' ? "hilang" : ""; ?>
                        <?php $nonaktif = $datheader['send_ceisa']==1 ? "readonly" : ""; ?>
                        <?php $hilangbc23 = $datheader['jns_bc']==23 ? "hilang" : ""; ?>
                        <?php $selectnonaktif = $datheader['send_ceisa']==1 ? "disabled" : ""; ?>
                        <a href="<?= base_url().'ib/ceisa40excel/'.$datheader['id']; ?>" id="keexcel" style="border-right: 1px solid black;" class="btn btn-sm btn-success mr-0"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="<?= base_url().'ib/getresponhost/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-info <?= $hilang; ?>"><i class="fa fa-cloud mr-1"></i>Respon H2H</a><a href="#" id="cekdata" class="btn btn-sm btn-yellow <?= $hilang2; ?>"><i class="fa fa-cloud mr-1"></i>Kirim H2H</a><a id="kirimkeceisax" href="<?= base_url().'ib/getresponpdf/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-danger <?= $hilang3; ?>"><i class="fa fa-file-pdf-o mr-1"></i>GET PDF</a>
                        <!-- <a href="<?= base_url().'ib/hosttohost/'.$datheader['id']; ?>" style="border-left: 1px solid black;" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> H2H Token</a> -->
                        <?php if($datheader['send_ceisa']==0 || $datheader['nomor_sppb']==''){ ?>
                            <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Verifikasi Data</a>
                        <?php }else{ ?>
                            <a class="btn btn-sm btn-yellow" href="<?= base_url().'ib/uploaddok/'.$datheader['id']; ?>" style="color: white;" id="uploaddok" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Upload Dokumen"><i class="fa fa-file-o mr-1"></i> Upload Dokumen</a>
                        <?php } ?>
                        <a href="<?= base_url().'ib'; ?>" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left mr-1"></i> Kembali</a></span></div>
                        <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
                        <input type="hidden" name="tgl" id="tgl" value="<?= $datheader['tgl']; ?>">
                        <hr class="m-0">
                        <div class="d-flex justify-content-between">
                            <div class="p-2 font-kecil">
                                Nama Pengirim : <?= $datheader['namasupplier']; ?><br>
                                Alamat Pengirim : <?= $datheader['alamat']; ?></br>
                                NPWP : <?= $datheader['npwp']; ?>
                                <button href="#" id="kirimkeceisa" data-href="<?= base_url().'ib/kirimdatakeceisa'.$datheader['jns_bc'].'/'.$datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengirim data ini ke CIESA 40" style="border-right: 1px solid white;" class="btn btn-sm btn-yellow hilang"><i class="fa fa-cloud mr-1"></i>Kirim H2H</button>
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
                                            <?php $selek = $datheader['jns_bc']==$bcmas['jns_bc'] ? 'selected' : ''; ?>
                                            <option value="<?= $bcmas['jns_bc']; ?>" <?= $selek; ?>><?= $bcmas['ket_bc']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3 col-form-label font-kecil">No/Tgl AJU</label>
                                <div class="col">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="<?= $datheader['nomor_aju']; ?>"  placeholder="Nomor Aju" <?= $nonaktif; ?>>
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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card font-kecil mt-1">
                                <div class="bg-info-lt px-2 py-1 font-bold">Dokumen Pelengkap Kepabeanan</div>
                                <div class="card-body p-1">
                                    <!-- Surat Jalan  -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Surat Jalan</div>
                                    <div class="mb-1 row">
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
                                    <div class="<?= $hilangbc23; ?>">
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
                                    <!-- Ex BC  -->
                                    <div class="<?php if($datheader['jns_bc']==40){ echo "hilang"; } ?>">
                                        <div class="text-center bg-primary-lt mb-1 font-bold">Nomor BL / AWB</div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Nomor</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat" id="nomor_blawb" name="nomor_blawb" value="<?= $datheader['nomor_blawb']; ?>" aria-describedby="emailHelp" placeholder="Ex Nomor BC" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_blawb" name="tgl_blawb" value="<?= tglmysql($datheader['tgl_blawb']); ?>" aria-describedby="emailHelp" placeholder="Tgl Ex BC" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
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
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Sarana Angkutan</div>
                                    <div class="mb-1 mt-1 row">
                                        <label class="col-3 col-form-label font-kecil">Angkutan</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil font-bold btn-flat" name="jns_angkutan" id="jns_angkutan" <?= $selectnonaktif; ?> >
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
                                            <input type="text" class="form-control font-kecil btn-flat" id="angkutan" name="angkutan" value="<?= $datheader['angkutan']; ?>" aria-describedby="emailHelp" placeholder="Angkutan" <?= $nonaktif; ?>>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="no_kendaraan" name="no_kendaraan" value="<?= $datheader['no_kendaraan']; ?>" aria-describedby="emailHelp" placeholder="No Kendaraan" <?= $nonaktif; ?>>
                                        </div>
                                    </div>
                                    <!-- Kemasan -->
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Kemasan & Volume</div>
                                    <div class="mb-1 mt-0 row">
                                        <label class="col-3 col-form-label font-kecil mx-2">Jumlah Kemas</label>
                                        <div class="col-3">
                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="jml_kemasan" name="jml_kemasan" value="<?= rupiah($datheader['jml_kemasan'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas" <?= $nonaktif; ?>>
                                        </div>
                                        <div class="col">
                                            <select class="form-select font-kecil font-bold btn-flat" name="kd_kemasan" id="kd_kemasan" <?= $selectnonaktif; ?>>
                                                <option value="">Pilih Kemasan</option>
                                                <?php foreach ($refkemas->result_array() as $kemas) { ?>
                                                    <option value="<?= $kemas['kdkem']; ?>" <?php if($kemas['kdkem']==$datheader['kd_kemasan']){ echo "selected"; } ?>><?= $kemas['kdkem'].' # '.$kemas['kemasan']; ?></option>
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
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="bruto" name="bruto" value="<?= rupiah($datheader['bruto'],2); ?>" aria-describedby="emailHelp" placeholder="Bruto Kgs" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-1 row">
                                                <label class="col-3 col-form-label font-kecil">Netto</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="netto" name="netto" value="<?= rupiah($datheader['netto'],2); ?>" aria-describedby="emailHelp" placeholder="Netto Kgs" <?= $nonaktif; ?>>
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
                                                            <option value="<?= $mtuang['id']; ?>" <?php if($mtuang['id']==$datheader['mtuang']){ echo "selected"; } ?>><?= $mtuang['mt_uang']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="nilai_pab" name="nilai_pab" value="<?= rupiah($datheader['nilai_pab'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-1 pt-1 row bg-cyan-lt">
                                                <label class="col-3 col-form-label font-kecil">NDPBM</label>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil">USD</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="kurs_usd" name="kurs_usd" value="<?= rupiah($datheader['kurs_usd'],2); ?>" aria-describedby="emailHelp" placeholder="Kurs USD" <?= $nonaktif; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil">IDR</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="kurs_idr" name="kurs_idr" value="<?= rupiah($datheader['kurs_idr'],0); ?>" aria-describedby="emailHelp" placeholder="Kurs IDR" <?= $nonaktif; ?>>
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
                                                            <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="devisa_usd" name="devisa_usd" value="<?= rupiah($datheader['devisa_usd'],3); ?>" aria-describedby="emailHelp" placeholder="Devisa USD" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-1 row">
                                                        <label class="col-3 col-form-label font-kecil text-black">IDR</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control font-kecil btn-flat text-right" id="devisa_idr" name="devisa_idr" value="<?= rupiah($datheader['devisa_idr'],3); ?>" aria-describedby="emailHelp" placeholder="Devisa IDR" disabled>
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
                <div class="m-2 font-bold d-flex justify-content-between">Detail Barang</div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th class="text-left">Kategori</th>
                                    <th class="text-left">HS Code</th>
                                    <th>Satuan</th>
                                    <th>Pcs</th>
                                    <th>Kgs</th>
                                    <th>Hrg/Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-tablee" style="font-size: 13px !important;" >
                                    <?php $sumdetail=0; $sumpcs=0; $sumkgs=0; foreach ($header as $data) { 
                                        $jumlah = $data['kodesatuan']=='KGS' ? $data['kgs'] : $data['pcs']; 
                                        $sumdetail += $data['harga']*$jumlah;
                                        $sumpcs += $data['pcs'];
                                        $sumkgs += $data['kgs'];
                                         ?>
                                    <tr>
                                        <td><?= $data['nama_barang']; ?></td>
                                        <td class="text-left"><?= $data['kategori_id']; ?></td>
                                        <td class="text-left"><?= $data['nohs']; ?></td>
                                        <td><?= $data['kodesatuan']; ?></td>
                                        <td class="text-right"><?= rupiah($data['pcs'],0); ?></td>
                                        <td class="text-right"><?= rupiah($data['kgs'],2); ?></td>
                                        <td class="text-right"><?= rupiah($data['harga'],2); ?></td>
                                        <td class="text-right"><?= rupiah($data['harga']*$jumlah,2); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-primary-lt">
                                    <td class="text-black text-center font-bold" colspan="4">TOTAL</td>
                                    <td class="text-black text-right font-bold"><?= rupiah($sumpcs,0); ?></td>
                                    <td class="text-black text-right font-bold"><?= rupiah($sumkgs,2); ?></td>
                                    <td></td>
                                    <td class="text-black text-right font-bold"><?= rupiah($sumdetail,2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" id="sumdetail" class="hilang" value="<?= $sumdetail; ?>">
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
                        <input type="text" id="jmllampiran" class="hilang">
                    </div>
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