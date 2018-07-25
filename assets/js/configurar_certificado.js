$("#enviar_certificado").click(function(){
	var id_evento = $("#id_evento").val();
	var nombre = $("#nombre").val();
	var archivo = $("#archivo_html").prop('files')[0];

	if ((id_evento == "") || (nombre == "") || (archivo == undefined)) {
		return false;
	}

	var form_data = new FormData($('#form_registrar_certificado')[0]);

	$.ajax({
		url: "../controller/controller.php",
		data: form_data,
		contentType: false,
        processData: false,
		type: "POST",
		dataType: "json",
		success: function(respuesta, status, req){
			console.log(respuesta);
			return false;
		},
		error: function(respuesta, status, req){
			console.log(respuesta, status, req);
			return false;
		}
	});
});