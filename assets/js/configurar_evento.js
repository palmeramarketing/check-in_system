$(document).ready(function(){
	listar_eventos();
});

function listar_eventos(){
	// LISTAR EVENTOS----------------------------
	var table = $('#tabla_lista_eventos').DataTable({
		"destroy":true,
		"ajax":{
			"method":"POST",
			"url":"../controller/controller.php",
			"dataType":"json"
		},
		"columns":[
			{"data":"nombre"},
			{"data":"fecha"},
			{"data":"direccion"}
			// {"defaultContent":"<span id='boton-accion' class='accion_modificar glyphicon glyphicon-cog' data-toggle='modal' data-target='#myModal''>\
			// 				   </span><span id='boton-accion' class='glyphicon glyphicon-trash accion_eliminar' data-toggle='confirmation' data-title='¿Estás seguro?'></span>\
			// 				   <span id='boton-accion' class='accion_graficar glyphicon glyphicon-stats'>"}
		]
	});
	// ------------------------------------------
};

$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),
$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
$("#form_cod_part").validate({
	rules:{
        nombre_evento:{required:!0,minlength:2},
        fecha_evento:{required:!0},
        direccion_evento:{required:!0,minlength:5}
	},
	submitHandler: function(form) {
		var datos = {
			nombre:$("#nombre_evento").val(), 
			fecha:$("#fecha_evento").val(), 
			direccion:$("#direccion_evento").val()
		};
		$.ajax({
		    url : '../controller/controller.php',
		    data : {accion: "registrar_evento", datos: datos},
		    type : 'POST',
		    dataType : 'json',
		    success : function(respuesta, status, req) {
		    	if (respuesta.status == 200) {
		    		console.log(respuesta, status, req);
		    		$("#form_cod_part")[0].reset();
		    		listar_eventos();
		    	}else if (respuesta.status == 1062) {
		    		console.log(respuesta, status, req);
		    	}else if (respuesta.status == 500) {
		    		console.log(respuesta, status, req);
		    	};
		    	listar_eventos();
		    },
		    error : function(respuesta, status, req) {
		        console.log(respuesta, status, req);
		    },
		    // código a ejecutar sin importar si la petición falló o no
		    // complete : function(xhr, status) {
		    //     alert('LOADING!!!!!!!!!!');
		    // }
		});            		
	}
});