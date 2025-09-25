<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12 font-kecil">
            <form method="POST" action="<?= base_url() . 'hargamat/simpandata'; ?>" id="formhamat" name="formhamat" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nama Barang</label>
                            <input type="hidden" name="id_detail" id="id_detail">
                            <input type="text" class="form-control font-kecil" placeholder="Ketik Barang.." name="nama_barang" id="nama_barang">
                            <input type="hidden" name="id_barang" id="id_barang">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor IB</label>
                            <input type="text" class="form-control font-kecil" placeholder="Nomor IB" name="nobontr" id="nobontr">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Tgl IB</label>
                            <input type="text" class="form-control font-kecil" placeholder="Tanggal IB" name="tgl" id="tgl">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kategori Barang</label>
                            <input type="text" class="form-control font-kecil" name="nama_kategori" id="nama_kategori" placeholder="Kategori Barang">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Supplier</label>
                            <input type="text" class="form-control font-kecil" name="nama_supplier" id="nama_supplier" placeholder="Supllier">
                            <input type="hidden" name="id_supplier" id="id_supplier" placeholder="Supllier">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Currency</label>
                            <select class="form-select font-kecil font-bold btn-flat" name="mt_uang" id="mt_uang">
                                <option value="">Pilih Mata Uang</option>
                                <?php foreach ($refmtuang->result_array() as $mtuang) { ?>
                                    <option value="<?= $mtuang['mt_uang']; ?>"><?= $mtuang['mt_uang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kurs</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="kurs" placeholder="Input Kurs">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">CIF Barang</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="cif" placeholder="Input CIF">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Qty</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="qty" id="qty" placeholder="Input Qty">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kgs</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="weight" id="weight" placeholder="Input KGS">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" id="price" name="price" placeholder="Input Harga">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga Lainnya </label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="oth_amount" placeholder="Input Amount">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor Invoice</label>
                            <input type="text" class="form-control font-kecil" name="nomor_inv" id="nomor_inv">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-white">.</label>
                            <label class="form-check form-check-inline m-2">
                                <input class="form-check-input" type="checkbox" id="co" name="co">
                                <span class="form-check-label text-blue font-bold">Certificate Of Origin</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="nomor_co_wrapper" style="display: none;">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">
                        Nomor Certificate Of Origin
                    </label>
                    <input type="text" class="form-control font-kecil" name="nomor_co" id="nomor_co" placeholder="Certificate Of Origin">
                </div>

                <div class="row">
                    <div class="mb-3">
                        <label class="form-label font-kecil mb-0 font-bold text-primary">Noted</label>
                        <input type="text" class="form-control font-kecil" name="remark" placeholder="Keterangan">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label font-kecil mb-0 font-bold text-primary">Negara Produsen</label>
                        <select class="form-select font-kecil font-bold btn-flat" name="kode_negara" id="kode_negara">
                            <option value="">Pilih Negara</option>
                            <?php foreach ($refbendera->result_array() as $bendera) { ?>
                                <option value="<?= $bendera['kode_negara']; ?>"><?= $bendera['kode_negara'] . '-' . $bendera['uraian_negara']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Bm</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="bm" placeholder="Input BM">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Ppn</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="ppn" placeholder="Input Ppn">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Pph</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="pph" placeholder="Input Pph">
                        </div>
                    </div>
                </div>
                <fieldset class="form-fieldset bg-primary-lt">
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">Jenis BC</label>
                        <div class="col">
                            <select name="jns_bc" id="jns_bc" class="form-control font-kecil form-select">
                                <option value="">Pilih Jenis BC</option>
                                <?php foreach ($dokbc->result_array() as $dokb) { ?>
                                    <option class="font-bold text-primary" value="<?= $dokb['jns_bc']; ?>"><?= $dokb['ket_bc']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">Nomor BC</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" placeholder="Nomor BC">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control font-kecil tgl" id="tgl_bc" name="tgl_bc" placeholder="Tgl BC">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor Seri</label>
                                <input type="text" class="form-control font-kecil" name="seri_barang" id="seri_barang" placeholder="Seri Barang">

                            </div>
                        </div>
                        <div class="col-7">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor Aju</label>
                                <input type="text" class="form-control font-kecil" name="nomor_aju" id="nomor_aju" placeholder="Nomor Aju">
                            </div>
                        </div>
                        <div class=" col-3">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Tanggal Aju</label>
                                <input type="text" class="form-control font-kecil tgl" name="tgl_aju" id="tgl_aju">
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">DOK</label>
                        <div class="col">
                            <div class="input-group mb-2">
                                <input type="file" class="hidden hilang" accept=".pdf" id="dok" name="dok">
                                <input type="text" class="form-control font-kecil" id="namedok" name="namedok" placeholder="Dok Empty" readonly>
                                <input type="text" class="form-control font-kecil hilang" id="dok_lama" name="dok_lama" placeholder="Dok Lama" readonly>
                                <a href="#" class="btn btn-info font-kecil" id="getdok">Add/Edit</a>
                                <a href="#" class="btn btn-danger font-kecil" id="removedok">Remove</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil p-0 mx-2" style="display: flex;justify-content: space-between;">
    <a href="#" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</a>
    <button type="button" class="btn btn-sm btn-primary" id="simpanbarang">Simpan</button>
</div>
<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery/jquery-ui.min.js"></script>

<script>
    $(function() {
        $("#nama_barang").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url('hargamat/barang'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nama_barang + " - " + item.nomor_dok,
                                id_detail: item.id,
                                value: item.nama_barang,
                                id_barang: item.id_barang,
                                nomor_dok: item.nomor_dok,
                                tgl_ib: item.tgl,
                                id_supplier: item.ids,
                                nama_supplier: item.nama_supplier,
                                nama_kategori: item.nama_kategori,
                                qty: item.qty,
                                kgs: item.kgs,
                                harga: item.harga,
                                jns_bc: item.jns_bc,
                                nomor_bc: item.jns_bc,
                                tgl_bc: item.tgl_bc,
                                mt_uang: item.mt_uang
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $("#id_detail").val(ui.item.id_detail);
                $("#id_barang").val(ui.item.id_barang);
                $("#nobontr").val(ui.item.nomor_dok);
                $("#tgl").val(ui.item.tgl_ib);
                $("#id_supplier").val(ui.item.id_supplier);
                $("#nama_supplier").val(ui.item.nama_supplier);
                $("#nama_kategori").val(ui.item.nama_kategori);
                $("#qty").val(ui.item.qty);
                $("#weight").val(ui.item.kgs);
                $("#price").val(ui.item.harga);
                $("#jns_bc").val(ui.item.jns_bc);
                $("#nomor_bc").val(ui.item.nomor_bc);
                $("#tgl_bc").val(ui.item.tgl_bc);
                $("#mt_uang").val(ui.item.mt_uang);
            },
            minLength: 3
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".tgl").datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true
        });
        $("#nama_barang").focus();
    });
    $("#removedok").click(function() {
        $("#namedok").val('');
    });
    $("#getdok").click(function() {
        $("#dok").click();
        $("#dok").change();
    });
    $("#dok").change(function() {
        var name = document.getElementById('dok');
        $("#namedok").val(name.files.item(0).name);
    })
    $(".inputangka").on("change click keyup input paste", function(event) {
        $(this).val(function(index, value) {
            return value
                .replace(/(?!\.)\D/g, "")
                .replace(/(?<=\..*)\./g, "")
                .replace(/(?<=\.\d\d).*/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    $("#nomor_bc").blur(function() {
        var nobc = $("#nomor_bc").val();
        $(this).val(isikurangnol(nobc));
    });

    $("#simpanbarang").click(function(e) {
        e.preventDefault();

        let coChecked = $("#co").is(":checked");
        let nomorCo = $("#nomor_co").val().trim();

        if (coChecked && nomorCo === "") {
            alert("Nomor Certificate Of Origin wajib diisi!");
            $("#nomor_co").focus();
            return;
        }


        document.formhamat.submit();
    });



    function isikurangnol(val) {
        var nol = "0";
        var jnsbc = nol.repeat(6 - val.length) + val;
        return jnsbc;
    }

    document.getElementById('co').addEventListener('change', function() {
        let wrapper = document.getElementById('nomor_co_wrapper');
        if (this.checked) {
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
        }
    });
</script>