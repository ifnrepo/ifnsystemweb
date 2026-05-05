<div class="container-xl font-kecil  ">
    <div id="tempatcari" class="">
        <div class="row">
            <div class="col-12 m-0">
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">Notes</label>
                    <div class="col"> 
                        <form name="formdok" id="formdok" action="<?= base_url().'ponet/simpannotes' ?>" method="post" enctype="multipart/form-data">
                            <input type="text" name="idpo" id="idpo" class="hilang" value="<?= $data['id'] ?>">
                            <textarea name="ppic_notes" id="ppic_notes" class="form-control form-control-sm font-kecil btn-flat" rows="5"><?= trim($data['ppic_notes']) ?></textarea>
                            <input type="file" class="hidden hilang" accept=".pdf,.xls,.xlsx,.jpg,.jpeg,.png,.mp4" id="dok_file" name="dok_file[]" multiple>
                            <input type="checkbox" id="item1" name="item1" class="hilang" value="option1">
                        </form>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">Attachment</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil hilang" id="dok_lama" name="dok_lama" value=""  placeholder="Dok Lama" readonly>
                        <span id="kodenya"></span>
                        <div class="input-group">
                            <input type="text" class="form-control font-kecil btn-flat" value="" name="filepdf" id="filepdf" placeholder="Dokumen Terkait">
                            <button class="btn font-kecil btn-info btn-flat" id="btnget" type="button">Get File</button>
                        </div>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="cek1" >
                            <span class="form-check-label text-primary">Kosongkan Attachment</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- class="modal-footer font-kecil" -->
<hr class="m-0">
<div class="d-flex justify-content-between p-2 mt-0" >
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="simpannotes">Simpan Notes PPIC</button>
</div>
<script>
    $(document).ready(function(){

    })
    $("#dok_file").change(function () {
        var name = document.getElementById("dok_file");
        var cc = '';
        for (let ix = 0; ix < name.files.length; ix++) {
            cc += name.files.item(ix).name;
        }
        $("#filepdf").val(name.files.length+' File dipilih');
    });
    $("#btnget").click(function () {
        $("#dok_file").click();
        $("#dok_file").change();
    });
    $("#simpannotes").click(function() {
        //  var name = document.getElementById("dok");
        // alert(name.files.item(0).name);
        // alert(name.val());
        document.formdok.submit();
        // $.ajax({
        //     dataType: "json",
        //     type: "POST",
        //     url: base_url+"ponet/simpannotes",
        //     data: {
        //         id: $("#idpo").val(),
        //         notes: $("#isinotes").val()
        //     },
        //     success: function(data){
        //         // alert('berhasil');
        //         window.location.reload();
        //     },
        //     error: function(xhr, ajaxOptions, thrownError){
        //         pesan('Ada Error, '+xhr.status+', Hubungi IT','error');
        //         console.log(xhr.status);
		// 	    console.log(thrownError);
        //     }
        // })
    })
    $("#cek1").change(function(){
        if ($('#cek1').is(':checked')){
            // alert('CEK ON');
            $('#item1').prop('checked', true);
        }else{
            // alert('CEK OFF');
            $('#item1').prop('checked', false);
        }
    })
</script>