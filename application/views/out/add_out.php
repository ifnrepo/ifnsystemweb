<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 input-group">
                <!-- <label class="form-label mb-0 font-kecil">Departemen</label> -->
                <input type="text" class="form-control font-kecil mt-1 mr-2 font-bold" id="departemenasal" placeholder="Input data" readonly>
                <button type="button" class="btn btn-primary btn-sm font-kecil mt-1" style="height: 35px !important;" id="simpanout">Simpan Barang</button>
            </div>
            <hr class="m-1">
            <div class="mb-1 input-group">
                <!-- <label class="form-label mb-0 font-kecil">Departemen</label> -->
                <input type="text" class="form-control font-kecil mt-1 mr-2 font-bold mb-1 text-uppercase" id="nobbon" placeholder="Cari Nomor Bon">
                <button type="button" class="btn btn-yellow btn-sm font-kecil mt-1 text-black" style="height: 35px !important;" id="carinobon">Cari</button>
            </div>
            <div class="text-center">
                <label class="form-label font-kecil font-bold mb-2">- Atau -</label>
            </div>
            <div class="mb-1 input-group">
                <select class="form-control font-kecil form-select bg-primary-lt btn-flat mr-2 mb-1" id="bonpb">
                    <option value="">Pilih BON</option>
                    <?php foreach ($bonpb->result_array() as $bonpb) { ?>
                        <option value="<?= $bonpb['nomor_dok']; ?>"><?= $bonpb['nomor_dok'].' Tgl. '.tglmysql($bonpb['tgl']); ?></option>
                    <?php } ?>
                </select>
                <button type="button" class="btn btn-success btn-sm font-kecil" style="height: 35px !important;" id="caribarangpb">Cari</button>
            </div>
            <div class="mb-1 input-group">
                <input type="text" class="form-control font-kecil mb-1 mr-2" id="namabarang" placeholder="Cari Nama Barang">
                <button type="button" class="btn btn-success btn-sm font-kecil" style="height: 35px !important;" id="caribarangpb2">Cari</button>
            </div>
            <hr class="m-1">
            <table class="table datatable6 nowrap">
                <thead>
                <tr>
                    <th>Spesifik</th>
                    <th>Tgl</th>
                    <th>Nomor</th>
                    <th>Keterangan</th>
                    <th>Pilih</th>
                </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                    <?php $no=1; foreach ($bon as $xbon) { $no++; ?>
                        <tr>
                            <td><?= $xbon['nama_barang']; ?></td>
                            <td style="font-size: 10px !important"><?= tglmysql($xbon['tgl']); ?></td>
                            <td><?= $xbon['nomor_dok']; ?></td>
                            <td style="font-size: 10px !important"><?= $xbon['keteranganx']; ?></td>
                            <td>
                                <!-- <a href="<?= base_url().'out/tambahdataout/'.$xbon['id']; ?>" class="btn btn-sm btn-success" style='padding: 3px !important;'>Pilih</a> -->
                                 <label class="form-check">
                                        <input class="form-check-input" name="cekpilihbarang" id="cekbok<?= $no; ?>" rel="<?= $xbon['idx']; ?>" type="checkbox" title="<?= $xbon['idx']; ?>">
                                        <span class="form-check-label">Pilih</span>
                                    </label>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if(count($bon)==0): ?>
                        <tr>
                            <td colspan="5" class="text-center">No Data / Cari dahulu data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn btn-primary btn-sm" id="simpanout2">Simpan Barang</button>
</div>
<script>
    $(document).ready(function(){
        // var zi = $("#dept_tuju").val();
        // var zu = $("#dept_kirim").val();
        $("#departemenasal").val('Bon Permintaan '+$("#nomor_dok").val().substr(0,5));
    })
    $("#simpanout").click(function(){
        $("#simpanout2").click();
    })
    $("#simpanout2").click(function(){
         var text = [];
        for (let i = 1; i < 1000; i++) {
            if($("#cekbok"+i).is(":checked")){
                text.push($("#cekbok"+i).attr('rel'));
            }
        }
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "out/tambahdataout",
                data: {
                    id: $("#id_header").val(),
                    out: text
                },
                success: function(data) {
                    // alert(data);
                    window.location.href = base_url + "out/dataout/" + data;
                    // $("#butbatal").click();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Tidak ada data yang dipilih','info');
            $("#modal-largescroll").modal('hide');
        }
    })
    $("#caribarangpb2").click(function(){
        $("#caribarang").click();
    })
    $("#caribarangpb").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/getbondengankey",
            data: {
                bon: $("#bonpb").val(),
                barang: $("#namabarang").val(),
                mode: 0
            },
            success: function(data) {
                // alert(data);
                $("#body-table").html(data.datagroup).show();
                // window.location.href = base_url + "out/dataout/" + data;
                // $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $("#carinobon").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "out/getbondengankey",
            data: {
                bon: $("#nobbon").val(),
                barang: $("#namabarang").val(),
                mode: 1
            },
            success: function(data) {
                // alert(data);
                $("#body-table").html(data.datagroup).show();
                // window.location.href = base_url + "out/dataout/" + data;
                // $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>