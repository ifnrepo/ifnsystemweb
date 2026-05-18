<div class="modal-body pt-1 pb-1 mb-1">
    <div class="row">
        <div class="mb-1 row font-kecil">
            <label class="col-3 col-form-label">Departemen</label>
            <div class="col">
                <input type="text" class="form-control font-kecil btn-flat" name="dept" id="dept" placeholder="Departemen" value="<?= datadepartemen($this->session->userdata('deptstok'),'departemen') ?>" readonly>
            </div>
        </div>
        <div class="mb-1 row font-kecil">
            <label class="col-3 col-form-label">User Input</label>
            <div class="col">
                <input type="text" class="form-control font-kecil btn-flat" name="userstok" id="userstok" value="<?= datauser($this->session->userdata('id'),'name') ?>" placeholder="User" readonly>
            </div>
        </div>
        <div class="mb-1 row font-kecil">
            <label class="col-3 col-form-label">Periode</label>
            <div class="col">
                <input type="text" class="form-control font-kecil btn-flat" name="tglperiode" id="tglperiode" value="<?= $this->session->userdata('periodeopname') ?>" placeholder="Tanggal" readonly>
                <div class="invalid-feedback mt-0" id="error-tglperiode">Tgl harus di isi</div>
            </div>
        </div>
        <div class="mb-1 row font-kecil">
            <label class="col-3 col-form-label">Keterangan</label>
            <div class="col">
                <select name="idlokasi" id="idlokasi" name="idlokasi" class="form-control form-select font-kecil">
                    <option value="">-- Pilih Sublok --</option>
                    <?php foreach($lokasi->result_array() as $lok): ?>
                        <option value="<?= $lok['kode_lokasi'] ?>"><?= $lok['kode_lokasi'].'-'.$lok['nama_lokasi'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <hr class="m-1">
        <div class="col-12 text-end">
            <a href="#" class="btn btn-sm btn-success" id="simpanstok" style="width:55px;">Simpan</a>
            <a href="#" class="btn btn-sm btn-danger" id="batalsimpan" data-bs-dismiss="modal" style="width:55px;">Batal</a>
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
    $("#simpanstok").click(function(){
            if($("#idlokasi").val()==''){
                pesan('Pilih sublok terlebih dahulu !','info');
                return false;
            }
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "opname/simpanstok",
                data: {
                    tgl: $("#tglperiode").val(),
                    kodelokasi: $("#idlokasi").val()
                },
                success: function (data) {
                    pesan('Data Berhasil disimpan !','info');
                    window.location.reload();
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