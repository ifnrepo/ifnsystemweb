<div class="container-xl"> 
    <div class="row">
        <div class="col-sm-6">
            <div class="m-2 font-bold d-flex justify-content-between">Data BC <span><a href="<?= base_url().'ib/ceisa40excel/'.$datheader['id']; ?>" id="keexcel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a><a href="#" class="btn btn-sm btn-yellow"><i class="fa fa-cloud mr-1"></i> Host2Host</a></span></div>
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
                    <label class="col-3 col-form-label font-kecil">Jenis DOK BC</label>
                    <div class="col font-kecil">
                        <select class="form-select font-kecil font-bold" name="jns_bc" id="jns_bc">
                            <option value="">Pilih Jenis BC</option>
                            <?php foreach ($bcmasuk->result_array() as $bcmas) { ?>
                                <?php $selek = $datheader['jns_bc']==$bcmas['jns_bc'] ? 'selected' : ''; ?>
                                <option value="<?= $bcmas['jns_bc']; ?>" <?= $selek; ?>><?= $bcmas['ket_bc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label font-kecil">No/Tgl AJU</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" value="<?= $datheader['nomor_aju']; ?>" aria-describedby="emailHelp" placeholder="No AJU">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control font-kecil tgl" id="tgl_aju" name="tgl_aju" value="<?= tglmysql($datheader['tgl_aju']); ?>" aria-describedby="emailHelp" placeholder="Tgl AJU">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label font-kecil">No/Tgl BC</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" value="<?= $datheader['nomor_bc']; ?>" aria-describedby="emailHelp" placeholder="No AJU">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control font-kecil tgl" id="tgl_bc" name="tgl_bc" value="<?= tglmysql($datheader['tgl_bc']); ?>" aria-describedby="emailHelp" placeholder="Tgl AJU">
                    </div>
                </div>
            </div>
            <div class="mb-1 mt-1 row">
                <label class="col-3 col-form-label font-kecil">Angkutan</label>
                <div class="col font-kecil">
                    <select class="form-select font-kecil font-bold" name="jns_angkutan" id="jns_angkutan">
                        <option value="">Pilih Angkutan</option>
                        <?php foreach ($jnsangkutan->result_array() as $angkut) { ?>
                            <option value="<?= $angkut['id']; ?>" <?php if($angkut['id']==$datheader['jns_angkutan']){ echo "selected"; } ?>><?= $angkut['angkutan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Jenis Angkutan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="angkutan" name="angkutan" value="<?= $datheader['angkutan']; ?>" aria-describedby="emailHelp" placeholder="Angkutan">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="no_kendaraan" name="no_kendaraan" value="<?= $datheader['no_kendaraan']; ?>" aria-describedby="emailHelp" placeholder="No Kendaraan">
                </div>
            </div>
            <div class="mb-0 row">
                <label class="col-3 col-form-label font-kecil">Kgs / Volume</label>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil">Bruto</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil inputangka text-right" id="bruto" name="bruto" value="<?= rupiah($datheader['bruto'],2); ?>" aria-describedby="emailHelp" placeholder="Bruto Kgs">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil">Netto</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil inputangka text-right" id="netto" name="netto" value="<?= rupiah($datheader['netto'],2); ?>" aria-describedby="emailHelp" placeholder="Netto Kgs">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-1 mt-0 row">
                <label class="col-3 col-form-label font-kecil">Jumlah Kemas</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" id="jml_kemasan" name="jml_kemasan" value="<?= rupiah($datheader['jml_kemasan'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas">
                </div>
                <div class="col">
                    <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                    <select class="form-select font-kecil font-bold" name="kd_kemasan" id="kd_kemasan">
                        <option value="">Pilih Kemasan</option>
                        <?php foreach ($refkemas->result_array() as $kemas) { ?>
                            <option value="<?= $kemas['kdkem']; ?>" <?php if($kemas['kdkem']==$datheader['kd_kemasan']){ echo "selected"; } ?>><?= $kemas['kdkem'].' # '.$kemas['kemasan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <hr class="m-0">
            <div class="mb-1 mt-1 row">
                <label class="col-3 col-form-label font-kecil">Nilai Pabean / CIF</label>
                <div class="col">
                    <!-- <input type="text" class="form-control font-kecil" id="netto" name="netto" aria-describedby="emailHelp" placeholder="Netto Kgs"> -->
                    <select class="form-select font-kecil font-bold" name="mtuang" id="mtuang">
                        <option value="">Pilih</option>
                        <?php foreach ($refmtuang->result_array() as $mtuang) { ?>
                            <option value="<?= $mtuang['id']; ?>" <?php if($mtuang['id']==$datheader['mtuang']){ echo "selected"; } ?>><?= $mtuang['mt_uang']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" id="totalharga" name="totalharga" value="<?= rupiah($datheader['totalharga'],0); ?>" aria-describedby="emailHelp" placeholder="Jml Kemas">
                </div>
            </div>
            <div class="mb-1 pt-1 row bg-cyan-lt">
                <label class="col-3 col-form-label font-kecil">NDPBM</label>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil">USD</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil inputangka text-right" id="kurs_usd" name="kurs_usd" value="<?= rupiah($datheader['kurs_usd'],0); ?>" aria-describedby="emailHelp" placeholder="Kurs USD">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil">IDR</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil inputangka text-right" id="kurs_idr" name="kurs_idr" value="<?= rupiah($datheader['kurs_idr'],0); ?>" aria-describedby="emailHelp" placeholder="Kurs IDR">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-1 pt-1 row bg-yellow-lt ">
                <label class="col-3 col-form-label font-kecil text-black">Nilai DEVISA</label>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil text-black">USD</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil inputangka text-right" id="devisa_usd" name="devisa_usd" value="<?= rupiah($datheader['devisa_usd'],2); ?>" aria-describedby="emailHelp" placeholder="Devisa USD" disabled>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label font-kecil text-black">IDR</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right" id="devisa_idr" name="devisa_idr" value="<?= rupiah($datheader['devisa_idr'],2); ?>" aria-describedby="emailHelp" placeholder="Devisa IDR" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="m-2 font-bold d-flex justify-content-between">Detail Barang</div>
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
        </div>
    </div>
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
    $(".inputangka").on("change click keyup input paste", function (event) {
        $(this).val(function (index, value) {
            return value
                .replace(/(?!\.)\D/g, "")
                .replace(/(?<=\..*)\./g, "")
                .replace(/(?<=\.\d\d).*/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    $("#keexcel").click(function(){
        if($("#jns_bc").val() == '' || $("#nomor_aju").val() == '' || $("#tgl_aju").val() == ''){
            pesan('Isi dahulu jenis BC serta nomor/tgl Aju !','error');
            alert(generatekodeaju());
            return false;
        }
    });
    $("#jns_bc").change(function(){
        savedata('jns_bc',$(this).val());
    });
    $("#mtuang").change(function(){
        savedata('mtuang',$(this).val());
        hitungdevisa();
    });
    $("#nomor_aju").blur(function(){
        if($(this).val() != ''){
            var jadi = isikurangnol($(this).val());
            $(this).val(jadi) ;
            savedata('nomor_aju',$(this).val());
        }
    });
    $("#tgl_aju").change(function(){
            savedata('tgl_aju',tglmysql($(this).val()));
    });
    // $("#nomor_bc").blur(function(){
    //     if($(this).val() != ''){
    //         var jadi = isikurangnol($(this).val());
    //         $(this).val(jadi) ;
    //         savedata('nomor_bc',$(this).val());
    //     }
    // });
    // $("#tgl_bc").change(function(){
    //         savedata('tgl_bc',tglmysql($(this).val()));
    // });
    $("#jns_angkutan").change(function(){
        savedata('jns_angkutan',$(this).val());
    });
    $("#angkutan").blur(function(){
        savedata('angkutan',$(this).val());
    });
    $("#no_kendaraan").blur(function(){
        savedata('no_kendaraan',$(this).val());
    });
    $("#bruto").blur(function(){
        savedata('bruto',toAngka($(this).val()));
    });
    $("#netto").blur(function(){
        savedata('netto',toAngka($(this).val()));
    });
    $("#kd_kemasan").change(function(){
        savedata('kd_kemasan',$(this).val());
    });
    $("#jml_kemasan").blur(function(){
        savedata('jml_kemasan',toAngka($(this).val()));
    });
    $("#kurs_usd").blur(function(){
        savedata('kurs_usd',toAngka($(this).val()));
    });
    $("#kurs_idr").blur(function(){
        savedata('kurs_idr',toAngka($(this).val()));
    });
    $("#devisa_usd").blur(function(){
        savedata('devisa_usd',toAngka($(this).val()));
    });
    $("#devisa_idr").blur(function(){
        savedata('devisa_idr',toAngka($(this).val()));
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
    function savedata(kolom,data){
        $("#keteranganerr").text('Loading ..!');
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'ib/updatebykolom/'+kolom,
            data: {
                id: $("#id_header").val(),
                isinya: data,
            },
            success: function(data){
                $("#keteranganerr").text('Data Saved ..!');
                setTimeout(() => {
                    $("#keteranganerr").text('');
                }, 3000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }
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
    function isikurangnol(val){
        var nol = "0";
        var jnsbc = nol.repeat(6 - val.length) + val;
        return jnsbc;
    }
    function hitungdevisa(){
        var xu = $("#mtuang").val();
        switch (xu) {
            case '1': //IDR
                tothar = parseFloat(toAngka($("#totalharga").val()));
                devidr = parseFloat(toAngka($("#kurs_idr").val()));
                devusd = parseFloat(toAngka($("#kurs_usd").val()));
                $("#devisa_usd").val(rupiah((tothar/devusd).toFixed(2),'.',',',3));
                $("#devisa_idr").val(rupiah((tothar*devidr).toFixed(2),'.',',',2));
                break;
            case '2': //USD
                tothar = parseFloat(toAngka($("#totalharga").val()));
                devidr = parseFloat(toAngka($("#kurs_idr").val()));
                devusd = parseFloat(toAngka($("#kurs_usd").val()));
                $("#devisa_idr").val(rupiah((tothar*devusd).toFixed(2),'.',',',3));
                $("#devisa_usd").val(rupiah((tothar/devidr).toFixed(2),'.',',',2));
                break;
            default:
                break;
        }
        $("#devisa_idr").blur();
        $("#devisa_usd").blur();
    }
</script>