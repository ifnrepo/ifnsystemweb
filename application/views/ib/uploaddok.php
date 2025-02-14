<div class="container-xl">
    <div class="row font-kecil">
        <div class="card mb-2">
            <div class="card-body font-kecil p-1">
                <div class="bg-primary-lt p-1 font-bold text-black mb-2">Upload Dokumen</div>
                <!-- <div class="mb-1 mt-1 row">
                    <label class="col-3 col-form-label">Nama</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil btn-flat" name="nama_di_ceisa" id="nama_di_ceisa" placeholder="Nama">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">Alamat</label>
                    <div class="col">
                        <textarea class="form-control font-kecil btn-flat" name="alamat_di_ceisa" id="alamat_di_ceisa" placeholder="Alamat"></textarea>
                    </div>
                </div> -->
                <form name="formdok" id="formdok" action="<?= $actiondok; ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id_header" id="id_header" value="<?= $data['id']; ?>">
                  <input type="file" class="hidden hilang" accept=".pdf" id="dok" name="dok">
                  <input type="text" class="form-control font-kecil hilang" id="dok_lama" name="dok_lama" value="<?= $data['filepdf']; ?>"  placeholder="Dok Lama" readonly>
                  <div class="input-group">
                    <input type="text" class="form-control font-kecil btn-flat" value="<?= $data['filepdf']; ?>" name="filepdf" id="filepdf" placeholder="Dokumen Terkait">
                    <button class="btn font-kecil btn-info btn-flat" id="btnget" type="button">Get File</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto font-kecil btn-flat" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary font-kecil btn-flat" id="simpandok">Simpan</button>
</div>
<script>
    $("#btnget").click(function () {
        $("#dok").click();
        $("#dok").change();
    });
    $("#dok").change(function () {
        var name = document.getElementById("dok");
        $("#filepdf").val(name.files.item(0).name);
    });
    $("#simpandok").click(function(){
        document.formdok.submit();
    });
</script>