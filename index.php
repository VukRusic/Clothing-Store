<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Elpida</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/b38f355859.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
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
              <input type="text" class="field" name="Naziv" />
              <label>Kategoriji</label>
              <select class="field">
                <option value="">-- Izaberi kategoriju --</option>
              </select>
              </br></br>
              <input type="button" id="search" class="search-submit" value="Pretraga" />
            </form>
          </div>
        </div>
        <!-- End Search -->
        <!-- Categories -->
        <div class="box categories">
          <h2>Kategorije <span></span></h2>
          <div>
            <ul>
              <li><a onclick="show1()"><i class="fas fa-plus-circle"></i></a>
                <a onclick="searchCategorie('Odrasli')">Odrasli</a>
                <ul id="showcategorie1">
                  <li id="subcategorie" onclick="searchCategorie('Odrasli','M')"><a>Muškarci</a></li>
                  <li id="subcategorie" onclick="searchCategorie('Odrasli','Z')"><a>Žene</a></li>
                </ul>
              </li>
              <li><a onclick="show2()"><i class="fas fa-plus-circle"></i></a>
                <a onclick="searchCategorie('Deca')"> Deca</a>
                <ul id="showcategorie2">
                  <li id="subcategorie" onclick="searchCategorie('Deca','M')"><a>Dečaci</a></li>
                  <li id="subcategorie" onclick="searchCategorie('Deca','Z')"><a>Devojčice</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- End Categories -->
      </div>
      <div id="content" class="col-md-9">
        <!-- Content Slider -->
        <div id="slider" class="box">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="img/carousel1.png" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/carousel2.png" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/carousel4.png" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <!-- End Content Slider -->
        <!-- Products -->
        <div class="products">
          <div class="cl">&nbsp;</div>
          <ul>
            <li> <a href="#"><img src="img/super.jpg" alt="super" /></a>
              <div class="product-info">
                <h3>Duks</h3>
                <div class="product-desc">
                  <button onclick="addToCart('super')" class="btn btn-primary">Dodaj u korpu</button>
                </div>
              </div>
            </li>
            <li> <a href="#"><img class="middle" src="img/dog.jpg" alt="super" /></a>
              <div class="product-info">
                <h3>Majica</h3>
                <div class="product-desc">
                  <button onclick="addToCart('snupi')" class="btn btn-primary">Dodaj u korpu</button>
                </div>
              </div>
            </li>
            <li> <a href="#" class="last"><img src="img/snupi.jpg" alt="super" /></a>
              <div class="product-info">
                <h3>Duks</h3>
                <div class="product-desc">
                  <button onclick="addToCart('snupi')" class="btn btn-primary">Dodaj u korpu</button>
                </div>
              </div>
            </li>
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