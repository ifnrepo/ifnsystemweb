<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" placeholder="Id Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="departemen" id="departemen" placeholder="Departemen">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori Dept</label>
                <div class="col">
                  <select name="katedept_id" id="katedept_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($katedept as $a) : ?>
                      <option value="<?= $a['id']; ?>"><?= $a['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>
            <div id="jikasubkon" class="hilang">
            <div class="hr m-0"></div>
                <div class="mb-1 row mt-1">
                    <label class="col-3 col-form-label required">Nama Subkon</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="nama_subkon" id="nama_subkon" placeholder="Nama">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label required">Alamat</label>
                    <div class="col">
                        <textarea name="alamat_subkon" id="alamat_subkon" class="form-control font-kecil" placeholder="Alamat"></textarea>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label required">NPWP</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="NPWP">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label required">PIC</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="pic" id="pic" placeholder="PIC">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label required">Jabatan</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="Jabatan PIC">
                    </div>
                </div>
            </div>
            <div class="hr m-0"></div>
            <div class="mt-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="pb" id="pb" type="checkbox" >
                        <span class="form-check-label">Bon Permintaan Barang / <strong>PB</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="bbl" id="bbl" type="checkbox" >
                        <span class="form-check-label">Bon Pembelian Barang / <strong>BBL</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="adj" id="adj" type="checkbox" >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="amb" id="amb" type="checkbox" >
                        <span class="form-check-label">Aju Masuk Barang / <strong>AMB</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="akb" id="akb" type="checkbox" >
                        <span class="form-check-label">Aju Keluar Barang / <strong>AKB</strong></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpandept">Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#katedept_id").change();
    })
    $("#simpandept").click(function() {
        var cekpb = $("#pb").prop('checked') ? '1' : '0';
        var cekbbl = $("#bbl").prop('checked') ? '1' : '0';
        var cekadj = $("#adj").prop('checked') ? '1' : '0';
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'dept/simpandept',
            data: {
                dept_id: $("#dept_id").val(),
                departemen: $("#departemen").val(),
                kat: $("#katedept_id").val(),
                sbk: $("#nama_subkon").val(),
                alamat_sbk: $("#alamat_subkon").val(),
                npwp: $("#npwp").val(),
                pic: $("#pic").val(),
                jabatan: $("#jabatan").val(),
                pb: cekpb,
                bbl: cekbbl,
                adj: cekadj
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
    $("#katedept_id").change(function(){
        var x = $(this).val();
        if(x==3){
            $("#jikasubkon").removeClass('hilang');
        }else{
            $("#jikasubkon").addClass('hilang');
        }
    })
</script>