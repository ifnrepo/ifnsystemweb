<div class="container-xl">
    <div class="row font-kecil">
        <input type="text" class="hilang" name="idheader" id="idheader" value="<?= $idheader; ?>">
        <input type="text" name="kode" id="kode" class="hilang" value="<?= $kode ?>">
        <div class="col-12 mb-1">
            <table class="table w-100 mb-1">
                <thead style="background-color: blue !important">
                    <tr>
                        <th>No</th>
                        <th>Nomor Kontrak</th>
                        <th>Tgl Awal/Akhir</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Real (Kg)</th>
                        <th>Pilih</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                    <?php $no=0; foreach ($kontrak->result_array() as $kontrak) { ?>
                    <?php $jmlkgsreal = jmlkgs261($kontrak['id']); if($kontrak['kgs'] > $jmlkgsreal) : $no++;?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td class="font-bold line-12"><?= $kontrak['nomor']; ?><br><span class="text-pink font-10" style="font-style: normal !important"><?= $kontrak['proses'] ?></span><br><span class="text-teal font-10" style="font-style: normal !important"><?= datasupplier($kontrak['id_supplier'],'nama_supplier') ?></span></td>
                            <td class="line-12 text-center"><?= tglmysql($kontrak['tgl_awal']); ?><br><?= tglmysql($kontrak['tgl_akhir']); ?></td>
                            <td class="text-right"><?= rupiah($kontrak['pcs'],0); ?></td>
                            <td class="text-right"><?= rupiah($kontrak['kgs'],2); ?></td>
                            <td class="text-right"><?= rupiah($jmlkgsreal,2); ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-success font-kecil btn-flat m-0 p-0" style="padding: 3px 5px !important;" rel="<?= $kontrak['id']; ?>" id="tombolpilih">Pilih</a>
                            </td>
                        </tr>
                    <?php endif; } ?>
                </tbody>
            </table>
            <hr class="small m-0">
            <div class="text-center mt-1 px-4">
                <a href="#" class="btn btn-sm btn-danger btn-flat" data-bs-dismiss="modal">Batal/Keluar</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    });
    $(document).on('click','#tombolpilih',function(){
        var x = $(this).attr('rel');
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+'akb/simpanaddkontrak',
            data: {
                id: $("#idheader").val(),
                kode: $("#kode").val(),
                kontrak: x
            },
            success: function(data){
                // window.location.reload();
                // alert("Data Sudah Masuk");
                // $("#keluar_bombc").click(); 
                $('#modal-large').modal('hide');
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $("#tombol").click(function(){

        // var cekbm = $("#bm").prop("checked");
        // var cekbmt = $("#bmt").prop("checked");
        // var cekcukai = $("#cukai").prop("checked");
        // var cekppn = $("#ppn").prop("checked");
        // var cekppnbm = $("#ppnbm").prop("checked");
        // var cekpph = $("#pph").prop("checked");
        // $.ajax({
        //     // dataType: "json",
        //     type: "POST",
        //     url: base_url+'akb/simpandetailbombc',
        //     data: {
        //         id: $("#id").val(),
        //         nobontr: $("#nobontr").val(),
        //         bm: cekbm,
        //         bmt: cekbmt,
        //         cukai: cekcukai,
        //         ppn: cekppn,
        //         ppnbm: cekppnbm,
        //         pph: cekpph
        //     },
        //     success: function(data){
        //         // window.location.reload();
        //         alert("Data Sudah Masuk");
        //         // $("#keluar_bombc").click(); 
        //         $('#modal-large').modal('hide');
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr.status);
        //         console.log(thrownError);
        //     }
        // })
    })
</script>