<?php
session_start();
  if (isset($_REQUEST["login"])){
    $_SESSION["login"] = $_REQUEST["login"];
  } elseif (!isset($_SESSION["login"])) {
    header("Location: login.html");
    exit;
  }
?>
<input type="hidden" id="login_id" name="login_id" value="<?php echo $_SESSION['login']; ?>">
<!DOCTYPE html>
<html lang=es>
	 <head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>CHECK-IN</title>
			<meta content="../assets/images/menarini_icon.jpg" name="msapplication-TileImage">
			<link href="../assets/images/menarini_icon.jpg" rel="icon" sizes="32x32">
			<link href="../assets/images/menarini_icon.jpg" rel="icon" sizes="192x192">
			<link href="../assets/images/menarini_icon.jpg" rel="apple-touch-icon-precomposed">
			<!-- Bootstrap y CSS -->
			<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
			<link href="../assets/css/fonts.css" rel="stylesheet">
			<link href="../assets/css/index.css" rel="stylesheet">
			<!-- Jquery -->
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery.validate.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-ui.min.js"></script>
      		<script type="text/javascript" src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/datatable/dataTables.bootstrap.js"></script>
			<script type="text/javascript" src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
			<style>
				.centrar-contenido {
					display: flex;
					justify-content: center;
				}
			</style>
	</head>
	<body style="background: #2c4c72;">
		<div class="container-fluid">
			<div class="row" style="background: #fff;">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">
					<div id="imagen_header_logo" class="centrar">
						<img src="../assets/images/menarini_icon.jpg" alt="">
					</div>
				</div>
			</div>

			<div class="row">
				<div id="form_background">
					<div id="div_contenedor_formulario">
						<div class="text-center p_texto_blanco"><h1>IX Simposium de Centroamérica y el Caribe <br>
							de actualización en Odontoestomatología</h1> 
						</div>
						<div id="div_parrafo_superior_formulario" class="centrar">
							<p class="text_book p_texto_blanco">
								Complete sus datos para asistir:
							</p>
						</div>
						<form class="form-horizontal" method="post" id="form_register">
						<div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="1" placeholder="NOMBRES:" name="nombre" id="nombre" />	
							</div>
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="2" placeholder="1er APELLIDO:" name="apellido_1" id="apellido_1"/>
							</div>
						</div>
						<div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="3" placeholder="2do. APELLIDO:" name="apellido_2" id="apellido_2"/>
							</div>
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="4" placeholder="ESPECIALIDAD:" name="especialidad" id="especialidad" />
							</div>
						</div>
						<div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="5" placeholder="No. COLEGIADO:" name="colegiado" id="colegiado" />
							</div>
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="6" placeholder="No. CELULAR:" name="celular" id="celular" />
							</div>
						</div>
						<div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="7" placeholder="EMAIL:" name="email" id="email" />
							</div>
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="8" placeholder="CIUDAD:" name="ciudad" id="ciudad" />
							</div>
						</div>
				        <div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="9" placeholder="PAÍS:" name="pais" id="pais" />
							</div>
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="10" placeholder="DIRECCIÓN:" name="direccion" id="direccion" />
							</div>
						</div>
						<div class="row centrar-contenido">
							<div class="col-xs-4">
								<input class="form-control input-form" type="text" tabindex="11" placeholder="TELÉFONO:" name="telefono" id="telefono" onkeypress="doKey(arguments[0] || window.event)" maxlength="13" />
							</div>
							<div class="col-xs-4" id="div_checkbox_terminos">
								<input type="checkbox" value="1" name="terminos" id="terminos" tabindex="12" class="ui-corner-all"><span id="span_terminos">*Acepto las políticas de manejo de datos</span>
							</div>
						</div>
							<input type="hidden" name="url" id="url" value="../controller/controller.php">
							<input type="hidden" name="url_gracias" id="url_gracias" value="../view/gracias.html"/>
							<input type="hidden" value="45" name="id_evento" id="id_evento">
			              	<input type="hidden" value="Sin asistencia" name="asistencia" id="asistencia">
				         	<div class="center-button">
				            	<button type="submit" class="btn button-form" id="boton_asistir">ENVIAR</button>
				            </div>
					    </form>
					</div>
				</div>
			</div>
    	</div>	
	</body>
	<!-- JS -->
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/validate.js"></script>
</html>

