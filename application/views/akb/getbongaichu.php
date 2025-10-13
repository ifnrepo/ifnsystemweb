<div class="container-xl">
    <div class="row font-kecil">
        <input type="text" class="hilang" name="idheader" id="idheader" value="<?= $idheader; ?>">
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-bold">BON DARI</label>
            <div class="col">
                <div class="input-group mb-2">
                    <select class="form-select form-control font-kecil font-bold" id="asaldokumen">
                       <option value="FG">GAICHU / MAKLOON</option>
                       <option value="PC">PO/PURCHASING SERVICE</option>
                    </select>
                    <button class="btn font-kecil btn-primary" id="submit-pilih" type="button">Cari</button>
                </div>
            </div>
        </div>
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
                    <tr>
                        <td class="text-center" colspan="7">Pilih asal Dok dan Klik Cari !</td>
                    </tr>
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
    $("#submit-pilih").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "akb/getdokumenakb",
            data: {
                id: $("#idheader").val(),
                asal: $("#asaldokumen").val()
            },
            success: function(data) {
                // alert(data);
                $("#body-table").html(data.datagroup).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
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