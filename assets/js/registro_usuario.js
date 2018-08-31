$('#tabla_lista_usuario').DataTable();

var table= $('#tabla_lista_usuario').DataTable();

			$('#tabla_lista_usuario tbody').on("click", ".accion_modificar", function(){
				var data = table.row($(this).parents("tr")).data();

				$("#mod_id").val(data[0]);
				$("#mod_usuario").val(data[1]);
				$("#mod_email").val(data[2]);
				$("#mod_tipo").val((data[3]== "Administrador")? "admin" : "superadmin");
				$("#mod_estatus").val((data[4]== "Activo")? 1: 0);
			});