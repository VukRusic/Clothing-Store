<?php
include "connect.php";
$cena = $_POST['cenap'];
$status = $_POST['statusp'];
$naziv = $_POST['nazivp'];

?>
<form id="formUpdatePriceStatus">
    <input type="hidden" name="naziv" value="<?=$naziv?>">
    <label>Cena: </label>
    <input value="<?=$cena?>" name="newCena" size="15"><br>
    <label>Status: </label>
    <input value="<?=$status?>" name="newStatus" size="15"><br>
    <input type="button" onclick="changePriceStatus()" value="Sačuvaj promene" class="btn btn-success upbtn">
</form>
<script>
    function changePriceStatus(){
      var form = $('#formUpdatePriceStatus').serialize();
      $.ajax({
        url: "php/changePriceStatus.php",
        method: "POST",
        data: form,
        success: function(response) {
          if(response == "Success"){
            showCustomize();
          }
        }
      });
    }
</script>