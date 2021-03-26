<?php
$mysqli = new mysqli("localhost", "root", "", "shop");
if($mysqli->error)
{
    die("Greska: " . $mysqli->error);
}

?>