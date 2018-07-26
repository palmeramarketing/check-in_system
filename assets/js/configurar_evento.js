$(document).ready(function(){
	listar_eventos();
	$.ajax({
		method: "POST",
		
	})
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