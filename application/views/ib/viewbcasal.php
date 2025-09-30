<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $idheader; ?>">
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">SKU</label>
                <div class="col">
                    <?php $sku = trim($detail['po'])=='' ? $detail['kode'] : viewsku($detail['po'],$detail['item'],$detail['dis']); ?>
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $sku ?>" aria-describedby="emailHelp" placeholder="SKU" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nama Barang</label>
                <div class="col">
                    <?php $spekbarang = trim($detail['po'])=='' ? namaspekbarang($detail['id_barang']) : spekpo($detail['po'],$detail['item'],$detail['dis']); ?>
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $spekbarang ?>" aria-describedby="emailHelp" placeholder="Nama Barang" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Insno</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $detail['insno'] ?>" aria-describedby="emailHelp" placeholder="Insno" >
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nomor IB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $detail['nobontr'] ?>" aria-describedby="emailHelp" placeholder="Nomor IB" >
                </div>
            </div>
        </div>
    </div>
    <hr class="small m-0">
    <div class="text-center bg-primary-lt mb-1 font-bold">Informasi BC ASAL (261)</div>
    <table class="table datatable6" id="cobasisip">
        <thead style="background-color: blue !important">
            <tr>
                <th>Seri <?= $detail['id_seri_exbc'] ?></th>
                <th>SKU</th>
                <th>Nama Barang / Uraian</th>
                <th>CIF (IDR)</th>
                <th>BM</th>
                <th>PPN</th>
                <th>PPH</th>
            </tr>
        </thead>
        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
            
        </tbody>
    </table>
    <hr class="small m-1">
    <div class="text-center mb-3">
        <a href="#" class="btn btn-sm btn-flat btn-danger" id="tutupmodal" data-bs-dismiss="modal">Keluar</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $(".tgl").datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     todayHighlight: true,
        // });
        $("#peringatan").text('');
    })
    $("#kode_entitas").change(function(){
        $("#divnegara").addClass('hilang');
        $("#dividentitas").addClass('hilang');
        var xx = $(this).val();
        if(xx == 7){
            $("#dividentitas").removeClass('hilang');
        }
        if(xx == 5){
            $("#divnegara").removeClass('hilang');
        }
    })
    $("#simpanentitas").click(function(){
        if($("#kode_entitas").val()==''){
            pesan('Pilih Kode Entitas','error');
            return false;
        }
        if($("#nama").val()==''){
            pesan('Isi Nama','error');
            return false;
        }
        if($("#alamat").val()==''){
            pesan('Isi Alamat','error');
            return false;
        }  
        if($("#kode_entitas").val() == 7 && $("#no_identitas").val() == ''){
            pesan('Isi Nomor Identitas','error');
            return false;
        }
        if($("#kode_entitas").val() == 5 && $("#kode_negara").val() == ''){
            pesan('Negara Harus di Isi','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/tambahentitas",
            data: {
                id: $("#id_header").val(),
                kode: $("#kode_entitas").val(),
                no: $("#no_identitas").val(),
                nama: $("#nama").val(),
                alamat: $("#alamat").val(),
                negara: $("#kode_negara").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table-entitas").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>