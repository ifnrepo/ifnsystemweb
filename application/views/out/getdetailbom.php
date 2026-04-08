<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
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
                        <label class="col-3 col-form-label">Pcs/Kgs</label>
                        <div class="col-5">
                            <input type="text" class="form-control font-kecil text-black text-right" name="kgs_tot" id="kgs_tot" value="<?= rupiah($data['pcs'],0) ?>" disabled>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control font-kecil text-black text-right" name="kgs_tot" id="kgs_tot" value="<?= rupiah($data['kgs'],2) ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="m-0">
                        <div class="font-kecil font-bold bg-orange-lt">
                            <span class="text-black">Stok di Departemen <?= $this->session->userdata('deptsekarang') ?></span>
                        </div>
                    <hr class="m-0">
                    <div id="table-default" class="table-responsive mb-1 mt-2">
                        <table class="table datatable6" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Insno/Nobontr</th>
                                    <th>Pcs</th>
                                    <th>Kgs</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                                <?php if($detail->num_rows() > 0){ foreach($detail->result_array() as $dt): ?>
                                    <tr>
                                        <?php $namabarang = trim($data['po'])=='' ? namaspekbarang($data['id_barang']) : spekpo($data['po'],$data['item'],$data['dis']);   ?>
                                        <td><?= $namabarang ?></td>
                                        <td><?= $dt['insno'].' - '.$dt['nobontr'] ?></td>
                                        <td class="text-right"><?= rupiah($dt['pcs_akhir'],0) ?></td>
                                        <td class="text-right"><?= rupiah($dt['kgs_akhir'],2) ?></td>
                                        <td class="text-center">
                                            <a href="#" id="pilihpakai" rel="<?= $dt['id'] ?>" class="btn btn-sm btn-success font-kecil p-0" style='padding: 2px 5px !important;'>Pilih dan Pakai</a>
                                        </td>
                                    </tr>
                                <?php endforeach; }else{ ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak Ada</td>
                                    </tr>
                                <?php } ?>
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
</div>
<script>
    $(document).off('click').on('click','#pilihpakai',function(){
        var idtemp = $("#id").val();
        var iddetail = $("#id_detail").val();
        var idhead = $("#id_header").val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'out/gantispekdetailtemp',
            data: {
                idstok: $(this).attr('rel'),
                idlama: idtemp,
            },
            success: function(data) {
                // window.location.reload();
                window.location.href = base_url+'out/editdetailgenout/'+iddetail+'/'+idhead+'/1';
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>