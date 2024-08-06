<?php
if($_SESSION["id"]==NULL)
{
header("Location:index");
}
session_start();
include("baglan.php");
session_unset();
session_destroy();
header("Location:/kasa otomasyon");
?>