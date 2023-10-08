/*=============================================
EDITAR EMPLEADO
=============================================*/
$(".tablas").on("click", ".btnEditarEmpleado", function(){

	var idEmpleado = $(this).attr("idEmpleado");

	var datos = new FormData();
    datos.append("idEmpleado", idEmpleado);

    $.ajax({

      url:"ajax/empleado.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idEmpleado").val(respuesta["idempleado"]);
	       $("#editarApePat").val(respuesta["ape_pat"]);
	       $("#editarApeMat").val(respuesta["ape_mat"]);
	       $("#editarNombres").val(respuesta["nombres"]);
	       $("#editarNumDocumento").val(respuesta["num_documento"]);
	       $("#editarEstado").val(respuesta["estado"]);
	  }

  	})

})

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoNumDocumento").change(function(){

	$(".alert").remove();

	var empleado = $(this).val();

	var datos = new FormData();
	datos.append("validarEmpleado", empleado);

	 $.ajax({
	    url:"ajax/empleado.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoNumDocumento").parent().after('<div class="alert alert-warning">Este numero de documento ya existe en la base de datos</div>');

	    		$("#nuevoNumDocumento").val("");

	    	}

	    }

	})
})


/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarEmpleado", function(){

	var idEmpleado = $(this).attr("idEmpleado");
	
	swal({
        title: '¿Está seguro de borrar este empleado?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar empleado!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=empleados&idEmpleado="+idEmpleado;
        }

  })

})