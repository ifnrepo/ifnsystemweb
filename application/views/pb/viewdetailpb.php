<div class="container-xl p-0"> 
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
            <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
            <li class="nav-item">
            <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
            </li>
            <!-- <li class="nav-item">
            <a href="#tabs-activity-8" class="nav-link" data-bs-toggle="tab">Activity</a>
            </li> -->
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
                    <h4 class="mb-1"><?= datauser($header['user_ok'],'name').' ('.$header['tgl_ok'].')' ?></h4>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="card card-lg">
                    <div class="card-body p-2">
                        <table class="table datatable6 table-hover mb-1" id="cobasisip">
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
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                            <?php $no=0; $jmlpcs=0; $jmlkgs=0; foreach ($detail as $val) { $no++; 
                                $kode = formatsku($val['po'],$val['item'],$val['dis'],$val['id_barang']);
                                $spek = trim($val['po']) == '' ? namaspekbarang($val['id_barang']) : spekpo($val['po'],$val['item'],$val['dis']);
                                $jmlpcs += $val['pcs'];$jmlkgs += $val['kgs'];
                                 ?>
                                <tr>
                                    <td class="line-12"><?= $no.'. '.$spek.'<br><span class="font-kecil text-teal">'.$val['insno'].' '.$val['nobontr'].'</span>'; ?></td>
                                    <td><?= $kode; ?></td>
                                    <td><?= $val['namasatuan']; ?></td>
                                    <td><?= rupiah($val['pcs'],0); ?></td>
                                    <td><?= rupiah($val['kgs'],2); ?></td>
                                    <td class="font-bold"><?= $val['sublok']; ?></td>
                                    <td><?= $val['keterangan']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="font-bold mt-1" style="text-align: right;"><span>Jumlah Pcs : <?= rupiah($jmlpcs,0) ?></span><br><span>Jumlah Kgs : <?= rupiah($jmlkgs,2) ?></span><br><span>Jumlah Item Barang : <?= rupiah($header['jumlah_barang'],0); ?></span></div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row mb-1">
                    <div class="col-4 text-primary font-bold">
                        <span>KETERANGAN :</span>
                        <h4 class="mb-1"><?= $header['keterangan']; ?></h4>
                    </div>
                    <div class="col-4"></div>
                    <?php $bgr = $header['ketcancel']==null ? "text-primary" : "text-danger"; ?>
                    <?php $vld = $header['ok_valid']==0 ? "hilang" : ""; ?>
                    <div class="col-4 <?= $bgr.' '.$vld; ?> font-bold ">
                        <?php $cek = $header['ketcancel']==null ? "Disetujui Oleh" : "Dicancel Oleh"; ?>
                        <span><?= $cek; ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_valid'],'name').' ('.$header['tgl_valid'].')'."<br>".$header['ketcancel'] ?></h4>
                    </div>
                </div>
                <hr class="m-1">
            </div>
            <div class="tab-pane fade p-4 text-blue" id="tabs-profile-8">
                <?php if(count($riwayat) > 0):  ?>
                    <ul>
                        <?php foreach ($riwayat as $riw) { ?>
                            <?php if(is_array($riw)){ ?>
                                <hr class="m-1">
                                <div class="p-2" style="border:1px solid #FBEBEB !important;">
                                <u>DETAIL PERMINTAAN</u>
                                <ol>
                                    <?php foreach ($riw as $raw) { ?>
                                        <?php if(is_array($raw)){ ?>
                                            <ul>
                                                <?php foreach ($raw as $ruw) { ?>
                                                    <li style="font-size: 12px;"><?= $ruw; ?></li>
                                                <?php } ?>
                                            </ul>
                                        <?php }else{ ?>
                                            <li class='text-pink'><?= $raw; ?></li>
                                        <?php } ?>
                                    <?php } ?>
                                </ol>
                                </div>
                            <?php }else{ ?>
                                <li><?= $riw; ?></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
                <hr class="m-1">
            </div>
        </div>
        <?php if($mode==1): 
            $ttdke = $header['data_ok']+$header['ok_pp']+$header['ok_valid']+$header['ok_tuju']+$header['ok_pc']+1; 
            $hilang = datauser($this->session->userdata('id'),'cekpc')==1 ? "hilang" : ""; ?>     
            <div class="text-center mt-0">
            <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" data-message="Anda yakin akan validasi bon <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'task/validasipb/' . $header['id'] ?>" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Approve Dokumen</a>
            <a href="<?= base_url() . 'task/canceltask/' . $header['id'] ?>" style="padding: 5px !important" data-bs-target="#canceltask" data-message="Anda yakin akan membatalkan bon <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'task/canceltask/' . $header['id'] ?>" data-tombol="Ya" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-danger <?= $hilang; ?>">Cancel</a>
            </div>           
        <?php endif; ?>
        <hr class="m-1">
    </div>
</div>
<script>
    $(document).ready(function(){
    })
</script>