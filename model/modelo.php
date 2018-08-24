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

	function registrar_participante_sistema_eventos($datos, $conexion){
		$sql = "INSERT INTO participante (email,nombre,apellido,direccion,telefono,estatus)
				VALUES ('".$datos["email"]."','".$datos["nombre"]."','".$datos["apellido_1"]."','".$datos["direccion"]."','".$datos["telefono"]."','1')";
		$resp = $conexion->sql_insert_update($sql,true);
		if ($resp["status"] == 1062) {
			return self::update_participante_sistema_eventos($datos, $conexion);
		}
		return $resp;
	}

	function update_participante_sistema_eventos($datos, $conexion){
		$sql = "UPDATE participante SET nombre = '".$datos["nombre"]."', apellido = '".$datos["apellido_1"]."', direccion = '".$datos["direccion"]."', telefono = '".$datos["telefono"]."' WHERE email = '".$datos["email"]."'";
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
			return $ejecutar["data"];
		}else{
			return $ejecutar["status"];
		}
	}

	function actualizar_asistencia($email){
		$conexion = new Recursos();
		$sql= "UPDATE participantes SET asistencia='Con asistencia' WHERE email='$email'";
		$ejecutar= $conexion->sql_insert_update($sql);

		if($ejecutar["status"] == 200){
			return $ejecutar["data"];
		}else{
			return $ejecutar["status"];
		}
	}

	function imprimir_certificado($datos, $imprimir = false){
		$conexion = new Recursos();
		$id_evento= $datos["id_evento"];
		$codigo= $datos["cod_part"];
		$select = "SELECT *
							FROM participantes par
							INNER JOIN clave_participante clave
							ON par.id = clave.id_participante
							INNER JOIN certificado cer
							ON clave.id_evento = cer.id_evento
							WHERE par.email= '$codigo' or par.colegiado='$codigo' and clave.id_evento=$id_evento";

		$datos = $conexion->sql_select($select);
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
			$sql = "INSERT INTO usuario (email, nombre, password, tipo, estatus)
			VALUES ('".$datos["email"]."','".$datos["usuario"]."','".$datos["password"]."', 'admin', 1)";
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
		$mail->Subject = 'Codigo de Verificacion';
		$mail->msgHTML('
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
		  <!-- NAME: HERO IMAGE -->
		    <!--[if gte mso 15]>
		<xml>
		  <o:OfficeDocumentSettings>
		  <o:AllowPNG/>
		  <o:PixelsPerInch>96</o:PixelsPerInch>
		  </o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1">


		<style type="text/css">
		p{
		  margin:10px 0;
		  padding:0;
		}
		table{
		  border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
		  display:block;
		  margin:0;
		  padding:0;
		}
		img,a img{
		  border:0;
		  height:auto;
		  outline:none;
		  text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
		  height:100%;
		  margin:0;
		  padding:0;
		  width:100%;
		}
		.mcnPreviewText{
		  display:none !important;
		}
		#outlook a{
		  padding:0;
		}
		img{
		  -ms-interpolation-mode:bicubic;
		}
		table{
		  mso-table-lspace:0pt;
		  mso-table-rspace:0pt;
		}
		.ReadMsgBody{
		  width:100%;
		}
		.ExternalClass{
		  width:100%;
		}
		p,a,li,td,blockquote{
		  mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
		  color:inherit;
		  cursor:default;
		  text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
		  -ms-text-size-adjust:100%;
		  -webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
		  line-height:100%;
		}
		a[x-apple-data-detectors]{
		  color:inherit !important;
		  text-decoration:none !important;
		  font-size:inherit !important;
		  font-family:inherit !important;
		  font-weight:inherit !important;
		  line-height:inherit !important;
		}
		a.mcnButton{
		  display:block;
		}
		.mcnImage,.mcnRetinaImage{
		  vertical-align:bottom;
		}
		.mcnTextContent{
		  word-break:break-word;
		}
		.mcnTextContent img{
		  height:auto !important;
		}
		.mcnDividerBlock{
		  table-layout:fixed !important;
		}
		body,#bodyTable{
		  background-color:#ffffff;
		}
		#bodyCell{
		  border-top:0;
		}
		#templateContainer{
		  border:0;
		}
		h1{
		  color:#FFFFFF !important;
		  font-family:Helvetica;
		  font-size:30px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:100%;
		  letter-spacing:-1px;
		  text-align:center;
		}
		h2{
		  color:#232327 !important;
		  font-family:Helvetica;
		  font-size:18px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:-.75px;
		  text-align:left;
		}
		h3{
		  color:#2e0b4a !important;
		  font-family:Helvetica;
		  font-size:26px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:-.5px;
		  text-align:left;
		}
		h4{
		  color:#AAAAAA !important;
		  font-family:Helvetica;
		  font-size:18px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:normal;
		  text-align:right;
		}
		#templatePreheader{
		  background-color:#ffffff;
		  border-top:0;
		  border-bottom:0;
		}
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:11px;
		  line-height:125%;
		  text-align:left;
		}
		.preheaderContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateHeader{
		  background-color:#ffffff;
		  border-top:0;
		  border-bottom:0;
		}
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:18px;
		  line-height:150%;
		  text-align:center;
		}
		.headerContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateUpperBody{
		  background-color:#FFFFFF;
		  border-top:1px none #000000;
		  border-bottom:0;
		}
		.upperBodyContainer .mcnTextContent,.upperBodyContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:16px;
		  line-height:150%;
		  text-align:left;
		}
		.upperBodyContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateColumns{
		  background-color:#FFFFFF;
		  border-top:0;
		  border-bottom:0;
		}
		.leftColumnContainer .mcnTextContent,.leftColumnContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:14px;
		  line-height:150%;
		  text-align:left;
		}
		.leftColumnContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		.rightColumnContainer .mcnTextContent,.rightColumnContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:14px;
		  line-height:150%;
		  text-align:left;
		}
		.rightColumnContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateLowerBody{

		  border-top:0;
		  border-bottom:0;
		}
		.lowerBodyContainer .mcnTextContent,.lowerBodyContainer .mcnTextContent p{
		  color:#AAAAAA;
		  font-family:Helvetica;
		  font-size:16px;
		  line-height:150%;
		  text-align:left;
		}
		.lowerBodyContainer .mcnTextContent a{
		  color:#AAAAAA;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateFooter{
		  border-top:0;
		  border-bottom:0;
		}
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:11px;
		  line-height:125%;
		  text-align:center;
		}
		.footerContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
		  -webkit-text-size-adjust:none !important;
		}

		}	@media only screen and (max-width: 480px){
		body{
		  width:100% !important;
		  min-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		#bodyCell{
		  padding-top:10px !important;
		}

		}	@media only screen and (max-width: 480px){
		#templateContainer,#templatePreheader,#templateHeader,#templateColumns,#templateUpperBody,#templateLowerBody,#templateFooter{
		  max-width:700px !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.columnsContainer{
		  display:block!important;
		  max-width:700px !important;
		  width:100%!important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
		  max-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImage{
		  height:auto !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
		  max-width:100% !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
		  min-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
		  padding:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
		  padding-top:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
		  padding-top:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
		  padding-bottom:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
		  padding-top:0 !important;
		  padding-bottom:0 !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
		  padding-top:9px !important;
		  padding-bottom:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
		  padding-right:18px !important;
		  padding-left:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
		  padding-right:18px !important;
		  padding-bottom:0 !important;
		  padding-left:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
		  display:none !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		h1{
		  font-size:24px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h2{
		  font-size:20px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h3{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h4{
		  font-size:16px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		#templatePreheader{
		  display:block !important;
		}

		}	@media only screen and (max-width: 480px){
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
		  font-size:14px !important;
		  line-height:115% !important;
		}

		}	@media only screen and (max-width: 480px){
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.upperBodyContainer .mcnTextContent,.upperBodyContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.lowerBodyContainer .mcnTextContent,.lowerBodyContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.leftColumnContainer .mcnTextContent,.leftColumnContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.rightColumnContainer .mcnTextContent,.rightColumnContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
		  font-size:14px !important;
		  line-height:115% !important;
		}

		}</style>
		<style>
		      #row_footer{
		      background-color: #301d5a;
		    }
		    .logo-header {
		        height: auto;
		        margin: 15px auto 15px auto;
		    }
		    div.a{
		      padding-top: 10px;
		    }
		    .a>a{
		      color: white;

		    }
		    .a>a>img{
		      width:25px;
		      float:left;
		      margin:0px
		    }
		    .a>a>span{
		      font-size: 18px;
		      margin-left: 5px;
		    }
		    p.a{
		      font-size: 18px;
		      margin-left: 5px;
		      color:white;
		    }
		    </style></head>
		<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;">
		<center>
		<table id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #ffffff;" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tbody>
		<tr>
		  <td id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;border-top: 0;" valign="top" align="center"><!-- BEGIN TEMPLATE // -->
		  <table id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		    <tbody>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN PREHEADER // -->
		        <table id="templatePreheader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;border-top: 0;border-bottom: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="preheaderContainer" style="padding-top: 9px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnImageBlockOuter">
		                  <tr>
		                    <td class="mcnImageBlockInner" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		                    <table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnImageContent" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><img alt="" class="mcnImage" src="http://palmera.marketing/check-in_system/assets/images/logo_header.png" style="max-width: 800px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"  align="middle"></td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END PREHEADER --></td>
		      </tr>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN HEADER // -->
		        <table id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;border-top: 0;border-bottom: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="headerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnImageBlockOuter">
		                  <tr>
		                    <td class="mcnImageBlockInner" style="padding: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		                    <table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnImageContent" style="padding-right: 0px;padding-left: 0px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><img alt="" class="mcnImage" src="http://palmera.marketing/check-in_system/assets/images/header.png" style="max-width: 800px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="700" align="middle"></td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END HEADER --></td>
		      </tr>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN UPPER BODY // -->
		        <table id="templateUpperBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 1px none #000000;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="upperBodyContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnTextBlockOuter">
		                  <tr>
		                    <td class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><!--[if mso]>
		    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
		    <tr>
		    <![endif]--><!--[if mso]>
		    <td valign="top" width="700" style="width:700px;">
		    <![endif]-->
		                    <table class="mcnTextContentContainer" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #232327;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;" valign="top">
		                          <div style="width: 100%; text-align: center;">
		                            <p style="text-align: center; font-size: 25pt">GRACIAS POR SU <br> REGISTRO</p>
		                          </div>
		                          </td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    <!--[if mso]>
		    </td>
		    <![endif]--><!--[if mso]>
		    </tr>
		    </table>
		    <![endif]--></td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END UPPER BODY --></td>
		      </tr>



		      <tr>
		        <td style=" padding-bottom: 40px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN FOOTER // -->
		            <tr>
		              <td class="mcnDividerBlockInner" style="min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
		              <table class="mcnDividerContent" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody>
		                  <tr>
		                    <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="">
		                    <div>
		                    <div>
		                    <table style="width: 100%;">
		                      <tbody>
		                        <tr>
		                          <td style="padding-top: 10px;" class="">
		                          <center>
		                          <table>
		                            <tbody>
		                              <tr>
		                                <td>
		                                <div style="padding-bottom: 10px;"><img src="http://palmera.marketing/check-in_system/assets/images/footer.png" style="max-width: 700px;float: left;">
		                                </div>
		                                </td>
		                              </tr>
		                            </tbody>
		                          </table>
		                          </center>
		                          </td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </div>
		                    </div>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              <!--
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		            <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
		--></td>
		            </tr>
		        </td>
		      </tr>
		    </tbody>
		  </table>
		        <!-- // END FOOTER --></td>
		      </tr>
		    </tbody>
		  </table>
		  <!-- // END TEMPLATE --></td>
		</tr>
		</tbody>
		</table>
		</center>
		</body>
		</html>'
		);
		$mail->AltBody = 'Agracias por Actualizar sus datos.';
		$mail->send();
	}

	function envioCorreoPasswd($email, $pass) {
	  	$mail = new PHPMailer;
		$mail->setFrom('info@cwc.com', 'MENARINI');
		$mail->addAddress($email,'');
		$mail->Subject = 'Reestablecer password';
		$mail->msgHTML('
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
		  <!-- NAME: HERO IMAGE -->
		    <!--[if gte mso 15]>
		<xml>
		  <o:OfficeDocumentSettings>
		  <o:AllowPNG/>
		  <o:PixelsPerInch>96</o:PixelsPerInch>
		  </o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1">


		<style type="text/css">
		p{
		  margin:10px 0;
		  padding:0;
		}
		table{
		  border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
		  display:block;
		  margin:0;
		  padding:0;
		}
		img,a img{
		  border:0;
		  height:auto;
		  outline:none;
		  text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
		  height:100%;
		  margin:0;
		  padding:0;
		  width:100%;
		}
		.mcnPreviewText{
		  display:none !important;
		}
		#outlook a{
		  padding:0;
		}
		img{
		  -ms-interpolation-mode:bicubic;
		}
		table{
		  mso-table-lspace:0pt;
		  mso-table-rspace:0pt;
		}
		.ReadMsgBody{
		  width:100%;
		}
		.ExternalClass{
		  width:100%;
		}
		p,a,li,td,blockquote{
		  mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
		  color:inherit;
		  cursor:default;
		  text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
		  -ms-text-size-adjust:100%;
		  -webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
		  line-height:100%;
		}
		a[x-apple-data-detectors]{
		  color:inherit !important;
		  text-decoration:none !important;
		  font-size:inherit !important;
		  font-family:inherit !important;
		  font-weight:inherit !important;
		  line-height:inherit !important;
		}
		a.mcnButton{
		  display:block;
		}
		.mcnImage,.mcnRetinaImage{
		  vertical-align:bottom;
		}
		.mcnTextContent{
		  word-break:break-word;
		}
		.mcnTextContent img{
		  height:auto !important;
		}
		.mcnDividerBlock{
		  table-layout:fixed !important;
		}
		body,#bodyTable{
		  background-color:#ffffff;
		}
		#bodyCell{
		  border-top:0;
		}
		#templateContainer{
		  border:0;
		}
		h1{
		  color:#FFFFFF !important;
		  font-family:Helvetica;
		  font-size:30px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:100%;
		  letter-spacing:-1px;
		  text-align:center;
		}
		h2{
		  color:#232327 !important;
		  font-family:Helvetica;
		  font-size:18px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:-.75px;
		  text-align:left;
		}
		h3{
		  color:#2e0b4a !important;
		  font-family:Helvetica;
		  font-size:26px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:-.5px;
		  text-align:left;
		}
		h4{
		  color:#AAAAAA !important;
		  font-family:Helvetica;
		  font-size:18px;
		  font-style:normal;
		  font-weight:bold;
		  line-height:125%;
		  letter-spacing:normal;
		  text-align:right;
		}
		#templatePreheader{
		  background-color:#ffffff;
		  border-top:0;
		  border-bottom:0;
		}
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:11px;
		  line-height:125%;
		  text-align:left;
		}
		.preheaderContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateHeader{
		  background-color:#ffffff;
		  border-top:0;
		  border-bottom:0;
		}
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:18px;
		  line-height:150%;
		  text-align:center;
		}
		.headerContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateUpperBody{
		  background-color:#FFFFFF;
		  border-top:1px none #000000;
		  border-bottom:0;
		}
		.upperBodyContainer .mcnTextContent,.upperBodyContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:16px;
		  line-height:150%;
		  text-align:left;
		}
		.upperBodyContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateColumns{
		  background-color:#FFFFFF;
		  border-top:0;
		  border-bottom:0;
		}
		.leftColumnContainer .mcnTextContent,.leftColumnContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:14px;
		  line-height:150%;
		  text-align:left;
		}
		.leftColumnContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		.rightColumnContainer .mcnTextContent,.rightColumnContainer .mcnTextContent p{
		  color:#232327;
		  font-family:Helvetica;
		  font-size:14px;
		  line-height:150%;
		  text-align:left;
		}
		.rightColumnContainer .mcnTextContent a{
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateLowerBody{

		  border-top:0;
		  border-bottom:0;
		}
		.lowerBodyContainer .mcnTextContent,.lowerBodyContainer .mcnTextContent p{
		  color:#AAAAAA;
		  font-family:Helvetica;
		  font-size:16px;
		  line-height:150%;
		  text-align:left;
		}
		.lowerBodyContainer .mcnTextContent a{
		  color:#AAAAAA;
		  font-weight:normal;
		  text-decoration:underline;
		}
		#templateFooter{
		  border-top:0;
		  border-bottom:0;
		}
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
		  color:#FFFFFF;
		  font-family:Helvetica;
		  font-size:11px;
		  line-height:125%;
		  text-align:center;
		}
		.footerContainer .mcnTextContent a{
		  color:#FFFFFF;
		  font-weight:normal;
		  text-decoration:underline;
		}
		@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
		  -webkit-text-size-adjust:none !important;
		}

		}	@media only screen and (max-width: 480px){
		body{
		  width:100% !important;
		  min-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		#bodyCell{
		  padding-top:10px !important;
		}

		}	@media only screen and (max-width: 480px){
		#templateContainer,#templatePreheader,#templateHeader,#templateColumns,#templateUpperBody,#templateLowerBody,#templateFooter{
		  max-width:700px !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.columnsContainer{
		  display:block!important;
		  max-width:700px !important;
		  width:100%!important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
		  max-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImage{
		  height:auto !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
		  max-width:100% !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
		  min-width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
		  padding:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
		  padding-top:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
		  padding-top:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
		  padding-bottom:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
		  padding-top:0 !important;
		  padding-bottom:0 !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
		  padding-top:9px !important;
		  padding-bottom:9px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
		  padding-right:18px !important;
		  padding-left:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
		  padding-right:18px !important;
		  padding-bottom:0 !important;
		  padding-left:18px !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
		  display:none !important;
		  width:100% !important;
		}

		}	@media only screen and (max-width: 480px){
		h1{
		  font-size:24px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h2{
		  font-size:20px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h3{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		h4{
		  font-size:16px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		#templatePreheader{
		  display:block !important;
		}

		}	@media only screen and (max-width: 480px){
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
		  font-size:14px !important;
		  line-height:115% !important;
		}

		}	@media only screen and (max-width: 480px){
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.upperBodyContainer .mcnTextContent,.upperBodyContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.lowerBodyContainer .mcnTextContent,.lowerBodyContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.leftColumnContainer .mcnTextContent,.leftColumnContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.rightColumnContainer .mcnTextContent,.rightColumnContainer .mcnTextContent p{
		  font-size:18px !important;
		  line-height:125% !important;
		}

		}	@media only screen and (max-width: 480px){
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
		  font-size:14px !important;
		  line-height:115% !important;
		}

		}</style>
		<style>
		      #row_footer{
		      background-color: #301d5a;
		    }
		    .logo-header {
		        height: auto;
		        margin: 15px auto 15px auto;
		    }
		    div.a{
		      padding-top: 10px;
		    }
		    .a>a{
		      color: white;

		    }
		    .a>a>img{
		      width:25px;
		      float:left;
		      margin:0px
		    }
		    .a>a>span{
		      font-size: 18px;
		      margin-left: 5px;
		    }
		    p.a{
		      font-size: 18px;
		      margin-left: 5px;
		      color:white;
		    }
		    </style></head>
		<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;">
		<center>
		<table id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #ffffff;" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tbody>
		<tr>
		  <td id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;border-top: 0;" valign="top" align="center"><!-- BEGIN TEMPLATE // -->
		  <table id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		    <tbody>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN PREHEADER // -->
		        <table id="templatePreheader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;border-top: 0;border-bottom: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="preheaderContainer" style="padding-top: 9px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnImageBlockOuter">
		                  <tr>
		                    <td class="mcnImageBlockInner" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		                    <table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnImageContent" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><img alt="" class="mcnImage" src="http://palmera.marketing/check-in_system/assets/images/logo_header.png" style="max-width: 800px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"  align="middle"></td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END PREHEADER --></td>
		      </tr>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN HEADER // -->
		        <table id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;border-top: 0;border-bottom: 0;" width="700" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="headerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnImageBlockOuter">
		                  <tr>
		                    <td class="mcnImageBlockInner" style="padding: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		                    <table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnImageContent" style="padding-right: 0px;padding-left: 0px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><img alt="" class="mcnImage" src="http://palmera.marketing/check-in_system/assets/images/header.png" style="max-width: 800px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="700" align="middle"></td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END HEADER --></td>
		      </tr>
		      <tr>
		        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN UPPER BODY // -->
		        <table id="templateUpperBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 1px none #000000;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
		          <tbody>
		            <tr>
		              <td class="upperBodyContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
		              <table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody class="mcnTextBlockOuter">
		                  <tr>
		                    <td class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><!--[if mso]>
		    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
		    <tr>
		    <![endif]--><!--[if mso]>
		    <td valign="top" width="700" style="width:700px;">
		    <![endif]-->
		                    <table class="mcnTextContentContainer" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
		                      <tbody>
		                        <tr>
		                          <td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #232327;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;" valign="top">
		                          <div style="width: 100%; text-align: center;">
		                            <p style="text-align: center; font-size: 20pt">Su password ha sido reestablecido de manera exitosa</p>
		                          </div>
		                          <div style="width: 100%; text-align: center;">
		                            <p style="color: #adadad; text-align: center; font-size: 25pt"> PASSWORD: '.$pass.'</p>
		                          </div>
		                          <div style="width: 100%; text-align: center;">
		                            <p style="text-align: center; font-size: 20pt">Para mayor seguridad al ingresar con este password debera cambiarlo.</p>
		                          </div>
		                          </td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    <!--[if mso]>
		    </td>
		    <![endif]--><!--[if mso]>
		    </tr>
		    </table>
		    <![endif]--></td>
		                  </tr>
		                </tbody>
		              </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!-- // END UPPER BODY --></td>
		      </tr>


		      <tr>
		        <td style=" padding-bottom: 40px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center"><!-- BEGIN FOOTER // -->
		            <tr>
		              <td class="mcnDividerBlockInner" style="min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
		              <table class="mcnDividerContent" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
		                <tbody>
		                  <tr>
		                    <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="">
		                    <div>
		                    <div>
		                    <table style="width: 100%;">
		                      <tbody>
		                        <tr>
		                          <td style="padding-top: 10px;" class="">
		                          <center>
		                          <table>
		                            <tbody>
		                              <tr>
		                                <td>
		                                <div style="padding-bottom: 10px;"><img src="http://palmera.marketing/check-in_system/assets/images/footer.png" style="max-width: 700px;float: left;">
		                                </div>
		                                </td>
		                              </tr>
		                            </tbody>
		                          </table>
		                          </center>
		                          </td>
		                        </tr>
		                      </tbody>
		                    </table>
		                    </div>
		                    </div>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		              <!--
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		            <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
		--></td>
		            </tr>
		        </td>
		      </tr>
		    </tbody>
		  </table>
		        <!-- // END FOOTER --></td>
		      </tr>
		    </tbody>
		  </table>
		  <!-- // END TEMPLATE --></td>
		</tr>
		</tbody>
		</table>
		</center>
		</body>
		</html>'
		);
		$mail->AltBody = 'Agracias por Actualizar sus datos.';
		$mail->send();
	}
}

?>
