<table class="table table-striped">
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td><b>BUYER</b></td>
            <td>:</td>
            <td><?= $detail['nama_customer']; ?></td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td><b>PO</b></td>
            <td>:</td>
            <td> <?= $detail['po']; ?>#<?= $detail['item']; ?></td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>HIKIAI</td>
            <td>:</td>
            <td> <?= $detail['ord']; ?>#<?= $detail['ordno']; ?></td>
        </tr>
        <tr>
            <th scope="row">4</th>
            <td>SPEC</td>
            <td>:</td>
            <td> <?= $detail['spek']; ?>#<?= $detail['color']; ?></td>
        </tr>
        <tr>
            <th scope="row">5</th>
            <td>LIMIT</td>
            <td>:</td>
            <td style="color: red;"> <?= $detail['lim']; ?></td>
        </tr>
        <tr>
            <th scope="row">6</th>
            <td>NETTYPE</td>
            <td>:</td>
            <td> <?= $detail['name_nettype']; ?></td>
        </tr>
        <tr>
            <th scope="row">7</th>
            <td>OUTSTAND</td>
            <td>:</td>
            <td> <?= $detail['outstand']; ?></td>
        </tr>
        <tr>
            <th scope="row">8</th>
            <td>WEIGHT/PIECE</td>
            <td>:</td>
            <td> <?= $detail['weight']; ?> <?= $detail['st_piece']; ?></td>
        </tr>
    </tbody>
</table>