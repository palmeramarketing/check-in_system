<?php
error_reporting( E_ALL );

require_once("recursos.php");

class Modelo
{

	function registrar_participantes($datos){
		$sql = new Recursos();
		$result = "";
		$clave = "";
		$insert = "INSERT INTO participantes (nombre,apellido_1,apellido_2,especialidad,colegiado,celular,email,ciudad,pais,direccion,telefono)
					VALUES ('".$datos["nombre"]."','".$datos["apellido_1"]."','".$datos["apellido_2"]."','".$datos["especialidad"]."','".$datos["colegiado"]."','".$datos["celular"]."','".$datos["email"]."','".$datos["ciudad"]."','".$datos["pais"]."','".$datos["direccion"]."','".$datos["telefono"]."')";
		$result = $sql->sql_insert($insert);

		if ($result["status"] == 200) {
			$clave = $datos["id_evento"]."-".$result["data"];

			$resp = self::registrar_clave_participante($clave,$datos["id_evento"],$result["data"]);

			return $result;

		}elseif ($result["status"] == 1062) {
			$result_select = "";
			$select = "SELECT id FROM participantes WHERE email = '".$datos["email"]."'";
			$result_select = $sql->sql_select($select);
			return $result;
		}
	}

	function registrar_clave_participante($clave, $id_participante, $id_evento){
		$sql = new Recursos();
		$insert = "INSERT INTO clave_participante (clave,id_participante,id_evento)
					VALUES ('".$clave."','".$id_participante."','".$id_evento."')";

		return $sql->sql_insert($insert);
	}

	function buscar_participante($email){
		$conexion = new Recursos();
		$sql= "SELECT * FROM participantes WHERE email='$email'";
		$ejecutar= $conexion->sql_select($sql);

		if ($ejecutar["status"] == 200) {
			return $ejecutar["data"];
		}else{
			return $ejecutar["status"];
		}
	}

	function actualizar_asistencia($email){
		$conexion = new Recursos();
		$sql= "UPDATE participantes SET asistencia='Con asistencia' WHERE email='$email'";
		$ejecutar= $conexion->sql_insert($sql);

		if($ejecutar["status"] == 200){
			return $ejecutar["data"];
		}else{
			return $ejecutar["status"];
		}
	}

}


?>