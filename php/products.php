<?php
session_start();
$naziv = "";
$kategorija = "";
$pol = "";
include "connect.php";

if (isset($_POST['kategorija']) && !isset($_POST['pol'])) {
    $kategorija = $_POST['kategorija'];
    $upit = "SELECT * FROM proizvod WHERE Kategorija LIKE '$kategorija'";

    if (!$rez = $mysqli->query($upit)) {
        die("Greska: " . $mysqli->error);
    } else {
        $products = $rez->fetch_all();
    }
}

if(isset($_POST['pol']) && isset($_POST['kategorija'])) {
    $kategorija = $_POST['kategorija'];
    $pol = $_POST['pol'];
    $upit = "SELECT * FROM proizvod WHERE Kategorija LIKE '$kategorija' and Pol LIKE '$pol'";
    if (!$rez = $mysqli->query($upit)) {
        die("Greska: " . $mysqli->error);
    } else {
        $products = $rez->fetch_all();
    }
}

if (!isset($_POST['kategorija'])) {
    $naziv = $_POST['Naziv'];
    if ($naziv != "") {
        $upit = "SELECT * FROM proizvod WHERE Naziv LIKE '$naziv'";
    } else {
        $upit = "SELECT * FROM proizvod";
    }
    if (!$rez = $mysqli->query($upit)) {
        die("Greska: " . $mysqli->error);
    } else {
        $products = $rez->fetch_all();
    }
}
?>

<div class="products content-wrapper">
    <h1>Proizvodi</h1>
    <p class="categorie">Deca</p>
    <div>
        <?php foreach ($products as $product) : ?>
            <?php if ($product[2] == "Deca") : ?>
                <div class="row product">
                    <div>
                        <img src="img/<?= $product[7] ?>" width="380" height="370" alt="<?= $product[1] ?>">
                    </div>
                    <div class="info">
                        <span>
                            <?= $product[3] ?>: "<?= $product[1] ?>"<br><br>
                            Cena: <?= $product[4] ?>.00 Din<br><br>
                        </span>
                        <button class="btn btn-primary" onclick="addToCart('<?= $product[1] ?>')">
                            Dodaj u korpu
                        </button>
                    </div>
                </div>
        <?php endif;
        endforeach; ?>
    </div>
    <hr>
    <p class="categorie">Odrasli</p>
    <div>
        <?php foreach ($products as $product) : ?>
            <?php if ($product[2] == "Odrasli") : ?>
                <div class="row product">
                    <div>
                        <img src="img/<?= $product[7] ?>" width="350" height="370" alt="<?= $product[1] ?>">
                    </div>
                    <div class="info">
                        <span>
                            <?= $product[3] ?>: "<?= $product[1] ?>"<br><br>
                            Cena: <?= $product[4] ?>.00 Din<br><br>
                        </span>
                        <button class="btn btn-primary" onclick="addToCart('<?= $product[1] ?>')">
                            Dodaj u korpu
                        </button>
                    </div>
                </div>
        <?php endif;
        endforeach; ?>
    </div>
</div>
<script>
    function addToCart(_name) {
      var name = _name;
      $.ajax({
        url: "php/addToCart.php",
        type: "POST",
        cache: false,
        data: {name: _name},
        success: function(response) {
          if(response == "error") {
            openLoginForm();
          } else {
            $('#quantity').html(response);
          }
        },
      });
    }
</script>