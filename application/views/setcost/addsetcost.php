<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Departemen</label>
                <div class="col">
                    <select class="form-select form-control form-sm font-kecil font-bold" id="dept_act" name="dept_act" disabled>
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach($departemen->result_array() as $dept){ $selek = $this->session->userdata('currdeptcost')==$dept['dept_id'] ? 'selected' : '';  ?>
                            <option value="<?= $dept['dept_id'] ?>" <?= $selek ?>><?= $dept['departemen'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Kategori Barang</label>
                <div class="col">
                    <select class="form-select form-control form-sm font-kecil font-bold" id="id_kategori" name="id_kategori">
                        <option value="">-- Pilih Kategori Barang --</option>
                        <?php foreach($kategori->result_array() as $katgr){ ?>
                            <option value="<?= $katgr['kategori_id'] ?>"><?= $katgr['nama_kategori'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <?php $hilang = $this->session->userdata('currdeptcost')=='FN' ? '' : 'hilang'; ?>
        <div class="col-12 <?= $hilang ?>">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Sub Lokasi</label>
                <div class="col">
                    <select class="form-select form-control form-sm font-kecil font-bold" id="sublok" name="sublok">
                        <option value="">-- Pilih Sub Lokasi --</option>
                        <?php foreach($sublok->result_array() as $sbl){ ?>
                            <option value="<?= $sbl['sublok'] ?>"><?= $sbl['nama_sublok'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <?php $hilang2 = $this->session->userdata('currdeptcost')=='GW' ? '' : 'hilang'; ?>
        <div class="col-12 <?= $hilang2 ?>">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Asal Waste</label>
                <div class="col">
                    <select class="form-select form-control form-sm font-kecil font-bold" id="asal" name="asal">
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach($departemen->result_array() as $dept){  ?>
                            <option value="<?= $dept['dept_id'] ?>"><?= $dept['departemen'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">

        </div>
        <div class="card mb-2">
            <div class="card-body font-kecil p-1">
                <div class="bg-primary-lt p-1 font-bold text-black">Data Job Cost Dept</div>
                <div class="p-2">
                    <table class="table table-bordered m-0">
                    <thead class="bg-primary-lt">
                      <tr>
                        <th class="text-center text-black line-11">SP<br><small>Spinning</small></th>
                        <th class="text-center text-black line-11">RR<br><small>Ringrope</small></th>
                        <th class="text-center text-black line-11">NT<br><small>Netting</small></th>
                        <th class="text-center text-black line-11">SN<br><small>Senshoku</small></th>
                        <th class="text-center text-black line-11">HO1<br><small>Hoshu 1</small></th>
                        <th class="text-center text-black line-11">KOA<br><small>Koatsu</small></th>
                        <th class="text-center text-black line-11">HO2<br><small>Hoshu 2</small></th>
                        <th class="text-center text-black line-11">PAC<br><small>Packing</small></th>
                        <th class="text-center text-black line-11">SHI<br><small>Shitate</small></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="sp" name="sp" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="rr" name="rr" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="nt" name="nt" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="sn" name="sn" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="h1" name="h1" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input disable" id="ko" name="ko" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="h2" name="h2" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2">
                                    <input class="form-check-input" id="pa" name="pa" type="checkbox">
                                </label>
                            </td>
                            <td>
                                <label class="form-check form-check-single form-switch pl-2"> 
                                    <input class="form-check-input" id="sh" name="sh" type="checkbox">
                                </label>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-center">
        <button type="button" class="btn me-auto font-kecil btn-flat" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary font-kecil btn-flat" id="updatesupplier">Simpan</button>
    </div>
</div>
<script>
    $("#sublok").change(function(){
        var xu = $(this).val();
        $("#sn").prop('checked',false);
        $("#h1").prop('checked',false);
        $("#ko").prop('checked',false);
        $("#h2").prop('checked',false);
        $("#pa").prop('checked',false);
        $("#sh").prop('checked',false);
        
        $("#sn").prop('disabled',true);
        $("#h1").prop('disabled',true);
        $("#ko").prop('disabled',true);
        $("#h2").prop('disabled',true);
        $("#pa").prop('disabled',true);
        $("#sh").prop('disabled',true);
        if(xu=='SN'){
            $("#sn").prop('disabled',true);
            $("#h1").prop('disabled',true);
            $("#ko").prop('disabled',true);
            $("#h2").prop('disabled',true);
            $("#pa").prop('disabled',true);
            $("#sh").prop('disabled',true);
        }
        if(xu=='H1'){
            $("#sn").prop('disabled',false);
            $("#h1").prop('disabled',true);
            $("#ko").prop('disabled',true);
            $("#h2").prop('disabled',true);
            $("#pa").prop('disabled',true);
            $("#sh").prop('disabled',true);
        }
        if(xu=='KO'){
            $("#sn").prop('disabled',false);
            $("#h1").prop('disabled',false);
            $("#ko").prop('disabled',true);
            $("#h2").prop('disabled',true);
            $("#pa").prop('disabled',true);
            $("#sh").prop('disabled',true);
        }
        if(xu=='H2'){
            $("#sn").prop('disabled',false);
            $("#h1").prop('disabled',false);
            $("#ko").prop('disabled',false);
            $("#h2").prop('disabled',true);
            $("#pa").prop('disabled',true);
            $("#sh").prop('disabled',true);
        }
        if(xu=='PA'){
            $("#sn").prop('disabled',false);
            $("#h1").prop('disabled',false);
            $("#ko").prop('disabled',false);
            $("#h2").prop('disabled',false);
            $("#pa").prop('disabled',true);
            $("#sh").prop('disabled',true);
        }
        if(xu=='SH'){
            $("#sn").prop('disabled',false);
            $("#h1").prop('disabled',false);
            $("#ko").prop('disabled',false);
            $("#h2").prop('disabled',false);
            $("#pa").prop('disabled',false);
            $("#sh").prop('disabled',false);
        }
    });
    $("#updatesupplier").click(function() {
        // var aktif = $("#aktif").prop('checked') ? 1 : 0;
        if ($("#dept_act").val() == '') {
            pesan('Departemen harus di isi !', 'error');
            return;
        }
        if ($("#id_kategori").val() == '') {
            pesan('Kategori harus di isi !', 'error');
            return;
        }
        if($("#dept_act").val()=='FN'){
            if ($("#sublok").val() == '') {
                pesan('Sub lokasi harus di isi !', 'error');
                return;
            }
        }
        if($("#dept_act").val()=='GW'){
            if ($("#asal").val() == '') {
                pesan('Asal lokasi Waste harus di isi !', 'error');
                return;
            }
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'setcost/simpandata',
            data: {
                dept_id: $("#dept_act").val(),
                idkat: $("#id_kategori").val(),
                sublok: $("#sublok").val(),
                asal: $("#asal").val(),
                sp: $("#sp").prop('checked') ? 1 : 0,
                rr: $("#rr").prop('checked') ? 1 : 0,
                nt: $("#nt").prop('checked') ? 1 : 0,
                sn: $("#sn").prop('checked') ? 1 : 0,
                h1: $("#h1").prop('checked') ? 1 : 0,
                ko: $("#ko").prop('checked') ? 1 : 0,
                h2: $("#h2").prop('checked') ? 1 : 0,
                pa: $("#pa").prop('checked') ? 1 : 0,
                sh: $("#sh").prop('checked') ? 1 : 0,
            },
            success: function(data) {
                window.location.reload();

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>