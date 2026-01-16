<div class="modal-body pt-1 pb-1 mb-1">
    <div class="row">
        <div class="col font-kecil">
            <h4>Data Periode Stok Opname</h4>
            <table class="table table-bordered table-hover m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-black">No</th>
                        <th class="text-black">Tgl</th>
                        <th class="text-black">Keterangan</th>
                        <th class="text-black">Add By</th>
                        <th class="text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php $no=1; if($data->num_rows() > 0){ foreach($data->result_array() as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="font-bold"><?= tglmysql($d['tgl']) ?></td>
                            <td><?= $d['keterangan'] ?></td>
                            <td class="line-12"><?= datauser($d['user_add'],'name') ?><br>On. <?= tglmysql2($d['tgl_add']) ?></td>
                            <td class="text-center">
                                <a href="#" id="kuncidata" rel="<?= $d['id'] ?>" rel2="<?= tglmysql($d['tgl']) ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                                <a href="#" id="editdata" rel="<?= $d['id'] ?>" rel2="<?= tglmysql($d['tgl']) ?>" rel3="<?= $d['keterangan'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; }else{ ?>
                        <tr>
                            <td colspan="5" class="text-center">-- Data tidak ada --</td>
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
            <div class="col text-end">
                <a id="tambah-periode" href="#" class="btn btn-sm btn-primary">
                    Tambah Data
                </a>
                <a id="oke-batal" href="#" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
                    Keluar
                </a>
            </div>
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
    <div class="w-100 hilang" id="tombolfoot2">
        <div class="row">
            <div class="mb-1 row font-kecil">
                <label class="col-3 col-form-label">Tanggal</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="tglperiode" id="tglperiode" placeholder="Tanggal">
                    <div class="invalid-feedback mt-0" id="error-tglperiode">Tgl harus di isi</div>
                </div>
            </div>
            <div class="mb-1 row font-kecil">
                <label class="col-3 col-form-label">Keterangan</label>
                <div class="col">
                    <!-- <input type="text" class="form-control font-kecil btn-flat" name="keterangan" id="keterangan" placeholder="Keterangan"> -->
                    <textarea name="keterangan" id="keterangan" class="form-control font-kecil" placeholder="Keterangan"></textarea>
                    <div class="invalid-feedback mt-0" id="error-keterangan">Keterangan harus di isi</div>
                </div>
            </div>
            <div class="col-12 text-end">
                <a href="#" class="btn btn-sm btn-success" id="simpanperiode" style="width:55px;">Simpan</a>
                <a href="#" class="btn btn-sm btn-danger" id="batalsimpan" style="width:55px;">Batal</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#tglperiode").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true
        });
    })
    $(document).on('click','#kuncidata',function(){
        $("#tombolfootkeluar").addClass('hilang');
        $("#tombolfoot").removeClass('hilang');
        $("#tampungid").val($(this).attr('rel'));
        $("#tampungnama").text("Anda yakin akan Menghapus Periode SO tanggal "+$(this).attr('rel2')+" ?");
        var url = base_url+"opname/hapusperiode/"+$(this).attr('rel');
        $("#siaphapus").attr("href",url);
    })
    $(document).on('click','#editdata',function(){
        $("#tombolfootkeluar").addClass('hilang');
        $("#tombolfoot2").removeClass('hilang');
        $("#tampungid").val($(this).attr('rel'));
        var url = base_url+"opname/editperiode/"+$(this).attr('rel');
        // $("#simpanperiode").attr("href",url);
        $("#simpanperiode").html('Update');
        $("#tglperiode").val($(this).attr('rel2'));
        $("#keterangan").val($(this).attr('rel3'));
    })
    $("#tambah-periode").click(function(){
        $("#tombolfootkeluar").addClass('hilang');
        $("#tombolfoot2").removeClass('hilang');
        $("#simpanperiode").attr("href",'#');
        $("#simpanperiode").html('Simpan');
    })
    $("#batalsimpan").click(function(){
        $("#tombolfootkeluar").removeClass('hilang');
        $("#tombolfoot2").addClass('hilang');
    })
    $("#simpanperiode").click(function(){
        $("#tglperiode").removeClass('is-invalid');
        $("#keterangan").removeClass('is-invalid');
        if($("#tglperiode").val()==''){
            $("#tglperiode").addClass('is-invalid');
            return false;
        }
        if($("#keterangan").val()==''){
            $("#keterangan").addClass('is-invalid');
            return false;
        }
        if($(this).text()=='Simpan'){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "opname/simpanperiode",
                data: {
                    tgl: $("#tglperiode").val(),
                    cttn: $("#keterangan").val()
                },
                success: function (data) {
                    alert('Data Berhasil disimpan !');
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }else{  // APabila Update
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "opname/editperiode",
                data: {
                    tgl: $("#tglperiode").val(),
                    cttn: $("#keterangan").val(),
                    id: $("#tampungid").val()
                },
                success: function (data) {
                    alert('Data Berhasil diupdate !');
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
    })
     $("#batalhapus").click(function(){
        $("#tombolfootkeluar").removeClass('hilang');
        $("#tombolfoot").addClass('hilang');
    })
</script>