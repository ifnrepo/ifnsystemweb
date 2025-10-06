<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $idheader; ?>">
    <input type="hidden" name="id_detail" id="id_detail" value="<?= $header['id']; ?>">
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">SKU</label>
                <div class="col">
                    <?php $sku = trim($header['po'])=='' ? $header['kode'] : viewsku($header['po'],$header['item'],$header['dis']); ?>
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $sku ?>" aria-describedby="emailHelp" placeholder="SKU" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nama Barang</label>
                <div class="col">
                    <?php $spekbarang = trim($header['po'])=='' ? namaspekbarang($header['id_barang']) : spekpo($header['po'],$header['item'],$header['dis']); ?>
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $spekbarang ?>" aria-describedby="emailHelp" placeholder="Nama Barang" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Insno</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $header['insno'] ?>" aria-describedby="emailHelp" placeholder="Insno" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nomor IB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" id="nomor_inv" name="nomor_inv" value="<?= $header['nobontr'] ?>" aria-describedby="emailHelp" placeholder="Nomor IB" >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Pcs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="pcs" name="pcs" value="<?= rupiah($header['pcsx'],2) ?>" aria-describedby="emailHelp" placeholder="Nama Barang" readonly >
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="kgs" name="kgs" value="<?= rupiah($header['kgsx'],2) ?>" aria-describedby="emailHelp" placeholder="Nama Barang" readonly >
                </div>
            </div>
        </div>
    </div>
    <hr class="small m-0">
    <div id="table-default" class="table-responsive mb-1">
        <table class="table datatable6" id="cobasisip">
            <thead style="background-color: blue !important">
                <tr>
                    <th>Seri </th>
                    <th>SKU</th>
                    <th>Nama Barang / Uraian</th>
                    <th>CIF</th>    
                    <th>Qty</th>
                    <th>Berat (Kg)</th>
                    <th>Pilih</th>
                    <th>Jml</th>
                </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                <?php 
                    $no=0;
                    $disab = $detail->num_rows() > 0 ? '' : 'disabled';
                    if($detail->num_rows() > 0){
                    foreach($detail->result_array() as $detail){ 
                    $no++;
                    $sku = trim($detail['po'])=='' ? $detail['kode'] : viewsku($detail['po'],$detail['item'],$detail['dis']);
                    $spekbarang = trim($detail['po'])=='' ? namaspekbarang($detail['id_barang']) : spekpo($detail['po'],$detail['item'],$detail['dis']);
                    $inidipakai = in_array($detail['id'],$arrayid) ? 'text-teal' : '';
                    $inidanger = $detail['cif']==0 ? 'text-danger' : '';
                ?>
                    <tr>
                        <td><?= $detail['seri_urut_akb'] ?></td>
                        <td><?= $sku ?></td>
                        <td class="<?= $inidipakai ?>"><?= $spekbarang ?></td>
                        <td class="<?= $inidanger ?>"><?= round($detail['cif'],2) ?></td>
                        <td id="pcsx<?= $no ?>"><?= rupiah($detail['pcs']-$detail['in_exbc'],0) ?></td>
                        <td><?= rupiah($detail['kgs'],2) ?></td>
                        <td class="text-center">
                            <label class="form-check mb-0">
                                <input class="form-check-input pilihcek" rel2="<?= round($detail['cif'],2) ?>" rel3="<?= $detail['kgs'] ?>" rel4="<?= $detail['pcs']-$detail['in_exbc'] ?>" name="cekpilihbcasal" id="cekbok<?= $no; ?>" rel="<?= $detail['id']; ?>" type="checkbox" title="<?= $detail['id']; ?>">
                                <span class="form-check-label">Pilih</span>
                            </label>
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control font-kecil btn-flat text-center iniinput" style="max-width: 45px !important; height: 20px;"   rel="<?= $detail['id']; ?>" id="input<?= $no; ?>" value="" aria-describedby="emailHelp" placeholder="Pcs Dipilih">
                        </td>
                    </tr>
                <?php }}else{ ?>
                    <tr>
                        <td colspan="8" class="text-center">Data tidak ada / sudah habis dikembalikan</td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>
    <hr class="small m-1">
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Pcs Dipilih</label>
                <div class="col">
                    <input type="text" name="pcsasli" id="pcsasli" class="hilang">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="inipcs" value="" aria-describedby="emailHelp" placeholder="Pcs Dipilih">
                </div>
            </div>
        </div>
    </div>
    <div class="mb-1 row">
        <div class="col">
            <div class="row">
                <label class="col-3 col-form-label font-kecil">Nilai CIF</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right" id="nilaicif" value="" aria-describedby="emailHelp" placeholder="Nilai CIF">
                </div>
            </div>
        </div>
    </div>
    <hr class="small m-1">
    <div class="text-center mb-3">
        <a href="#" id="simpankedb" class="btn btn-sm btn-flat btn-primary <?= $disab; ?>">Simpan</a>
        <a href="#" id="hitungcif" class="btn btn-sm btn-flat btn-primary hilang">Hitung</a>
        <a href="#" class="btn btn-sm btn-flat btn-danger" id="tutupmodal" data-bs-dismiss="modal">Batal</a>
        <!-- <div id="peringatan">0</div> -->
    </div>
</div>
<script>
    $(document).ready(function(){
        // $(".tgl").datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     todayHighlight: true,
        // });
        // $("#peringatan").text('');
    })
    $(document).on('change','.iniinput',function(){
        $("#hitungcif").click();
    })
    $(document).on('click','.pilihcek',function(){
        var kode = $(this).attr('id');
        var jmlpcs = $(this).attr('rel4');
        kode = kode.replace('cekbok','input');
        $("#"+kode).val(Math.round(jmlpcs,0));
        $("#hitungcif").click();
    })
    $("#hitungcif").click(function(){
        var cif = 0;
        var kgs = 0;
        var pcs = 0;
        var pcsx = 0;
        var kgsheader = parseFloat($("#kgs").val());
        var pcsheader = parseFloat($("#pcs").val());
        for (let i = 1; i < 1000; i++) {
            if($("#cekbok"+i).is(":checked")){
                cif += parseFloat($("#cekbok"+i).attr('rel2'));
                kgs += parseFloat($("#cekbok"+i).attr('rel3'));
                pcsx += parseFloat($("#cekbok"+i).attr('rel4'));
                pcs += parseFloat($("#input"+i).val());
            }
        }
        pembagi = Math.round(kgs/kgsheader,2);
        if(pcs < pcsheader){
            pcspembagi = 1;
        }else{
            pcspembagi = pcs/pcsx;
        }
        hasil = isNaN(cif) ? 0 : cif;
        $("#nilaicif").val(hasil*pcspembagi);
        $("#inipcs").val(pcs);
        $("#pcsasli").val(pcsx);
    })

    $("#simpankedb").click(function(){
        if($("#peringatan").text()=='0'){
            pesan('Pilih Salah satu BC ASAL','error');
            return false;
        }
        var pcsterima = parseFloat($("#pcs").val());
        var pcs = parseFloat($("#inipcs").val());
        if(pcs != pcsterima){
            pesan('Jumlah Penerimaan harus sama dengan BC ASAL','info');
            return false;
        }
        var text = [];
        var text2 = [];
        for (let i = 1; i < 1000; i++) {
            if($("#cekbok"+i).is(":checked")){
                text.push($("#cekbok"+i).attr('rel'));
                text2.push($("#input"+i).val());
            }
        }
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "ib/simpaneditbcasal",
                data: {
                    id: $("#id_header").val(),
                    iddetail: $("#id_detail").val(),
                    bcasal: text,
                    cifbaru: $("#nilaicif").val(),
                    jmlkembali: text2
                },
                success: function (data) {
                    $('#modal-large-loading').modal('hide');
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                },
            });
        }
    })
</script>