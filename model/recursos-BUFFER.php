<?php



class Recursos

{



	function sql_select($sql, $change_db=false){

		$conexion = new Conexion();

		if ($change_db) {

			$mysqli = $conexion->conectar_mysqli("checkin_evento_u","sn*moqTiGFvN","evento_palmera");

		}else{

			$mysqli = $conexion->conectar_mysqli();

		}

		if ($mysqli["status"] == 200) {

			$result = $mysqli["data"]->query($sql);

			if ($result->num_rows > 0) {

				while($row = $result->fetch_array(MYSQLI_ASSOC)){

				   $arreglo[] = $row;

				}

				$conexion->cerrar_mysqli();

				if (count($arreglo) == 1){

					$arreglo = $arreglo[0];

				}

				return ["data"=>$arreglo, "error"=>"", "status"=>200];

			}else{

				$cod_error = ($mysqli["data"]->errno);

				$error = mysqli_error($mysqli["data"]);

				$conexion->cerrar_mysqli();

				if ($error) {

					return ["data"=>"", "error"=>$error, "status"=>404];

				}else{

					return ["data"=>"", "error"=>"The search does not match", "status"=>404];

				}

			}

		}else{

			$error = $mysqli["error"];

			$conexion->cerrar_mysqli();

			return ["data"=>"", "error"=>$error, "status"=>500];

		}

	}



	function sql_insert_update($sql, $change_db=false){

		$conexion = new Conexion();

		if ($change_db) {

			$mysqli = $conexion->conectar_mysqli("checkin_evento_u","sn*moqTiGFvN","evento_palmera");

		}else{

			$mysqli = $conexion->conectar_mysqli();

		}

		if($mysqli["status"] == 200){

			$result = $mysqli["data"]->query($sql);

			if ($result === true) {

				$id_pregunta = $mysqli["data"]->insert_id;

				return ["data"=>$id_pregunta, "error"=>"", "status"=>200];

			}else{

				$cod_error = ($mysqli["data"]->errno);

				$error = mysqli_error($mysqli["data"]);

				return ["data"=>"", "error"=>$error, "status"=>$cod_error];

			}

		}else{

			return ["data"=>"", "error"=>$mysqli["error"], "status"=>500];

		}

		$conexion->cerrar_mysqli();

	}



}

?>