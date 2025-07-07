<div class="container-xl">
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
            <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
            <li class="nav-item">
            <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
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
                                    <?php if($this->session->userdata('viewharga')==1): ?>
                                        <th>Harga terakhir</th>
                                        <th>Total</th>
                                    <?php endif; ?>
                                    <th title="Buffer Stok">Buffer</th>
                                    <th title="Stok Terkini">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php foreach ($detail->result_array() as $val) { $tampil = $val['pcs']!=0 ? $val['pcs'] : $val['kgs']; 
                                    $getstok = getstokbarangsaatini($val['id_barang'],substr($header['nomor_dok'],0,2));
                                    if($getstok->num_rows() > 0){
                                        $stoksaatini = $getstok->row_array();
                                        $stok = $stoksaatini['id_satuan']==22 ? rupiah($stoksaatini['kgs_akhir'],0) : rupiah($stoksaatini['pcs_akhir'],0);
                                    }else{
                                        $stok = rupiah(0,0);
                                    }
                                    ?>
                                    <tr>
                                        <?php if($this->session->userdata('viewharga')==1){ ?>
                                            <td class="line-12"><a href="<?= base_url().'bbl/hargaterakhir/'.$val['id_barang']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Harga Terakhir <?= $val['nama_barang']; ?>"><?= $val['nama_barang']; ?></a><br><span style="font-size: 10px" class="text-primary"><?= $val['id_pb']; ?></span><br><span style="font-size: 11px" class="text-success"><?= $val['ketpb']; ?></span></td>
                                        <?php }else{ ?>
                                            <td class="line-12"><?= $val['nama_barang']; ?><br><span style="font-size: 10px" class="text-primary"><?= $val['id_pb']; ?></span></td>
                                        <?php } ?>
                                        <td><?= $val['brg_id']; ?></td>
                                        <td><?= $val['namasatuan']; ?></td>
                                        <td><?= rupiah($val['pcs'], 0); ?></td>
                                        <td><?= rupiah($val['kgs'], 2); ?></td>
                                        <?php if($this->session->userdata('viewharga')==1): ?>
                                            <td class="text-danger text-right"><?= rupiah(gethrg($val['id_barang'], $val['nobontr']),2); ?></td>
                                            <td class="text-danger text-right"><?= rupiah(gethrg($val['id_barang'], $val['nobontr'])*$tampil,2); ?></td>
                                        <?php endif; ?>
                                        <td class="text-right text-blue"><?= rupiah($val['kgs'],0); ?></td>
                                        <td class="text-right text-blue"><?= $stok; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row mb-1">
                    <div class="col-3">
                        <div class="<?php if($header['ok_pp']==1 && $header['bbl_pp']==0){ echo "hilang"; } ?>">
                        <span>Mengetahui :</span>
                        <h4 class="mb-1"><?= datauser($header['user_pp'], 'name') . ' ' . $header['tgl_pp'] . "<br>" . $header['ketcancel'] ?></h4>
                        </div>
                    </div>
                    <div class="col-3 <?php if($header['ok_valid']==2){ echo "text-danger"; } ?>">
                        <div class="<?php if($header['ok_valid']==0){ echo "hilang"; } ?>">
                        <span><?php if($header['ok_valid']==2){ echo "Dicancel :"; }else{echo "Diperiksa :"; } ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_valid'], 'name') . ' ' . $header['tgl_valid'] . "<br>" . $header['ketcancel'] ?></h4>
                        </div>
                    </div>
                    <div class="col-3 <?php if($header['ok_tuju']==2){ echo "text-danger"; } ?>">
                        <div class="<?php if($header['ok_tuju']==0){ echo "hilang"; } ?>">
                        <span><?php if($header['ok_tuju']==2){ echo "Dicancel :"; }else{echo "Disetujui :"; } ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_tuju'], 'name') . ' ' . $header['tgl_tuju'] . "<br>" . $header['ketcancel'] ?></h4>
                        </div>
                    </div>
                    <div class="col-3 <?php if($header['ok_pc']==2){ echo "text-danger"; } ?>">
                        <div class="<?php if($header['ok_pc']==0){ echo "hilang"; } ?>">
                        <span><?php if($header['ok_pc']==2){ echo "Dicancel :"; }else{echo "Diterima :"; } ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_pc'], 'name') . ' ' . $header['tgl_pc'] . "<br>" . $header['ketcancel'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-4 text-blue" id="tabs-profile-8">
                <?php if(count($riwayat) > 0):  ?>
                    <ul>
                        <?php foreach ($riwayat as $riw) { ?>
                            <?php if(is_array($riw)){ ?>
                                <hr class="m-1">
                                <div class="p-2" style="border:1px solid #FBEBEB !important;">
                                <u>DETAIL BBL</u>
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
            <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" data-message="Anda yakin akan validasi bon <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'task/validasibbl/' . $header['id'] . '/' . $ttdke; ?>" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Approve Dokumen</a>
            <a href="<?= base_url() . 'task/canceltask/' . $header['id'] . '/' . $ttdke ?>" style="padding: 5px !important" data-bs-target="#canceltask" data-message="Anda yakin akan membatalkan bon <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'task/canceltask/' . $header['id'] . '/' . $ttdke ?>" data-tombol="Ya" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-danger <?= $hilang; ?>">Cancel</a>
            </div>           
        <?php endif; ?>
    </div>
    <hr class="m-1">
</div>
<script>
    $(document).ready(function() {

    })
</script>