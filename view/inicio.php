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

			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 quitar_padding">

					<div id="imagen_header">

						<img src="../assets/images/header.jpg" alt="" width="100%">

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-10 col-xs-offset-1">

					<div id="div_contenedor_texto_derecho_formulario">

						<p class="text_helvetica p_texto_negro">

							El evento más esperado por la comunidad odontológica está aquí y usted tiene la oportunidad de asistir y actualizar sus conocimientos en compañía de los mejores, solo debe llenar el formulario de registro para confirmar su asistencia.

						</p>

					</div>

				</div>

				<div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-12 col-xs-offset-0" id="form_background">

					<div id="div_contenedor_formulario">

						<div id="div_parrafo_superior_formulario" class="centrar">

							<p class="text_book p_texto_blanco">

								Complete sus datos para asistir:

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

	            <div id="div_checkbox_terminos">

              	<input type="checkbox" value="1" name="terminos" id="terminos" tabindex="12" class="ui-corner-all"><span id="span_terminos">*Acepto las políticas de manejo de datos</span>

              </div>

							<input type="hidden" name="url" id="url" value="../controller/controller.php">

							<input type="hidden" name="url_gracias" id="url_gracias" value="../view/gracias.html"/>

							<input type="hidden" value="45" name="id_evento" id="id_evento">

              <input type="hidden" value="Sin asistencia" name="asistencia" id="asistencia">

	            <div class="center-button">

	            	<button type="submit" class="btn button-form">ENVIAR</button>

	            </div>

		        </form>

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 agenda_background">

					<div id="div_titutlo_agenda">

						<span class="text_helvetica">AGENDA</span>

					</div>

					<div id="div_agenda">

						<img src="../assets/images/agenda.jpg" alt="" width="100%">

					</div>

				</div>

			</div>



			<div class="row">

       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margen_carousel">

         <div id="div_titutlo_conferencistas">

           <span class="mayuscula gris text_helvetica">conferencistas</span>

         </div>

         <div id="myCarousel2" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->

          <ol class="carousel-indicators">

            <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>

            <li data-target="#myCarousel2" data-slide-to="1"></li>

            <li data-target="#myCarousel2" data-slide-to="2"></li>

          </ol>



          <!-- Wrapper for slides -->

          <div class="carousel-inner">

            <div class="item active">

              <div class="row">

                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-1">

                  <div class="div_img_conferencista">

                    <img src="../assets/images/conf_1.jpg" alt="" class="img-responsive">

                  </div>

                </div>

                <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">

                  <div class="div_texto_conferencista">

                    <span class="negrita mayuscula span_nombres gris">Dr. José Luis Cobos Serrano</span><br>

                    <p class="p_texto_conferencista gris">

                      Profesor del máster de implantología y rehabilitación oral en la Universidad Europea de Madrid, España.

                    </p>

                    <div style="width: 100%; text-align: right; margin-left:-60px;"><button type="button" class="btn btn-link negrita span_leer_mas" data-toggle="modal" data-target="#myModal_1">Leer más</button></div>

                  </div>

                </div>

              </div>

            </div>



            <div class="item">

              <div class="row">

                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-1">

                  <div class="div_img_conferencista">

                    <img src="../assets/images/conf_2.jpg" alt="" class="img-responsive">

                  </div>

                </div>

                <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">

                  <div class="div_texto_conferencista">

                    <span class="negrita mayuscula span_nombres gris">Guillermo Uzcátegui</span><br>

                    <p class="p_texto_conferencista gris">

                      Director de Ingeniería para Caribe, Centro América y países Andinos, con 24 años de experiencia en la industria, 18 años trabajando para Cisco en diversos roles, tanto en América Latina como en Europa.

                    </p>

                    <div style="width: 100%; text-align: right; margin-left:-60px;"><button type="button" class="btn btn-link negrita span_leer_mas" data-toggle="modal" data-target="#myModal_2">Leer más</button></div>

                  </div>

                </div>

              </div>

            </div>



            <div class="item">

              <div class="row">

                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-10 col-xs-offset-1">

                  <div class="div_img_conferencista">

                    <img src="../assets/images/conf_3.jpg" alt="" class="img-responsive">

                  </div>

                </div>

                <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">

                  <div class="div_texto_conferencista">

                    <span class="negrita mayuscula span_nombres gris">Robert Landires</span><br>

                    <p class="p_texto_conferencista gris">

                      Consultor de Cisco en Redes Empresariales para Caribe, Centro América y países Andinos. Mas de 13 años de experiencia en la industria y 7 años de experiencia, trabajando para Cisco en diversos roles.

                    </p>

                    <div style="width: 100%; text-align: right; margin-left:-60px;"><button type="button" class="btn btn-link negrita span_leer_mas" data-toggle="modal" data-target="#myModal_3">Leer más</button></div>

                  </div>

                </div>

              </div>

            </div>

	          <!-- Left and right controls -->

	          <a class="left carousel-control" href="#myCarousel2" data-slide="prev">

	            <img src="../assets/images/le.png" class="arroy_slider_2">

	          </a>

	          <a class="right carousel-control" href="#myCarousel2" data-slide="next">

	            <img src="../assets/images/ri.png" class="arroy_slider_2">

	          </a>

	        </div>

	       </div>

	     </div>

	   </div>



		 <!-- Modal -->

		 <div class="modal fade" id="myModal_1" role="dialog">

			 <div class="modal-dialog">



				 <!-- Modal content-->

				 <div class="modal-content">

					 <div class="modal-header">

						 <button type="button" class="close" data-dismiss="modal">&times;</button>

						 <span class="modal-title negrita mayuscula span_nombres gris">Dr. José Luis Cobos Serrano</span>

					 </div>

					 <div class="modal-body">

						 <p class="p_texto_conferencista gris">

							 Es un profesional experimentado en productos y servicios de misión crítica con más de 15 años en el diseño y gestión de soluciones de TI complejas. <br>

							 Actualmente es Director Regional de Ingeniaría de Ventas en LATAM para CW Business. Lidera el equipo regional de expertos que trabaja directamente con los clientes, enfocados en entender las necesidades del negocio para organizaciones de todos los tamaños, y en el asesoramiento en procesos complejos de transformación y adopción de TI. <br>

							 Tiene un MBA y es Ingeniero Sistemas, con varios estudios de postgrados en alta gerencia y dirección estratégica, cuenta con diversas certificaciones de reconocimiento internacional en la industria de TI. Es un orador frecuente en conferencias internacionales y eventos regionales sobre los temas de ciberseguridad, servicios en la nube y mejores prácticas en proceso de transformación.

						 </p>

					 </div>

					 <div class="modal-footer">

						 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

					 </div>

				 </div>



			 </div>

		 </div>



		 <!-- Modal -->

		 <div class="modal fade" id="myModal_2" role="dialog">

			 <div class="modal-dialog">



				 <!-- Modal content-->

				 <div class="modal-content">

					 <div class="modal-header">

						 <button type="button" class="close" data-dismiss="modal">&times;</button>

						 <span class="modal-title negrita mayuscula span_nombres gris">Guillermo Uzcátegui</span>

					 </div>

					 <div class="modal-body">

						 <p class="p_texto_conferencista gris">

							 Director de Ingeniería para Caribe, Centro América y países Andinos, con 24 años de experiencia en la industria, 18 años trabajando para Cisco en diversos roles, tanto en América Latina como en Europa.

							 <br>

							 Durante la última década estuvo a cargo de la expansión en la región de Centro América y Caribes de proveedores de “Managed Services” definiendo la oferta de servicios y el modelo de operación en países como Panamá, Guatemala y Rep. Dominicana.

							 <br>

							 En el 2017 se une a una de las top 5 compañías de Cyber Seguridad en el mundo, Fortinet,  para atender y desarrollar el mercado de proveedores de servicios y telco´s debido el impacto que pueden tener en la seguridad con su importante numero de clientes corporativos y de consumo.

							 <br>

							 Actualmente es Director Regional de Ingeniaría de Ventas en LATAM para CW Business. Lidera el equipo regional d

							 e expertos que trabaja directamente con los clientes, enfocados en entender las necesidades del negocio para organizaciones de todos los tamaños, y en el asesoramiento en procesos complejos de transformación y adopción de TI. Tiene un MBA y es Ingeniero Sistemas, con varios estudios de postgrados en alta gerencia y dirección estratégica, cuenta con diversas certificaciones de reconocimiento internacional en la industria de TI. Es un orador frecuente en conferencias internacionales y eventos regionales sobre los temas de ciberseguridad, servicios en la nube y mejores prácticas en proceso de transformación.

						 </p>

					 </div>

					 <div class="modal-footer">

						 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

					 </div>

				 </div>



			 </div>

		 </div>



		 <!-- Modal -->

		 <div class="modal fade" id="myModal_3" role="dialog">

			 <div class="modal-dialog">



				 <!-- Modal content-->

				 <div class="modal-content">

					 <div class="modal-header">

						 <button type="button" class="close" data-dismiss="modal">&times;</button>

						 <span class="modal-title negrita mayuscula span_nombres gris">Robert Landires</span>

					 </div>

					 <div class="modal-body">

						 <p class="p_texto_conferencista gris">

							 Consultor de Cisco en Redes Empresariales para Caribe, Centro América y países Andinos. Mas de 13 años de experiencia en la industria y 7 años de experiencia, trabajando para Cisco en diversos roles.

							 <br>

							 Durante la última década estuvo a cargo de la expansión en la región de Centro América y Caribes de proveedores de “Managed Services” definiendo la oferta de servicios y el modelo de operación en países como Panamá, Guatemala y Rep. Dominicana.

							 <br>

							 En el 2017 se une a una de las top 5 compañías de Cyber Seguridad en el mundo, Fortinet,  para atender y desarrollar el mercado de proveedores de servicios y telco´s debido el impacto que pueden tener en la seguridad con su importante numero de clientes corporativos y de consumo.

							 <br>

							 Actualmente es Director Regional de Ingeniaría de Ventas en LATAM para CW Business. Lidera el equipo regional d

							 e expertos que trabaja directamente con los clientes, enfocados en entender las necesidades del negocio para organizaciones de todos los tamaños, y en el asesoramiento en procesos complejos de transformación y adopción de TI. Tiene un MBA y es Ingeniero Sistemas, con varios estudios de postgrados en alta gerencia y dirección estratégica, cuenta con diversas certificaciones de reconocimiento internacional en la industria de TI. Es un orador frecuente en conferencias internacionales y eventos regionales sobre los temas de ciberseguridad, servicios en la nube y mejores prácticas en proceso de transformación.

						 </p>

					 </div>

					 <div class="modal-footer">

						 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

					 </div>

				 </div>

			 </div>

		 </div>



		 <div id="div_contenedor_asistir">

			 <div class="row">

				 <div class="col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">

					 <div id="div_contenedor_asistir">

						 <div id="div_texto_asistir">

							 <span id="span_texto_asistir">

								 No pierda ningún detalle <br>

								 de este simposium

							 </span>

						 </div>

						 <div id="div_boton_asistir">

							 <a href="#form_background"><button class="btn" id="boton_asistir"><span class="mayuscula negrita text_helvetica" id="span_texto_boton">ASISTIR</span></button></a>

						 </div>

					 </div>

				 </div>

			 </div>

			 <div class="row">

				 <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">

					 <div class="row" id="margen_redes_sociales">

						 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

							 <a href="https://www.facebook.com/MenariniCA/" target="_blank">

								 <div class="div_img_redes_sociales">

									 <img src="../assets/images/C&W_Landing_FB.png" alt="" width="23px">

								 </div>

								 <div class="div_texto_redes_sociales">

									 <span class="span_texto_redes_sociales">MenariniCA</span>

								 </div>

							 </a>

						 </div>

						 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

							 <a href="https://twitter.com/menarinica?lang=es" target="_blank">

								 <div class="div_img_redes_sociales">

									 <img src="../assets/images/C&W_Landing_TW.png" alt="" width="23px">

								 </div>

								 <div class="div_texto_redes_sociales">

									 <span class="span_texto_redes_sociales">@MenariniCA</span>

								 </div>

							 </a>

						 </div>

						 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

							 <a href="https://www.youtube.com/user/MenariniCA" target="_blank">

								 <div class="div_img_redes_sociales">

									 <img src="../assets/images/C&W_Landing_YT.png" alt="" width="23px">

								 </div>

								 <div class="div_texto_redes_sociales">

									 <span class="span_texto_redes_sociales">MenariniCA</span>

								 </div>

							 </a>

						 </div>

						 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

							 <a href="https://www.linkedin.com/company/grupomenarinicentroam%C3%A9ricayelcaribe/?originalSubdomain=ve" target="_blank">

								 <div class="div_img_redes_sociales">

									 <img src="../assets/images/logo_linkedin.png" alt="" width="23px">

								 </div>

								 <div class="div_texto_redes_sociales">

									 <span class="span_texto_redes_sociales">grupomenarini_ca</span>

								 </div>

							 </a>

						 </div>

					 </div>

				 </div>

			 </div>

		 </div>



		 <div class="row" id="div_background_footer_web">

			 <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">

				 <div id="div_web_footer">

					 <span class="negrita text_helvetica"><a href="http://www.menarini-ca.com/" id="enlace_web">www.menarini-ca.com</a></span>

				 </div>

			 </div>

		 </div>



		 <div class="row">

			 <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">

				 <div id="div_terminos">

					 <p class="text_helvetica negrita" id="terminos_condiciones">

						 *Política de privacidad: <br>

						 En cumplimiento de la ley 1581 de 2012 y el Decreto 1377 de 2013 sobre protección de datos personales, le manifestamos que la información aquí suministrada se encontrará incluida en nuestras bases de datos y tendrá el siguiente tratamiento:<br>

						 Autorizo a MENARINI /o la agencia Palmera Marketing S.A.S. para recolectar, procesar y utilizar lo datos personales contenidos en el presente formulario y para administrarlos en desarrollo de su objeto.

					 </p>

				 </div>

			 </div>

		 </div>



		</div>

	 <!-- JS -->

	 <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	 <script src="../assets/js/validate.js"></script>

	 </body>

</html>

