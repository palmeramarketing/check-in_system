

$("#btn_imprimir").click(function(){
	var codigo = $("#input_codigo").val();
	if (codigo != "") {
		$.ajax({
			url: "../controller/controller.php",
			data: {accion: "imprimir_certificado", codigo: codigo},
			type: "POST",
			dataType: "json",
			success: function(respuesta, status, req){
				console.log(respuesta);
				return false;
			},
			error: function(respuesta, status, req){
				console.log(respuesta);
				return false;
			}
		});
	}
	return false;
});
