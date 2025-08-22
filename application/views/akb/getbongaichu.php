<div class="container-xl">
    <div class="row font-kecil">
        <input type="text" class="hilang" name="idheader" id="idheader" value="<?= $idheader; ?>">
        <div class="col-12 mb-1">
            <table class="table w-100 mb-1 table-hover">
                <thead style="background-color: blue !important">
                    <tr>
                        <th>No</th>
                        <th>Nomor Bon</th>
                        <th>Tgl</th>
                        <th>Proses</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pilih</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                   <?php $no=1; if($databongaichu->num_rows() > 0) {  foreach ($databongaichu->result_array() as $bongaichu) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-blue font-bold"><?= $bongaichu['nomor_dok']; ?></td>
                        <td><?= $bongaichu['tgl']; ?></td>
                        <td><?= $bongaichu['ket']; ?></td>
                        <td class="text-right"><?= rupiah($bongaichu['pcs'],0); ?></td>
                        <td class="text-right"><?= rupiah($bongaichu['kgs'],2); ?></td>
                        <td class="text-center">
                            <label class="form-check m-0">
                            <input class="form-check-input" name="cekpilihbarang" id="cekbok<?= $no; ?>" rel="<?= $bongaichu['id']; ?>" type="checkbox" title="<?= $bongaichu['id']; ?>">
                            <span class="form-check-label"></span>
                            </label>
                        </td>
                    </tr>
                   <?php } } else { ?>
                        <tr>
                            <td class="text-center" colspan="7">Data tidak Ditemukan !</td>
                        </tr>
                   <?php } ?>
                </tbody>
            </table>
            <hr class="small m-0">
            <div class="text-right mt-1 px-4">
                <a href="#" class="btn btn-sm btn-danger btn-flat" data-bs-dismiss="modal">Batal/Keluar</a>
                <a href="#" class="btn btn-sm btn-success btn-flat" id="simpanbon">Simpan</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    });
    $("#simpanbon").click(function(){
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
                url: base_url + "akb/tambahbongaichu",
                data: {
                    id: $("#idheader").val(),
                    out: text
                },
                success: function(data) {
                    window.location.href = base_url + "akb/isidokbc/" + data+'/1';
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Tidak ada data yang dipilih','info');
            // $("#modal-largescroll").modal('hide');
        }
    })
</script>