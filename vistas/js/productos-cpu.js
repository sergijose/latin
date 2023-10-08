/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS CPU
=============================================

$.ajax({
	url: "ajax/datatable-productos-cpu.ajax.php",
	success: function (respuesta) {
	//	console.log("respuesta", respuesta);
	},
});
*/

var perfilOculto = $("#perfilOculto").val();


$(".tablaProductosCpu").DataTable({
	ajax: "ajax/datatable-productos-cpu.ajax.php?perfilOculto=" + perfilOculto,
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

$("#nuevoCodProductoCpu").change(function(){

	$(".alert").remove();


	var codigo = $(this).val();
	console.log("cod",codigo);

	var datos = new FormData();
	datos.append("validarCodigo", codigo);

	 $.ajax({
	    url:"ajax/productos-cpu.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	console.log("res",respuesta);
	    	if(respuesta){

	    		$("#nuevoCodProductoCpu").parent().after('<div class="alert alert-warning">Este codigo ya esta registrado, ingrese otro</div>');

	    		$("#nuevoCodProductoCpu").val("");

	    	}

	    }

	})
})



/*=============================================
EDITAR PRODUCTO CPU
=============================================*/

$(".tablaProductosCpu tbody").on("click", "button.btnEditarProductoCpu", function () {
	var idProductoCpu = $(this).attr("idProductoCpu");

	var datos = new FormData();
	datos.append("idProductoCpu", idProductoCpu);

	$.ajax({
		url: "ajax/productos-cpu.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			console.log("res",respuesta)
			var datosProducto = new FormData();
			datosProducto.append("idProducto", respuesta["idproducto"]);

			$.ajax({
				url: "ajax/productos.ajax.php",
				method: "POST",
				data: datosProducto,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {
					
					$("#editarCodProductoCpu").val(respuesta["cod_producto"]);
					//$("#editarCodProductoCpu").html(respuesta["cod_producto"]);
				},
			});
			

			$("#editarTipoDisco").val(respuesta["tipo_disco"]);
			$("#editarCantDisco").val(respuesta["cant_disco"]);
			$("#editarTipoRam").val(respuesta["tipo_ram"]);
			$("#editarCantRam").val(respuesta["cant_ram"]);
			$("#editarProcesador").val(respuesta["procesador"]);
			$("#editarSistemaOperativo").val(respuesta["sistema_operativo"]);
			$("#editarObservacion").val(respuesta["observaciones"]);
			//$("#editarEmpleado").val(respuesta["idempleado"]);
			//$("#editarEmpleado").select2("val", respuesta["idempleado"]);
			$("#editarIp").val(respuesta["direccion_ip"]);
			$("#editarModeloPlaca").val(respuesta["modelo_placa"]);
			$("#editarEdicion").val(respuesta["edicion_so"]);
			$("#editarMac").val(respuesta["mac"]);
			$("#editarGeneracion").val(respuesta["generacion"]);
			
			//para editar producto -capturando el id
			$("#id").val(respuesta["id"]);
			
			
		},
	});
});

/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablaProductosCpu tbody").on(
	"click",
	"button.btnEliminarProductoCpu",
	function () {
		var idProductoCpu = $(this).attr("idProductoCpu");
	
		swal({
			title: "¿Está seguro de borrar el detalle de este producto?",
			text: "¡Si no lo está puede cancelar la accíón!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Si, borrar detalle del producto!",
		}).then(function (result) {
			if (result.value) {
				window.location =
					"index.php?ruta=productos-cpu&idProductoCpu=" +
					idProductoCpu;
			}
		});
	}
);

//select2 para listar CODIGO DE PRODUCTOS CPU
$(document).ready(function() {
	$('.mi-selector2').select2({
		//width : 'resolve'
		width: '380px'
		
	});
	
  });

  //select2 para listar CLIENTE  a quien pertenece el cpu
$(document).ready(function() {
	$('.mi-selector-cliente').select2({
		//width : 'resolve'
		width: '380px'
		
	});
	
  });

  $(document).ready(function() {
	$(":input").inputmask();
  });