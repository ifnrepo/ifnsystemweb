<div class="container-xl"> 
    <div class="m-2 font-bold d-flex justify-content-between">Detail <span><a href="<?= base_url().'ib/ceisa40excel'; ?>" id="keexcel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="<?= base_url().'ib/ceisa40excel'; ?>" id="keexcel" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> Host2Host</a></span></div>
    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader['id']; ?>">
    <input type="hidden" name="tgl" id="tgl" value="<?= $datheader['tgl']; ?>">
    <hr class="m-0">
    <div class="p-2 font-kecil">
        Nama Pengirim : <?= $datheader['namasupplier']; ?><br>
        Alamat Pengirim : <?= $datheader['alamat']; ?></br>
        NPWP : <?= $datheader['npwp']; ?>
    </div>
    <hr class="m-0">
    <hr class="m-0">
    <div class="bg-teal-lt px-2 py-1 mt-1">
        <div class="mb-1 mt-3 row">
            <label class="col-3 col-form-label font-kecil required">Jenis DOK BC</label>
            <div class="col font-kecil">
                <select class="form-select font-kecil font-bold" name="jns_bc" id="jns_bc">
                    <option value="">Pilih Jenis BC</option>
                    <?php foreach ($bcmasuk->result_array() as $bcmas) { ?>
                        <option value="<?= $bcmas['jns_bc']; ?>"><?= $bcmas['ket_bc']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-kecil required">No/Tgl AJU</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" aria-describedby="emailHelp" placeholder="No AJU">
            </div>
            <div class="col">
                <input type="text" class="form-control font-kecil tgl" id="tgl_aju" name="tgl_aju" aria-describedby="emailHelp" placeholder="Tgl AJU">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-kecil">No/Tgl BC</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" aria-describedby="emailHelp" placeholder="No AJU">
            </div>
            <div class="col">
                <input type="text" class="form-control font-kecil tgl" id="tgl_bc" name="tgl_bc" aria-describedby="emailHelp" placeholder="Tgl AJU">
            </div>
        </div>
    </div>
    <div class="mb-1 mt-1 row">
        <label class="col-3 col-form-label font-kecil">Jenis Angkutan</label>
        <div class="col font-kecil">
            <select class="form-select font-kecil font-bold" name="jns_angkutan" id="jns_angkutan">
                <option value="">Pilih Jenis Angkutan</option>
                <option value="2">LAUT</option>
                <option value="2">DARAT</option>
                <option value="3">UDARA</option>
                <option value="9">LAINNYA</option>
            </select>
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-3 col-form-label font-kecil required">Angkutan</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="angkutan" name="angkutan" aria-describedby="emailHelp" placeholder="Angkutan">
        </div>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="no_kendaraan" name="no_kendaraan" aria-describedby="emailHelp" placeholder="No Kendaraan">
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-3 col-form-label font-kecil required">Kgs / Volume</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="bruto" name="bruto" aria-describedby="emailHelp" placeholder="Bruto Kgs">
        </div>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs">
        </div>
    </div>
    <div class="mb-1 row">
        <label class="col-3 col-form-label font-kecil required">Jumlah Kemas</label>
        <div class="col">
            <input type="text" class="form-control font-kecil" id="bruto" name="bruto" aria-describedby="emailHelp" placeholder="Bruto Kgs">
        </div>
        <div class="col">
            <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
            <select class="form-select font-kecil font-bold" name="jns_angkutan" id="jns_angkutan">
                <option value="">Pilih Jenis Angkutan</option>
                <option value="2">LAUT</option>
                <option value="2">DARAT</option>
                <option value="3">UDARA</option>
                <option value="9">LAINNYA</option>
            </select>
        </div>
    </div>
    <table class="table datatable6 table-hover mb-3" id="cobasisip">
        <thead style="background-color: blue !important">
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Pcs</th>
                <th>Kgs</th>
            </tr>
        </thead>
        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
            <?php foreach ($header as $data) { ?>
                <tr>
                    <td><?= $data['nama_barang']; ?></td>
                    <td><?= $data['nama_kategori']; ?></td>
                    <td><?= $data['namasatuan']; ?></td>
                    <td><?= rupiah($data['pcs'],2); ?></td>
                    <td><?= rupiah($data['kgs'],2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
        <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
        <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Simpan</a>
    </div>
    <div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".tgl").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true
        });
    })
    $("#keexcel").click(function(){
        if($("#jns_bc").val() == '' || $("#nomor_aju").val() == '' || $("#tgl_aju").val() == ''){
            pesan('Isi dahulu jenis BC serta nomor/tgl Aju !','error');
            alert(generatekodeaju());
            return false;
        }
    });
    $("#simpanhakbc").click(function(){
        if($("#jns_bc").val() == ''){
            $("#keteranganerr").text('Pilih Jenis BC !');
            return false;
        }
        if($("#nomor_aju").val() == '' || $("#tgl_aju").val() == ''){
            $("#keteranganerr").text('isi Nomor Aju dan Tanggal Aju !');
            return false;
        }
        if($("#nomor_bc").val() == '' || $("#tgl_bc").val() == ''){
            $("#keteranganerr").text('isi Nomor BC dan Tanggal BC !');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'ib/simpandatanobc',
            data: {
                id: $("#id_header").val(),
                jns: $("#jns_bc").val(),
                aju: $("#nomor_aju").val(),
                tglaju: $("#tgl_aju").val(),
                bc: $("#nomor_bc").val(),
                tglbc: $("#tgl_bc").val(),
            },
            success: function(data){
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    function generatekode() {
        var nol = "0";
        var jnsbc =
            $("#jns_bc").val() == ""
                ? "000000"
                : nol.repeat(6 - $("#jns_bc").val().length) + $("#jns_bc").val();
        var tglbc =
            $("#tgl_bc").val() == ""
                ? "00000000"
                : tglmysql($("#tgl_bc").val()).replace(/-/g, "");
        var nobc = $("#nomor_bc").val() == "" ? "000000" : $("#nomor_bc").val();
        // alert(jnsbc + "-010017-" + tglbc + "-" + nobc);
        return jnsbc + "-010017-" + tglbc + "-" + nobc;
    }
    function generatekodeaju() {
        var nol = "0";
        var jnsbc =
            $("#jns_bc").val() == ""
                ? "000000"
                : nol.repeat(6 - $("#jns_bc").val().length) + $("#jns_bc").val();
        var tglbc =
            $("#tgl_aju").val() == ""
                ? "00000000"
                : tglmysql($("#tgl_aju").val()).replace(/-/g, "");
        var nobc = $("#nomor_aju").val() == "" ? "000000" : nol.repeat(6 - $("#nomor_aju").val().length) + $("#nomor_aju").val();
        // alert(jnsbc + "-010017-" + tglbc + "-" + nobc);
        return jnsbc + "-010017-" + tglbc + "-" + nobc;
    }
</script>