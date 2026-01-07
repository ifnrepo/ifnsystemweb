<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <input id="id" class="btn btn-sm btn-danger hilang" value="<?= $data['id']; ?>">
            <input id="id_header" class="btn btn-sm btn-danger hilang" value="<?= $data['id_header']; ?>">
            <input id="id_detail" class="btn btn-sm btn-danger hilang" value="<?= $data['id_detail']; ?>">
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Spec Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" value="<?= $data['nama_barang']; ?>" placeholder="Spec Barang" disabled>
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">SKU</label>
                <div class="col">
                    <?php $sku = trim($data['po'])=='' ? namaspekbarang($data['id_barang'],'kode') : viewsku($data['po'],$data['item'],$data['dis']); ?>
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="<?= $sku; ?>" placeholder="Spec Barang" disabled>
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Satuan</label>
                <div class="col">
                    <select name="id_satuan" id="id_satuan" class="form-control font-kecil form-select btn-flat">
                        <option value="">Pilih Satuan</option>
                        <?php foreach ($satuan as $sat) { $selek = $sat['id']==$data['id_satuan'] ? 'selected' : ''; ?>
                            <option value="<?= $sat['id']; ?>" <?= $selek ?>><?= $sat['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-sm-6 mb-1">
                    <div class="row font-kecil mb-1">
                        <label class="col-2 col-form-label">Pcs</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right font-bold inputangka" id="pcs" value="<?= $data['pcs']; ?>" placeholder="Pcs">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-1">
                    <div class="row font-kecil mb-1">
                        <label class="col-2 col-form-label">Kgs</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil text-right font-bold inputangka" id="kgs" value="<?= round($data['kgs'],2); ?>" placeholder="Berat">
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-1">
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Insno</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil text-uppercase" id="insno" value="<?= $data['insno']; ?>" placeholder="Nomor Instruksi">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Nobontr</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil text-uppercase" id="nobontr" value="<?= $data['nobontr']; ?>" placeholder="Nomor IB">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">No Bale</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="nobale" value="<?= $data['nobale']; ?>" placeholder="Nomor Bale">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Exnet</label>
                <div class="col">
                    <select name="exnet" id="exnet" class="form-control font-kecil form-select btn-flat">
                            <option value="0" <?php if($data['exnet']==0){ echo "selected"; } ?>> Tidak</option>
                            <option value="1" <?php if($data['exnet']==1){ echo "selected"; } ?>>Ya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="updatedetailtemp" >Simpan Data</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
        $(".inputangka").on("change click keyup input paste", function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/(?!\.)\D/g, "")
                    .replace(/(?<=\..*)\./g, "")
                    .replace(/(?<=\.\d\d\d\d\d\d\d).*/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    })
    $("#updatedetailtemp").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/updategentemp",
            data: {
                id: $("#id").val(),
                id_header: $("#id_header").val(),
                id_detail: $("#id_detail").val(),
                pcs: toAngka($("#pcs").val()),
                kgs: toAngka($("#kgs").val()),
                sat: $("#id_satuan").val(),
                insno: $("#insno").val(),
                nobontr: $("#nobontr").val(),
                exnet: $("#exnet").val(),
                nobale: $("#nobale").val()
            },
            success: function (data) {
                // alert(data.jmlrek);
                var lokasi = base_url+'out/editdetailgenout/'+$("#id_detail").val()+'/'+$("#id_header").val()+'/1';
                window.location.replace(lokasi);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
    function toAngka(rp) {
        if (rp == "" || rp.trim() == "-") {
            return 0;
        } else {
            return rp.replace(/,*|\D/g, "");
        }
    }
</script>