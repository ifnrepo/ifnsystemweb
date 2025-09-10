<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                </div>
                <div>
                    <h4 class="alert-title">PERHATIAN : Berikut PO/Barang yang tidak ada BOM (<?= count($hasil['ng']) ?> Seri Barang)</h4>
                    <div class="text-secondary">
                        <ul style="list-style-type:none;">
                        <?php 
                            if(count($hasil['ng']) > 0): foreach($hasil['ng'] as $notbreak){ 
                            $sku = viewsku($notbreak['po'],$notbreak['item'],$notbreak['dis'],$notbreak['id_barang']);
                            $nambar = trim($notbreak['po'])=='' ? namaspekbarang($notbreak['id_barang']) : spekpo($notbreak['po'],$notbreak['item'],$notbreak['dis']);
                        ?>
                        <li>Seri Barang Ke <b class="text-danger"><?= $notbreak['seri_barang'] ?></b><?=' . '.$sku ?><br><?= '-'.$nambar ?></li>
                        <?php } endif; ?>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>Seri <?= count($hasil); ?></th>
                            <th>Kode / ID</th>
                            <th>Nama Barang</th>
                            <th>Nobontr</th>
                            <th>Qty</th>
                            <th>Berat (Kg)</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                        <?php if(count($hasil['ok']) > 0) { $jumlahpcs=0;$jumlahkgs=0; foreach ($hasil['ok'] as $databom ) { ?>
                            <tr>
                                <td><?= $databom['noe']; ?></td>
                                <td><?= $databom['id_barang']; ?></td>
                                <td><?= namaspekbarang($databom['id_barang']); ?></td>
                                <td><?= $databom['nobontr']; ?></td>
                                <td class="text-right"><?= rupiah($databom['pcs_asli'],0); ?></td>
                                <td class="text-right"><?= rupiah($databom['kgs_asli'],5); ?></td>
                            </tr>
                        <?php $jumlahpcs += $databom['pcs_asli']; $jumlahkgs += $databom['kgs_asli']; } } else { ?>
                            <tr>
                                <td class="text-center" colspan="6">Data tidak bisa di BREAKDOWM !</td>
                            </tr>
                        <?php } ?>
                         <?php if(count($hasil['ok']) > 0) { ?>
                            <tr>
                                <td colspan="4" class="text-center font-bold">TOTAL</td>
                                <td class="text-right font-bold"><?= rupiah($jumlahpcs,0); ?></td>
                                <td class="text-right font-bold" id="txtsumbom"><?= rupiah($jumlahkgs,2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr class="small m-1">
                <div class="text-center">
                    <a href="#" data-href="<?= base_url().'akb/simpanbomjf/'.$idheader.'/1'; ?>" id="simpankedb" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini " data-title="Bill Of Material" class="btn btn-sm btn-flat btn-primary hilang">Simpan</a>
                    <a href="#" id="simpannya" class="btn btn-sm btn-flat btn-primary">Simpan</a>
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
    });
    $("#simpannya").click(function(){
        var harus = $("#txtsum").text();
        var aktual = $("#txtsumbom").text();
        if(harus != aktual){
            alert('Data Header dan Detail Breakdown tidak Sama');
        }else{
            $("#simpankedb").click();
        }
    })
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