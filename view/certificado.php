<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Generar Certificado</title>

	<meta content="../assets/images/menarini_icon.jpg" name="msapplication-TileImage">

	<link href="../assets/images/menarini_icon.jpg" rel="icon" sizes="32x32">

	<link href="../assets/images/menarini_icon.jpg" rel="icon" sizes="192x192">

	<link href="../assets/images/menarini_icon.jpg" rel="apple-touch-icon-precomposed">

	<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="../assets/css/fonts.css" rel="stylesheet">

	<link href="../assets/css/index.css" rel="stylesheet">

</head>

<body>

	<div class="container-fluid">

		<div class="row">

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">

				<div id="imagen_header">

					<img src="../assets/images/baner_certificado.jpg" alt="" width="100%">

				</div>

			</div>

		</div>




		<div class="row" id="formBusqueda"  >

      <div class="col-lg-offset-1 col-md-offset-1  col-sm-offset-1 col-xs-offset-1 col-lg-10  col-md-10  col-sm-10 col-xs-10 text-center ">
				<div id="div_contenedor_formulario">

					<?php if (isset($_REQUEST["error"])){		?>
						<div class="col-md-10 col-md-offset-1">
							<div class="mensaje-div alert alert-danger">
								<strong class="mensaje-strong">Error! </strong><span class="mensaje-span">El codigo o correo no existe.</span>
							</div>
						</div>
						<div class="col-md-10 col-md-offset-1">
							<a href="certificado.php">Volver</a>
						</div>
					<?php } else {?>

					<div id="div_parrafo_superior_formulario" class="centrar">

						<p class="text_book p_texto_gris">

							Ingrese su correo o codigo de colegiado para imprimir su certificado del evento.

						</p>

					</div>

          <form class="form-horizontal" id="form_codigo" method="post" action="../controller/controller.php" target="_blank">

            <input class="form-control input-form" tabindex="1" type="text" name=cod_part id=input_codigo  placeholder="Ingrese su email o codigo de colegiado">

            <input type="hidden" name=id_evento id=id_evento value="45">

            <input type="hidden" name="accion" value="imprimir_certificado">


						<div class="center-button">

            	<input type="submit" id="enviar_cod_part" value="Imprimir Certificado" class="btn button-form">

						</div>

          </form>

				<?php }?>
        </div>

      </div>

    </div>
	</div>

	<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>

	<script type="text/javascript" src="../assets/js/certificado.js"></script>

</body>

</html>
