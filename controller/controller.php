<?php
require_once("../db/conexion.php");
include "../model/modelo.php";

error_reporting(0);

$modelo = new Modelo();

switch ($_POST["accion"]) {

	case 'registrar_participantes':
		echo json_encode($modelo->registrar_participantes($_POST["data"]));
		break;

	case 'buscar_participante':
		echo json_encode($modelo->buscar_participante($_POST["email"]));
		break;

	case 'actualizar_asistencia':
		echo json_encode($modelo->actualizar_asistencia($_POST["email"]));
		break;

	case 'imprimir_certificado':
		echo json_encode($modelo->imprimir_certificado($_POST["codigo"]));
		break;

	case 'login':
		echo json_encode($modelo->login($_POST["correo"], $_POST["clave"]));
		break;

	default:
		# code...
		break;
}
?>
