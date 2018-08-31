<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Configurar Gafete PDF</title>
	<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
	@media print {
		@page { margin: 0; }
	  body * {
	    display: none;
	  }
	  #resultado {
	    display: block;
	  }
	}
</style>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
				<div id="div_nombre_participante" style="margin: auto; width: auto;">
					<span style="width: auto; font-size: 70px;" id="nombre_participante">GAFETE DE PRUEBA</span>
				</div><br>
				<div style="margin: 25px auto 50px auto;">
					<input type="button" id="imprimir_imagen_gafete" value="Imprimir Imagen Gafete">
				</div>
				<div id="resultado" style="width: 100%; visibility: hidden;">
					
				</div><br><br>
			</div>
		</div>
		<hr>
	</div>
	<link href="../assets/plugins/jquery/jquery-ui.css" rel="stylesheet">
	<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../assets/plugins/jquery/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../assets/plugins/html2canvas/html2canvas.js"></script>
	<script type="text/javascript" src="../assets/js/configurar_gafete.js"></script>
</body>
</html>