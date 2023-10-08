/*=============================================
SUBIENDO LA FOTO DEL MODELO
=============================================*/
$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaFoto").val("");

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
EDITAR MODELO
=============================================*/
$(".tablas").on("click", ".btnEditarModelo", function(){

	var idModelo = $(this).attr("idModelo");
	
	var datos = new FormData();
	datos.append("idModelo", idModelo);

	$.ajax({

		url:"ajax/modelos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarCategoria").val(respuesta["idcategoria"]);
			$("#editarMarca").val(respuesta["idmarca"]);
			$("#editarModelo").val(respuesta["descripcion"]);
			$("#editarInformacion").val(respuesta["informacion"]);
			//$("#imagenActual").val(respuesta["imagen"]);
			$("#id").val(respuesta["id"]);
			if(respuesta["imagen"] != ""){

				$("#imagenActual").val(respuesta["imagen"]);
 
				$(".previsualizar").attr("src",  respuesta["imagen"]);
 
			}

		}

	});

})
/*=============================================
MOSTRAR IMAGEN EN MODAL PARA VISUALIZAR
=============================================*/
$(".tablas").on("click", ".btnMostrarImagen", function(){

	var id = $(this).attr("id");
	
	var datos = new FormData();
	datos.append("idModelo", id);

	$.ajax({

		url:"ajax/modelos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){	

			$(".previsualizarimagen").attr("src", respuesta["imagen"]);
	
			

			}

		

	});
});




/*=============================================
ELIMINAR MODELO
=============================================*/
$(".tablas").on("click", ".btnEliminarModelo", function(){

  var idModelo = $(this).attr("idModelo");
  var imagen = $(this).attr("fotoModelo");
  var modelo = $(this).attr("modelo");

  swal({
    title: '¿Está seguro de borrar el modelo?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar modelo!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=modelo&idModelo="+idModelo+"&modelo="+modelo+"&imagen="+imagen;

    }

  })

})








