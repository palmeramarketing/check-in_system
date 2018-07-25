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

	case 'guardar_certificado':
		$archivo = $_FILES["archivo_html"];
		echo json_encode($modelo->guardar_certificado($_POST, $archivo));
		break;

	case 'imprimir_certificado':
		$modelo->imprimir_certificado($_POST["cod_part"],true);
		// echo json_encode($modelo->imprimir_certificado($_POST["codigo"]));
		break;
		
	default:
		# code...
		break;
}
?>
