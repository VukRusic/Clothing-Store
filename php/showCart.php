<?php
session_start();
include "connect.php";
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
$product_array = "";
$names = "";

if ($products_in_cart) {
    foreach ($products_in_cart as $name => $quantity) {
        $product_array .= ",'" . $name . "'";
    }
    $names = substr($product_array, 1);
    $upit = "SELECT * FROM proizvod WHERE Naziv in ($names)";

    if (!$rez = $mysqli->query($upit)) {
        die("Greska: " . $mysqli->error);
    } else {
        $products = $rez->fetch_all();
    }

    foreach ($products as $product) {
        $subtotal += (float)$product[4] * (int)$products_in_cart[$product[1]];
        $_SESSION['subtotal'] = $subtotal;
    }
}

?>
<main id="main-cart">
    <div class="cd-popup" id="pop" role="alert">
        <div class="cd-popup-container">
            <p class="pop-tekst">Da li sigurno zelite da poručite izabrane prozvode?</p>
            <button class="btn btn-success" onclick="order()">Da</button>
            <button class="btn btn-danger" onclick="closeModal()">Ne</button><br>
        </div>
    </div>
    <div class="cart content-wrapper">
        <h1>Vaša korpa:</h1>
        <form id="cartForm" method="post">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Proizvod</td>
                        <td>Cena</td>
                        <td>Količina</td>
                        <td>Ukupno</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) : ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">Niste dodali proizvode u korpu.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td class="img">
                                    <img src="img/<?= $product[7] ?>" width="210" height="180" alt="<?= $product[1] ?>">
                                </td>
                                <td class="trash">
                                    <a onclick="removeFromCart('<?= $product[1] ?>')" class="remove"><i class="fas fa-trash-alt fa-3x"></i></a>
                                </td>
                                <td class="price"><?= $product[4] ?>.00 din</td>
                                <td class="quantity">
                                    <input type="number" name="quantity-<?= $product[1] ?>" value="<?= $products_in_cart[$product[1]] ?>" min="1" max="15" placeholder="Quantity" required>
                                </td>
                                <td class="price"><?= $product[4] * $products_in_cart[$product[1]] ?>.00 din</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="subtotal">
                <span class="text">Ukupan račun</span>
                <span class="price"><?= $subtotal ?>.00 din</span>
            </div>
            <div class="buttons">
                <input type="button" value="Ažuriraj" name="update" onclick="updateCart()">
                <input type="button" value="Poruči" name="order" onclick="modal()">
            </div>
        </form>
    </div>
</main>
<script>
    function modal() {
        <?php if ($products_in_cart) { ?>
            $('#pop').addClass('is-visible');
        <?php } ?>
    }

    function closeModal() {
        $('#pop').removeClass('is-visible');
    }

    function order() {
        closeModal();
        $.ajax({
            type: 'POST',
            url: 'php/placeOrder.php',
            cache: false,
            success: function(data) {
                $('#main-cart').html(data);
            }
        });
    }

    function updateCart() {
        var form = $('#cartForm').serialize();
        $.ajax({
            url: "php/updateCart.php",
            method: "POST",
            data: form,
            success: function(response) {
                if (response == "Success") {
                    showPageAjax('showCart');
                }
            }
        });
    }

    function removeFromCart(_remove) {
        $.ajax({
            type: 'GET',
            data: {
                remove: _remove
            },
            url: 'php/removeFromCart.php',
            cache: false,
            success: function(response) {
                showPageAjax('showCart');
            }
        });
    }
</script>