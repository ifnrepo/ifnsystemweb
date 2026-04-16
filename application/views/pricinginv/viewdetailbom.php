<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-2 text-center my-auto bg-cyan-lt p-2 line-11 ">
                    <h5 class="text-black">Dept</h5>
                    <?php if(trim($data['dept_id'])!=''){ ?>
                        <label for="" style="font-size: 16px !important;" class="font-bold text-black"><?= $data['dept_id'] ?></label>
                    <?php }else{ ?>
                        <label for="" style="font-size: 16px !important; color: #E8F6F8 !important;" class="font-bold">.</label>
                    <?php } ?>
                    <div class="text-teal"><small>No Bale : <?= $data['nobale'] ?></small></div>
                </div>
                <div class="col-10">
                    <div class="mb-1 row font-kecil text-right">
                        <label class="col-3 col-form-label">SKU</label>
                        <div class="col">
                            <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                            <?php 
                                $sku = trim($data['po'])=='' ? $data['kode'] : viewsku($data['po'],$data['item'],$data['dis']); 
                                $namabarang = trim($data['po'])=='' ? namaspekbarang($data['id_barang']) : spekpo($data['po'],$data['item'],$data['dis']); 
                            ?>
                            <input type="text" class="form-control font-kecil text-black" name="kategori_id" id="kategori_id" value="<?= $data['kode']; ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-1 row font-kecil text-right">
                        <label class="col-3 col-form-label">Spesifikasi</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-black" name="nama_kategori" id="nama_kategori" value="<?= $namabarang; ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-1 row font-kecil text-right">
                        <label class="col-3 col-form-label">Insno/Nobontr</label>
                         <div class="col-5">
                            <input type="text" class="form-control font-kecil text-black" name="kgs_tot" id="kgs_tot" value="<?= $data['insno'] ?>" disabled>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control font-kecil text-black" name="kgs_tot" id="kgs_tot" value="<?= $data['nobontr'] ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-1 row font-kecil text-right">
                        <label class="col-3 col-form-label">Kgs/Pcs</label>
                        <div class="col-5">
                            <input type="text" class="form-control font-kecil text-black text-right" name="kgs_tot" id="kgs_tot" value="<?= rupiah($data['kgs_akhir'],2) ?>" disabled>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control font-kecil text-black text-right" name="kgs_tot" id="kgs_tot" value="<?= rupiah($data['pcs_akhir'],0) ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <span class="font-kecil font-bold">Pricing Cost Dept</span>
                    <?php $pengaliatas = $data['id_satuan']==22 ? $data['kgs_akhir'] : ($data['pcs_akhir']==0 ? $data['kgs_akhir'] : $data['pcs_akhir']); ?>
                    <table class="table table-bordered m-0">
                        <thead class="bg-primary-lt">
                        <tr>
                            <th class="text-center bg-blue-lt text-black">Rm</th>
                            <th class="text-center bg-blue-lt text-black">Sm</th>
                            <th class="text-center bg-yellow-lt text-black"><span class="text-black">SP</span></th>
                            <th class="text-center bg-yellow-lt text-black"><span class="text-black">RR</span></th>
                            <th class="text-center bg-yellow-lt text-black"><span class="text-black">NT</span></th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody">
                            <tr>
                                <td class="text-right font-kecil"><?= rupiah($data['rm']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['sm']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['spinning']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['ringrope']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['netting']*$pengaliatas,8) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered mt-1 mb-0">
                        <thead class="bg-primary-lt">
                        <tr>
                            <th class="text-center text-black">SN</th>
                            <th class="text-center text-black">H1</th>
                            <th class="text-center text-black">KO</th>
                            <th class="text-center text-black">H2</th>
                            <th class="text-center text-black">PA</th>
                            <th class="text-center text-black">SHI</th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody">
                            <tr>
                                <td class="text-right font-kecil"><?= rupiah($data['senshoku']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['hoshu1']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['koatsu']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['hoshu2']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['packing']*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah($data['shitate']*$pengaliatas,8) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered mt-1">
                        <thead class="bg-primary-lt">
                        <tr>
                            <th class="text-center text-black">TOTAL RM+SM</th>
                            <th class="text-center text-black">TOTAL JOB COST</th>
                            <th class="text-center bg-red-lt text-black"><span class="text-black font-bold">GRAND TOTAL</span></th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody">
                            <tr>
                                <td class="text-right font-kecil"><?= rupiah(($data['rm']+$data['sm'])*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil"><?= rupiah(($data['spinning']+$data['ringrope']+$data['netting']+$data['senshoku']+$data['hoshu1']+$data['koatsu']+$data['hoshu2']+$data['packing']+$data['shitate'])*$pengaliatas,8) ?></td>
                                <td class="text-right font-kecil font-bold"><?= rupiah(($data['rm']+$data['sm']+$data['spinning']+$data['ringrope']+$data['netting']+$data['senshoku']+$data['hoshu1']+$data['koatsu']+$data['hoshu2']+$data['packing']+$data['shitate'])*$pengaliatas,8) ?></td>

                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <span class="font-kecil font-bold">Detail RM+SM</span>
                <div id="table-default" class="table-responsive mb-1">
                    <table class="table datatable6" id="cobasisip">
                        <thead style="background-color: blue !important">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Nobontr</th>
                                <th>Kgs</th>
                                <th>Pcs</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                            <?php $no=0; $jmlkgs=0; $jmlpcs=0; $jumlahrm=0; $jumlahsm=0; foreach($detail->result_array() as $det): $no++; $jmlpcs += $det['pcs']; $jmlkgs += $det['kgs']; ?>
                            <?php $pengali = $det['id_satuan']==22 ? $det['kgs'] : ($det['pcs']==0 ? $det['kgs'] : $det['pcs']); ?>
                            <?php $jumlahrm += $det['id_kategori']=='8189' ? round($det['harga_acct']*$pengali,10) : 0; ?>
                            <?php $jumlahsm += $det['id_kategori']!='8189' ? round($det['harga_acct']*$pengali,10) : 0; ?>
                                <tr>
                                    <td><?= $no ?><span class="badge bg-orange ml-1 <?php if($det['id_kategori']!='8189'){ echo 'hilang'; } ?>"></span></td>
                                    <td class="line-11"><?= '<span class="text-teal font-kecil">'.$det['kode'].'</span><br>'.namaspekbarang($det['id_barang']) ?></td>
                                    <td><?= $det['nobontr'] ?></td>
                                    <td class="text-right"><?= rupiah($det['kgs'],6) ?></td>
                                    <td class="text-right"><?= rupiah($det['pcs'],0) ?></td>
                                    <td class="text-right"><?= rupiah($det['harga_acct'],8) ?></td>
                                    <td class="text-right"><?= rupiah($det['harga_acct']*$pengali,8) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2" ><span class="badge bg-orange mr-1"></span> Raw Material</td>
                                <td class="font-bold">TOTAL</td>
                                <td class="text-right font-bold"><?= rupiah($jmlkgs,2) ?></td>
                                <td class="text-right font-bold"><?= rupiah($jmlpcs,0) ?></td>
                                <td></td>
                                <td class="text-right font-bold"><?= rupiah((float) $jumlahrm + $jumlahsm,6) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-blue   " data-bs-dismiss="modal">Close</button>
</div>
<script>
    $("#updatekategori").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'kategori/updatekategori',
            data: {
                kategori_id: $("#kategori_id").val(),
                nama_kategori: $("#nama_kategori").val(),
                urut: $("#urut").val(),
                kode: $("#kode").val(),
                ket: $("#ket").val(),
                jns: $("#jns").val(),
                net: $("#net").val(),
                id: $("#id").val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>