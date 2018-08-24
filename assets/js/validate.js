$('#tabla_lista_usuario').DataTable();

$("#nuevo_user").click(function(){
	if ($(this).hasClass("active")) {
		$("#registroUser").slideUp();
	}else{
		$("#registroUser").slideDown();
	}
	$(this).toggleClass("active");
});

$.validator.addMethod('betterEmail', function (value, element) {
	return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
}, "Please enter a valid email address.");

$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),
$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
$("#form_register").validate({
	rules:{
	  nombre:{required:!0,minlength:2},
	  apellido_1:{required:!0,minlength:2},
	  apellido_2:{required:!0,minlength:2},
	  especialidad:{required:!0,minlength:2},
	  colegiado:{required:!0,minlength:2},
	  celular:{required:!0,minlength:2},
	  email:{required:!0,betterEmail:!0},
	  ciudad:{required:!0,minlength:2},
	  pais:{required:!0,minlength:2},
	  direccion:{required:!0,minlength:7},
	  telefono:{required:!0,minlength:2},
	  terminos:{required:!0}
	},
	messages:{
	  nombre:{},
	  apellido_1:{},
	  apellido_2:{},
	  especialidad:{},
	  colegiado:{},
	  celular:{},
	  email:{},
	  ciudad:{},
	  pais:{},
	  direccion:{},
	  telefono:{},
	  terminos:{}
	},
	submitHandler: function() {
		var datos = {
			nombre : $("#nombre").val(),
			apellido_1 : $("#apellido_1").val(),
			apellido_2 : $("#apellido_2").val(),
			especialidad : $("#especialidad").val(),
			colegiado : $("#colegiado").val(),
			celular : $("#celular").val(),
			email : $("#email").val(),
			ciudad : $("#ciudad").val(),
			pais : $("#pais").val(),
			direccion : $("#direccion").val(),
			telefono : $("#telefono").val(),
			id_evento : $("#id_evento").val(),
			asistencia : $("#asistencia").val()
		};

		var url= $("#url").val();
		var url_gracias= $("#url_gracias").val();

		$.ajax({
		    url : url,
		    data : {data: datos, accion: "registrar_participantes"},
		    type : 'POST',
		    dataType : 'json',
		    success : function(respuesta, status, req) {
		    	if(respuesta.status == 200){
					$("#form_register")[0].reset();
	    		$(location).attr('href', url_gracias);
				}else {
					$("#form_register")[0].reset();
					alert("Error. Imposible conectar con el servidor, intente de nuevo más tarde.");
				}
		    },
		    error : function(respuesta, status, req) {
		    	console.log(status, respuesta, req);
		    	alert_message("Error! ","Imposible conectar con el servidor, intente de nuevo más tarde.", "alert-danger");
		    }
		});
	  }
  });

	$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
	$("#frm").validate(
		 {
					 rules:{
							correo:{required:!0,email:!0},
					 },
					 messages:{
								correo:{}
						},
						submitHandler: function(form) {
							$("#resultado").hide();
									$.ajax({
										url : "../controller/controller.php",
										data : {email: $("#correo").val(), accion: "buscar_participante"},
										type : "POST",
										dataType: "json",
										success : function(result) {
											 if(result == 404){
												 $("#resultado").hide();
												 $("#modalRegistro").modal('show');
												 $("#correo").val('');
												 $("#registrarse").on("click", function(){
													 $("#modalRegistro").modal('hide');
													 $("#formBusqueda").hide();
													 $("#formRegistro").show();

												 });
												 $("#noregistrarse").on("click", function(){
														 $("#modalRegistro").modal('hide');
														 $("#formRegistro").hide();
												 });
											 }else{
												 $("#label_nombre").html(result.nombre);
												 $("#label_primer_apellido").html(result.apellido_1);
												 $("#label_segundo_apellido").html(result.apellido_2);
												 $("#label_especialidad").html(result.especialidad);
												 $("#label_nun_colegiado").html(result.colegiado);
												 $("#label_celular").html(result.celular);
												 $("#label_email").html(result.email);
												 $("#label_ciudad").html(result.ciudad);
												 $("#label_pais").html(result.pais);
												 $("#label_direccion_clinica").html(result.direccion);
												 $("#label_telefono").html(result.telefono);
												 if(result.asistencia== "Con asistencia"){
													 $("#correo").val('');
													$("#resultado").show();
												 }else {
													 $("#modalAsistencia").modal('show');
												 }

												 $("#noconfirmar").on("click", function(){
													 	 $("#correo").val('');
														 $("#modalAsistencia").modal('hide');
														 $("#resultado").hide();
												 });

											 }

												// console.log(result.apellido); return false;
										}
									})

						}

		 })


	$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
	$("#frm-login").validate(
		 {
					 rules:{
							correo:{required:!0,email:!0},
							clave:{required:!0},
					 },
					 messages:{
								correo:{},
								correo:{}
						},
						submitHandler: function(form) {

									$.ajax({
										url : "../controller/controller.php",
										data : {correo: $("#correo").val(), clave: $("#clave").val(), accion: "login"},
										type : "POST",
										dataType: "json",
										success : function(result) {
											if(result == 404){
												alert("Disculpe su correo o password son incorrectos"); return false;
											}else if (result == 500){
												alert("Disculpe ha ocurrido un error interno en el servidor"); return false;
											}else {
												if(result.estatus == 1){
													window.location.href = "visitador_medico.php?login="+result.id;
												}else if(result.estatus == 2){
													$("#div_login").hide();
													$("#div_recperar").hide();
													$("#div_cambiar_passwd").show();
												}
											}
										}
									})

						}

		 })

		 $("#confimar").on("click", function(){

			 $.ajax({
				 url : "../controller/controller.php",
				 data : {email: $("#correo").val(), accion: "actualizar_asistencia"},
				 type : "POST",
				 dataType: "json",
				 success : function(result) {

					 $("#correo").val('');
					 $("#modalAsistencia").modal('hide');
					 $("#resultado").show();

				 }
			 })

		 })

		 $("#olvido_passw").on("click", function(){

				$("#div_login").hide();
				$("#div_recperar").show();
				$("#div_cambiar_passwd").hide();

		 })

		 $("input[type=submit]").button(),$("input").addClass("ui-corner-all"),$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
	 	$("#frm-recuperar").validate(
	 		 {
	 					 rules:{
	 							correo:{required:!0,email:!0},
	 					 },
	 					 messages:{
	 								correo:{},
	 						},
	 						submitHandler: function(form) {

	 									$.ajax({
	 										url : "../controller/controller.php",
	 										data : {correo: $("#correo_rec").val(), accion: "recuperar_password"},
	 										type : "POST",
	 										dataType: "json",
	 										success : function(result) {
	 											if(result == 500){
													alert("Disculpe ha ocurrido un error interno en el servidor"); return false;
	 											}else if (result == 404){
													alert("Disculpe usted no posee usuario"); return false;
	 											}else {
													alert("Su nueva clave fue enviada a su correo"+ result);
													$("#div_login").show();
													$("#div_recperar").hide();
													$("#div_cambiar_passwd").hide();
	 											}
	 										}
	 									})

	 						}

	 		 })

		 $("input[type=submit]").button(),$("input").addClass("ui-corner-all"),$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
	 	$("#frm-cambiar").validate(
	 		 {
	 					 rules:{
	 							password1:{required:!0},
	 							password2:{required:!0},
	 					 },
	 					 messages:{
	 								password1:{},
	 								password2:{},
	 						},
	 						submitHandler: function(form) {

									if($("#password1").val() != $("#password2").val()){
											alert("Verfique que los passwords ingresados coincidan");
											return false;
									}

	 									$.ajax({
	 										url : "../controller/controller.php",
	 										data : {correo: $("#correo").val(), passwd: $("#password1").val(), accion: "cambiar_password"},
	 										type : "POST",
	 										dataType: "json",
	 										success : function(result) {
	 											if(result == 200){
	 												alert("Su clave fue cambiada exitosamente. Ingrese con su nueva clave");
													$("#div_login").show();
													$("#div_recperar").hide();
													$("#div_cambiar_passwd").hide();
	 											}else{
													alert("Disculpe ha ocurrido un error interno en el servidor"); return false;
	 											}
	 										}
	 									})

	 						}

	 		 })


			$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),
		 	$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
		 	$("#form_registro_usuario").validate({
				rules:{
					usuario_r:{required:!0,minlength:2},
					email_r:{required:!0,email:!0},
					password_r:{required:!0,minlength:5}
				},
				submitHandler: function(form) {
					var datos = {
						accion:"registrar_usuario",
						usuario:$("#usuario_r").val(),
						email:$("#email_r").val(),
						password:$("#password_r").val()
					};

					$.ajax({
						url : '../controller/controller.php',
						data : datos,
						type : 'POST',
						dataType : 'json',
						success : function(respuesta) {
							if (respuesta.status == 200) {
								alert_message("Exito! ","Nuevo usuario registrado.", "alert-success");
								$("#form_registro_usuario")[0].reset();
								location.reload();
							}else if (respuesta.status == 1062) {
								alert_message("Aviso! ","El usuario ya existe.", "alert-warning");
							}else if (respuesta.status == 500) {
								alert_message("Error! ","Hubo un error con el servidor.", "alert-danger");
							};
						},
						error : function(respuesta) {
							alert_message("Error! ","Hubo un error con el servidor, intente de nuevo m&aacute;s tarde.", "alert-danger");
						},
					});
				}
			});

			var table= $('#tabla_lista_usuario').DataTable();

			$('#tabla_lista_usuario tbody').on("click", ".accion_modificar", function(){
				var data = table.row($(this).parents("tr")).data();

				$("#mod_id").val(data[0]);
				$("#mod_usuario").val(data[1]);
				$("#mod_email").val(data[2]);
				$("#mod_tipo").val((data[3]== "Administrador")? "admin" : "superadmin");
				$("#mod_estatus").val((data[4]== "Activo")? 1: 0);
			});

			// ACCION MODIFICAR USUARIO-------------------
			$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),
			$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
			$("#form_modifi_usuario").validate({
		    	rules:{
		            mod_usuario:{required:!0,minlength:2},
		            mod_email:{required:!0},
		            mod_tipo:{required:!0},
		            mod_estatus:{required:!0}
		    	},
		    	submitHandler: function(form) {
					var datos = {
						accion:"modificar_usuario",
						id: $("#mod_id").val(),
						nombre:$("#mod_usuario").val(),
						email:$("#mod_email").val(),
						perfil:$("#mod_tipo").val(),
						estatus:$("#mod_estatus").val()
					};

					$.ajax({
					    url : '../controller/controller.php',
					    data : datos,
					    type : 'POST',
					    dataType : 'json',
					    success : function(respuesta) {
					    	if (respuesta.status == 200) {
					    		alert_message("Exito! ","Usuario actualizado.", "alert-success");
					    		setTimeout(function(){
					    			$(".cerrar_modal").click();
										location.reload();
									 }, 2000);
					    	}else if (respuesta.status == 500) {
					    		alert_message("Error! ","Hubo un error con el servidor.", "alert-danger");
					    	};
					    },
					    error : function(respuesta) {
					        alert_message("Error! ","Imposible conectar con el servidor, intente de nuevo más tarde.", "alert-danger");
					    },
					    // código a ejecutar sin importar si la petición falló o no
					    // complete : function(xhr, status) {
					    //     alert('LOADING!!!!!!!!!!');
					    // }
					});
		    	}
		    });
			// ------------------------------------------

			// ACCION ELIMINAR EVENTO--------------------
			$('#tabla_lista_usuario tbody').on("click", ".accion_eliminar", function(){
				$(this).confirmation({
					onConfirm: function() {
						var data = table.row($(this).parents("tr")).data();
						var datos = {
							accion:"deshabilitar_usuario",
							id:data[0]
						}
						$.ajax({
						    url : '../controller/controller.php',
						    data : datos,
						    type : 'POST',
						    dataType : 'json',
						    success : function(respuesta) {
						    	if (respuesta.status == 200) {
						    		location.reload();
						    	}else if (respuesta.status == 500) {
						    		alert_message("Error! ","Hubo un error con el servidor.", "alert-danger");
						    	};
						    },
						    error : function(respuesta) {
								alert_message("Error! ","Imposible conectar con el servidor, intente de nuevo más tarde.", "alert-danger");
						    },
						    // código a ejecutar sin importar si la petición falló o no
						    // complete : function(xhr, status) {
						    //     alert('LOADING!!!!!!!!!!');
						    // }
						});
					}
				});
				$(this).confirmation( 'show' );
			});
			// ------------------------------------------

function alert_message(strong, span, tipo){
		$(".mensaje-strong").text(strong+" ");
		$(".mensaje-span").text(span);
		$(".mensaje-div").addClass("alert "+tipo);
		$(".mensaje-div").slideDown();
		setTimeout(function(){
			$(".mensaje-div").slideUp();
		}, 2500);
}
function doKey(event){
  var key = event.which || event.keyCode;
  if ((key < 48 || key > 57) && (key != 43) && (key != 32) && (key != 8)){
	event.preventDefault();
  }
}
