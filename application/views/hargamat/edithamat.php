<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12 font-kecil">
            <form method="POST" action="<?= base_url() . 'hargamat/updatehamat'; ?>" id="formhamat" name="formhamat" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id_hargamaterial" value="<?= $data['idx']; ?>">
                <div class="row">
                    <div class="col-10">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nama Barang</label>
                            <input type="text" class="form-control font-kecil" placeholder="Nama Barang KOSONG" value="<?= $data['nama_barang']; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0">ID Barang</label>
                            <input type="text" class="form-control font-kecil" placeholder="Input placeholder" value="<?= $data['idx'] . '-' . $data['id_barang']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Tgl IB</label>
                            <input type="text" class="form-control font-kecil" placeholder="Input placeholder" value="<?= tglmysql($data['tgl']); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor IB</label>
                            <input type="text" class="form-control font-kecil" placeholder="Input placeholder" value="<?= $data['nobontr']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="mb-1">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">Kategori Barang</label>
                    <input type="email" class="form-control font-kecil" value="<?= $data['nama_kategori']; ?>" placeholder="Kategori Barang" disabled>
                </div>
                <div class="mb-1">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">Supplier</label>
                    <input type="text" class="form-control font-kecil" value="<?= $data['nama_supplier']; ?>" disabled>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Currency</label>
                            <input type="text" class="form-control font-kecil" name="mt_uang" placeholder="Input placeholder" value="<?= $data['mt_uang']; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kurs</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="kurs" placeholder="Input Kurs" value="<?= rupiah($data['kurs'], 2); ?>">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">CIF</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="cif" placeholder="Input CIF" value="<?= rupiah($data['cif'], 2); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Qty</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="qty" placeholder="Input Qty" value="<?= rupiah($data['qty'], 0); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kgs</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="weight" placeholder="Input KGS" value="<?= rupiah($data['weight'], 2); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" id="price" name="price" placeholder="Input Harga" value="<?= rupiah($data['price'], 8); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga Lainnya (<?= $data['mt_uang']  ?>)</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="oth_amount" placeholder="Input Amount" value="<?= rupiah($data['oth_amount'], 2); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label font-kecil mb-0 font-bold text-primary">Noted</label>
                        <input type="text" class="form-control font-kecil" name="remark" placeholder="Keterangan" value="<?= $data['remark']; ?>">
                    </div>
                </div>
                <fieldset class="form-fieldset bg-primary-lt">
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">Jenis BC</label>
                        <div class="col">
                            <select name="jns_bc" id="jns_bc" class="form-control font-kecil form-select">
                                <option value="">Pilih Jenis BC</option>
                                <?php foreach ($dokbc->result_array() as $dokb) {
                                    $selek = $dokb['jns_bc'] == $data['jns_bc'] ? 'selected' : ''; ?>
                                    <option class="font-bold text-primary" value="<?= $dokb['jns_bc']; ?>" <?= $selek; ?>><?= $dokb['ket_bc']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor Seri</label>
                                <input type="text" class="form-control font-kecil text-end inputangka" name="seri_barang" id="seri_barang" placeholder="Seri Barang" value="<?= $data['seri_barang']; ?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor Aju</label>
                                <input type="text" class="form-control font-kecil text-end inputangka" name="nomor_aju" id="nomor_aju" placeholder="Nomor Aju" value="<?= $data['nomor_aju']; ?>">
                            </div>
                        </div>
                        <div class=" col-4">
                            <div class="mb-1">
                                <label class="form-label font-kecil mb-0 font-bold text-primary">Tanggal Aju</label>
                                <input type="text" class="form-control font-kecil tgl" value="<?= tglmysql($data['tgl_aju']); ?>" name="tgl_aju" id="tgl_aju" placeholder="Tanggal Aju">
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">Nomor BC</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control font-kecil" value="<?= $data['nomor_bc']; ?>" id="nomor_bc" name="nomor_bc" placeholder="Nomor BC">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control font-kecil tgl" value="<?= tglmysql($data['tgl_bc']); ?>" id="tgl_bc" name="tgl_bc" placeholder="Tgl BC">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-2 col-form-label font-bold">DOK</label>
                        <div class="col">
                            <div class="input-group mb-2">
                                <input type="file" class="hidden hilang" accept=".pdf" id="dok" name="dok">
                                <input type="text" class="form-control font-kecil" id="namedok" name="namedok" value="<?= $data['filedok']; ?>" placeholder="Dok Empty" readonly>
                                <input type="text" class="form-control font-kecil hilang" id="dok_lama" name="dok_lama" value="<?= $data['filedok']; ?>" placeholder="Dok Lama" readonly>
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
    $("#simpanbarang").click(function() {
        document.formhamat.submit();
    });

    function isikurangnol(val) {
        var nol = "0";
        var jnsbc = nol.repeat(6 - val.length) + val;
        return jnsbc;
    }
</script>