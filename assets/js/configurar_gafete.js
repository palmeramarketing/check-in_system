var element = $("#nombre_participante"); // global variable
var getCanvas; // global variable
$('document').ready(function(){
	$('#imprimir_imagen_gafete').click(function(){
	  html2canvas(element, {
	    onrendered: function (canvas) {
	      getCanvas = canvas;
	    	var img = canvas.toDataURL("image/png",1.0);
	    	$("#resultado").html("<img id='Image' src=" + img + " style='width:100%;'></img>").ready(function(){
		    	var htmlToPrint = '' +
	        '<style type="text/css">' +
				    '@media print {'+
					  '@page { margin: 0; }'+
					'}'+
	        '</style>';
	        htmlToPrint += $("#resultado").html();
	        var tWindow = window.open("");
	        $(tWindow.document.body)
	          .html(htmlToPrint)
	          tWindow.focus();
	          tWindow.print();
	          tWindow.close();
	    	$("#resultado").hide();
	    	});
	    }
	  });
	});
});