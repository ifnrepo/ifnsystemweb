<div class="container-xl"> 
    <input type="hidden" name="id_header" id="id_header" value="<?= $idheader; ?>">
    <div id="table-default" class="table-responsive mb-1">
        <table class="table datatable6" id="cobasisip">
            <thead style="background-color: blue !important">
                <tr>
                    <th>Seri <?= $data->num_rows(); ?></th>
                    <th>SKU</th>
                    <th>Nama Barang / Uraian</th>
                    <th>Qty</th>
                    <th>Berat (Kg)</th>
                </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">
                <?php 
                    $no=0; foreach($data->result_array() as $data){ $no++; 
                        $sku = trim($data['po'])=='' ? $data['kode'] : viewsku($data['po'],$data['item'],$data['dis']);
                        $spekbarang = trim($data['po'])=='' ? namaspekbarang($data['id_barang']) : spekpo($data['po'],$data['item'],$data['dis'],$data['id_barang']);
                ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $sku ?></td>
                        <td><?= $spekbarang ?></td>
                        <td><?= $data['pcsx'] ?></td>
                        <td><?= $data['kgsx'] ?></td>
                    </tr>
                    <?php
                        $kondisi = [
                            'id_barang' => $data['id_barang'],
                            'po' => $data['po'],
                            'item' => $data['item'],
                            'dis' => $data['dis'],
                            'insno' => $data['insno'],
                            'nobontr' => $data['nobontr']
                        ];
                        $datdetail = getbcasal($data['nomor_bc'],$kondisi)->row_array(); 
                    ?>
                    <tr style="padding: 0px !important; margin: 0px !important;" class="text-teal">
                        <td></td>
                        <td colspan="4">Aju <?= $datdetail['nomor_aju'] ?>, Seri Barang <?= $datdetail['seri_barang'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <hr class="small m-1">
        <div class="text-center">
            <a href="#" data-href="<?= base_url().'ib/simpanbcasal/'.$idheader.'/1'; ?>" id="simpankedb" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini " data-title="Bill Of Material" class="btn btn-sm btn-flat btn-primary">Simpan</a>
            <a href="#" class="btn btn-sm btn-flat btn-danger" id="tutupmodal" data-bs-dismiss="modal">Batal</a>
            <div id="peringatan">XXX</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $(".tgl").datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     todayHighlight: true,
        // });
        $("#peringatan").text('');
    })
    $("#kode_entitas").change(function(){
        $("#divnegara").addClass('hilang');
        $("#dividentitas").addClass('hilang');
        var xx = $(this).val();
        if(xx == 7){
            $("#dividentitas").removeClass('hilang');
        }
        if(xx == 5){
            $("#divnegara").removeClass('hilang');
        }
    })
    $("#simpanentitas").click(function(){
        if($("#kode_entitas").val()==''){
            pesan('Pilih Kode Entitas','error');
            return false;
        }
        if($("#nama").val()==''){
            pesan('Isi Nama','error');
            return false;
        }
        if($("#alamat").val()==''){
            pesan('Isi Alamat','error');
            return false;
        }  
        if($("#kode_entitas").val() == 7 && $("#no_identitas").val() == ''){
            pesan('Isi Nomor Identitas','error');
            return false;
        }
        if($("#kode_entitas").val() == 5 && $("#kode_negara").val() == ''){
            pesan('Negara Harus di Isi','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "ib/tambahentitas",
            data: {
                id: $("#id_header").val(),
                kode: $("#kode_entitas").val(),
                no: $("#no_identitas").val(),
                nama: $("#nama").val(),
                alamat: $("#alamat").val(),
                negara: $("#kode_negara").val(),
            },
            success: function (data) {
                // window.location.reload();
                $("#body-table-entitas").html(data.datagroup).show();
                $('#modal-large').modal('hide');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>