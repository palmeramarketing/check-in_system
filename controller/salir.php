<?php
session_start();
session_destroy();

require_once("../db/conexion.php");
include "../model/modelo.php";
$modelo = new Modelo();
$modelo->updateLogeo($_SESSION["login"]);

header("Location: ../view/login.html");
?>
