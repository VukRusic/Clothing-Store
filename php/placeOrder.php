<?php
session_start();
include "connect.php";
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$adresa = "";
$telefon = "";
$cena = 0;
$vreme = "";

if (isset($_POST['submit'])) {
    $adresa = $mysqli->real_escape_string($_POST['adresa']);
    $telefon = $mysqli->real_escape_string($_POST['telefon']);
    $cena = $_SESSION['subtotal'];
    $vreme = date('Y-m-d H:i:s');
    $status = "U pripremi";

    $upit = "INSERT INTO narudzbenica (Vreme, Cena, Adresa, Telefon, StatusP) VALUES
('$vreme','$cena','$adresa','$telefon','$status')";

    if ($rez = $mysqli->query($upit)) {
        echo "Uspesna izvršena porudžbina";
    } else {
        echo "Greska" . $mysqli->error;
    }

    $nalog = $_SESSION['username'];

    $upit = "SELECT MAX(Id) from narudzbenica";
    $rez = $mysqli->query($upit);
    $red = $rez->fetch_assoc();
    $IdNarudz = (int)$red['MAX(Id)'];


    if ($products_in_cart) {
        foreach ($products_in_cart as $name => $quantity) {
            $upit = "";
            $upit = "INSERT INTO proizvod_narudzbenica (IdNarudz, NazivProizvoda, Nalog, Kolicina) VALUES
        ('$IdNarudz','$name','$nalog','$quantity')";
            $rez = $mysqli->query($upit);
        }
    }

    $mysqli->close();

    unset($_SESSION['cart']);
    $_SESSION['quantity'] = 0;
    $_SESSION['subtotal'] = 0;
    header("location: ../index.php");
}
?>

<div class="login-page">
    <div class="formRegister">
        <form class="register-form" id="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label>Unesite adresu</label>
            <input type="text" placeholder="Adresa" name="adresa" required />
            <label>Unesite kontakt telefon</label>
            <input type="text" placeholder="Telefon" name="telefon" required />
            <p>Porudžbina se plaća pouzećem. Pošiljka stiže na adresa u periodu od 1-3 radnih dana.</p>
            <div class="cd-popup" id="pop" role="alert">
                <div class="cd-popup-container">
                    <p class="pop-tekst2">Vaša porudžbina je poslata.
                        Možete pratiti status vaše pošiljke u delu "Moj nalog".
                        Za sve dodatne informacija kontaktirajte naš korisnički servis. Hvala!
                    </p>
                    <button type="submit" name="submit" class="btn btn-danger" onclick="closeModal()">Potvrdi porudžbinu</button><br>
                </div>
            </div>
        </form>
        <button name="kreiraj" onclick="modal()">Unesi podatke</button>
    </div>
    <script>
        function modal() {
            $('#pop').addClass('is-visible');
        }

        function closeModal() {
            $('#pop').removeClass('is-visible');
        }
    </script>
</div>