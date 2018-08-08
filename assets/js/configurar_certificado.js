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
			if (respuesta.status == 200) {
				$("#span_texto_respuesta").text("Listo.");
			}else if (respuesta.status == 1062) {
				$("#span_texto_respuesta").text("Ya existe un certificado para este evento.");
			}else{
				$("#span_texto_respuesta").text("Hubo un error, pilla la consola a ver...");
			}
			console.log(respuesta, status, req);
		},
		error: function(respuesta, status, req){
			$("#span_texto_respuesta").text("CRASH! Pilla la consola a ver que paso...");
			console.log(respuesta, status, req);
		}
	});
});

$("#enviar_cod_part").click(function(){
	if ($("#cod_part").val() == "") {
		return false;
	}
});