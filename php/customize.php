<?php
session_start();
include "connect.php";
$id = 0;
$products = "";
$nalozi = "";

$upit = "SELECT * FROM nalog WHERE Tip LIKE 'korisnik'";

if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    $nalozi = $rez->fetch_all();
}

$upit = "SELECT * FROM proizvod";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    $products = $rez->fetch_all();
}

?>
<div id="accounts" class="col-md-2">
    <h2 style="font-weight: bold;">Registrovani nalozi:</h2>
    <table class="accounts">
        <thead>
            <tr>
                <td colspan="2">Korisnička imena:</td>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($nalozi)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Nema registrovanih naloga.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($nalozi as $nalog) : ?>
                    <tr>
                        <td><?= $nalog[0] ?></td>
                        <td class="del"><a onclick="openModal('<?= $nalog[0] ?>')"><i class="fas fa-user-times fa-2x"></i></a></td>
                    </tr>
                    <div class="cd-popup" id="pop" role="alert">
                        <div class="cd-popup-container admin-popup">
                            <p style="visibility: hidden;" id="ime"></p>
                            <p class="pop-tekst2">Da li sigurno želite da obrišete izabrani nalog?</p>
                            <button type="submit" name="submit" class="btn btn-success status-btn" onclick="deleteAcc()">Da</button>
                            <button type="submit" name="submit" class="btn btn-danger status-btn" onclick="closeModal()">Ne</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="col-md-6" id="products">
    <h1>Objavljeni proizvodi:</h1>
    <table class="products-list">
        <thead>
            <tr>
                <td>Naziv</td>
                <td>Kategorija</td>
                <td>Podkategorija</td>
                <td>Pol</td>
                <td>Cena</td>
                <td>Slika</td>
                <td>Status</td>
                <td colspan="2"></td>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Nema objavljenih proizvoda.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product[1] ?></td>
                        <td><?= $product[2] ?></td>
                        <td><?= $product[3] ?></td>
                        <td><?= $product[8] ?></td>
                        <td><?= $product[4] ?></td>
                        <td><?= $product[7] ?></td>
                        <td><?= $product[5] ?></td>
                        <td><a onclick="openModal1('<?= $product[5] ?>','<?= $product[4] ?>','<?= $product[1] ?>')"><i class="fas fa-edit fa-2x"></i></a></td>
                        <td class="del"><a onclick="openModal2('<?= $product[1] ?>')"><i class="fas fa-trash-alt fa-2x"></i></a></td>
                    </tr>
                    <div class="cd-popup" id="pop1" role="alert">
                        <div class="cd-popup-container admin-popup">
                            <p id="naziv" style="display: none;"></p>
                            <div id="popup2-tekst" style="display: none;">
                                <p class="pop-tekst2">Da li sigurno želite da obrišete izabrani proizvod?</p>
                                <button type="submit" name="submit" class="btn btn-success status-btn" onclick="deleteProduct()">Da</button>
                                <button type="submit" name="submit" class="btn btn-danger status-btn" onclick="closeModal2()">Ne</button>
                            </div>
                            <div id="formUpdateProduct">

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="col-md-4">
    <h1>Kreiranje novog proizvoda:</h1>
    <form id="formCreate" enctype="multipart/form-data" method="post">
        <label class="info-label">Naziv: </label>
        <input class="info-text" name="naziv" size="15" required><br><br>
        <label class="info-label">Kategorija: </label>
        <input class="info-text" name="kategorija" size="15" required><br><br>
        <label class="info-label">Podkategorija: </label>
        <input class="info-text" name="podkategorija" size="15" required><br><br>
        <label class="info-label">Cena: </label>
        <input class="info-text" name="cena" size="15" required><br><br>
        <label class="info-label">Pol: </label>
        <input class="info-text" name="pol" size="15" required><br><br>
        <label class="info-label">Status: </label>
        <input class="info-text" name="statusP" size="15" required><br><br>
        <label class="info-label">Izaberi sliku: </label>
        <input type="file" name="upload"><br><br>
    </form>
    <button onclick="createProduct()" class="btn btn-success" id="btnKreiraj">Kreiraj</button>
</div>

<script>
    function openModal(_ime) {
        $('#pop').addClass('is-visible');
        $('#ime').html(_ime);
    }

    function closeModal() {
        $('#pop').removeClass('is-visible');
    }

    function deleteAcc() {
        closeModal();
        _ime = $('#ime').html();
        $.ajax({
            type: 'POST',
            url: 'php/deleteUser.php',
            cache: false,
            data: {
                ime: _ime,
            },
            success: function() {
                showCustomize();
            }
        });
    }

    function openModal1(_status, _cena, _naziv) {
        $('#pop1').addClass('is-visible');
        updateProduct(_status, _cena, _naziv);
    }

    function closeModal1() {
        $('#pop1').removeClass('is-visible');
    }

    function openModal2(_naziv) {
        $('#pop1').addClass('is-visible');
        $('#popup2-tekst').css("display", "block");
        $('#naziv').html(_naziv);
    }

    function closeModal2() {
        $('#pop1').removeClass('is-visible');
    }

    function updateProduct(_status, _cena, _naziv) {
        $.ajax({
            url: "php/updateProduct.php",
            type: "POST",
            cache: false,
            data: {
                statusp: _status,
                cenap: _cena,
                nazivp: _naziv
            },
            success: function(response) {
                $('#formUpdateProduct').html(response);
            }
        });
    }

    function deleteProduct() {
        closeModal2();
        _naziv = $('#naziv').html();
        $.ajax({
            url: "php/deleteProduct.php",
            type: "POST",
            cache: false,
            data: {
                nazivp: _naziv
            },
            success: function(response) {
                if (response == "Success") {
                    showCustomize();
                }
            }
        });
    }
    
    function createProduct() {
        var data = new FormData(document.getElementById('formCreate'));
        $.ajax({
            url: "php/createProduct.php",
            enctype: 'multipart/form-data',
            method: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == "Success") {
                    showCustomize();
                    $("#formCreate")[0].reset();
                } else {
                    $("#formCreate")[0].reset();
                }
            }
        });
    }
</script>