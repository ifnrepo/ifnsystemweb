<div class="container-xl font-kecil">
    <div class="row">

    </div>
    <div class="row">
        <div class="row mt-1 mb-1">
            <label class="col-4 col-form-label font-bold">Nama Pemasok</label>
            <div class="col">
                <input type="text" class="form-control font-kecil"aria-label="Text input with dropdown" placeholder="Nama Pemasok" value="<?= $header['nama_supplier']; ?>">
            </div>

        </div>
        <div class="row mb-1">
            <label class="col-4 col-form-label font-bold">Alamat</label>
            <div class="col">
                <textarea class="form-control font-kecil"><?= $header['alamat']; ?></textarea>
            </div>
        </div>
        <div class="col-12">
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No PO</th>
                            <th>Nama Barang</th>
                            <th>PO Qty</th>
                            <th>PO Terima</th>
                            <th>Sisa</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <?php $no=0; foreach($datadetail->result_array() as $detail){ if(($detail['pcs']+$detail['kgs'])> ($detail['pcssudahterima']+$detail['kgssudahterima'])): $no++; ?>
                        <?php  
                            if($detail['kodesatuan']!='KGS'){
                                $pcs = $detail['pcssudahterima'];
                                $pcspo = $detail['pcs'];
                            }else{
                                $pcs = $detail['kgssudahterima'];
                                $pcspo = $detail['kgs'];
                            }
                        ?>
                            <tr class="font-kecil">
                                <td><?= $detail['nodok']; ?></td>
                                <td><?= $detail['nama_barang']; ?></td>
                                <td class="text-center"><?= rupiah($pcspo,2); ?></td>
                                <td class="text-center"><?= rupiah($pcs,2); ?></td>
                                <td class="text-center text-blue"><?= rupiah($pcspo-$pcs,2); ?></td>
                                <td>
                                    <label class="form-check">
                                        <input class="form-check-input" name="cekpilihbarang" id="cekbok<?= $no; ?>" rel="<?= $detail['iddetbbl']; ?>" type="checkbox">
                                        <span class="form-check-label">Pilih</span>
                                    </label>
                                </td>
                            </tr>
                        <?php endif; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <a href="#" class="btn btn-sm btn-primary" id="simpanbarang">Simpan Barang</a>
</div>
<script>
    $("#simpanbarang").click(function(){
        var text = [];
        for (let i = 1; i < 1000; i++) {
            if($("#cekbok"+i).is(":checked")){
                text.push($("#cekbok"+i).attr('rel'));
            }
        }
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "ib/adddetailib",
                data: {
                    id: $("#id_header").val(),
                    brg: text
                },
                success: function(data) {
                    // alert('berhasil');
                    window.location.href = base_url + "ib/dataib/" + $("#id_header").val();
                    // $("#butbatal").click();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Tidak ada data yang dipilih','info');
            window.location.reload();
        }
    })
</script>