<ol class="list-group list-group-numbered " style="border: 1px solid grey;">
    <?php if (!empty($detail)) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-start ">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Buyer</div>
                <?= $detail['nama_customer']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">PO</div>
                <?= $detail['po']; ?>#<?= $detail['item']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Hikiai</div>
                <?= $detail['ord']; ?>#<?= $detail['ordno']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Spek</div>
                <?= $detail['spek']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">LIMIT</div>
                <?= date('d/M/Y', strtotime($detail['lim'])); ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">COLOR</div>
                <?= $detail['color']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class=" fa fa-edit"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">JUMLAH ORDER</div>
                <?= $detail['piece']; ?>.<?= $detail['st_piece']; ?>
            </div>
            <span class="badge text-bg-primary"> <i class="fa fa-edit"></i></span>
        </li>
    <?php else : ?>
        <p>Tidak ada detail yang dipilih.</p>
    <?php endif; ?>
</ol>