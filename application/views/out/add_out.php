<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1">
                <label class="form-label mb-0 font-kecil">Dari Departemen</label>
                <input type="text" class="form-control font-kecil mt-1" id="departemenasal" placeholder="Input placeholder">
            </div>
            <hr class="m-1">
            <table class="table datatable6">
                <thead>
                <tr>
                    <th>Nomor Dok</th>
                    <th>Tgl</th>
                    <th>Dibuat Oleh</th>
                    <th>Keterangan</th>
                    <th>Pilih</th>
                </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                    <?php foreach ($bon as $xbon) { ?>
                        <tr>
                            <td><?= $xbon['nomor_dok']; ?></td>
                            <td><?= $xbon['tgl']; ?></td>
                            <td><?= datauser($xbon['user_ok'],'username'); ?></td>
                            <td><?= $xbon['keterangan']; ?></td>
                            <td>
                                <a href="<?= base_url().'out/tambahdataout/'.$xbon['id']; ?>" class="btn btn-sm btn-success" style='padding: 3px !important;'>Pilih</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(count($bon)==0): ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada Data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn btn-success btn-sm text-black" data-bs-dismiss="modal">Batal</button>
</div>
<script>
    $(document).ready(function(){
        $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
</script>