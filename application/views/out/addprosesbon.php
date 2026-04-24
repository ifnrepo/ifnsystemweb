<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <!-- <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Nama Proses</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" id="pcs" name="pcs" value="" placeholder="Nama Proses">
                </div>
            </div> -->
            <div class="font-kecil mb-2 text-right d-flex justify-content-between">
                <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
                 <span></span>
                <button type="button" class="btn btn-success btn-sm text-black" id="simpanproses">Simpan</button>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable6 table-hover sticky-top" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Proses</th>
                    <th>Kode</th>
                    <th>Pilih</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                    <tr class="font-kecil">
                        <td>HOSHU METHOUSHI</td>
                        <td>HM</td>
                        <td>
                            <label class="form-check m-0" style="display: inline-block;">
                                <input class="form-check-input" name="cekpilihbarang" type="checkbox" id="cekbok1" rel="H  ,M  " title="cekbok1">
                                <div class="form-check-label font-bold">Pilih</div>
                            </label>
                        </td>
                    </tr>
                    <?php $no=1; foreach($proses->result_array() as $pros): $no++; ?>
                        <tr class="font-kecil">
                            <td><?= $pros['ket'] ?></td>
                            <td><?= $pros['kode'] ?></td>
                            <td>
                                <label class="form-check m-0" style="display: inline-block;">
                                    <input class="form-check-input" name="cekpilihbarang" type="checkbox" id="cekbok<?= $no ?>" rel="<?= $pros['kode'] ?>" title="cekbok<?= $no ?>">
                                    <div class="form-check-label font-bold">Pilih</div>
                                </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <hr class="m-1">
    <div class="font-kecil mb-2 text-right d-flex justify-content-between">
        <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success btn-sm text-black" id="simpanprosesx">Simpan</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
    $(document).on('click','#pilihnobontr',function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/editnobontr",
            data: {
                id: $(this).attr('rel'),
                bon: $(this).attr('rel2'),
                idd: $("#iddetail").val()
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
    $("#simpanprosesx").click(function(){
        $("#simpanproses").click();
    })
    $("#simpanproses").click(function(){
        var isiproses = '';
        var spasi = " ";
        for(let i=0;i < 100;i++){
            var btn = $("#cekbok"+i).is(':checked');
            if(btn){
                var len = $("#cekbok"+i).attr('rel').length;
                if(i=1){
                    isiproses += $("#cekbok"+i).attr('rel')+',';
                }else{
                    isiproses += $("#cekbok"+i).attr('rel').substring(0,3)+spasi.repeat(3-len)+',';
                }
            }
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/adddatasubkon",
            data: {
                kode: isiproses
            },
            success: function (data) {
                // alert(data.jmlrek);
                // window.location.reload();
                window.location.href = base_url+'out/dataout/'+data;
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
	    });
    })
</script>