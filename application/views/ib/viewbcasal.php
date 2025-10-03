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
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nomor IB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $detail['nobontr'] ?>" aria-describedby="emailHelp" placeholder="Nomor IB" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="kgs" name="kgs" value="<?= rupiah($detail['sumkgs'],2) ?>" aria-describedby="emailHelp" placeholder="Nama Barang" >
                </div>
            </div>
        </div>
    </div>
    <hr class="small m-0">
    <div class="text-center font-kecil bg-primary-lt mb-1 font-bold">Informasi BC ASAL (261)</div>
    <table class="table datatable6" id="cobasisip">
        <thead style="background-color: blue !important">
            <tr>
                <th>Seri</th>
                <th>SKU</th>
                <th>Nama Barang / Uraian</th>
                <th>Kgs</th>
                <th>CIF (IDR)</th>
                <th class="text-center">BM</th>
                <th class="text-center">PPN</th>
                <th class="text-center">PPH</th>
            </tr>
        </thead>
        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
            <?php
                $jumlahcif = 0; $jumlahkgs = 0;
                foreach($databcasal as $databcasal){ 
                $adabm = $databcasal->bm > 0 ? '<i class="fa fa-check text-green"></i>' : '';
                $adappn = $databcasal->ppn > 0 ? '<i class="fa fa-check text-green"></i>' : '';
                $adapph = $databcasal->pph > 0 ? '<i class="fa fa-check text-green"></i>' : '';
                // $jumlahcif += $databcasal->bm_rupiah+$databcasal->pph_rupiah+$databcasal->ppn_rupiah;
                $jumlahkgs += $databcasal->kgs;
                $ndpbm = $databcasal->ndpbm;
                // $xcif = (($jumlahcif/$jumlahkgs)*$detail['sumkgs'])/$ndpbm;
                $xcif = $jumlahcif;
                $xcoba = $xcif/$ndpbm;
                $rupiahcif = $xcif*$ndpbm;
                $jumlahcif += $databcasal->cif*$databcasal->ndpbm;
            ?>
                <tr>
                    <td><?= $databcasal->seri_urut_akb ?></td>
                    <td><?= $databcasal->kode ?></td>
                    <td class="line-12"><?= $databcasal->nama_barang ?><br><span class="font-12 text-teal"><?= $databcasal->nobontr ?></span></td>
                    <td><?= round($databcasal->kgs,2) ?></td>
                    <td><?= round($databcasal->cif,2)*$ndpbm ?></td>
                    <td class="text-center"><?= $adabm ?></td>
                    <td class="text-center"><?= $adappn ?></td>
                    <td class="text-center"><?= $adapph ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="8" class="font-bold text-center">
                    <span class="mr-5">TOTAL KGS <span style="font-weight: normal"><?= $jumlahkgs ?></span></span>
                    <span class="mr-5">TOTAL CIF <span style="font-weight: normal"><?= $databcasal->sumcif ?></span></span>
                    <span class="mr-3">TOTAL CIF (IDR) <span style="font-weight: normal"><?= rupiah($jumlahcif,2) ?></span></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center font-kecil bg-primary-lt mb-1 font-bold">Nilai CIF (<?= $detail['sumkgs'] ?> Kgs)</div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">IDR</label>
                <div class="col">
                    <?php $sumkgs = $detail['sumkgs']==0 ? 1 : $detail['sumkgs']; ?>
                    <?php $jumlahidr = $jumlahkgs/$sumkgs; ?>
                    <input type="text" class="form-control font-14 btn-flat text-right font-bold" id="kgs" name="kgs" value="<?= rupiah($jumlahcif/round($jumlahidr,2),2) ?>" aria-describedby="emailHelp" placeholder="Nama Barang" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">USD</label>
                <div class="col">
                    <input type="text" class="form-control font-14 btn-flat text-right font-bold" id="kgs" name="kgs" value="<?= rupiah(($jumlahcif/round($jumlahidr,2))/$ndpbm,2) ?>" aria-describedby="emailHelp" placeholder="Nama Barang" >
                </div>
            </div>
        </div>
    </div>
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