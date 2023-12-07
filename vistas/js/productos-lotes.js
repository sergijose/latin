/*====================== 
CARGAR LA TABLA DINÁMICA DE PRODUCTOS PRINCIPAL 
=============================================
 $.ajax({
url: "ajax/datatable-productos-lotes.ajax.php",
 	success:function(respuesta){	

	}
})
*/

var perfilOculto = $("#perfilOculto").val();
$('.tablaProductosLotes').DataTable( {
    "ajax": "ajax/datatable-productos-lotes.ajax.php?perfilOculto="+perfilOculto,
    "deferRender": true,
	"retrieve": true,
	"processing": true,
  
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	},
  "lengthMenu":[5, 10, 15, 20, 50, 100],
  "pageLength":50

});

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function(){
	var idCategoria = $(this).val();

	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/productos-lotes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"01";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})

/*=============================================
CAMBIO DE PORCENTAJE
=============================================
$(".nuevoPorcentaje").change(function () {
	if ($(".porcentaje").prop("checked")) {

		var valorPorcentaje = $(this).val();
		var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());
		var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly", true);
		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly", true);
	}
})
$(".porcentaje").on("ifUnchecked", function () {
	$("#nuevoPrecioVenta").prop("readonly", false);
	$("#editarPrecioVenta").prop("readonly", false);
})
$(".porcentaje").on("ifChecked", function () {
	$("#nuevoPrecioVenta").prop("readonly", true);
	$("#editarPrecioVenta").prop("readonly", true);
})

/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablaProductosLotes tbody").on("click", "button.btnEditarProductoLotes", function () {

	var idProducto = $(this).attr("idProducto");
//	 console.log("mensajito", idProducto);
	var datos = new FormData();
	datos.append("idProducto", idProducto);
	$.ajax({ // Aqui empieza la Edicion de Productos Ajax

		url: "ajax/productos-lotes.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) { // Aqui se devuelve la data

            // Mostramos los datos para Editar la Categoria
			var datosCategoria = new FormData();
			datosCategoria.append("idCategoria", respuesta["idcategoria"]);
			$.ajax({ // Inicio para categorias

				url: "ajax/categorias.ajax.php",
				method: "POST",
				data: datosCategoria,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {
				
     				$("#editarCategoria").val(respuesta["id"]);
				}

			}) // Final para categorias

			// Mostramos los datos para Editar la Sucursal
          
	
			
			$("#id").val(respuesta["id"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarCodigo").val(respuesta["codigo"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
			$("#editarUnidadMedida").val(respuesta["unidad_medida"]);
			$("#editarStock").val(respuesta["stock"]);
			$("#editarPrecioCompra").val(respuesta["precio_compra"]);
			$("#editarPrecioVenta").val(respuesta["precio_venta"]);
			if (respuesta["imagen"] != "") {

				$("#imagenActual").val(respuesta["imagen"]);
				$(".previsualizar").attr("src", respuesta["imagen"]);

			}

		}

	}) // Aqui termina la edicion de Productos Ajax

})

/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaProductosLotes tbody").on("click", "button.btnEliminarProductoLotes", function () {
	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");
	swal({

		title: '¿Está seguro de borrar el producto?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar producto!'
	}).then(function (result) {
		if (result.value) {
			window.location = "index.php?ruta=productos-lotes&idProducto=" + idProducto+"&imagen="+imagen+"&codigo="+codigo;

		}

	})
})



/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/

$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})
/*=============================================
Generamos Codigo del Producto Mediante el Boton
=============================================*/

//function getCodigoProducto(){
//	document.getElementById('nuevoCodigo').value = autoCreate(13);
//}

/*function autoCreate(plength){
	var chars = "abcdefghijklmnopqrstubwsyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	var nuevoCodigo = '';	
		for(i=0; i<plength; i++){
			nuevoCodigo+=chars.charAt(Math.floor(Math.random()*chars.length));
		}
	
	return nuevoCodigo;
}
*/

/*=============================================
Seleccionamos el Tipo de Producto
1: Comidas
2: Productos
3: Bebidas
=============================================*/


/*$("#nuevaCategoria").change(function(){

  var vacios ="9999";
  var limpio ="";
  var nulo ="0";
  var metodo = $(this).val();

  if(metodo == "1"){ // Aplica para Productos

  	  $("#nuevoStock").val(limpio);
     $("#nuevoPrecioCompra").val(limpio);

     $('#nuevoStock').prop('readonly', false);
  	$('#nuevoPrecioCompra').prop('readonly', false);
  }else
  {
      // Aplica para Comidas y Bebidas
     $("#nuevoStock").val(vacios);
     $("#nuevoPrecioCompra").val(nulo);

    $('#nuevoStock').prop('readonly', true);
  	$('#nuevoPrecioCompra').prop('readonly', true);
  }

})
*/
