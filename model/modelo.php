<?php
error_reporting( E_ALL );

require_once("recursos.php");
require_once('../mailer/class.phpmailer.php');
require '../mailer/PHPMailerAutoload.php';
include "../model/pdf_generator.php";


class Modelo
{

	function registrar_participantes($datos){
		$sql = new Recursos();
		$result = "";
		$clave = "";
		$registro = self::registrar_participante_sistema_eventos($datos, $sql);
		if ($registro["status"] != 200) {
			return $registro;
		}
		$insert = "INSERT INTO participantes (nombre,apellido_1,apellido_2,especialidad,colegiado,celular,email,ciudad,pais,direccion,telefono,asistencia)
					VALUES ('".$datos["nombre"]."','".$datos["apellido_1"]."','".$datos["apellido_2"]."','".$datos["especialidad"]."','".$datos["colegiado"]."','".$datos["celular"]."','".$datos["email"]."','".$datos["ciudad"]."','".$datos["pais"]."','".$datos["direccion"]."','".$datos["telefono"]."','".$datos["asistencia"]."')";
		$result = $sql->sql_insert_update($insert);

		if ($result["status"] == 200) {
			$clave = $datos["id_evento"]."-".$result["data"];

			self::relacion_usuario_participante($datos["id_usuario"],$result["data"],$sql);

			$resp = self::registrar_clave_participante($clave,$result["data"],$datos["id_evento"]);

			if($resp["status"] = 200){

				$envioEmail= self::envioCorreo($datos["email"]);
				return $result;
			}

		}elseif ($result["status"] == 1062) {
			$update = "UPDATE participantes SET nombre = '".$datos["nombre"]."', apellido_1 = '".$datos["apellido_1"]."', apellido_2 = '".$datos["apellido_2"]."', especialidad = '".$datos["especialidad"]."', colegiado = '".$datos["colegiado"]."', celular = '".$datos["celular"]."', ciudad = '".$datos["ciudad"]."', pais = '".$datos["pais"]."', direccion = '".$datos["direccion"]."', telefono = '".$datos["telefono"]."' WHERE email = '".$datos["email"]."'";
			$result = $sql->sql_insert_update($update);
			return $result;
		}
	}

	function relacion_usuario_participante($id_usuario, $id_participante, $conexion){
		$sql = "INSERT INTO usuario_participante (fk_usuario,fk_participante)
				VALUES ('$id_usuario','$id_participante')";
		$conexion->sql_insert_update($sql);
	}

	function registrar_participante_sistema_eventos($datos, $conexion){
		$sql = "INSERT INTO participante (email,nombre,apellido,direccion,telefono,estatus, asistencia)
				VALUES ('".$datos["email"]."','".$datos["nombre"]."','".$datos["apellido_1"]."','".$datos["direccion"]."','".$datos["telefono"]."','1', '".$datos["asistencia"]."')";
		$resp = $conexion->sql_insert_update($sql,true);
		if ($resp["status"] == 1062) {
			return self::update_participante_sistema_eventos($datos, $conexion);
		}elseif ($resp["status"] == 200) {
			$sql = "INSERT INTO evento_participante (id_evento,id_participante)
				VALUES ('".$datos["id_evento"]."','".$resp["data"]."')";
			$resp = $conexion->sql_insert_update($sql,true);
		}
		return $resp;
	}

	function update_participante_sistema_eventos($datos, $conexion){
		$sql = "UPDATE participante SET nombre = '".$datos["nombre"]."', apellido = '".$datos["apellido_1"]."', direccion = '".$datos["direccion"]."', telefono = '".$datos["telefono"]."', asistencia = '".$datos["asistencia"]."' WHERE email = '".$datos["email"]."'";
		return $conexion->sql_insert_update($sql,true);
	}

	function registrar_clave_participante($clave, $id_participante, $id_evento){
		$sql = new Recursos();
		$insert = "INSERT INTO clave_participante (clave,id_participante,id_evento)
					VALUES ('".$clave."','".$id_participante."','".$id_evento."')";

		return $sql->sql_insert_update($insert);
	}

	function buscar_participante($email){
		$conexion = new Recursos();
		$sql= "SELECT * FROM participantes WHERE email='$email'";
		$ejecutar= $conexion->sql_select($sql);

		if ($ejecutar["status"] == 200) {
			self::update_participante_asistencia_eventos($email, $conexion);
			$sqlupdate= "UPDATE participantes SET asistencia='Con asistencia' WHERE email='$email'";
			$ejecutarupdate= $conexion->sql_insert_update($sqlupdate);

			if($ejecutarupdate["status"] == 200){
				self::envioCorreoAsistencia($email);
				return $ejecutar["data"];
			}else{
				return $ejecutarupdate["status"];
			}
		}else{
			return $ejecutar["status"];
		}
	}

	function update_participante_asistencia_eventos($email, $conexion){
		$sql = "UPDATE participante SET asistencia = 'Con asistencia' WHERE email = '$email'";
		return $conexion->sql_insert_update($sql,true);
	}
	function imprimir_certificado($datos, $imprimir = false){
		$conexion = new Recursos();
		$id_evento= $datos["id_evento"];
		$codigo= $datos["cod_part"];
		$select = "SELECT * FROM participantes WHERE email='$codigo' OR colegiado='$codigo'";
		$datos = $conexion->sql_select($select);
		if ($datos["status"] == 200) {
			$select = "SELECT * FROM certificado WHERE id_evento = $id_evento";
			$result = $conexion->sql_select($select,true);
			$datos["data"]["data_html"] = $result["data"]["data_html"];
		}else{
			header('Location: ../view/certificado.php?error="true"');
		}
		if ($imprimir) {
			if ($datos["status"] == 200) {
				$pdf = new PDF_generator();
				$pdf->imprimir_pdf($datos);
			}else{
				return $datos;
			}
		}else{
			return $datos;
		}
	}

	function imprimir_gafete($email){
		$pdf = new PDF_generator();
		$pdf->imprimir_gafete($email);
	}

	function guardar_certificado($data, $archivo){
		$conexion = new Recursos();
		$file_data = file_get_contents($archivo['tmp_name']);
		$insert = "INSERT INTO certificado (id_evento,nombre_certificado,data_html)
					VALUES ('".$data["id_evento"]."','".$data["nombre"]."','$file_data')";
		return $conexion->sql_insert_update($insert);
    }

	function login($correo, $clave){
		$conexion = new Recursos();
		$claveEn= md5($clave);
		$sql= "SELECT * FROM usuario WHERE email='$correo' AND password='$claveEn'";
		$ejecutar= $conexion->sql_select($sql);

		if ($ejecutar["status"] == 200) {

			if($ejecutar["data"]["estatus"] == 1){
				$sqlup= "UPDATE usuario SET  logeado=1 WHERE email='$correo'";
				$ejecutarup= $conexion->sql_insert_update($sqlup);
			}

			return $ejecutar["data"];
		}else{
			return $ejecutar["status"];
		}
	}

	function recuperar_password($correo){
		$conexion = new Recursos();
		$logitud = 6;
		$psswd = substr( md5(microtime()), 1, $logitud);
		$sql= "SELECT * FROM usuario WHERE email='$correo'";
		$ejecutar= $conexion->sql_select($sql);

		if($ejecutar['status']== 200){
			$nuevaclave= md5($psswd);
			$sqlUp= "UPDATE usuario SET password='$nuevaclave', estatus=2 WHERE email='$correo'";
			$ejecutarUpdate= $conexion->sql_insert_update($sqlUp);

			if($ejecutarUpdate["status"]== 200){
				$envioEmail= self::envioCorreoPasswd($correo, $psswd);
				return $psswd;
			}
		}else if ($ejecutar['status']== 404) {
			return $ejecutar["status"];
		}
	}

	function cambiar_password($correo, $pass){
		$conexion = new Recursos();
		$nuevaclave= md5($pass);
		$sql= "UPDATE usuario SET password='$nuevaclave', estatus=1 WHERE email='$correo'";
		$ejecutar= $conexion->sql_insert_update($sql);
		return $ejecutar['status'];

	}

	function buscarUsuario($id){
		$conexion = new Recursos();
		$sql= "SELECT * FROM usuario WHERE id=$id";
		$ejecutar= $conexion->sql_select($sql);
		return $ejecutar["data"];
	}

	function buscarAllUsuario(){
		$conexion = new Recursos();
		$sql= "SELECT * FROM usuario";
		$ejecutar= $conexion->sql_select($sql);
		return $ejecutar["data"];
	}

	function updateLogeo($id){
		$conexion = new Recursos();
		$sql= "UPDATE usuario SET logeado=0 WHERE id=$id";
		$ejecutar = $conexion->sql_insert_update($sql);
		return $ejecutar["status"];
    }

    function listar_evento(){
    	$conexion = new Recursos();
    	$sql = "SELECT * FROM evento WHERE estatus=1";
    	return $conexion->sql_select($sql);
    }

    function registrar_evento($datos){
    	$conexion = new Recursos();
    	$sql = "INSERT INTO evento (nombre,fecha,direccion)
    			VALUES ('".$datos["nombre"]."','".$datos["fecha"]."','".$datos["direccion"]."')";
    	return $conexion->sql_insert_update($sql);
    }

    function registrar_usuario($datos){
    	$conexion = new Recursos();
    	$nuevaclave= md5($datos["password"]);
			$sql = "INSERT INTO usuario (email, nombre, password, tipo, estatus)
			VALUES ('".$datos["email"]."','".$datos["usuario"]."','$nuevaclave', 'admin', 1)";
    	return $conexion->sql_insert_update($sql);
    }

    function modificar_usuario($datos){
    	$conexion = new Recursos();
			$sql = "UPDATE usuario SET estatus='".$datos['estatus']."', email='".$datos['email']."', tipo='".$datos['perfil']."', nombre='".$datos['nombre']."' WHERE id= ".$datos['id'];
    	return $conexion->sql_insert_update($sql);
    }

	function deshabilitar_usuario($datos){
		$conexion = new Recursos();
		$sql= "UPDATE usuario SET estatus=0 WHERE id=".$datos['id'];
		$ejecutar= $conexion->sql_insert_update($sql);
		return $ejecutar;
	}

	function envioCorreo($email) {
	  	$mail = new PHPMailer;
		$mail->setFrom('info@cwc.com', 'MENARINI');
		$mail->addAddress($email,'');
		$mail->Subject = 'Gracias por su Registro';
		$mail->msgHTML('
		<html lang="es">
		<head>
			<meta charset="UTF-8">
		</head>
		<body style="font-family: Helvetica; margin: 0px;">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center">
				<tbody>
					<tr>
						<td align="center"><img src="http://palmera.marketing/check-in_system/assets/images/menarini_icon.jpg" alt=""></td>
					</tr>
					<tr>
						<td><img src="http://palmera.marketing/check-in_system/assets/images/Gracias.jpg" alt="" width="100%"></td>
					</tr>
					<tr>
						<td align="center">
							<p style="font-size: 14pt; padding-top: 20px">Gracias por tu interés en participar <br>
							en nuestro evento:</p>
							<p style="font-size: 20pt;">IX Simposium de Centroamérica y el Caribe <br>
							de actualización en Odontoestomatología</p>
							<p style="font-size: 14pt; padding-bottom: 20px;">Uno de nuestros representantes <br>
							estará contactándote en los próximos días.</p>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle" style=" background-image: url(http://palmera.marketing/check-in_system/assets/images/fondo_asistir.jpg);background-repeat: no-repeat fixed center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; height: 100%; width: 100% ; text-align: center; padding: 20px;">
				    		<a href="https://www.facebook.com/MenariniCA/" target="_blank" style=" text-decoration: none; color: white;  margin: 2%;">
					    		<img src="http://palmera.marketing/check-in_system/assets/images/C&W_Landing_FB.png" alt="" width="23px">
					    		<span style="font-size: 18px; vertical-align: top;">MenariniCA</span>
					    	</a>

				    		<a href="https://twitter.com/menarinica?lang=es" target="_blank" style=" text-decoration: none; color: white; margin: 2%;">
					    		<img src="http://palmera.marketing/check-in_system/assets/images/C&W_Landing_TW.png" alt="" width="23px">
					    		<span style="font-size: 18px; vertical-align: top;">@MenariniCA</span>
					    	</a>

				    		<a href="https://www.youtube.com/user/MenariniCA" target="_blank" style=" text-decoration: none; color: white; margin: 2%;">
					    		<img src="http://palmera.marketing/check-in_system/assets/images/C&W_Landing_YT.png" alt="" width="23px">
					    		<span style="font-size: 18px; vertical-align: top;" >MenariniCA</span>
				    		</a>

				    		<a href="https://www.linkedin.com/company/grupomenarinicentroam%C3%A9ricayelcaribe/?originalSubdomain=ve" target="_blank" style=" text-decoration: none; color: white; margin: 2%;">
					    		<img src="http://palmera.marketing/check-in_system/assets/images/logo_linkedin.png" alt="" width="23px">
					    		<span style="font-size: 18px; vertical-align: top;">grupomenarini_ca</span>
					    	</a>

				    	</td>
					</tr>
					<tr>
						<td align="center" style="background: url(http://palmera.marketing/check-in_system/assets/images/footer_web.jpg); background-repeat: no-repeat fixed center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; height: 100%; width: 100% ; text-align: center; padding: 20px;"><span><a href="http://www.menarini-ca.com/" style=" text-decoration: none; color: white; font-size: 40px;">www.menarini-ca.com</a></span>
						</td>
					</tr>
				</tbody>
			</table>
		</body>
		</html>'
		);
		$mail->AltBody = 'Gracias por Actualizar sus datos.';
		$mail->send();
	}

	function envioCorreoAsistencia($email) {
	  	$mail = new PHPMailer;
		$mail->setFrom('info@cwc.com', 'MENARINI');
		$mail->addAddress($email,'');
		$mail->Subject = 'Gracias por su Asistencia';
		$mail->msgHTML('
		<html lang="es">
		<head>
			<meta charset="UTF-8">
		</head>
		<body style="font-family: Helvetica; margin: 0px;">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center">
				<tbody>
					<tr>
						<td><img  style="position: absolute; top: 0;" src="http://palmera.marketing/check-in_system/assets/images/Web_Confirmacion_Banner.jpg" alt="" width="100%"></td>
					</tr>
					<tr>
						<td align="center">
							<p style="font-size: 30pt; color: #2d4c72; padding: 20px;">Gracias por asistir a nuestro evento</p>

						</td>
					</tr>
				</tbody>
			</table>
		</body>
		</html>'
		);
		$mail->AltBody = 'Gracias por Asistir a nuetro evento.';
		$mail->send();
	}
}

?>
