<?php
require_once("../db/conexion.php");
include "../model/modelo.php";

error_reporting(0);

$Modelo = new Modelo();

switch ($_POST["accion"]) {

	case 'registrar_participantes':
		echo json_encode($Modelo->registrar_participantes($_POST["data"]));
		break;
	
	default:
		# code...
		break;
}
?>