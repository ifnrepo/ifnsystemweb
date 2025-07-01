<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="iddetail" class="btn btn-sm btn-danger hilang" value="">
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Nomor Bon</th>
                    <th>Tgl</th>
                    <th>Sv</th>
                    <th>Supplier</th>
                    <th class='text-right'>Qty</th>
                    <th class='text-right'>Kgs</th>
                    <th class='text-right'>Harga Satuan</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                   <?php foreach ($data->result_array() as $det) { $bblsv = $det['bbl_sv']==1 ? 'Sv' : ''; ?>
                        <tr class="font-kecil">
                            <td><?= $det['nomor_dok']; ?></td>
                            <td><?= tgl_indo($det['tgl']); ?></td>
                            <td class="text-danger"><?= $bblsv ?></td>
                            <td><?= ucwords(strtolower($det['nama_supplier'])) ?></td>
                            <td class='text-right'><?= rupiah($det['pcs'],0); ?></td>
                            <td class='text-right'><?= rupiah($det['kgs'],2); ?></td>
                            <td class='text-right'><?= $det['mt_uang']; ?> <?= rupiah($det['harga'],2); ?></td>
                        </tr>
                   <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
    <button type="button" class="btn btn-success btn-sm text-black" data-bs-dismiss="modal">Keluar</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
</script>