/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS UBICACION
=============================================*/

/*
$.ajax({
	url: "ajax/datatable-productos-ubicacion.ajax.php",
	success: function (respuesta) {
		console.log("respuesta", respuesta);
	},
});
*/

var perfilOculto = $("#perfilOculto").val();


$(".tablaProductosUbicacion").DataTable({
	ajax: "ajax/datatable-productos-ubicacion.ajax.php?perfilOculto=" + perfilOculto,
	deferRender: true,
	retrieve: true,
	processing: true,
	language: {
		sProcessing: "Procesando...",
		sLengthMenu: "Mostrar _MENU_ registros",
		sZeroRecords: "No se encontraron resultados",
		sEmptyTable: "Ningún dato disponible en esta tabla",
		sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
		sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
		sInfoPostFix: "",
		sSearch: "Buscar:",
		sUrl: "",
		sInfoThousands: ",",
		sLoadingRecords: "Cargando...",
		oPaginate: {
			sFirst: "Primero",
			sLast: "Último",
			sNext: "Siguiente",
			sPrevious: "Anterior",
		},
		oAria: {
			sSortAscending: ": Activar para ordenar la columna de manera ascendente",
			sSortDescending:
				": Activar para ordenar la columna de manera descendente",
		},
	},
});

/*=============================================
REVISAR SI EL CODIGO DEL PRODUCTO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoProductoUbicacion").change(function(){

	$(".alert").remove();


	var codigo = $(this).val();
	console.log("cod",codigo);

	var datos = new FormData();
	datos.append("validarCodigo", codigo);

	 $.ajax({
	    url:"ajax/productos-ubicacion.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){

	    	if(respuesta){

	    		$("#nuevoProductoUbicacion").parent().after('<div class="alert alert-warning">Este codigo de producto ya esta registrado</div>');

	    		$("#nuevoProductoUbicacion").val("");

	    	}

	    }

	})
})



/*=============================================
EDITAR PRODUCTO CPU
=============================================*/

$(".tablaProductosUbicacion tbody").on("click", "button.btnEditarProductoUbicacion", function () {
	
	var idProducto = $(this).attr("idProductoUbicacion");
	console.log("id",idProducto);
	var datos = new FormData();
	datos.append("idProducto", idProducto);
	$.ajax({
		url: "ajax/productos-ubicacion.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			console.log("res",respuesta)
			var datosProducto = new FormData();
			datosProducto.append("idProducto", respuesta["id_producto"]);
			

			$.ajax({
				url: "ajax/productos.ajax.php",
				method: "POST",
				data: datosProducto,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {
					console.log("respuesta",respuesta)
					$("#editarProductoUbicacion").val(respuesta["cod_producto"]);
				
				//$("#editarProductoUbicacion").html(respuesta["cod_producto"]);
				},
			});
			
			$("#editarReferencia").val(respuesta["referencia"]);
			$("#editarUbicacion").val(respuesta["id_ubicacion"]);
			$("#editarPosicion").val(respuesta["posicion"]);
			//para editar producto -capturando el id
			$("#id").val(respuesta["id"]);
			
			
		},
	});
});

/*=============================================
ELIMINAR UBICACION DEL PRODUCTO
=============================================*/

$(".tablaProductosUbicacion tbody").on(
	"click",
	"button.btnEliminarProductoUbicacion",
	function () {
		var idProductoUbicacion = $(this).attr("idProductoUbicacion");
	
		swal({
			title: "¿Está seguro de borrar la ubicacion de este producto?",
			text: "¡Si no lo está puede cancelar la accíón!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Si, borrar la ubicacion!",
		}).then(function (result) {
			if (result.value) {
				window.location =
					"index.php?ruta=ubicacion-productos&idProductoUbicacion=" +
					idProductoUbicacion;
			}
		});
	}
);

//select2 para listar CODIGO DE PRODUCTOS 	UBICACION
$(document).ready(function() {
	$('.mi-selector3').select2({
		width: '510px'
		
	});
	
  });

  //select2 para listar CODIGO DE PRODUCTOS UBICACION
$(document).ready(function() {
	$('.mi-selector4').select2({
		width: '510px'
		
	});
	
  });


  //PARA MOSTRAR IMAGEN DE LA UBICACION SELECCIONADA
  function ShowSelected(vista)
  {

  var ruta = $('option:selected', vista).attr('ruta');
  $("#previsualizar").attr("src", ruta);




  }


