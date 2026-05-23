<div class="modal-body pt-1 pb-1 mb-1">
    <div class="row">
        <div class="col font-kecil">
            <table class="table table-bordered table-hover m-0">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-black">No</th>
                        <th class="text-black">Departemen</th>
                        <th class="text-black">Verifikasi 1 (Data)</th>
                        <th class="text-black">Verifikasi 2 (KAP)</th>
                        <th class="text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php $no=1; if($data->num_rows() > 0){ foreach($data->result_array() as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="font-bold"><?= $d['departemen'] ?></td>
                            <td class="text-right" id="kolomverif<?= $d['dept_id'] ?>"><?= rupiah($d['persen_verif'],2) ?></td>
                            <td class="text-right" id="kolomrilis<?= $d['dept_id'] ?>"><?= rupiah($d['persen_rilis'],2) ?></td>
                            <td class="text-center">
                                <a href="#" id="editdata" rel="<?= $d['dept_id'] ?>" rel2="<?= $d['departemen'] ?>" rel3="<?= rupiah($d['persen_verif'],2) ?>" rel4="<?= rupiah($d['persen_rilis'],2) ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
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
                <a id="oke-batal" href="#" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
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
                <label class="col-3 col-form-label">Departemen</label>
                <div class="col">
                    <input type="text" name="dept_id" id="dept_id" class="hilang">
                    <input type="text" class="form-control font-kecil btn-flat" name="departemen" id="departemen" placeholder="Departemen" readonly>
                </div>
            </div>
            <div class="mb-1 row font-kecil">
                <label class="col-3 col-form-label">Verifikasi 1 (Data)</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right inputangka" name="departemen" id="verif" placeholder="Verifikasi 1 (Data)">
                </div>
            </div>
            <div class="mb-1 row font-kecil">
                <label class="col-3 col-form-label">Verifikasi 2 (Data)</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right inputangka" name="departemen" id="rilis" placeholder="Verifikasi 2 (KAP)">
                </div>
            </div>
            <div class="col-12 text-end">
                <a href="#" class="btn btn-sm btn-success" id="simpanpersenstok" style="width:55px;">Simpan</a>
                <a href="#" class="btn btn-sm btn-danger" id="batalsimpan" style="width:55px;">Batal</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".inputangka").on("change click keyup input paste", function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/(?!\.)\D/g, "")
                    .replace(/(?<=\..*)\./g, "")
                    .replace(/(?<=\.\d\d).*/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    })
    $(document).on('click','#editdata',function(){
        $("#tombolfootkeluar").addClass('hilang');
        $("#tombolfoot2").removeClass('hilang');
        $("#tampungid").val($(this).attr('rel'));
        var url = base_url+"opname/editperiode/"+$(this).attr('rel');
        // $("#simpanperiode").attr("href",url);
        $("#simpanpersenstok").html('Update');
        $("#departemen").val($(this).attr('rel2'));
        $("#verif").val($(this).attr('rel3'));
        $("#rilis").val($(this).attr('rel4'));
        $("#dept_id").val($(this).attr('rel'));
    })
    $("#batalsimpan").click(function(){
        $("#tombolfootkeluar").removeClass('hilang');
        $("#tombolfoot2").addClass('hilang');
    })
    $("#simpanpersenstok").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "opname/updatepersenstok",
            data: {
                dept: $("#dept_id").val(),
                verif: $("#verif").val(),
                rilis: $("#rilis").val()
            },
            success: function (data) {
                alert('Data Berhasil diupdate !');
                var dep = $("#dept_id").val();
                $("#kolomverif"+dep).html(data[0].persen_verif);
                $("#kolomrilis"+dep).html(data[0].persen_rilis);
                // window.location.reload();
                $("#tombolfootkeluar").removeClass('hilang');
                $("#tombolfoot2").addClass('hilang');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
     $("#batalhapus").click(function(){
        $("#tombolfootkeluar").removeClass('hilang');
        $("#tombolfoot").addClass('hilang');
    })
</script>