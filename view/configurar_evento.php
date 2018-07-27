<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Configurar Evento</title>
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
						Registra un evento
					</h1>
					<br>
					<form class="form-horizontal" id="form_cod_part" method="post">
						<input type="text" name="nombre_evento" id="nombre_evento" class="form-control input-form" placeholder="Nombre">
						<br>
						<input type="date" name="fecha_evento" id="fecha_evento" class="form-control input-form" placeholder="Fecha">
						<br>
						<input type="text" name="direccion_evento" id="direccion_evento" class="form-control input-form" placeholder="Direccion">
						<br>
						<input type="submit" id="enviar_cod_part" value="Registrarlo" class="btn button-form">
					</form>
					<div id="div_respuesta">
						<span id="span_texto_respuesta_imprimir"></span>
					</div>
				</div>
			</div>
		</div>
		  <!-- /////////////////////////DATATABLE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
    <br>
    <div class="row">
      <div class="col-md-10 col-lg-offset-1">
        <table class="table table-striped" id="tabla_lista_eventos" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Direcci&oacute;n</th>
            <!-- <th>Acciones</th> -->
          </tr>
        </thead>
      </table>
      </div>
    </div>
  </div>
  <!-- /////////////////////////DATATABLE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
	</div>
<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../assets/plugins/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="../assets/js/configurar_evento.js"></script>
</body>
</html>