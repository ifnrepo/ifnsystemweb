<div class="container-xl"> 
    <div class="mx-2 font-bold">AJU KELUAR BARANG</div>
    <div class="mx-2 mb-2 font-bold">DATA BC - NO <span class="text-blue"><?= $datheader['nomor_dok']; ?></span></div>
    <div class="card-header font-kecil">    
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" style="background-color: #F6F8FB">
            <li class="nav-item">
             <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat font-bold" data-bs-toggle="tab">Header Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-barang-8" class="nav-link bg-cyan-lt btn-flat font-bold" data-bs-toggle="tab">Detail Barang</a>
            </li>
            <?php $navhilang = $datheader['jns_bc']!=261 ?  "hilang" : ""; ?>
            <li class="nav-item <?= $navhilang; ?>">
                <a href="#tabs-barangdet-8" class="nav-link bg-purple-lt btn-flat font-bold" data-bs-toggle="tab">Detail Ver. BC </a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Dokumen</a>
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
                    <input type="hidden" id="namahalaman" value="akb">
                    <input type="hidden" id="modehalaman" value="<?= $mode; ?>">
                    <?php $date = date("Y-m-d H:i:s",strtotime("+2 hours",strtotime($datatoken['update_at']))); ?>
                    <input type="hidden" id="updateon" value="<?= $date; ?>">
                    <div class="m-2 font-bold d-flex justify-content-between">
                    <span class="mt-2 text-info" id="adaapadengantoken">

                    </span>
                    <span>
                        <?php $hilang = ($datheader['send_ceisa']==0  || $datheader['nomor_sppb']!='') ? "hilang" : ""; ?>
                        <?php $hilang2 = $datheader['send_ceisa']==1 ? "hilang" : ""; ?>
                        <?php $hilang3 = $datheader['nomor_sppb']=='' ? "hilang" : ""; ?>
                        <?php $nonaktif = $datheader['send_ceisa']==1 ? "readonly" : ""; ?>
                        <?php $hilangbc30 = $datheader['jns_bc']==30 ? "hilang" : ""; ?>
                        <?php $hilangbc40 = $datheader['jns_bc']==40 ? "hilang" : ""; ?>
                        <?php $hilangbc262 = $datheader['jns_bc']==262 ? "hilang" : ""; ?>
                        <?php $hilangbc261 = $datheader['jns_bc']==261 ? "hilang" : ""; ?>
                        <?php $selectnonaktif = $datheader['send_ceisa']==1 ? "disabled" : ""; ?>
                        <a href="<?= base_url().'akb/ceisa40excel/'.$datheader['id']; ?>" id="keexcel" style="border-right: 1px solid black;" class="btn btn-sm btn-success mr-0"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="<?= base_url().'akb/getresponhost/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-info <?= $hilang; ?>"><i class="fa fa-cloud mr-1"></i>Respon H2H</a><a href="#" id="cekdata" class="btn btn-sm btn-yellow text-black <?= $hilang2; ?>"><i class="fa fa-cloud mr-1"></i>Kirim H2H</a><a id="kirimkeceisax" href="<?= base_url().'akb/getresponpdf/'.$datheader['id']; ?>" style="border-right: 1px solid white;" class="btn btn-sm btn-danger <?= $hilang3; ?>"><i class="fa fa-file-pdf-o mr-1"></i>GET PDF</a>
                        <!-- <a href="<?= base_url().'akb/hosttohost/'.$datheader['id']; ?>" style="border-left: 1px solid black;" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> H2H Token</a> -->
                        <?php if($datheader['send_ceisa']==0 || $datheader['nomor_sppb']==''){ ?>
                            <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Verifikasi Data</a>
                        <?php }else{ ?>
                            <a class="btn btn-sm btn-yellow" href="<?= base_url().'akb/uploaddok/'.$datheader['id']; ?>" style="color: white;" id="uploaddok" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Upload Dokumen"><i class="fa fa-file-o mr-1"></i> Upload Dokumen</a>
                        <?php } ?>
                        <a href="<?= base_url().'akb'; ?>" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left mr-1"></i> Kembali</a></span></div>
                        <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
                        <input type="hidden" name="tgl" id="tgl" value="<?= $datheader['tgl']; ?>">
                        <hr class="m-0">
                        <div class="d-flex justify-content-between">
                            <div class="p-2 font-kecil">
                                <?php if($mode==0){ ?>
                                Nama Customer : <?= $datheader['namacustomer']; ?><br>
                                Alamat : <?= $datheader['alamat']; ?></br>
                                NPWP : <?= $datheader['npwp']; ?>
                                <?php }else{ ?>
                                Nama Subkontrak : <?= datadepartemen($datheader['dept_tuju'],'nama_subkon'); ?><br>
                                Alamat : <?= datadepartemen($datheader['dept_tuju'],'alamat_subkon'); ?></br>
                                NPWP : <?= datadepartemen($datheader['dept_tuju'],'npwp'); ?>
                                <?php } ?>
                                <button href="#" id="kirimkeceisa" data-href="<?= base_url().'akb/kirimdatakeceisa'.$datheader['jns_bc'].'/'.$datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan mengirim data ini ke CIESA" style="border-right: 1px solid white;" class="btn btn-sm btn-yellow hilang"><i class="fa fa-cloud mr-1"></i>Kirim H2H</button>
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
                                        <?php foreach ($bckeluar->result_array() as $bcmas) { ?>
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
                                                <label class="col-3 col-form-label font-kecil mx-2">No SJ</label>
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
                                                <label class="col-3 col-form-label font-kecil mx-2">No Dok</label>
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
                                                <label class="col-3 col-form-label font-kecil mx-2">No PO</label>
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
                                                <label class="col-3 col-form-label font-kecil mx-2">No INV</label>
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
                                                <label class="col-3 col-form-label font-kecil mx-2">No PL</label>
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
                                    <div class="<?= $hilangbc30; ?><?= $hilangbc40; ?><?= $hilangbc261; ?>">
                                        <div class="text-center bg-danger-lt mb-1 font-bold">Ex BC</div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil mx-2">No Ex-BC</label>
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
                                    <div class="<?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <div class="text-center bg-primary-lt mb-1 font-bold">Nomor BL / AWB</div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil mx-2">Nomor</label>
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
                                    </div>
                                    <!-- BL AWB  -->
                                    <div class="<?= $hilangbc30; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <div class="text-center bg-danger-lt mb-1 font-bold"><span class="text-black">BC 1.1</span></div>
                                        <div class="mb-1 row">
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil mx-2">Nomor</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat" id="bc11" name="bc11" value="<?= $datheader['bc11']; ?>" aria-describedby="emailHelp" placeholder="BC 1.1" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <label class="col-3 col-form-label font-kecil">Tgl</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control font-kecil btn-flat tgl" id="tgl_bc11" name="tgl_bc11" value="<?= tglmysql($datheader['tgl_bc11']); ?>" aria-describedby="emailHelp" placeholder="Tgl BC 1.1" <?= $nonaktif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-3 col-form-label font-kecil mx-2">Nomor Pos BC11</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-flat" id="nomor_posbc11" name="nomor_posbc11" value="<?= $datheader['nomor_posbc11']; ?>" aria-describedby="emailHelp" placeholder="Nomor Pos" <?= $nonaktif; ?>>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <label class="col-3 col-form-label font-kecil mx-2">Nomor Subpos BC11</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-flat" id="nomor_subposbc11" name="nomor_subposbc11" value="<?= $datheader['nomor_subposbc11']; ?>" aria-describedby="emailHelp" placeholder="Nomor Subpos" <?= $nonaktif; ?>>
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
                                    <div class="text-center bg-primary-lt mb-1 font-bold <?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">Pelabuhan & Tempat Penimbunan</div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <label class="col-3 col-form-label font-kecil mx-2">Pelabuhan Muat</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil font-bold btn-flat pelabuhan" name="pelabuhan_muat" data-placeholder="Pilih Pelabuhan" id="pelabuhan_muat" <?= $selectnonaktif; ?> >
                                                <!-- <option value="">Pilih Pelabuhan Muat</option> -->
                                                 <option value="<?= $datheader['pelabuhan_muat']; ?>"><?= $datheader['p elabuhan_muat'].' - '.$datheader['pelmuat']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <label class="col-3 col-form-label font-kecil mx-2">Pelabuhan Bongkar</label>
                                        <div class="col font-kecil">
                                            <select class="form-select font-kecil btn-flat pelabuhan" name="pelabuhan_bongkar" data-placeholder="Pilih Pelabuhan" id="pelabuhan_bongkar" <?= $selectnonaktif; ?>>
                                                <option value="<?= $datheader['pelabuhan_bongkar']; ?>"><?= $datheader['pelabuhan_bongkar'].' - '.$datheader['pelbongkar']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center bg-primary-lt mb-1 font-bold">Sarana / Cara Angkutan</div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <label class="col-3 col-form-label font-kecil mx-2">No & Tipe Peti Kemas</label>
                                        <div class="col font-kecil">
                                            <div class="mb-1 text-right">
                                                <a href="<?= base_url().'ib/addkontainer/'.$datheader['id']; ?>" class="btn btn-success py-0 px-1 btn-flat" title="Add Kontainer" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Kontainer"><i class="fa fa-plus"></i></a>
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
                                    </div>
                                    <hr class="m-0">
                                    <div class="mb-1 mt-1 row">
                                        <label class="col-3 col-form-label font-kecil mx-2">Angkutan</label>
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
                                        <label class="col-3 col-form-label font-kecil mx-2">Jenis Angkutan</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="angkutan" name="angkutan" value="<?= $datheader['angkutan']; ?>" aria-describedby="emailHelp" placeholder="Angkutan" <?= $nonaktif; ?>>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil btn-flat" id="no_kendaraan" name="no_kendaraan" value="<?= $datheader['no_kendaraan']; ?>" aria-describedby="emailHelp" placeholder="No Kendaraan" <?= $nonaktif; ?>>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-1 row <?= $hilangbc40; ?> <?= $hilangbc262; ?><?= $hilangbc261; ?>">
                                        <label class="col-3 col-form-label font-kecil mx-2">Bendera</label>
                                        <div class="col">
                                            <select class="form-select font-kecil font-bold btn-flat" name="bendera_angkutan" id="bendera_angkutan" <?= $selectnonaktif; ?> >
                                                <option value="">Pilih Bendera Angkutan</option>
                                                <?php foreach ($refbendera->result_array() as $bendera) { ?>
                                                    <option value="<?= $bendera['id']; ?>" <?php if($datheader['bendera_angkutan']==$bendera['id']){ echo "selected"; } ?>><?= $bendera['kode_negara'].'-'.$bendera['uraian_negara']; ?></option>
                                                <?php } ?>
                                            </select>
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
                                <?php $caption_de = $datheader['jns_bc']==261 ? "Kontrak & Nilai Pabean" : "Nilai Penyerahan, Devisa";  ?>
                                <div class="bg-primary-lt px-2 py-1 font-bold"><?= $caption_de; ?></div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-1 row <?= $hilangbc261; ?>">
                                                <label class="col-3 col-form-label font-kecil mx-2">Kode Cara Bayar</label>
                                                <div class="col">
                                                    <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                                                    <select class="form-select font-kecil font-bold btn-flat" name="kode_incoterm" id="kode_incoterm" <?= $selectnonaktif; ?>>
                                                        <option value="">Pilih</option>
                                                        <?php foreach ($refincoterm->result_array() as $incoterm) { ?>
                                                            <option value="<?= $incoterm['kode_incoterm']; ?>" <?php if($incoterm['kode_incoterm']==$datheader['kode_incoterm']){ echo "selected"; } ?>><?= $incoterm['kode_incoterm'].' - '.$incoterm['uraian_incoterm']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-1 row" id="kolomfreight">
                                                <label class="col-3 col-form-label font-kecil mx-2">Freight</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="freight" name="freight" value="<?= rupiah($datheader['freight'],2); ?>" aria-describedby="emailHelp" placeholder="Nilai Freight" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                            <div class="mb-1 row" id="kolomasuransi">
                                                <label class="col-3 col-form-label font-kecil mx-2">Insurance</label>
                                                <div class="col">
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="asuransi" name="asuransi" value="<?= rupiah($datheader['asuransi'],2); ?>" aria-describedby="emailHelp" placeholder="Nilai Insurance" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                            <div class="mb-1 mt-1 row">
                                                <label class="col-3 col-form-label font-kecil mx-2">Nilai Pabean</label>
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
                                                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" id="nilai_pab" name="nilai_pab" value="<?= rupiah($datheader['nilai_pab'],2); ?>" aria-describedby="emailHelp" placeholder="Nilai Pabean" <?= $nonaktif; ?>>
                                                </div>
                                            </div>
                                            <div class="mb-1 row <?= $hilangbc30; ?> <?= $hilangbc40; ?>">
                                                <?php 
                                                    $hilangtomboladdkontrak = $datheader['nomorkontrak']==NULL && $datheader['send_ceisa']==0 ? '' : 'hilang';  
                                                    $hilangtombolhapuskontrak = $datheader['nomorkontrak']!=NULL && $datheader['send_ceisa']==0  ? '' : 'hilang';  
                                                ?>
                                                <label class="col-3 col-form-label font-kecil mx-2">Nomor Kontrak</label>
                                                <div class="col">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control font-bold font-kecil btn-flat " id="nomorkontrak" value="<?= $datheader['nomorkontrak']; ?>" placeholder="Nomor Kontrak Kosong" disabled>
                                                        <a href="<?= base_url().'akb/addkontrak/'.$datheader['id'].'/'.$datheader['dept_tuju']; ?>" class="btn btn-info font-kecil btn-flat <?= $hilangtomboladdkontrak; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Pilih Kontrak" >Pilih</a>
                                                        <a data-href="<?= base_url().'akb/hapuskontrak/'.$datheader['id']; ?>" class="btn btn-danger font-kecil btn-flat text-white <?= $hilangtombolhapuskontrak; ?>" style="color: white !important;" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus Kontrak ini" data-title="Hapus Kontrak" >Hapus</a>
                                                        <a class="btn btn-success font-kecil btn-flat <?= $hilangtombolhapuskontrak; ?>" href="<?= base_url('kontrak/view/') . $datheader['idkontrak'].'/1'; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Kontrak" >View</a>
                                                        <!-- <button class="btn font-kecil btn-flat" type="button">View</button> -->
                                                    </div>
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
                <div class="m-2 font-bold d-flex justify-content-between">Detail Barang 
                    <span>
                        <a href="<?= base_url().'akb/excellampiran261/'.$datheader['id'].'/1'; ?>" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-1"></i> Lampiran dan Konversi</a>
                        <a href="<?= base_url().'akb/exceljaminan261/'.$datheader['id'].'/1'; ?>" class="btn btn-sm btn-warning text-black"><i class="fa fa-file-excel-o mr-1"></i> Perhitungan Jaminan</a>
                        <a href="<?= base_url().'akb/uploadijin/'.$datheader['id'].'/1'; ?>" class="btn btn-sm btn-teal"><i class="fa fa-file-excel-o mr-1"></i> Upload Perijinan</a>
                        <a href="<?= base_url().'akb/rekapnobontr/'.$datheader['id'].'/1'; ?>" class="btn btn-sm btn-info"><i class="fa fa-file-excel-o mr-1"></i> Rekap IB</a>
                    <span>
                </div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>Nama Barang</th>
                                    <?php if($mode==1): ?>
                                        <th>Bon Gaichu</th>
                                    <?php endif; ?>
                                    <th class="text-left">SKU</th>
                                    <th class="text-left">HS Code</th>
                                    <th>Satuan</th>
                                    <th>Pcs</th>
                                    <th>Kgs</th>
                                    <th>Hrg/Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-tablee" style="font-size: 13px !important;" >
                                    <?php $sumdetail=0; $sumpcs=0; $sumkgs=0; $nom=0; $jumlahhskosong=0; foreach ($header as $data) {  $nom++;
                                        $jumlah = $data['kodesatuan']=='KGS' ? $data['kgs'] : $data['pcs']; 
                                        $sumdetail += $data['harga']; //*$jumlah;
                                        $sumpcs += $data['pcs'];
                                        $sumkgs += $data['kgs'];
                                        // $nambar = $data['po']!='' ? $data['spek'] : $data['nama_barang'];
                                        $nambar = trim($data['po'])=='' ? $data['nama_barang'] : spekpo($data['po'],$data['item'],$data['dis']);
                                        if($datheader['jns_bc']==30){
                                            $nambar = $data['engklp'];
                                        }
                                        $hs = trim($data['po'])=='' ? substr($data['hsx'],0,8) : substr($data['nohs'],0,8) ;
                                        if(trim($hs) == '' || $hs==NULL){
                                            $jumlahhskosong += 1;
                                        }
                                        $jumlah = $jumlah==0 ? 1 : $jumlah;
                                         ?>
                                    <tr>
                                        <td class="line-12"><?= $nom.'. '.$nambar; ?><br><span class="font-kecil text-teal"><?= $data['insno']; ?></span></td>
                                        <?php if($mode==1): ?>
                                            <td class="font-kecil text-teal font-bold"><?= $data['dokgaichu']; ?></td>
                                        <?php endif; ?>
                                        <td class="text-left"><?= formatsku($data['po'],$data['item'],$data['dis'],$data['id_barang']); ?></td>
                                        <td class="text-left"><?= $hs; ?></td>
                                        <td><?= $data['kodesatuan']; ?></td>
                                        <td class="text-right"><?= rupiah($data['pcs'],0); ?></td>
                                        <td class="text-right"><?= rupiah($data['kgs'],2); ?></td>
                                        <td class="text-right"><?= rupiah($data['harga']/$jumlah,2); ?></td>
                                        <td class="text-right"><?= rupiah($data['harga'],2); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-primary-lt">
                                    <?php $jmcolspan = $mode==1 ? 5 : 4; ?>
                                    <td class="text-black text-center font-bold" colspan="<?= $jmcolspan; ?>">TOTAL</td>
                                    <td class="text-black text-right font-bold"><?= rupiah($sumpcs,0); ?></td>
                                    <td class="text-black text-right font-bold" id="txtsum"><?= rupiah($sumkgs,1); ?></td>
                                    <td></td>
                                    <td class="text-black text-right font-bold"><?= rupiah($sumdetail,2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" id="sumdetail" class="hilang" value="<?= rupiah($sumdetail,2); ?>">
                        <input type="text" id="jumlahhskosong" class="hilang" value="<?= $jumlahhskosong; ?>">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2 bg-red-lt" id="tabs-profile-8">
                <div class="m-2 font-bold d-flex justify-content-between">Lampiran Dokumen <span><a href="<?= base_url().'ib/addlampiran/'.$datheader['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Lampiran" id="keexcel" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-1"></i> Tambah Data</a><span></div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table w-100">
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
            <div class="tab-pane fade p-2" id="tabs-barangdet-8">
                <div class="m-2 font-bold d-flex justify-content-between">Barang Versi BC/CEISA <span><a href="<?= base_url().'akb/hitungbomjf/'.$datheader['id'].'/1'; ?>" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-message="Akan menghitung nilai BOM " data-title="Bill Of Material" class="btn btn-sm btn-primary"><i class="fa fa-calculator mr-1"></i> HITUNG</a><span></div>
                <div class="card card-lg font-kecil">
                    <div class="card-body p-2">
                        <table class="table w-100">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>SKU</th>
                                    <th>Hs Code</th>
                                    <th>Negara</th>
                                    <th>Qty</th>
                                    <th>Jumlah</th>
                                    <th>Sat</th>
                                    <th>No BC</th>
                                    <th>Jns BC</th>
                                    <th>Harga IDR</th>
                                    <th>TOTAL IDR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                                <?php 
                                    $no=0;
                                    $serbar=0; 
                                    $jmlkgs=0;
                                    $jumlahtot=0;
                                    $jmbm=0;$jmppn=0;$jmpph=0;$totpajak=0;
                                    $jumlahnobontrkosong = 0;
                                    $kurssekarang = getkurssekarang($datheader['tgl_aju'])->row_array();
                                    foreach ($detbombc->result_array() as $detbom ) { 
                                        if($detbom['seri_barang']!= $serbar){
                                           $no=0; 
                                        }
                                        $no++; 
                                        $pembagi = $detbom['hamat_weight']==0 ? 1 : $detbom['hamat_weight'];
                                        switch ($detbom['mt_uang']) {
                                            case 'IDR':
                                                $hargaperkilo = round($detbom['hamat_harga']/$pembagi,2);
                                                break;
                                            case 'USD':
                                                $hargaperkilo = ($detbom['cif']/$pembagi)*$kurssekarang['usd'];
                                                break;
                                                break;
                                            case 'JPY':
                                                $hargaperkilo = ($detbom['cif']/$pembagi)*$kurssekarang['jpy'];
                                                break;
                                            
                                            default:
                                                # code...
                                                break;
                                        }
                                        $jmlkgs += $detbom['kgs'];
                                        $serbar = $detbom['seri_barang'];
                                        $jns_bc = $detbom['hamat_jnsbc'];
                                        $nomor_bc = $detbom['hamat_nomorbc'];
                                        $jumlahhargaperkilo = $hargaperkilo*$detbom['kgs'];
                                        $jumlahtot += $jumlahhargaperkilo;
                                        $hitungbm = $detbom['bm'] > 0 ? '' : 'hilang';
                                        $hitungppn = $detbom['ppn'] > 0 ? '' : 'hilang';
                                        $hitungpph = $detbom['pph'] > 0 ? '' : 'hilang';
                                        if($jns_bc == 23){
                                            $jmbm += $jumlahhargaperkilo*($detbom['bm']/100);
                                            $jmppn += $jumlahhargaperkilo*($detbom['ppn']/100);
                                            $jmpph += $jumlahhargaperkilo*($detbom['pph']/100);
                                        }
                                ?>
                                    <tr>
                                        <td><?= $detbom['seri_barang'].'.'.$no; ?></td>
                                        <td class="line-12">
                                            <?= $detbom['nama_barang']; ?><br>
                                            <span style="font-size:12px;" class="text-pink"><?= $detbom['nobontr']; ?></span>
                                            <span style="font-size:9px;" class="badge bg-blue text-blue-fg <?= $hitungbm; ?>">BM</span>
                                            <span style="font-size:9px;" class="badge bg-yellow text-black <?= $hitungppn; ?>">PPN</span>
                                            <span style="font-size:9px;" class="badge bg-azure text-azure-fg <?= $hitungpph; ?>">PPH</span>
                                        </td>
                                        <td><?= $detbom['kode']; ?></td>
                                        <td><?= $detbom['nohs']; ?></td>
                                        <td><?= $detbom['kode_negara']; ?></td>
                                        <td class="text-right"><?= rupiah($detbom['pcs'],0); ?></td>
                                        <td class="text-right"><?= rupiah($detbom['kgs'],5); ?></td>
                                        <td><?= $detbom['kodesatuan']; ?></td>
                                        <td><?= $nomor_bc ?></td>
                                        <td class="text-center text-blue"><?= $jns_bc; ?></td>
                                        <td class="text-right"><?= rupiah($hargaperkilo,2) ?></td>
                                        <td class="text-right"><?= rupiah($jumlahhargaperkilo,2) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url().'akb/editbombc/'.$detbom['id']; ?>" class="btn btn-sm btn-success font-bold" style="padding: 0px 2px !important;" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data" >EDIT</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr style="font-size: 16px !important" >
                                    <td colspan="5" class="text-right">TOTAL</td>
                                    <td class="text-right text-primary"><?= rupiah($jmlkgs,1); ?></td>
                                    <td colspan="4"></td>
                                    <td></td>
                                    <td class="text-right text-primary"><?= rupiah(bulatkan($jumlahtot,1000),2); ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" id="jmllampiran" class="hilang">
                        <table class="table w-100 table-bordered">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>BM</th>
                                    <th>BMT</th>
                                    <th>Cukai</th>
                                    <th>PPN</th>
                                    <th>PPNBM</th>
                                    <th>PPH</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                                <tr>
                                    <td class="text-right"><?= rupiah(bulatkan($jmbm,1000),2); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><?= rupiah(bulatkan($jmppn,1000),2); ?></td>
                                    <td></td>
                                    <td class="text-right"><?= rupiah(bulatkan($jmpph,1000),2); ?></td>
                                    <td class="text-right"><?= rupiah(bulatkan($jmbm,1000)+bulatkan($jmppn,1000)+bulatkan($jmpph,1000),2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="text" id="sumdetailbc" class="hilang" value="<?= rupiah(bulatkan($jumlahtot,1000),2); ?>">
                        <input type="text" id="jumlahnobontrkosong" class="hilang" value="<?= $jumlahnobontrkosong; ?>">
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