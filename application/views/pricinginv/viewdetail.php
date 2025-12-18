<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SKU</label>
                <div class="col"> 
                    <?php $sku = trim($data['po'])=='' ? namaspekbarang($data['id_barang'],'kode') : viewsku($data['po'],$data['item'],$data['dis']); ?>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0" name="id" id="id" placeholder="Tanggal Produksi" value="<?= $sku ?>">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0" name="id" id="id" placeholder="Tanggal Produksi" value="<?= $data['id_kategori'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">Spesifikasi</label>
                <div class="col"> 
                    <?php $spekbarang = trim($data['po'])=='' ? namaspekbarang($data['id_barang'],'nama_barang') : spekpo($data['po'],$data['item'],$data['dis']); ?>
                    <input type="text" class="form-control font-kecil" name="spek" id="spek" placeholder="Tanggal Produksi" value="<?= $spekbarang ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SKU</label>
                <div class="col"> 
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0" name="id" id="id" placeholder="Nomor IB" value="<?= $data['nobontr'] ?>">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0" name="id" id="id" placeholder="Instruksi" value="<?= $data['insno'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">PCS/KGS</label>
                <div class="col"> 
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0 text-right" name="id" id="id" placeholder="Pcs" value="<?= rupiah($data['pcs_akhir'],0) ?>">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control font-kecil mb-0 text-right" name="id" id="id" placeholder="Kgs" value="<?= rupiah($data['kgs_akhir'],2) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">PRICE</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['harga'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">RM</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['rm'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SM</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['sm'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SPINNING</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['spinning'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">RINGROPE</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['ringrope'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">NETTING</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['netting'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SENSHOKU</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['senshoku'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">HOSHU 1</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['hoshu1'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">KOATSU</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['koatsu'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">HOSHU 2</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['hoshu2'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">PACKING</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['packing'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">SHITATE</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['shitate'],8) ?>">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-2 col-form-label">JUMLAH</label>
                <div class="col"> 
                    <input type="text" class="form-control font-kecil text-right" name="spek" id="spek" placeholder="Harga" value="<?= rupiah($data['amount'],8) ?>" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="m-0">
<div class="p-3 text-right">
    <a href="#" class="btn me-auto btn-sm btn-primary" id="butbatal" data-bs-dismiss="modal">Keluar</a>
</div>
<script>
   
</script>