// $(document).ready(function(){
// 	$('#imprimir_imagen_gafete').click(function(){//calling this function when Save button pressed
// 		html2canvas($('#div_nombre_participante'), {//give the div id whose image you want in my case this is #div_nombre_participante
// 			onrendered: function (canvas) {
// 				var img = canvas.toDataURL("image/png",1.0);//here set the image extension and now image data is in var img that will send by our ajax call to our api or server site page


// 				$.ajax({
// 							type: 'POST',
// 							url: "../controller/controller.php",//path to send this image data to the server site api or file where we will get this data and convert it into a file by base64
// 							data:{
// 								"img":img,
// 								"accion":"imprimir_imagen_gafete"
// 							},
// 							success:function(data){
// 							$("#resultado").html(data);
// 							}
// 				});
// 			}
// 		});
// 	});
// });
// 
var element = $("#nombre_participante"); // global variable
var getCanvas; // global variable
$('document').ready(function(){
	$('#imprimir_imagen_gafete').click(function(){
	  html2canvas(element, {
	    onrendered: function (canvas) {
	      // $("#resultado").append(canvas);
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
	    		
	    	});
      //   newWin = window.open("");
		    // newWin.document.write(htmlToPrint);
		    // newWin.print();
		    // newWin.close();
	  //   	$("#resultado").html("<img id='Image' src=" + img + " style='width:100%;'></img>");
	  //   	$("<img id='Image' src=" + img + " style='width:100%;'></img>").printThis();
	  //   	var tWindow = window.open("");
   //      $(tWindow.document.body)
   //        .html("<img id='Image' src=" + img + " style='width:100%;'></img>")
   //        .ready(function() {
   //            tWindow.focus();
   //            tWindow.print();
   //            tWindow.close();
   //        });
	    }
	  });
// var divToPrint = document.getElementById('printarea');
//     var htmlToPrint = '' +
//         '<style type="text/css">' +
// 			    '@media print {'+
// 				  '@page { margin: 0; }'+
// 				  'body { margin: 1.6cm; }'+
// 				'}'+
//         '</style>';
//     htmlToPrint += divToPrint.outerHTML;
//     newWin = window.open("");
//     newWin.document.write("<h3 align='center'>Print Page</h3>");
//     newWin.document.write(htmlToPrint);
//     newWin.print();
//     newWin.close();
	});
});