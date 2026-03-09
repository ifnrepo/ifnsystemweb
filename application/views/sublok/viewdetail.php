<div class="container-xl">
            <div id="sisipkan" class="sticky-top bg-white">
                <div class="card card-active" style="clear:both;">
                    <div class="card-body p-2 font-kecil">
                        <div class="row">
                            <div class="col-sm-4 col-12">
                                <span style="display:inline-block; width:100px;">Tanggal</span> : <b><?= tgl_indo($header['tgl']) ?></b><br>
                                <span style="display:inline-block; width:100px;">Nomor</span> : <b><?= $header['nomor'] ?></b><br>
                                <span style="display:inline-block; width:100px;">Departemen</span> : <b><?= $header['departemen'] ?></b><br>
                                <span style="display:inline-block; width:100px;">Sub Lokasi</span> : <b><?= $header['kode_lokasi'].'-'.$header['nama_lokasi'] ?></b><br>
                            </div>
                            <div class="col-sm-4 col-12">
                                <span style="display:inline-block; width:100px;">Dibuat</span> : <b><?= datauser($header['dibuat_oleh'],'name') ?></b><br>
                                <span style="display:inline-block; width:100px;">Tgl buat</span> : <b><?= tglmysql2($header['tgl_buat']) ?></b><br>
                                <span style="display:inline-block; width:100px;">Pcs</span> : <b><span class="text-pink"><?= rupiah($header['pcs'],0) ?></span></b><br>
                                <span style="display:inline-block; width:100px;">Kgs</span> : <b><span class="text-pink"><?= rupiah($header['kgs'],2) ?></span></b><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2" style="overflow: auto;">
                    <table id="pbtabel" class="table nowrap order-column table-hover table-bordered" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>SKU</th>
                            <th>Specific</th>
                            <th>Insno</th>
                            <th>Lot</th>
                            <th>Pcs</th>
                            <th>Kgs</th>
                            <th>Keterangan</th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                            <?php if($data->num_rows() > 0): ?>
                                <?php $no=1; foreach($data->result_array() as $dt): ?>
                                <?php $sku = viewsku($dt['po'],$dt['item'],$dt['dis']); ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $sku ?></td>
                                        <td class="text-primary"><?= spekpo($dt['po'],$dt['item'],$dt['dis']); ?></td>
                                        <td><?= $dt['insno'] ?></td>
                                        <td class="text-center"><?= tambahnol($dt['lot'],2).'-'.tambahnol($dt['jalur'],2) ?></td>
                                        <td class="text-right"><?= rupiah($dt['pcs'],0) ?></td>
                                        <td class="text-right"><?= rupiah($dt['kgs'],2) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-bold">
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right"><?= rupiah($header['pcs'],0) ?></td>
                                    <td class="text-right"><?= rupiah($header['kgs'],2) ?></td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center"> Data Kosong</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
</div>