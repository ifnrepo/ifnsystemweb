<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>Seri</th>
                            <th>Kode / ID</th>
                            <th>Nama Barang</th>
                            <th>Nobontr</th>
                            <th>Qty</th>
                            <th>Berat (Kg)</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                        <?php foreach ($hasil as $databom ) { ?>
                            <tr>
                                <td><?= $databom['noe']; ?></td>
                                <td><?= $databom['id_barang']; ?></td>
                                <td><?= namaspekbarang($databom['id_barang']); ?></td>
                                <td><?= $databom['nobontr']; ?></td>
                                <td class="text-right"><?= rupiah($databom['pcs_asli'],0); ?></td>
                                <td class="text-right"><?= rupiah($databom['kgs_asli'],5); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr class="small m-1">
                <div class="text-center">
                    <a href="#" data-href="<?= base_url().'akb/simpanbom/'.$idheader.'/1'; ?>" id="simpankedb" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini " data-title="Bill Of Material" class="btn btn-sm btn-flat btn-primary">Simpan</a>
                    <a href="#" class="btn btn-sm btn-flat btn-danger" data-bs-dismiss="modal">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#modal-scroll').on('shown.bs.modal', function() {
            // $('#textareaID').focus();
            $("#keyw").focus();
        })
        // $("#keyw").val($("#nomor_dok").val());
        // if ($("#keyw").val() != '') {
        //     $("#getbarang").click();
        // }
        // $("#getbarang").click();
        // $("#deptselect").val($("#xdeptselect").val());
    });
    $("#deptselect").change(function(){
        $("#getbarang").click();
    })
    $("#keyw").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $("#getbarang").click();
        }
    });

    $("#getbarang").click(function() {
        if($("#keyw").val()==''){
            pesan('Isi dulu Keyword pencarian ','info');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('bbl/getbarang') ?>',
            data: {
                data: $("#keyw").val(),
                header: $("#id_header").val()
            },
            success: function(data) {
                console.log(data); // Log data yang diterima
                if (data.datagroup) {
                    $("#body-table").html(data.datagroup).show();
                } else {
                    alert('Tidak ada data yang ditemukan');
                    $("#body-table").html('').hide();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });
</script>