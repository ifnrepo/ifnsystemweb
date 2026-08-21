<div class="container-xl font-kecil overflow-auto mb-3">
    <h3></h3>
    <table class="table table-bordered m-0 table-hover">
        <thead class="bg-primary-lt">
        <tr>
            <th class="text-blue">Cek</th>
            <th class="text-blue">Tgl</th>
            <th class="text-blue">Tgl FN</th>
            <th class="text-blue">Tgl Cek</th>
            <th class="text-blue">SKU</th>
            <th class="text-blue">Instruksi</th>
            <th class="text-blue">Pcs</th>
            <th class="text-blue line-11">Meai<br>Dry</th>
            <th class="text-blue line-11">Meai<br>Wet</th>
            <th class="text-blue line-11">ST<br>Dry</th>
            <th class="text-blue">DT S</th>
            <th class="text-blue">DE</th>
            <th class="text-blue line-11">ST<br>Wet</th>
            <th class="text-blue">WT S</th>
            <th class="text-blue">WE</th>
            <th class="text-blue">QC</th>
            <th class="text-blue">LAB</th>
            <th class="text-blue">Kirim</th>
        </tr>
        </thead>
        <tbody class="table-tbody" id="body-tabel-caripo">  
            <?php if($ceklab->num_rows() > 0): foreach($ceklab->result_array() as $cklab): ?>
            <?php  
                $qc = $cklab['status_qc']==1 ? 'OK' : ($cklab['status_qc']==2 ? 'SA' : ($cklab['status_qc']==3 ? 'NG' : ''));
                $warnaqc = $cklab['status_qc']==1 ? 'text-green' : ($cklab['status_qc']==2 ? 'text-muted' : ($cklab['status_qc']==3 ? 'text-red' : ''));
                $lab = $cklab['status_lab']==1 ? 'OK' : ($cklab['status_lab']==2 ? 'SA' : ($cklab['status_lab']==3 ? 'NG' : ''));
                $warnalab = $cklab['status_lab']==1 ? 'text-green' : ($cklab['status_lab']==2 ? 'text-muted' : ($cklab['status_lab']==3 ? 'text-red' : ''));
                $kirim = $cklab['status_cek']==1 ? 'OK' : '';
            ?>
                <tr>
                    <td class="text-center font-bold"><a href="#" id="kolom" rel="<?= $cklab['id'] ?>" style="text-decoration: none;" class="btn btn-sm btn-danger" title="View Report"><i class="fa fa-file"></i></a></td>
                    <td><?= tglmysql2($cklab['tgl_terima']) ?></td>
                    <td><?= tglmysql2($cklab['tgl']) ?></td>
                    <td><?= tglmysql2($cklab['tgl_cek']) ?></td>
                    <td><?= viewsku($cklab['po'],$cklab['item'],$cklab['dis']) ?></td>
                    <td><?= $cklab['insno'] ?></td>
                    <td class="text-right"><?= rupiah($cklab['pcs'],0) ?></td>
                    <td class="text-right"><?= rupiah($cklab['meai_d'],3) ?></td>
                    <td class="text-right"><?= rupiah($cklab['meai_w'],3) ?></td>
                    <td class="text-right"><?= rupiah($cklab['std_dry'],2) ?></td>
                    <td class="text-right"><?= rupiah($cklab['dts_dry'],3) ?></td>
                    <td class="text-right"><?= rupiah($cklab['de'],3) ?></td>
                    <td class="text-right"><?= rupiah($cklab['std_wet'],2) ?></td>
                    <td class="text-right"><?= rupiah($cklab['dts_wet'],3) ?></td>
                    <td class="text-right"><?= rupiah($cklab['we'],3) ?></td>
                    <td class="text-center font-bold <?= $warnaqc ?>"><?= $qc ?></td>
                    <td class="text-center font-bold <?= $warnalab ?>"><?= $lab ?></td>
                    <td class="text-center font-bold"><?= $kirim ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="18" class="text-center font-kecil">Data Belum Ada (Hubungi R&D)</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="border: 1px solid #eaeaea;" class="mt-2 hilang" id="dokhasil">
        <div class="row mt-2">
            <div class="col-6">
                <div class="font-bold mt-2 ml-2"><h3>Dokumen Hasil Pengecekan</h3></div>
            </div>
            <div class="col-6">
                <div class="text-right">
                    <a href="#" class="btn btn-sm btn-success mr-3" id="hidedok">Hide</a>
                </div>
            </div>
        </div>
        <hr class="m-0">
        <div class="text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 400px !important;">
            <div><h1>We Are Building Something New</h1></div>
            <div>Our page is under construction. Please check back soon!</div>
        </div>
    </div>
</div>

<script>
    $(document).on('click','#kolom',function(){
        if($("#dokhasil").hasClass('hilang')){
            $("#dokhasil").removeClass('hilang');
        }
    })
    $(document).on('click','#hidedok',function(){
            $("#dokhasil").addClass('hilang');
    })
</script>