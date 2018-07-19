$.validator.addMethod('betterEmail', function (value, element) {
	return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
}, "Please enter a valid email address.");

$("input[type=submit]").button(),$("input").addClass("ui-corner-all"),
$.validator.addMethod("valueNotEquals",function(e,i,a){return a!==e},"Value must not equal arg."),
$("#form_register").validate({
	rules:{
	  nombre:{required:!0,minlength:2},
	  apellido:{required:!0,minlength:2},
	  telefono:{required:!0,minlength:2},
	  email:{required:!0,betterEmail:!0},
	  compania:{required:!0,minlength:7},
	  cargo:{required:!0,minlength:2}
	},
	messages:{
	  nombre:{},
	  apellido:{},
	  telefono:{},
	  email:{},
	  compania:{},
	  cargo:{}
	},
	submitHandler: function(form) {
		var cont = 0;
		$(".form-inline select").each(function(i){
			if (this.value == "no") {
				cont = cont+1;
			}
		  });
		if (cont == 4) {
			$("#div_error_hidden").css("display","block");
			return false;
		}else{
			$("#div_error_hidden").css("display","none");
		}
	  }
  });

function doKey(event){
  var key = event.which || event.keyCode;
  if ((key < 48 || key > 57) && (key != 43) && (key != 32) && (key != 8)){
	event.preventDefault();
  } 
}