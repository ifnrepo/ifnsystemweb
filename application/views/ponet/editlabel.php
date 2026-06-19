<div class="container-xl font-kecil">
    <?php $gambar = trim($data['gbrlogo'])!='' ? base_url().'assets/image/label/'.$data['gbrlogo'] : base_url().'assets/image/avatars/005f.jpg'; ?>
    <div class="card">
        <div class="card-body p-1">
            <div class="row">
                <div class="col-md-4 col-12">
                    <img src="<?= $gambar ?>" alt="OK" id="gbimage" style="height:180px; width: auto;">
                </div>
                <div class="col-md-8 col-12">
                    <form name="formFoto" id="formFoto" action="<?= base_url().'ponet/updatefoto' ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                        <h4 class="mb-2">Pilih Gambar Label</h4>
                        <div class="mb-2">
                            <div class="input-group">
                                <input type="hidden" class="form-control group-control" id="file_path" name="file_path">
                                <input type="file" class="hilang" accept="image/*" id="file" name="file" onchange="loadFile(event)">
                                <input type="hidden" name="old_logo" value="<?= $data['gbrlogo'] ?>">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control font-kecil btn-flat" value="<?= $data['gbrlogo'] ?>" name="filepdf" id="filepdf" placeholder="Dokumen Terkait">
                                <button class="btn font-kecil btn-info btn-flat" id="file_browser" type="button">Get File</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-danger btn-flat disabled" id="okesubmit"><i class="fa fa-check mr-1"></i> Update Foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#file_browser").click(function (e) {
		e.preventDefault();
		$("#file").click();
	});
	$("#file_path").click(function () {
		$("#file_browser").click();
	});
	$("#file").change(function () {
		$("#file_path").val($(this).val());
		$("#filepdf").val($(this).val());
	});

    var loadFile = function (event) {
        var output = document.getElementById("gbimage");
        var isifile = event.target.files[0];

        if (!isifile) {
            $("#okesubmit").addClass("disabled");
        } else {
            output.src = URL.createObjectURL(isifile);
            output.onload = function () {
                URL.revokeObjectURL(output.src);
            };
            $("#okesubmit").removeClass("disabled");
        }
    };
</script>