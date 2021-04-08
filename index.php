<?php
session_start();
include "php/connect.php";

$proizvods = null;

$statusP = "sale";
$upit = "SELECT * FROM proizvod WHERE statusP='$statusP'";
if (!$rez = $mysqli->query($upit)) {
  echo "Greska: " . $mysqli->error;
} else {
  $proizvods = $rez->fetch_all();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Elpida</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/b38f355859.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row" id="nav">
      <?php include "php/nav.php"; ?>
    </div>
    <!-- Main -->
    <div class="row" id="main">
      <!-- Content -->
      <div class="col-md-3" id="sidebar">
        <!-- Search -->
        <div class="box search">
          <h2>Pretraga po <span></span></h2>
          <div class="box-content">
            <form id="searchForm" method="post">
              <label>Nazivu</label>
              <input type="text" id="poNazivu" class="form-control" name="Naziv" />
              </br>
              <input type="button" id="search" class="btn btn-primary" value="Pretraži" />
            </form>
          </div>
        </div>
        <!-- End Search -->
        <!-- Categories -->
        <div class="box categories">
          <h2>Kategorije</h2>
          <div>
            <ul>
              <li>
              <div>
                <a onclick="show1()"><i class="fas fa-plus-circle"></i></a>
                <a onclick="searchCategorie('Odrasli')">Odrasli</a>
              </div>
                <ul id="showcategorie1">
                  <li id="subcategorie" onclick="searchCategorie('Odrasli','M')"><i class="fas fa-angle-right"></i><a>Muškarci</a></li>
                  <li id="subcategorie" onclick="searchCategorie('Odrasli','Z')"><i class="fas fa-angle-right"></i><a>Žene</a></li>
                </ul>
              </li>
              <li>
              <div>
                <a onclick="show2()"><i class="fas fa-plus-circle"></i></a>
                <a onclick="searchCategorie('Deca')"> Deca</a>
              </div>
                <ul id="showcategorie2">
                  <li id="subcategorie" onclick="searchCategorie('Deca','M')"><i class="fas fa-angle-right"></i> <a>Dečaci</a></li>
                  <li id="subcategorie" onclick="searchCategorie('Deca','Z')"><i class="fas fa-angle-right"></i> <a>Devojčice</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- End Categories -->
      </div>
      <div id="content" class="col-md-9">
        <!-- Content Slider -->
        <!-- Products -->
        <div class="products">
          <div class="cl">&nbsp;</div>
          <ul>
            <?php foreach ($proizvods as $proizvod) : ?>
              <li>
                <a href="#"><img class="middle" src="img/<?= $proizvod[7] ?>" alt="<?= $proizvod[1] ?>" /></a>
                <div class="product-info">
                  <h3><?php echo ($proizvod[3] . "\t" . $proizvod[4] . ".00 din")?></h3>
                  <div class="product-desc">
                    <button onclick="addToCart('<?= $proizvod[1] ?>')" class="btn btn-primary">Dodaj u korpu</button>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="cl">&nbsp;</div>
        </div>
        <!-- End Products -->
      </div>
      <!-- End Content -->
    </div>
    <!-- End Main -->
    <?php include "php/footer.php" ?>
  </div>
  <script src="js/jquery-func.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    function addToCart(_name) {
      var name = _name;
      $.ajax({
        url: "php/addToCart.php",
        type: "POST",
        cache: false,
        data: {
          name: _name
        },
        success: function(response) {
          if (response == "error") {
            openLoginForm();
          } else {
            $('#quantity').html(response);
          }
        },
      });
    }

    $('#search').click(function() {
      var form = $('#searchForm').serialize();
      $.ajax({
        url: "php/products.php",
        type: "POST",
        cache: false,
        data: form,
        success: function(data) {
          $('#content').html(data);
        }
      });
    });

    function searchCategorie(_kategorija, _pol) {
      $.ajax({
        url: "php/products.php",
        type: "POST",
        cache: false,
        data: {
          kategorija: _kategorija,
          pol: _pol
        },
        success: function(data) {
          $('#content').html(data);
        }
      });
    }
  </script>
</body>

</html>