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
	  telefono:{required:!0,minlength:2}
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
	  telefono:{}
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
			id_evento : $("#id_evento").val()
		};

		var url= $("#url").val();
		var url_gracias= $("#url_gracias").val();

		$.ajax({
		    url : url,
		    data : {data: datos, accion: "registrar_participantes"},
		    type : 'POST',
		    dataType : 'json',
		    success : function(respuesta, status, req) {
		    	if(respuesta.status == 1062){
						$("#form_register")[0].reset();
						alert("Disculpe ya existe un partcipente registrado con este email. Verifique su email.")
					}else if(respuesta.status == 200){
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
												 $("#modalAsistencia").modal('show');

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

function doKey(event){
  var key = event.which || event.keyCode;
  if ((key < 48 || key > 57) && (key != 43) && (key != 32) && (key != 8)){
	event.preventDefault();
  }
}
