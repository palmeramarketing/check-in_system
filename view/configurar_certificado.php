<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Configurar Certificado PDF</title>
	<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
	.div_normal{
		text-align: center; 
		width: 400px; 
		margin: auto;
	}
</style>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
				<div class="div_normal">
					<h1>
						Insertar código participante
					</h1>
					<br>
					<form class="form-horizontal" id="form_cod_part" method="post" action="../controller/controller.php" target="_blank">
						<input type="text" name="cod_part" id="cod_part" class="form-control input-form">
						<input type="hidden" name="accion" value="imprimir_certificado">
						<br>
						<input type="submit" id="enviar_cod_part" value="Imprimir Certificado" class="btn button-form">
					</form>
					<div id="div_respuesta">
						<span id="span_texto_respuesta_imprimir"></span>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
				<div class="div_normal">
					<h1>
						Registrar un certificado
					</h1>
					<br>
					<form class="form-horizontal" id="form_registrar_certificado" method="post">
						<label for="id_evento">
							ID del Evento
						</label>
						<input type="text" name="id_evento" id="id_evento" class="form-control input-form">
						<label for="nombre">
							Nombre del Certificado
						</label>
						<input type="text" name="nombre" id="nombre" class="form-control input-form">
						<label for="archivo_html">
							Archivo HTML
						</label>
						<input type="file" name="archivo_html" id="archivo_html">
						<input type="hidden" name="accion" value="guardar_certificado">
						<br>
						<input type="button" id="enviar_certificado" value="Guardar Certificado" class="btn button-form">
					</form>
					<div id="div_respuesta">
						<span id="span_texto_respuesta"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="div">
		
	</div>
	<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../assets/js/configurar_certificado.js"></script>
</body>
</html>