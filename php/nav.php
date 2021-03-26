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
  <div id="cart"><a onclick="showCart()"><i class="fas fa-shopping-cart fa-2x"></i> Vaša korpa</a>
    <div class="cl">&nbsp;</div>
    <span>Broj artikala: <strong><span id="quantity">0</span></strong></span> &nbsp;&nbsp;
  </div>
  <!-- End Cart -->
  <!-- Navigation -->
  <div id="navigation">
    <ul>
      <li><a href="index.php" id="pocetna" class="active">Početna</a></li>
      <li><a href="#" id="usluge">Usluge</a></li>
      <?php if ($user == "admin") { ?>
        <li><a id="porudzbine" onclick="showAdmin()">Porudžbine</a></li>
        <li><a id="editovanje" onclick="showCustomize()">Editovanje</a></li> 
        <?php } else { ?>
        <li><a id="nalog" onclick="openLoginForm()">Moj nalog</a></li>
      <?php } ?>
      <li><a href="#" id="kontakt">Kontakt</a></li>
      <li>
        <a id="signOut" href="php/logOut.php">Log out <i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </div>

  <div class="popup-overlay"></div>
  <div class="popup" id="popup">
    <div class="popup-close" onclick="closeLoginForm()"><i class="fas fa-times"></i></div>
    <div class="form">
      <form class="form" id="form">
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
        <button id="submit">Login</button>
      </div>
      <div class="element">
        Nemate nalog?
        <button onclick="openRegistration()">Registruj se</button>
      </div>
    </div>
  </div>

  <!-- End Navigation -->

  <script>
    $(document).ready(function() {
      <?php
      if (isset($_SESSION['username'])) { ?>
        $('#quantity').html(<?php echo $_SESSION['quantity'] ?>)
      <?php } else { ?>
        $('#signOut').css("display", "none");
      <?php } ?>
    });

    function openLoginForm() {
      <?php
      if (isset($_SESSION['username'])) { ?>
        showUser();
      <?php } else { ?>
        document.body.classList.add("showLoginForm");
      <?php } ?>
    };

    function closeLoginForm() {
      document.body.classList.remove("showLoginForm");
    };

    function showUser() {
      closeLoginForm();
      $.ajax({
        type: 'get',
        url: 'php/user.php',
        cache: false,
        success: function(data) {
          $('#main').html(data);
          $('#pocetna').removeClass("active");
          $('#nalog').addClass("active");
          $('#signOut').css("display", "block");
        }
      });
    };

    function showAdmin() {
      closeLoginForm();
      $.ajax({
        type: 'get',
        url: 'php/admin.php',
        cache: false,
        success: function(data) {
          $('#main').html(data);
          $('#pocetna').removeClass("active");
          $('#editovanje').removeClass("active");
          $('#porudzbine').addClass("active");
          $('#signOut').css("display", "block");
        }
      });
    }

    function showCustomize() {
      $.ajax({
        type: 'get',
        url: 'php/customize.php',
        cache: false,
        success: function(data) {
          $('#main').html(data);
          $('#pocetna').removeClass("active");
          $('#porudzbine').removeClass("active");
          $('#editovanje').addClass("active");
        }
      });
    }

    $('#submit').click(function() {
      var form = $('#form').serialize();
      $.ajax({
        url: "php/login.php",
        type: "POST",
        cache: false,
        data: form,
        success: function(response) {
          if (response == "success") {
            window.location.reload(); 
          } else if(response == "admin") {
            window.location.reload(); 
          } else {
            $('#poruka').html(response);
          }
        }
      });
    });

    function openRegistration() {
      closeLoginForm();
      $.ajax({
        type: 'get',
        url: 'php/reg.php',
        success: function(data) {
          $('#main').html(data);
          $('#pocetna').removeClass("active");
          $('#nalog').addClass("active");
        }
      });
    }

    function showCart() {
      $.ajax({
        type: 'get',
        url: 'php/showCart.php',
        success: function(data) {
          $('#main').html(data);
          $('#pocetna').removeClass("active");
        }
      });
    }
  </script>
</div>