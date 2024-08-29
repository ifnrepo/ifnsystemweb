<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12">
            <table id="tabel" class="table nowrap order-column table-hover datatable" style="width: 100% !important;">
                <thead>
                    <tr>
                    <th>Nama Barang</th>
                    <th>Tgl</th>
                    <th>Nomor IB</th>
                    <th>Unit</th>
                    <th>Weight</th>
                    <th>Price (Rp)</th>
                    <th>Supplier</th>
                    <th>Pilih</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                    <?php $no=1; foreach ($data->result_array() as $det) { ?>
                        <tr>
                            <td style="font-size: 12px;"><?= $det['nama_barang']; ?></td>
                            <td style="font-size: 12px;"><?= $det['tgl']; ?></td>
                            <td style="font-size: 12px;"><?= $det['nomor_dok']; ?></td>
                            <td style="font-size: 12px;"><?= $det['nama_kategori']; ?></td>
                            <td style="font-size: 12px;"><?= $det['id_satuan']; ?></td>
                            <td style="font-size: 12px;"><?= rupiah($det['harga'],2); ?></td>
                            <td style="font-size: 12px;"><?= $det['nama_supplier']; ?></td>
                            <td class="text-center">
                                <input class="form-check-input" id="pilih<?= $no++; ?>" name="pilih" rel="<?= $det['idx']; ?>" type="checkbox">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpanbarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#nama_barang").focus();
    })
    $("#simpanbarang").click(function(){
        var text = [];
        for (let i = 1; i < 1000; i++) {
            if($("#pilih"+i).is(":checked")){
                text.push($("#pilih"+i).attr('rel'));
            }
        }
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url+'hargamat/simpanbarang',
                data: {
                    out: text
                },
                success: function(data){
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Tidak ada data yang dipilih','info');
            $("#modal-large").modal('hide');
        }
    })
</script>