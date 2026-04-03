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
            </div>
            <div class="col-12">
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Nobontr</th>
                            <th>Kgs</th>
                            <th>Pcs</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                        <?php $no=0; $jmlkgs=0; $jmlpcs=0; foreach($detail->result_array() as $det): $no++; $jmlpcs += $det['pcs']; $jmlkgs += $det['kgs']; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td class="line-11"><?= '<span class="text-teal font-kecil">'.$det['kode'].'</span><br>'.namaspekbarang($det['id_barang']) ?></td>
                                <td><?= $det['nobontr'] ?></td>
                                <td class="text-right"><?= rupiah($det['kgs'],6) ?></td>
                                <td class="text-right"><?= rupiah($det['pcs'],0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-center font-bold">TOTAL</td>
                            <td class="text-right font-bold"><?= rupiah($jmlkgs,2) ?></td>
                            <td class="text-right font-bold"><?= rupiah($jmlpcs,0) ?></td>
                        </tr>
                    </tbody>
                </table>
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