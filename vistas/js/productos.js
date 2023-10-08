/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/
/*
$.ajax({
	url: "ajax/datatable-productos.ajax.php",
	success: function (respuesta) {
		//	console.log("respuesta", respuesta);
	},
});
*/

var perfilOculto = $("#perfilOculto").val();

var tableProduct =$(".tablaProductos").DataTable({

	ajax: {
		url: "ajax/datatable-productos.ajax.php?perfilOculto=" + perfilOculto,
		type: 'POST',
		data: function(d) {
		  console.log(d);
			d.categoria = $('#categoria').val();
		 d.busqueda = $('#busqueda').val();
		 d.marca = $('#marca').val();
		 d.oficina = $('#oficina').val();
		 d.posicion = $('#posicion').val();
		 d.referencia = $('#referencia').val();
		 d.direccion_ip = $('#direccion_ip').val();
		},
	  },
	  
	deferRender: true,
	searching: false, // Esto deshabilitará la barra de búsqueda
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

$('#categoria').on('change', function() {
	tableProduct.ajax.reload();
});

$('#marca').on('change', function() {
	tableProduct.ajax.reload();
});


$('.busqueda').on('keyup', function() {
	tableProduct.ajax.reload();
});
$('.oficina').on('keyup', function() {
	tableProduct.ajax.reload();
});
$('.posicion').on('keyup', function() {
	tableProduct.ajax.reload();
});
$('.referencia').on('keyup', function() {
	tableProduct.ajax.reload();
});
$('.direccion_ip').on('keyup', function() {
	tableProduct.ajax.reload();
});

//LIMPIRAR FILTROS
$('#limpiarFiltrosButton').click(function() {
	// Limpia el contenido de todas las cajas de texto de filtro
	$('#categoria').val('').trigger('change');;
	$('#busqueda').val('');
	$('#marca').val('').trigger('change');;
	$('#oficina').val('');
	$('#posicion').val('');
	$('#referencia').val('');
	$('#direccion_ip').val('');

	// Vuelve a cargar los datos en la tabla
	tableProduct.ajax.reload();
});










/*=============================================
REVISAR SI EL CODIGO DEL PRODUCTO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoCodigo").change(function(){

	$(".alert").remove();


	var codigo = $(this).val();

	var datos = new FormData();
	datos.append("validarCodigo", codigo);

	 $.ajax({
	    url:"ajax/productos.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoCodigo").parent().after('<div class="alert alert-warning">Este codigo de producto  ya existe en la base de datos</div>');

	    		$("#nuevoCodigo").val("");

	    	}

	    }

	})
})

/*=============================================
REVISAR SI EL NUMERO DE SERIE YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoNumSerie").change(function(){

	$(".alert").remove();
	var serie = $(this).val();

	var datos = new FormData();
	datos.append("validarSerie", serie);

	 $.ajax({
	    url:"ajax/productos.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoNumSerie").parent().after('<div class="alert alert-warning">Este numero de serie  ya existe en la base de datos</div>');

	    		$("#nuevoNumSerie").val("");

	    	}

	    }

	})
})


/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on("click", "a.btnEditarProducto", function () {
	var idProducto = $(this).attr("idProducto");

	var datos = new FormData();
	datos.append("idProducto", idProducto);

	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			var datosModelo = new FormData();
			datosModelo.append("idModelo", respuesta["idmodelo"]);

			$.ajax({
				url: "ajax/modelos.ajax.php",
				method: "POST",
				data: datosModelo,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {
					
					$("#editarModelo").val(respuesta["id"]);
					//  $("#editarModelo").html(respuesta["descripcion"]);
				},
			});
			var datosEstado = new FormData();
			datosEstado.append("idEstado", respuesta["idestado"]);

			$.ajax({
				url: "ajax/estados.ajax.php",
				method: "POST",
				data: datosEstado,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {
					
					$("#editarEstado").val(respuesta["id"]);
					// $("#editarEstado").html(respuesta["descripcion"]);
				},
			});

			$("#editarCodigo").val(respuesta["cod_producto"]);
			$("#editarNumSerie").val(respuesta["num_serie"]);

			$("#editarEstadoPrestamo").val(respuesta["estado_prestamo"]);
			$("#editarObservaciones").val(respuesta["observaciones"]);
			//para editar producto -capturando el id
			$("#id").val(respuesta["id"]);
			
		},
	});
});

/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on(
	"click",
	"a.btnEliminarProducto",
	function () {
		var idProducto = $(this).attr("idProducto");
		swal({
			title: "¿Está seguro de borrar el producto?",
			text: "¡Si no lo está puede cancelar la accíón!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Si, borrar producto!",
		}).then(function (result) {
			if (result.value) {
				window.location =
					"index.php?ruta=productos&idProducto=" +
					idProducto;
			}
		});
	}
);


/*=============================================
MOSTRAR DATOS DE DETALLE UBICACION PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "a.btnMostrarDetalleProducto", function(){
	//console.log("hola")
	var idProducto = $(this).attr("idProducto");
	var datos = new FormData();
	datos.append("idProducto", idProducto);

	$.ajax({
		url: "ajax/productos-detalle.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(data){
			if(data.oficina==null ||data.oficina=="" ){
				$('#oficinaProducto').text("Sin Registro");
			} 
			
			else{
				$('#oficinaProducto').text(data.oficina);
			}

			if(data.posicion==null ||data.posicion=="" ){
				$('#posicionProducto').text("Sin Registro");
			} 

			else{
				$('#posicionProducto').text(data.posicion);
			}


			if(data.referencia==null ||data.referencia==""){
				$('#referenciaProducto').text("Sin Registro");
			} 
			else{
				$('#referenciaProducto').text(data.referencia);
			}
			
     	},
		 error: function (jqXHR, textStatus, errorThrown) {
           console.error('Error en la solicitud:', textStatus, errorThrown);
            // Aquí puedes mostrar un mensaje de error al usuario o tomar otras acciones para manejar el error
        }

	})


})


/*=============================================
MOSTRAR DATOS MODALDETALLES CPU PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "a.btnMostrarCaracteristicasCpu", function(){
	//console.log("hola")
	var idProducto = $(this).attr("idProducto");
	var datos = new FormData();
	datos.append("idProducto", idProducto);

	$.ajax({
		url: "ajax/productos-detalle.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(data){
			console.log(data)
			$('#ram').html('<b> Memoria RAM:</b>'  +data.cant_ram + 'GB ' +data.tipo_ram);
			$('#procesador').html('<b> Procesador:</b>'  +data.procesador +'<b> Generacion:</b>'+data.generacion);
			$('#disco_duro').html('<b> Disco Duro:</b>'  +data.cantidad_disco+ 'GB ' +data.tipo_disco);
			$('#sistema_operativo').html('<b> Sistema Operativo:</b>'  +data.sistema_operativo+'<b> Edicion:</b>'+data.edicion_so);
			$('#direccion_ip').html('<b> Direccion Ip:</b>'  +data.direccion_ip+'<b>');
			$('#mac').html('<b> Mac:</b>'  +data.mac+'<b>');
			$('#modelo_placa').html('<b> Modelo Placa:</b>'  +data.modelo_placa+'<b>');
			$('#notas').html('<b> Notas:</b>'  +data.observaciones+'<b>');
			$('#cod_producto').html('<b> ' + data.cod_producto+'<b>');

     	},
		 error: function (jqXHR, textStatus, errorThrown) {
           console.error('Error en la solicitud:', textStatus, errorThrown);
            // Aquí puedes mostrar un mensaje de error al usuario o tomar otras acciones para manejar el error
        }

	})


})

//select2 LISTA DE CATEGORIA
$(document).ready(function() {
	
 $('.categoria').select2({
	width: '250px'

 });
 
 $('.marca').select2({
	width: '250px'

 });
});





/*para llenar atributo del svg el codigo del producto
$("#nuevoCodigo").change(function(){
	var codigo = $(this).val();
	$("#barcode").attr("codigobarras", codigo);
	JsBarcode("#barcode",codigo.toString(),{
		format:"CODE39",
		lineColor: "#000",
		width:2,
		height:80,
		displayValue:true
		
	})

})


//var codigo_barras=document.querySelectorAll("barcodetabla");
//console.log("barras",codigo_barras);
*/
