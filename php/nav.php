<?php
if (isset($_SESSION['username'])) {
  $user = $_SESSION['username'];
} else {
  $user = "";
}

?>

<div id="header">
  <h1 id="logo"><a href="#"><img src="img/logo.jpg"></a></h1>
  <!-- Cart -->
  <div id="cart"><a id="showCart" onclick="showPageAjax('showCart')"><i class="fas fa-shopping-cart fa-2x"></i> Vaša korpa</a>
    <div class="cl">&nbsp;</div>
    <span>Broj artikala: <strong><span id="quantity">0</span></strong></span> &nbsp;&nbsp;
  </div>
  <!-- End Cart -->
  <!-- Navigation -->
  <div id="navigation">
    <ul>
      <li><a href="index.php" id="pocetna" class="navItem">Početna</a></li>
      <li><a id="services" class="navItem" onclick="showPageAjax('services')">Usluge</a></li>
      <?php if ($user == "admin") { ?>
        <li><a id="admin" class="navItem" onclick="showPageAjax('admin')">Porudžbine</a></li>
        <li><a id="customize" class="navItem" onclick="showPageAjax('customize')">Editovanje</a></li>
      <?php } else { ?>
        <li><a id="user" class="navItem" onclick="openLoginForm()">Moj nalog</a></li>
      <?php } ?>
      <li><a id="kontakt" class="navItem">Kontakt</a></li>
      <li>
        <a id="signOut" href="php/logOut.php">Log out <i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </div>

  <div class="popup-overlay"></div>
  <div class="popup" id="popup">
    <div class="popup-close" onclick="closeLoginForm()"><i class="fas fa-times"></i></div>
    <div class="form">
      <form class="form" id="formLogin">
        <div class="avatar">
          <i class="fas fa-user fa-7x"></i>
        </div>
        <div class="header">
          Login
        </div>
        <p id="poruka"></p>
        <div class="element">
          <label for="username">Email</label>
          <input type="text" id="email" name="Email">
        </div>
        <div class="element">
          <label for="password">Password</label>
          <input type="password" id="password" name="Password">
        </div>
      </form>
      <div class="element">
        <button id="loginBtn">Login</button>
      </div>
      <div class="element">
        Nemate nalog?
        <button onclick="showPageAjax('reg')">Registruj se</button>
      </div>
    </div>
  </div>

  <!-- End Navigation -->

  <script>
    $(document).ready(function() {
      $('#pocetna').addClass('active');
      <?php
      if (isset($_SESSION['username'])) { ?>
        updateQuantity();
      <?php } else { ?>
        $('#signOut').css("display", "none");
      <?php } ?>
    });

    function openLoginForm() {
      <?php
      if (isset($_SESSION['username'])) { ?>
        showPageAjax('user');
      <?php } else { ?>
        document.body.classList.add("showLoginForm");
      <?php } ?>
    };

    function closeLoginForm() {
      document.body.classList.remove("showLoginForm");
    };

    function updateQuantity() {
      $.ajax({
        type: 'get',
        url: 'php/getQuantity.php',
        cache: false,
        success: function(quantity) {
          $('#quantity').html(quantity);
        }
      });
    }

    $('#loginBtn').click(function() {
      var form = $('#formLogin').serialize();
      $.ajax({
        url: "php/login.php",
        type: "POST",
        cache: false,
        data: form,
        success: function(response) {
          if (response == "success") {
            window.location.reload();
          } else if (response == "admin") {
            window.location.reload();
          } else {
            $('#poruka').html(response);
          }
        }
      });
    });

    function showPageAjax(page) {
      $.ajax({
        type: 'get',
        url: 'php/' + page + '.php',
        success: function(data) {
          $('#main').html(data);
          if(page == 'showCart'){
            updateQuantity();
          }
          navItems = document.querySelectorAll('.navItem');
          navItems.forEach(function(item) {
            item.classList.remove("active")
          })
          if(page == "reg"){
            closeLoginForm();
            $('#user').addClass('active');
          } else {
          $('#' + page).addClass('active');
          }
        }
      });
    }
  </script>
</div>