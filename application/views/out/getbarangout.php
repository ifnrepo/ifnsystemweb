<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered m-0 mt-1 mb-1 table-hover">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-center text-black">SKU</th>
                        <th class="text-center text-black">Spesifikasi</th>
                        <th class="text-center text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    <?php foreach($data->result_array() as $dt): ?>
                    <?php  
                        if($mode=='brg'){
                            $sku = $dt['kode'];
                            $spek = $dt['nama_barang'];
                            $id = $dt['id'];
                            $po = '';
                            $item = '';
                            $dis = 0;
                        }else{
                            if($mode=='po'){
                                $sku = viewsku($dt['po'],$dt['item'],$dt['dis']);
                                $spek = spekpo($dt['po'],$dt['item'],$dt['dis']);
                                $id = $dt['id'];
                                $po = $dt['po'];
                                $item = $dt['item'];
                                $dis = $dt['dis'];
                            }
                        }
                    ?>
                        <tr>
                            <td><?= $sku ?></td>
                            <td><?= $spek ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-success font-kecil btn-flat" style="padding: 0px 2px !important;" id="pilihbarang" rel="<?= $po ?>" rel2="<?= $item ?>" rel3="<?= $dis ?>" rel4="<?= $id ?>" rel5="<?= $mode ?>" rel6="<?= $sku ?>">Pilih</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <!-- <button type="button" class="btn me-auto btn-sm text-black" data-bs-dismiss="modal">Batal</button> -->
    <button type="button" class="btn btn-success btn-sm text-black" id="tutupform" data-bs-dismiss="modal">Batal Pilih</button>
</div>
<script>
    $(document).ready(function(){
        // $("#departemenasal").val($("#dept_tuju option:selected").attr('rel'));
    })
    $(document).on('click','#pilihbarang',function(){
        var po = $(this).attr('rel'); //PO
        var item = $(this).attr('rel2'); //ITEM
        var dis = $(this).attr('rel3'); //DIS
        var idb = $(this).attr('rel4'); //ID BARANG
        var md = $(this).attr('rel5'); //MODE
        var sku = $(this).attr('rel6'); //SKU
        $("#po").val('');
        $("#item").val('');
        $("#dis").val('');
        $("#idbarang").val('');
        $("#id_barang").val('');
        $("#spek").val('');
        if(md=='brg'){
            $("#id_barang").val(sku);
            document.getElementById('pencarianitembarang').click();
            $("#tutupform").click();
        }else{
            if(md=='po'){
                $("#po").val(po);
                $("#item").val(item);
                $("#dis").val(dis);
                document.getElementById('pencarianitembarang').click();
                $("#tutupform").click();
            }
        }
        // $.ajax({
        //     // dataType: "json",
        //     type: "POST",
        //     // url: base_url + "out/editinsno",
        //     data: {
        //         id: $(this).attr('rel'),
        //         bon: $(this).attr('rel2'),
        //         idd: $("#iddetail").val()
        //     },
        //     success: function (data) {
        //         // alert(data.jmlrek);
        //         window.location.reload();
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr.status);
        //         console.log(thrownError);
        //     },
	    // });
    })
</script>