<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12 mb-1">
            <input type="text" name="id" id="id" class="hilang" value="<?= $detail['id']; ?>">
            <input type="text" name="id_header" id="id_header" class="hilang" value="<?= $detail['id_header']; ?>">
            <div class="row">
                <div class="col-9">
                    <div class="row mb-1">
                        <label class="col-3 col-form-label font-kecil">Nama Barang</label>
                        <div class="col">
                            <input type="hidden" name="id_barang" id="id_barang" value ="<?= $detail['id_barang'] ?>">
                            <input type="text" class="form-control font-kecil" id="nama_barang" name="nama_barang" value="<?= $detail['nama_barang']; ?>" aria-describedby="emailHelp" placeholder="Barang" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-3 col-form-label font-kecil">Nomor IB</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" id="nobontr" name="nobontr" value="<?= trim($detail['nobontr']); ?>" aria-describedby="emailHelp" placeholder="Nomor Input Barang">
                        </div>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <?php $jnsbc = $detail['jns_bc']==null ? $detail['hamat_jnsbc'] : $detail['jns_bc']; ?>
                    <span>Jenis BC</span><br><span><h1><?= $jnsbc; ?></h1></span>
                </div>
            </div>
            <hr class="small m-1">
            <table class="table w-100 table-bordered">
                <thead style="background-color: blue !important">
                    <tr>
                        <th>Jenis</th>
                        <th>Cek</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                    <?php
                        $datapajak = ["BM","BMT","CUKAI","PPN","PPNBM","PPH"];
                        foreach ($datapajak as $isipajak) { 
                        $ceked = $detail[strtolower($isipajak)] > 0 ? 'checked' : '';
                        $disabel = $jnsbc == 40 ? 'disabled' : '';
                        $kethilang = $jnsbc != 40 ? 'hilang' : '';
                     ?>
                    <tr>
                        <td><?= $isipajak; ?></td>
                        <td>
                            <label class="form-check form-switch">
                              <input class="form-check-input" id="<?= strtolower($isipajak); ?>" type="checkbox" <?= $ceked; ?> <?= $disabel; ?>>
                              <span class="form-check-label <?= $kethilang; ?>">BC 40 tidak dipungut</span>
                            </label>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr class="small m-1">
            <div class="text-center">
                <a href="#" class="btn btn-sm btn-flat btn-success" id="simpandata">Simpan</a>
                <a href="#" class="btn btn-sm btn-flat btn-danger" id="keluar_bombc" data-bs-dismiss="modal">Batal/Keluar</a>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    
</div>


<script>
    $(document).ready(function() {
        // $("#keyw").val($("#nomor_dok").val());
        // if ($("#keyw").val() != '') {
        //     $("#getbarang").click();
        // }
        // $("#getbarang").click();
        // $("#deptselect").val($("#xdeptselect").val());
    });
    $("#simpandata").click(function(){
        var cekbm = $("#bm").prop("checked");
        var cekbmt = $("#bmt").prop("checked");
        var cekcukai = $("#cukai").prop("checked");
        var cekppn = $("#ppn").prop("checked");
        var cekppnbm = $("#ppnbm").prop("checked");
        var cekpph = $("#pph").prop("checked");
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+'akb/simpandetailbombc',
            data: {
                id: $("#id").val(),
                idheader: $("#id_header").val(),
                nobontr: $("#nobontr").val(),
                idbarang: $("#id_barang").val(),
                bm: cekbm,
                bmt: cekbmt,
                cukai: cekcukai,
                ppn: cekppn,
                ppnbm: cekppnbm,
                pph: cekpph
            },
            success: function(data){
                // window.location.reload();
                alert("Data berhasil diupdate, \r\nRefresh halaman untuk melihat hasil");
                // $("#keluar_bombc").click(); 
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>