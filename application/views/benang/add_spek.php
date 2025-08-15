<form action="<?= base_url('benang/simpandata_spek'); ?>" method="post">
    <div class="mb-3">
        <label for="id_benang">Spek Benang</label>
        <input type="text" name="filter_benang" id="filter_benang" class="form-control" placeholder="Ketik Ukuran Benang" required>
        <input type="hidden" name="barang_id" id="barang_id">
    </div>

    <!-- <div class="mb-3">
        <label for="id_benang">Warna Benang</label>
        <input type="text" name="warna_benang" id="warna_benang" class="form-control" placeholder="Warna Benang" style="text-transform: uppercase;" required>
        <input type="hidden" name="id_header" id="id_header" value="<?= $id_header; ?>">
    </div> -->

    <div class="mb-3">
        <label for="id_benang">Warna Benang</label>
        <!-- <input type="text" name="warna_benang" id="warna_benang" class="form-control" placeholder="Warna Benang" style="text-transform: uppercase;" required> -->
        <input type="text" name="filter_warna" id="filter_warna" class="form-control" placeholder="Ketik Spek Benang" required>
        <input type="hidden" name="warna_benang" id="warna_benang">
        <input type="hidden" name="id_header" id="id_header" value="<?= $id_header; ?>">
    </div>

    <div class="mb-3">
        <label for="id_satuan">Satuan</label>
        <select name="id_satuan" id="id_satuan" class="form-control">
            <?php foreach ($satuan as $key) : ?>
                <option value="<?= $key['id']; ?>"><?= $key['kodesatuan']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>


<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css" />
<script src="<?= base_url(); ?>assets/js/vendor/jquery-ui.min.js"></script>


<script>
    $(document).ready(function() {
        $("#filter_benang").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url('benang/spek_ukuran'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.ukuran_benang.trim() + ' (' + item.warna_benang.trim() + ')',
                                value: item.ukuran_benang.trim() + ' (' + item.warna_benang.trim() + ')',
                                barang_id: item.barang_id
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $("#barang_id").val(ui.item.barang_id);
            },
            minLength: 1
        });
        // $("#filter_benang").autocomplete({
        //     source: function(request, response) {
        //         $.ajax({
        //             url: "<?= base_url('benang/spek_ukuran'); ?>",
        //             dataType: "json",
        //             data: {
        //                 term: request.term
        //             },
        //             success: function(data) {
        //                 response($.map(data, function(item) {
        //                     return {
        //                         label: item.nama_barang.trim(),
        //                         value: item.nama_barang.trim(),
        //                         barang_id: item.id
        //                     };
        //                 }));
        //             }
        //         });
        //     },
        //     select: function(event, ui) {
        //         $("#barang_id").val(ui.item.barang_id);
        //     },
        //     minLength: 1
        // });
        $("#filter_warna").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url('benang/spek_warna'); ?>",
                    dataType: "json",
                    data: {
                        warna: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.warna_benang.trim(),
                                value: item.warna_benang.trim(),
                                warna_benang: item.warna_benang
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $("#warna_benang").val(ui.item.warna_benang);
            },
            minLength: 1
        });
    });
</script>