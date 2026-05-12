<div class="container-xl font-kecil">
    <input id="id" class="btn btn-sm btn-danger hilang" value="<?= $data['id']; ?>">
    <input id="id_header" class="btn btn-sm btn-danger hilang" value="<?= $data['id_header']; ?>">
    <div class="row">
        <div class="col-8">
            <table class="table table-bordered m-0 mt-1 mb-1">
                <thead class="bg-primary-lt">
                    <!-- <tr>
                        <th class="text-center text-black" colspan="2"></th>
                    </tr> -->
                </thead>
                <tbody class="table-tbody">
                    <tr>
                        <td class="font-kecil">SKU</td>
                        <?php $sku = $data['id_barang']==0 ? viewsku($data['po'],$data['item'],$data['dis']) : $data['brg_id']; ?>
                        <td class="font-kecil font-bold text-blue"><?= $sku ?></td>
                    </tr>
                    <tr>
                        <td class="font-kecil">Spek Barang</td>
                        <?php $barang = $data['id_barang']==0 ? spekpo($data['po'],$data['item'],$data['dis']) : $data['nama_barang']; ?>
                        <td class="font-kecil font-bold"><?= $barang ?></td>
                    </tr>
                    <tr>
                        <td class="font-kecil">Insno</td>
                        <td class="font-kecil"><?= $data['insno'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-kecil">Nobontr</td>
                        <td class="font-kecil"><?= $data['nobontr'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-bordered m-0 mt-1 mb-1">
                <thead class="bg-primary-lt">
                    <!-- <tr>
                        <th class="text-center text-black" colspan="2"></th>
                    </tr> -->
                </thead>
                <tbody class="table-tbody">
                    <tr>
                        <td class="font-kecil">No Bale</td>
                        <td class="font-kecil font-bold"><?= $data['nobale'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-kecil">DLN</td>
                        <?php $dln = $data['dln']==0 ? 'Tidak' : 'Ya'; ?>
                        <td class="font-kecil font-bold"><?= $dln ?></td>
                    </tr>
                    <tr>
                        <td class="font-kecil">Stok</td>
                        <?php $stok = $data['stok']==0 ? '' : ($data['stok']==1 ? 'A' : 'B' ); ?>
                        <td class="font-kecil"><?= $stok ?></td>
                    </tr>
                    <tr class="<?php if(!str_contains($data['item'],'-1')){ echo "hilang"; } ?>">
                        <td class="font-kecil text-center" colspan="2"><a href="#" class="btn btn-sm btn-info" rel="<?= $data['po'] ?>" rel2="<?= $data['item'] ?>" id="hitungshitate" style="padding: 4px 6px !important;" title="Akan otomatis menghitung berat jala setelah digabung">Hitung Berat Jala Shitate</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="m-1">
        <div class="col-12">
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Pcs</label>
                <div class="col">
                    <input type="text" class="form-control font-bold font-kecil text-right inputangka" id="pcs" name="pcs" value="<?= rupiah($data['pcs'],2) ?>" placeholder="Pcs Barang">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-bold font-kecil text-right inputangka" id="kgs" name="kgs" value="<?= rupiah($data['kgs'],2) ?>" placeholder="Kgs Barang">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="updatedetail" >Simpan Data</button>
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
    $("#updatedetail").click(function(){
        var kgs = parseFloat(toAngka($("#kgs").val()));
        var pcs = parseFloat(toAngka($("#pcs").val()));
        if(kgs==0){
            pesan('Kgs Harus di isi','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/updatedetailbaru",
            data: {
                id: $("#id").val(),
                pcs: toAngka($("#pcs").val()),
                kgs: toAngka($("#kgs").val()),
            },
            success: function (data) {
                // alert(data.jmlrek);
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
    $("#hitungshitate").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/getberatshitate",
            data: {
                po: $(this).attr('rel'),
                item: $(this).attr('rel2'),
                pcs: toAngka($("#pcs").val()),
                kgs: toAngka($("#kgs").val()),
            },
            success: function (data) {
                pesan('Kgs diupdate dengan Berat Jala A+B !','info');
                $("#kgs").val(data);
                $("#hitungshitate").addClass('disabled');
                // window.location.reload();
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