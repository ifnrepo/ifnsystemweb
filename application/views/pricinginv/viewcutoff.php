<div class="modal-body pt-1 pb-1 mb-1">
    <div class="row">
        <div class="col font-kecil">
            <h4>Data Cutoff Tahun <?= $this->session->userdata('thpricing') ?></h4>
            <table class="table table-bordered table-hover m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-black">No</th>
                        <th class="text-black">Tgl Cutoff</th>
                        <th class="text-black">Remark</th>
                        <th class="text-black">Add By</th>
                        <th class="text-black">Lock By</th>
                        <th class="text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php if($data->num_rows() > 0){ $no=1; foreach($data->result_array() as $d): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="font-bold"><?= tglmysql($d['tgl']) ?></td>
                            <td><?= $d['catatan'] ?></td>
                            <td class="line-11"><?= datauser($d['user_add'],'name').'<br><span class="text-secondary" style="font-size: 11px;">'.tglmysql2($d['tgl_add']).'</span>' ?></td>
                            <td class="line-11"><?= datauser($d['user_lock'],'name').'<br><span class="text-teal">'.tglmysql2($d['tgl_lock']).'</span>' ?></td>
                            <td class="text-center">
                                <?php $lock = $d['user_lock']!=NULL ? 'disabled' : ''; ?>
                                <a href="#" class="btn btn-sm btn-danger <?= $lock ?>" title="Hapus data Cut Off Inventory" id="kuncidata" rel="<?= $d['id'] ?>" rel2="<?= $d['tgl'] ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="6" class="text-center"> Data tidak ditemukan</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer py-0">
    <div class="w-100" id="tombolfootkeluar">
        <div class="row">
            <div class="col text-end"><a id="oke-batal" href="#" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
                Keluar
            </a></div>
        </div>
    </div>
    <div class="w-100 hilang" id="tombolfoot">
        <div class="row">
            <input type="text" id="tampungid" class="hilang">
            <div class="col-8 font-bold" id="tampungnama">
                Anda yakin akan Menghapus data ini ?
            </div>
            <div class="col-4 text-end">
                <a href="#" class="btn btn-sm btn-success" id="siaphapus" style="width:55px;">Ya</a>
                <a href="#" class="btn btn-sm btn-danger" id="batalhapus" style="width:55px;">Batal</a>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function(){

    })
    $(document).on('click','#kuncidata',function(){
        $("#tombolfootkeluar").addClass('hilang');
        $("#tombolfoot").removeClass('hilang');
        $("#tampungid").val($(this).attr('rel'));
        $("#tampungnama").text("Anda yakin akan Menghapus cutoff tanggal "+$(this).attr('rel2')+" ?");
        var url = base_url+"pricinginv/hapuscutoff/"+$(this).attr('rel');
        $("#siaphapus").attr("href",url);
    })
    $("#batalhapus").click(function(){
        $("#tombolfootkeluar").removeClass('hilang');
        $("#tombolfoot").addClass('hilang');
    })
    $("#oke").click(function(){
        // alert($("#idrek").val());
        var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	    $("#loadview").html(isinya);
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "pricinginv/simpancutoff",
            data: {
                tgl: $("#tglcut").val(),
                cttn: $("#catatan").val()
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    });
</script>