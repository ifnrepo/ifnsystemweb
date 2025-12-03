<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-2 text-center my-auto bg-cyan-lt p-2 ">
                    <h5 class="text-black">No Bale</h5>
                    <?php if(trim($data['nobale'])!=''){ ?>
                        <label for="" style="font-size: 16px !important;" class="font-bold text-black"><?= $data['nobale'] ?></label>
                    <?php }else{ ?>
                        <label for="" style="font-size: 16px !important; color: #E8F6F8 !important;" class="font-bold">.</label>
                    <?php } ?>
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
                            <input type="text" class="form-control font-kecil text-black" name="kategori_id" id="kategori_id" value="<?= $sku; ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-1 row font-kecil text-right">
                        <label class="col-3 col-form-label">Spesifikasi</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-black" name="nama_kategori" id="nama_kategori" value="<?= $namabarang; ?>" disabled>
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
                            <th>Persen RM</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                        <?php $no=0; $jmlpersen=0; foreach($detail->result_array() as $det): $no++; $jmlpersen+= $det['persen'];?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $det['nama_barang'] ?></td>
                                <td><?= $det['nobontr'] ?></td>
                                <td class="text-right"><?= rupiah($det['persen'],6) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-center font-bold">TOTAL</td>
                            <td class="text-right font-bold"><?= rupiah($jmlpersen,2) ?></td>
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