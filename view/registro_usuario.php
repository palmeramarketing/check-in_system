<?php
	require_once('../db/conexion.php');
  require_once('../model/modelo.php');
  $obj_u  = new Modelo();
  $filas  = $obj_u->buscarAllUsuario();
// var_dump($filas[0]); die;
	?>

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
			<link rel="stylesheet" href="../assets/plugins/datatable/datatables.css">
			<link rel="stylesheet" href="../assets/plugins/bootstrap/dist/css/bootstrap.min.css">
			<!-- Jquery -->
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery.validate.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/jquery/jquery-ui.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/datatable/dataTables.bootstrap.js"></script>
			<script type="text/javascript" src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
			<script type="text/javascript" src="../assets/plugins/bootstrap/dist/js/bootstrap-confirmation.js"></script>

	 </head>
	 <body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">
					<div id="imagen_header_logo" class="centrar">
						<img src="../assets/images/menarini_icon.jpg" alt="">
					</div>
				</div>
			</div>

      <div class="row" id="formBusqueda"  >
				<div class="container" id="registroUser" style="display: none">
			    <div class="row">
			    </div>
			    <div class="row">
			      <div class="col-md-10 col-md-offset-1">
			        <div class="panel panel-info">
			          <div class="panel-heading">
			            <center><h3 class="display-3">Registro de Usuario</h3></center>
			          </div>
			          <br>
			          <div class="panel-body">
			            <div class="col-md-10 col-lg-offset-2">
			              <form role="form" class="form-horizontal" id="form_registro_usuario" name="form_registro_usuario">
			                <div class="form-group">
			                  <div class="col-xs-10 ">
			                    <input type="text" id="usuario_r" tabindex=1 placeholder="Usuario" name="usuario_r" class="form-control input_style">
			                  </div>
			                </div>
			                <div class="form-group">
			                  <div class="col-xs-10 ">
			                    <input type="email" id="email_r" tabindex=2 placeholder="E-Mail" name="email_r" class="form-control input_style">
			                  </div>
			                </div>
			                <div class="form-group">
			                  <div class="col-xs-10 ">
			                    <input type="password" id="password_r" tabindex=3 placeholder="Password" name="password_r" class="form-control col-xs-12 input_style">
			                  </div>
			                </div>
			                <div class="form-group text-center">
			                  <div class="col-xs-10 ">
			                    <button type="submit" class="btn btn-success " id="btn_registrar">Registrar</button>
			                  </div>
			                </div>
			              </form>
			            </div>
			            <div class="col-md-10 col-md-offset-1">
			              <div class="mensaje-div">
			                <strong class="mensaje-strong"></strong><span class="mensaje-span"></span>
			              </div>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>

			  <div class="row">
			    <div class="col-md-2 col-md-offset-9"><center><button type="button" id="nuevo_user" class="btn btn-info">Nuevo Usuario</button></center></div>
			  </div>

			  <!-- /////////////////////////DATATABLE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
			    <br>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<table class="table table-striped" id="tabla_lista_usuario" cellspacing="0" width="100%" height="100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Usuario</th>
										<th>Email</th>
										<th>Perfil</th>
										<th>Estatus</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
									try {
										foreach($filas as $fila) {
											echo '<tr>'.
											'<td>'.$fila['id'].'</td>'.
											'<td>'.$fila['nombre'].'</td>'.
											'<td>'.$fila['email'].'</td>'.
											'<td>'.($fila['tipo'] == "admin"? "Administrador" : "Super Administrador").'</td>'.
											'<td>'.(($fila['estatus']== "1")? "Activo" : "Inactivo" ).'</td>'.
											'<td><span id="boton-accion" class="accion_modificar glyphicon glyphicon-cog" data-toggle="modal" data-target="#myModal" ">
											</span><span id="boton-accion" class="glyphicon glyphicon-trash accion_eliminar" data-toggle="confirmation" data-title="¿Estás seguro?"></span></td>';
										}
										$mbd = null;
									} catch (PDOException $e) {
										print "¡Error!: " . $e->getMessage() . "<br/>";
										die();
									}
									?>
								</tbody>
							</table>
						</div>
					</div>


			  </div>
			  <!-- /////////////////////////DATATABLE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
			  <!-- /////////////////////////MODAL MODIFICAR EVENTO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
			  <!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Modificar Usuario</h4>
			        </div>
			        <div class="modal-body">
			        <div class="mensaje-div">
			            <strong class="mensaje-strong"></strong><span class="mensaje-span"></span>
			        </div>
			          <form role="form" class="form-horizontal" id="form_modifi_usuario">
									<input type="hidden" id="mod_id" name="mod_id" >
			            <div class="form-group">
			              <div class="col-xs-10 col-xs-offset-1">
			                <input type="text" id="mod_usuario" name="mod_usuario" tabindex=1 placeholder="Usuario" class="form-control input_style">
			              </div>
			            </div>
			            <div class="form-group">
			              <div class="col-xs-10 col-xs-offset-1">
			                <input type="text" id="mod_email" name="mod_email" tabindex=2 placeholder="Email" class="form-control input_style">
			              </div>
			            </div>
			            <div class="form-group">
			              <div class="col-xs-10 col-xs-offset-1">
			                <select class="form-control"  id="mod_tipo" name="mod_tipo" required>
			                  <option value="">Seleccionar</option>
			                  <option value="admin">Administrador</option>
			                  <option value="superadmin">Super Administrador</option>
			                </select>
			              </div>
			            </div>
			            <div class="form-group">
			              <div class="col-xs-10 col-xs-offset-1">
			                <select class="form-control" id="mod_estatus" name="mod_estatus" required>
			                  <option value="">Seleccionar</option>
			                  <option value="1">Activo</option>
			                  <option value="0">Inactivo</option>
			                </select>
			              </div>
			            </div>
			            <div class="form-group">
			              <button type="submit" class="btn btn-primary center-block">Guardar Cambios</button>
			            </div>
			          </form>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default cerrar_modal" data-dismiss="modal">Cerrar</button>
			        </div>
			      </div>
			    </div>
			  </div>



			<!--<div class="row content-footer" id="row_footer">
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
			 </div>-->
		 </div>

    </div>




   </body>
	 <!-- JS -->
	 <script src="../assets/js/validate.js"></script>
	  <script src="../assets/js/registro_usuario.js"></script>

</html>
