<?php
session_start();
include "connect.php";
$porudzbine = "";

$upit = "SELECT * FROM narudzbenica WHERE StatusP is not null";

if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    $porudzbine = $rez->fetch_all();
}
$mysqli->close();
?>

<div class="col-md-8 admin">
    <h1>Informacije o porudžbinama:</h1>
    <table class="orders">
        <thead>
            <tr>
                <td>Id</td>
                <td>Datum poručivanja</td>
                <td>Adresa isporuke</td>
                <td>Cena</td>
                <td colspan="2">Status</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($porudzbine)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Nema novih porudžbina.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($porudzbine as $porudzbina) : ?>
                    <div class="cd-popup" id="pop" role="alert">
                        <div class="cd-popup-container admin-popup">
                            <p class="pop-tekst2">Poručeni proizvodi:</p>
                            <div id="proizvodi"></div>
                            <label>Status porudžbine:</label>
                            <select id="statusi" name="statusi">
                                <option value="U pripremi">U pripremi</option>
                                <option value="U fazi isporuke">U fazi isporuke</option>
                                <option value="Isporučeno">Isporučeno</option>
                                <option value="Otkazano">Otkazano</option>
                            </select><br><br>
                            <p style="visibility:hidden" id="IdEdit"></p>
                            <button type="submit" name="submit" class="btn btn-success status-btn" onclick="closeModal()" >Sačuvaj</button>
                        </div>
                    </div>
                    <tr>
                        <td><?= $porudzbina[0] ?></td>
                        <td><?= $porudzbina[1] ?></td>
                        <td><?= $porudzbina[3] ?></td>
                        <td><?= $porudzbina[2] ?>.00 din</td>
                        <td><?= $porudzbina[5] ?></td>
                        <td><a onclick="updateOrderStatus('<?= $porudzbina[0] ?>','<?=$porudzbina[5]?>')"><i class="fas fa-edit fa-2x"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    function updateOrderStatus(_id, _status) {
        $('#pop').addClass('is-visible');
        $('#statusi').val(_status);

        $.ajax({
            type: 'POST',
            url: 'php/listOrdered.php',
            cache: false,
            data: {id:_id},
            success: function(data) {
                $('#proizvodi').html(data);
                $('#IdEdit').html(_id);
            }
        });
    }

    function closeModal() {
        $('#pop').removeClass('is-visible');
        _id = $('#IdEdit').html();
        _newStatus = $('#statusi').val();

        $.ajax({
            type: 'POST',
            url: 'php/changeOrderStatus.php',
            cache: false,
            data: {id:_id, newStatus: _newStatus},
            success: function() {
                showAdmin();
            }
        });
    }
</script>