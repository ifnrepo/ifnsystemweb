<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No BBL</th>
                            <th>PB</th>
                            <th>Nama Barang</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <?php $no=0; foreach($datadetail->result_array() as $detail){ $no++; ?>
                            <tr class="font-kecil">
                                <td><?= $detail['nomor_dok']; ?></td>
                                <td><?= $detail['nama_barang']; ?></td>
                                <td><?= $detail['nama_barang']; ?></td>
                                <td>
                                    <label class="form-check">
                                        <input class="form-check-input" name="cekpilihbarang" id="cekbok<?= $no; ?>" rel="<?= $detail['iddetbbl']; ?>" type="checkbox">
                                        <span class="form-check-label">Pilih</span>
                                    </label>
                                </td>
                            </tr>
                        <?php } ?>
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
                url: base_url + "po/adddetailpo",
                data: {
                    id: $("#id_header").val(),
                    brg: text
                },
                success: function(data) {
                    // alert('berhasil');
                    window.location.href = base_url + "po/datapo/" + $("#id_header").val();
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