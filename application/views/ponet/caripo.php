<div class="container-xl font-kecil  ">
    <input type="text" name="adaparam" id="adaparam" class="hilang" value="<?php if(isset($data)){ echo $data; }else{ echo 0; } ?>">
    <div id="tempatcari" class="<?php if(isset($data)){ echo 'hilang'; } ?>">
        <div class="row">
            <div class="col-12 m-0">
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">PO</label>
                    <div class="col"> 
                        <input type="text" class="form-control font-kecil btn-flat text-uppercase font-bold" name="ponya" id="ponya" placeholder="Nomor PO" value="">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">Item</label>
                    <div class="col"> 
                        <input type="text" class="form-control font-kecil btn-flat" name="itemnya" id="itemnya" placeholder="Item" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tempathasil" class="<?php if(!isset($data)){ echo 'hilang'; } ?>">
        <span class="font-kecil font-bold">Pilih PO</span>
        <table class="table table-bordered m-0 table-hover">
            <thead class="bg-primary-lt">
            <tr>
                <th class="text-center bg-blue-lt text-black">SKU</th>
                <th class="text-center bg-blue-lt text-black">Spec</th>
                <th class="text-center bg-blue-lt text-black">Buyer</th>
                <th class="text-center bg-blue-lt text-black">Act</th>
            </tr>
            </thead>
            <tbody class="table-tbody" id="body-tabel-caripo">  
                <tr>
                    <td colspan="4" class="text-center font-kecil">Load Data ...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- class="modal-footer font-kecil" -->
<hr class="m-1">
<div class="d-flex justify-content-between p-2 mt-0" >
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="caripo">Cari Data PO</button>
</div>
<script>
    $(document).ready(function(){
        // alert($("#adaparam").val());
        if($("#adaparam").val()==0){
            setTimeout(() => {
                $("#ponya").focus();
            }, 500);
        }else{
            var kode = $("#adaparam").val();
            getdatapo(kode);
        }
    })
    $(document).on('click','#resetcari',function(){
        $("#ponya").val('');
        $("#itemnya").val('');
        $("#tempatcari").removeClass('hilang');
        $("#tempathasil").addClass('hilang');
    })
    $("#caripo").click(function() {
        if($("#ponya").val() == ''){
            pesan('Isi Nomor PO yang akan dicari','info');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"ponet/caridatapo",
            data: {
                po: $("#ponya").val(),
                item: $("#itemnya").val()
            },
            success: function(data){
                // alert('berhasil');
                // window.location.reload();
                $("#tempatcari").addClass('hilang');
                $("#tempathasil").removeClass('hilang');
                $("#body-tabel-caripo").html(data.datagroup).show();
                // $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                pesan('Ada Error, '+xhr.status+', Hubungi IT','error');
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    })
    function getdatapo(op){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+"ponet/caridatapo",
            data: {
                po: op,
                item: ''
            },
            success: function(data){
                // alert('berhasil');
                // window.location.reload();
                $("#tempatcari").addClass('hilang');
                $("#tempathasil").removeClass('hilang');
                $("#body-tabel-caripo").html(data.datagroup).show();
                // $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                pesan('Ada Error, '+xhr.status+', Hubungi IT','error');
                console.log(xhr.status);
			    console.log(thrownError);
            }
        })
    }
</script>