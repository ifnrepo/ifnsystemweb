<div class="container-fluid w-100">
    <div class="card m-2">
        <div class="row">
            <div class="col-md-4">
                <div class="card-body p-2">
                    <div class="card card-active">
                        <div class="card-body p-2">
                            <h4 class="mb-2">Form Input On Machine</h4>
                            <hr class="m-1">
                            <div class="row mb-1">
                                <label class="col-3 col-form-label font-kecil font-bold">No Mesin</label>
                                <div class="col mb-1">
                                    <select name="machno" id="machno" class="form-control form-select btn-flat font-kecil">
                                        <option value="">-- Pilih Mesin --</option>
                                        <?php foreach($mesin->result_array() as $msn): ?>
                                            <option value="<?= $msn['mach_no'] ?>"><?= $msn['mach_no'].' - '.$msn['specifik'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div id="form-cari">
                                <hr class="m-1">
                                <div class="d-flex justify-content-between">
                                    <label class="form-check form-check-inline hilang">
                                        <input class="form-check-input" type="radio" value="cariidbarang" name="radios-filter">
                                        <span class="form-check-label font-kecil font-bold">ID Barang</span>
                                    </label>
                                    <label class="form-check form-check-inline hilang">
                                        <input class="form-check-input" type="radio" value="caripo" name="radios-filter" checked>
                                        <span class="form-check-label font-kecil font-bold">PO / Insno</span>
                                    </label>
                                    <label class="form-check form-check-inline hilang">
                                        <input class="form-check-input" type="radio" value="carispek" name="radios-filter">
                                        <span class="form-check-label font-kecil font-bold">Spek Barang</span>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="keywordinputstok" placeholder="Cari PO atau Instruksi…">
                                    <button class="btn btn-blue btn-flat font-kecil" type="button" id="cariinputstok">Cari !</button>
                                    <button href="#" class="hilang" id="caribarangdouble" data-bs-target="#modal-large" data-bs-toggle="modal" data-title="Pilih">caribarang</button>
                                </div>
                            </div>
                            <div id="form-hasilcari">
                                <hr class="m-1">
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                                    <div class="col mb-1">
                                        <input type="text" class="hilang" name="idbarang" id="idbarang">
                                        <input type="text" class="hilang" name="po" id="po">
                                        <input type="text" class="hilang" name="item" id="item">
                                        <input type="text" class="hilang" name="dis" id="dis">
                                        <input type="text" class="hilang" name="dln" id="dln">
                                        <input type="text" class="hilang" name="identristok" id="identristok">
                                        <input type="text" name="sku" id="sku" class="form-control btn-flat font-bold font-kecil" value="" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Spek Barang</label>
                                    <div class="col mb-1">
                                        <!-- <input type="text" name="spek" id="spek" class="form-control btn-flat font-bold font-kecil" value=""> -->
                                        <textarea name="spek" id="spek" class="form-control btn-flat font-kecil"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Color</label>
                                    <div class="col mb-1">
                                        <input type="text" name="color" id="color" class="form-control btn-flat font-kecil" value="" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Insno</label>
                                    <div class="col mb-1">
                                        <input type="text" name="insno" id="insno" class="form-control btn-flat font-kecil" value="">
                                    </div>
                                </div>
                                <!-- <hr class="m-1">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-ghost-danger btn-flat" data-dissmiss="modal" id="resetinputstok">Reset</a>
                                    <a href="#" class="btn btn-sm btn-success btn-flat" id="simpaninputstok">Simpan</a>
                                    <a href="#" class="btn btn-sm btn-info btn-flat hilang" id="updateinputstok">Update</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card m-2">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2" id="cardkosong" style="min-height: 329px !important;">
                        <h2 class="text-secondary">Pilih PO/Instruksi</h2>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2 hilang" id="cardisi" style="min-height: 329px !important;">
                        <h2 class="text-secondary">Ketemu</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // alert('Masuk');
    })
    $("#machno").change(function(){
        cekisidata();
    });
    $("#po").change(function(){
        cekisidata();
    });
    function cekisidata(){
        if($("#machno").val()!='' && $("#po").val()!=''){
            alert('Isi');
        }
    }
</script>