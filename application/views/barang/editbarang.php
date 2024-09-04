<div class="container-xl"> 
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="rekrow" id="rekrow" value="<?= $rekrow; ?>">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?= $data['nama_barang']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="id_kategori" name="id_kategori">
                        <option value="">--Pilih Kategori--</option>
                        <?php foreach ($itemkategori as $kategori) { $selek = $kategori['kategori_id']==$data['id_kategori'] ? 'selected' : ''; ?>
                            <option value="<?= $kategori['kategori_id']; ?>" <?= $selek; ?>><?= '['.$kategori['kategori_id'].'] '.$kategori['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Satuan</label>
                <div class="col">
                    <select class="form-select font-kecil" id="id_satuan" name="id_satuan">
                        <option value="">--Pilih Satuan--</option>
                        <?php foreach ($itemsatuan->result_array() as $satuan) { $selek = $satuan['id']==$data['id_satuan'] ? 'selected' : ''; ?>
                            <option value="<?= $satuan['id']; ?>" <?= $selek; ?>><?= '['.$satuan['kodesatuan'].'] '.$satuan['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="dln" name="dln" type="checkbox" <?php if($data['dln']==1){ echo 'checked'; } ?>>
                        <span class="form-check-label">DLN</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="noinv" name="noinv" type="checkbox" <?php if($data['noinv']==1){ echo 'checked'; } ?>>
                        <span class="form-check-label">No INV</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="act" name="act" type="checkbox" <?php if($data['act']==1){ echo 'checked'; } ?>>
                        <span class="form-check-label">Aktif</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatebarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#nama_barang").focus();
    })
    $("#updatebarang").click(function(){
        var x = $("#dln").prop('checked') ? 1 : 0;
        var y = $("#noinv").prop('checked') ? 1 : 0;
        var z = $("#act").prop('checked') ? 1 : 0;
        if($("#kode").val() == ''){
            pesan('Kode harus di isi !','error');
            return;
        }
        if($("#nama_barang").val() == ''){
            pesan('Nama Barang harus di isi !','error');
            return;
        }
        if($("#id_satuan").val() == ''){
            pesan('Satuan harus di isi !','error');
            return;
        }
        if($("#id_kategori").val() == ''){
            pesan('Kategori harus di isi !','error');
            return;
        }
        var noe = $("#currentrow").val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'barang/updatebarang',
            data: {
                kode: $("#kode").val(),
                nama: $("#nama_barang").val(),
                sat: $("#id_satuan").val(),
                kat: $("#id_kategori").val(),
                id: $("#id").val(),
                dln: x,
                noinv: y,
                act: z
            },
            success: function(data){
                var temp = $("#tabelnya").DataTable().row(noe).data();
                // alert(temp);
                let buton = '';
                let aktif = (data[0]['act'] == 1) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                let dln = (data[0]['dln'] == 1) ? '<i class="fa fa-check text-success"></i>' : '-';
                let noinv = (data[0]['noinv'] == 1) ? '<i class="fa fa-check text-success"></i>' : '-';
                temp[1] = data[0]['kode'];
                temp[2] = data[0]['nama_barang'];
                temp[3] = data[0]['nama_kategori'];
                temp[4] = data[0]['namasatuan'];
                temp[5] = dln;
                temp[6] = noinv;
                temp[7] = aktif;
                buton = "<a href=" + base_url + 'barang/editbarang/' + data[0]['id'] +'/'+noe+" class='btn btn-sm btn-primary btn-icon text-white mr-1' rel="+data[0]['id']+ " rel2=" +noe+ " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
                buton += "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" + base_url + 'barang/hapusbarang/' +data[0]['id']+ "><i class='fa fa-trash-o'></i></a>";
                buton += "<a href=" + base_url + 'barang/isistock/' +data[0]['id']+ " class='btn btn-sm btn-info btn-icon mr-1' id='stockbarang' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Isi Safety Stock' title='Isi Safety Stock' ><i class='fa fa-info pl-1 pr-1'></i></a>";
                buton += "<a href=" + base_url + 'barang/bombarang/' +data[0]['id']+ " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM</a>";
                // temp[9] = buton;
                $("#tabelnya").DataTable().row(noe).data(temp).invalidate();
                // $("#tabelnya").DataTable().row(noe).addClass('text-red').draw();
                // $(row).addClass("text-red");
                $("#modal-simple").modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>