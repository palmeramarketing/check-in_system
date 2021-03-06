<?php
require_once("../db/conexion.php");
include "../model/modelo.php";

session_start();
  if (isset($_REQUEST["login"])){
    $_SESSION["login"] = $_REQUEST["login"];
    $modelo = new Modelo();
    $user= $modelo->buscarUsuario($_SESSION["login"]);
    $logeo= $user["logeado"];
    if($logeo == 0){
      header("Location: login.html");
      exit;
    }

  }else if (!isset($_SESSION["login"]) && ($logeo == '0')) {
    header("Location: login.html");
    exit;
  }


?>

<!DOCTYPE html>
<html lang=es>
	 <head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>CHECK-IN</title>
			<meta content="http://mundialcw.com/images/cropped-favicon-270x270.png" name="msapplication-TileImage">
			<link href="http://mundialcw.com/images/cropped-favicon-32x32.png" rel="icon" sizes="32x32">
			<link href="http://mundialcw.com/images/cropped-favicon-192x192.png" rel="icon" sizes="192x192">
			<link href="http://mundialcw.com/images/cropped-favicon-180x180.png" rel="apple-touch-icon-precomposed">
			<!-- Bootstrap y CSS -->
			<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
			<link href="../assets/css/fonts.css" rel="stylesheet">
			<link href="../assets/css/index.css" rel="stylesheet">
			<!-- Jquery -->
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery.validate.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-ui.min.js"></script>
	 </head>
	 <body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">
					<div id="imagen_header_logo" class="centrar">
						<img src="../assets/images/logo_header.png" alt="">
					</div>
				</div>
			</div>
			<div  style="text-align: right; margin: 10px auto; margin-right: 20px;">
				<a href="../controller/salir.php">SALIR <img src="../assets/images/close.jpg" alt="" width="40px"></a>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">
					<div id="imagen_header">
						<img src="../assets/images/header.png" alt="" width="100%">
					</div>
				</div>
			</div>

      <div class="row background_azul" id="formRegistro">
        <div class="col-lg-offset-1 col-md-offset-1  col-sm-offset-1 col-xs-offset-1 col-lg-10  col-md-10  col-sm-10 col-xs-10 text-center ">
					<div id="div_contenedor_formulario">
						<div id="div_parrafo_superior_formulario" class="centrar">
							<p class="text_book p_texto_blanco">
								Hola <?php echo $user["nombre"];?> <br>

								Regístrate ya y disfruta <br>de éstas increíbles ponencias <br>en nuestro Business Lounge
							</p>
						</div>
						<form class="form-horizontal" method="post" id="form_register">
	            <input class="form-control input-form" type="text" tabindex="1" placeholder="NOMBRES:" name="nombre" id="nombre" />
	            <input class="form-control input-form" type="text" tabindex="2" placeholder="1er APELLIDO:" name="apellido_1" id="apellido_1"/>
	            <input class="form-control input-form" type="text" tabindex="3" placeholder="2do. APELLIDO:" name="apellido_2" id="apellido_2"/>
	            <input class="form-control input-form" type="text" tabindex="4" placeholder="ESPECIALIDAD:" name="especialidad" id="especialidad" />
	            <input class="form-control input-form" type="text" tabindex="5" placeholder="No. COLEGIADO:" name="colegiado" id="colegiado" />
	            <input class="form-control input-form" type="text" tabindex="6" placeholder="No. CELULAR:" name="celular" id="celular" />
	            <input class="form-control input-form" type="text" tabindex="7" placeholder="EMAIL:" name="email" id="email" />
	            <input class="form-control input-form" type="text" tabindex="8" placeholder="CIUDAD:" name="ciudad" id="ciudad" />
	            <input class="form-control input-form" type="text" tabindex="9" placeholder="PAÍS:" name="pais" id="pais" />
	            <input class="form-control input-form" type="text" tabindex="10" placeholder="DIRECCIÓN:" name="direccion" id="direccion" />
	            <input class="form-control input-form" type="text" tabindex="11" placeholder="TELÉFONO:" name="telefono" id="telefono" onkeypress="doKey(arguments[0] || window.event)" maxlength="13" />
							<input type="hidden" name="url" id="url" value="../controller/controller.php">
							<input type="hidden" name="url_gracias" id="url_gracias" value="../view/gracias.html"/>
							<input type="hidden" value="150" name="id_evento" id="id_evento">
	            <div class="center-button">
	            	<button type="submit" class="btn button-form">CONFIRMAR</button>
	            </div>
		        </form>
					</div>
        </div>
      </div>



			<div class="row content-footer" id="row_footer">
				<div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<img src="../assets/images/logo_footer.png" class="img-responsive logo-header">
					</div>
					<div class="col-xs-12 col-sm-9 col-md-8 col-md-offset-1">
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0">
								<div class="a"><a target="_blank" href="https://www.facebook.com/candwbusiness"><img src="../assets/images/C&W_Landing_FB.png" class="img-responsive logo-header"><span>candwbusiness</span></a></div>
							</div>
							<div class="col-xs-5 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0">
								<div class="a"><a target="_blank" href="https://twitter.com/CandWBusiness"><img src="../assets/images/C&W_Landing_TW.png" class="img-responsive logo-header"><span>@CandWBusiness</span></a></div>
							</div>
							<div class="col-xs-5 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0">
								<div class="a"><a target="_blank" href="https://vimeo.com/cwbusiness"><img src="../assets/images/C&W_Landing_YT.png" class="img-responsive logo-header"><span>C&W Business</span></a></div>
							</div>
							<div class="col-xs-5 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0">
								<div class="a"><a target="_blank" href="https://www.linkedin.com/company/c&w-business"><img src="../assets/images/logo_linkedin.png" class="img-responsive logo-header"><span>C&W Business</span></a></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 a">
								<p class="a text-center">Bogotá, Calle 108 45-30 Torre 3, Piso 7-9 y 10, Edif. Paralelo 108. Teléfono: +5714291400.</p>
								<p class="a text-center"><a href="http://palmera.marketing/wp-content/uploads/2018/05/Notice_of_Privacy.pdf" target="_blank" style="text-decoration:none;font-size: 12px; ">Aviso de Privacidad - Protección de datos personales Palmera Marketing S.A.S.</a></p>
							</div>
						</div>
				 </div>
			 </div>
		 </div>

    </div>




   </body>
	 <!-- JS -->
	 <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	 <script src="../assets/js/validate.js"></script>

</html>
