$(document).ready(function(){
	$('.sidebar-menu').tree();





	$("#nombres, #apellidos, #autor, #editorial, #titulo").keydown(function(event){
    	var key = event.which;
	    if((key < 65 || key > 90) && key !==8 && key !== 32){
	       	return false;
	    }
    });

	
	$('#dni, #telefono').keypress(function (tecla) {
	  if (tecla.charCode < 48 || tecla.charCode > 57) return false;
	});

	$("#logout").on("click", function(e){
		e.preventDefault();
		swal({
		    title: "¿Desear cerrar sesión?",
		    text: "Si estas seguro de hacerlo haga click en el boton Aceptar, caso contrario haga click en cancelar",
		    type: "warning",
	        showCancelButton: true,
	        cancelButtonClass: "btn-danger",
	        confirmButtonClass: "btn-success",
	        confirmButtonText: "Aceptar",
	        closeOnConfirm: true,
		},
		function(isConfirm){
		   	if (isConfirm){
		   		window.location.href= base_url + "auth/logout";
		    } 
		});
	});
  
	$(document).on("click",".btn-eliminar-usuario",function(){
		idusuario = $(this).val();
		fila = $(this).closest("tr"); 
		swal({
		    title: "¿Ventana de Confirmación?",
		    text: "Si estas seguro de eliminar al usuario haga click en el boton Aceptar, caso contrario haga click en cancelar",
		    type: "warning",
	        showCancelButton: true,
	        cancelButtonClass: "btn-danger",
	        confirmButtonClass: "btn-success",
	        confirmButtonText: "Aceptar",
	        closeOnConfirm: true,
		},
		function(isConfirm){
		   	if (isConfirm){
		   		$.ajax({
		   			url: base_url + "usuarios/delete",
		   			type: "POST",
		   			data:{id:idusuario},
		   			success: function(resp){
		   				if (resp=="1") {
		   					location.reload(true);
		   				}
		   			}
		   		});
		   		
		    } 
		});
	});
	$("#tb-without-buttons").DataTable({
		language: {
	            "lengthMenu": "Mostrar _MENU_ registros por pagina",
	            "zeroRecords": "No se encontraron resultados en su busqueda",
	            "searchPlaceholder": "Buscar registros",
	            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
	            "infoEmpty": "No existen registros",
	            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
	            "search": "Buscar:",
	            "paginate": {
	                "first": "Primero",
	                "last": "Último",
	                "next": "Siguiente",
	                "previous": "Anterior"
	            },
	        },
	}); 
});