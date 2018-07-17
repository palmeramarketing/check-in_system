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
		$.ajax({
		    url : 'controller/controller.php',
		    data : {data: datos, accion: "registrar_participantes"},
		    type : 'POST',
		    dataType : 'json',
		    success : function(respuesta, status, req) {
		    	console.log(status, respuesta, req);
		    	alert("exito");
		    },
		    error : function(respuesta, status, req) {
		    	console.log(status, respuesta, req);
		    	alert_message("Error! ","Imposible conectar con el servidor, intente de nuevo más tarde.", "alert-danger");
		    }
		});
	  }
  });

function doKey(event){
  var key = event.which || event.keyCode;
  if ((key < 48 || key > 57) && (key != 43) && (key != 32) && (key != 8)){
	event.preventDefault();
  } 
}