<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12" id="caribarang">
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Cari Berdasarkan</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="cari_by" name="cari_by">
                        <option value="0">Specific</option>
                        <option value="1">ID</option>
                        <option value="2">PO</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">Keyword</label>
                <div class="col input-group">
                    <input type="text" class="form-control font-kecil inputangka" name="keyw" id="keyw" placeholder="Cari.." >
                    <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a>
                </div>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable6" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Pilih</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                    <tr>
                        <td colspan="4" class="text-center">No Data / Cari dahulu data</td>
                    </tr>
                </tbody>
              </table>
            </div>
        </div>
        <div class="col-12 hilang" id="databarang">
            <input type="text" id="id_barang" name="id_barang" class="hilang">
            <input type="text" id="po" name="po" class="hilang">
            <input type="text" id="item" name="item" class="hilang">
            <input type="text" id="dis" name="dis" class="hilang">
            <input type="text" id="weightjala" name="weightjala" class="hilang">
            <div class="row font-kecil mb-0" id="cont-spek">
                <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                <div class="col input-group mb-1 text-teal font-bold mt-2" id="skubarangnya">XXXX YYYY</div>
            </div>
            <div class="row font-kecil mb-0" id="cont-spek">
                <label class="col-3 col-form-label font-kecil font-bold">Spesifikasi Barang</label>
                <div class="col input-group mb-1 text-teal font-bold mt-2" id="spekbarangnya">XXXX YYYY</div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-3 col-form-label font-bold">Satuan</label>
                <div class="col">
                    <select name="id_satuan" id="id_satuan" class="form-control font-kecil form-select btn-flat">
                        <option value="">Pilih Satuan</option>
                        <?php foreach ($satuan as $sat) { ?>
                            <option value="<?= $sat['id']; ?>"><?= $sat['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                    <div class="row font-kecil">
                        <div class="col-6">
                            <div class="mb-0">
                                <label class="form-label font-kecil mb-1 font-bold">Qty</label>
                                <div>
                                    <input type="text" class="form-control font-kecil btn-flat" id="pcs" name="pcs"  autocomplete="off" aria-describedby="emailHelp" placeholder="Qty">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-0">
                                <label class="form-label font-kecil mb-1 font-bold">Kgs</label>
                                <div>
                                    <input type="text" class="form-control font-kecil btn-flat" id="kgs" name="kgs"  autocomplete="off" aria-describedby="emailHelp" placeholder="Kgs">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-3 col-form-label font-bold">Insno</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="insno" name="insno"  autocomplete="off" aria-describedby="emailHelp" placeholder="Nomor instruksi">
                </div>
            </div>
            <div class="row font-kecil mb-1">
                <label class="col-3 col-form-label font-bold">Nomor IB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="nobontr" name="nobontr"  autocomplete="off" aria-describedby="emailHelp" placeholder="Nomor Input Barang">
                </div>
            </div>
            <?php if($this->session->userdata('deptsekarang')=='GF'): ?>
                <div class="row font-kecil mb-1">
                    <label class="col-3 col-form-label font-bold">No Bale</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="nobale" name="nobale"  autocomplete="off" aria-describedby="emailHelp" placeholder="Nomor Nomor Bale">
                    </div>
                </div>
            <?php endif; ?>
            <div class="row font-kecil mb-1">
                <label class="col-3 col-form-label font-bold">Ket</label>
                <div class="col">
                    <textarea class="form-control font-kecil btn-flat" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary mr-1 hilang" id="simpanbar">Simpan</button>
    <button type="button" class="btn btn-sm btn-danger m-0" data-bs-dismiss="modal">Close / Cancel</button>
</div>
<script>
    $(document).ready(function(){
        $("#keyw").focus();
        $("#keyw").val($("#nama_barang").val());
        if($("#keyw").val() != ''){
            $("#getbarang").click();
        }
    })
    $("#keyw").on('keyup',function(e){
        if(e.key == 'Enter' || e.keycode === 13){
            $("#getbarang").click();
        }
    })
    $("#pcs").on('blur',function(e){
        if($("#weightjala").val()!='0'){
            var berat = parseFloat($("#weightjala").val());
            var qty = parseFloat($(this).val());

            $("#kgs").val(berat*qty);
        }
    })
    $("#getbarang").click(function(){
        if($("#keyw").val() == ''){
            pesan('Isi dahulu keyword pencarian barang','info');
            return;
        }
        $("#getbarang").html('<i class="fa fa-circle-o-notch fa-spin mr-2"></i> Loading')
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'pb/getspecbarang',
            data: {
                mode: $("#cari_by").val(),
                data: $("#keyw").val(),
            },
            success: function(data){
                $("#getbarang").html('Get!')
                $("#body-table").html(data.datagroup).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $("#simpanbar").click(function(){
        if($("#id_barang").val() == ''){
            pesan('Barang tidak ditemukan','info');
            return;
        }
        if($("#id_satuan").val() == ''){
            pesan('Pilih Satuan','info');
            return;
        }
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url+'out/simpandetailbarangx',
            data: {
                id_header: $("#id_header").val(),
                id_barang: $("#id_barang").val(),
                id_satuan: $("#id_satuan").val(),
                po: $("#po").val(),
                item: $("#item").val(),
                dis: $("#dis").val(),
                insno: $("#insno").val(),
                nobontr: $("#nobontr").val(),
                nobale: $("#nobale").val(),
                pcs: toAngka($("#pcs").val()),
                kgs: toAngka($("#kgs").val()),
                keterangan: $("#keterangan").val(),
            },
            success: function(data){
                // $("#body-table").html(data.datagroup).show();
                // alert('BERHASIL');
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $(document).on('click','.pilihbarang',function(){
        var x = $(this).attr('rel1');
        var y = $(this).attr('rel2');
        var z = $(this).attr('rel3');
        var xpo = $(this).attr('rel5');
        var xitem = $(this).attr('rel6');
        var xdis = $(this).attr('rel7');
        var jala = $(this).attr('rel8');
        var sku = $(this).attr('rel9');
        // $("#nama_barang").val(x);
        $("#spekbarangnya").text(x);
        $("#skubarangnya").text(sku);
        $("#id_barang").val(y);
        $("#id_satuan").val(z)
        $("#po").val(xpo)
        $("#item").val(xitem)
        $("#dis").val(xdis)
        $("#weightjala").val(jala)
        $("#databarang").removeClass('hilang');
        $("#simpanbar").removeClass('hilang');
        $("#caribarang").addClass('hilang');
        // $("#modal-scroll").modal('hide');
        $("#pcs").focus();
    })
</script>