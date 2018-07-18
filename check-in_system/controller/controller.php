<?php
require_once("../db/conexion.php");
include "../model/modelo.php";

error_reporting(0);

$Modelo = new Modelo();

switch ($_POST["accion"]) {

	case 'registrar_participantes':
		echo json_encode($Modelo->registrar_participantes($_POST["data"]));
		break;

	case 'buscar_participante':
		echo json_encode($Modelo->buscar_participante($_POST["email"]));
		break;

	case 'actualizar_asistencia':
		echo json_encode($Modelo->actualizar_asistencia($_POST["email"]));
		break;
		
	default:
		# code...
		break;
}
?>
