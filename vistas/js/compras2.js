
/*
 $.ajax({

  url: "ajax/datatable-listado-compras.ajax.php",
  success:function(respuesta){
   
    //console.log("respuesta", respuesta);

  }

})
*/ 
var perfilOculto = $("#perfilOculto").val();
var idUsuario = $("#idUsuario").val();
$('.tablaListadoCompras').dataTable({
  "ajax":"ajax/datatable-listado-compras.ajax.php?perfilOculto="+perfilOculto,
  //"ajax": "ajax/datatable-listado-compras.ajax.php?idSede="+idSede,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {

    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst": "Primero",
      "sLast": "Último",
      "sNext": "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  },
  "lengthMenu": [3, 10, 15, 20, 50, 100],
  "pageLength": 3

});

/*=============================================
 BOTON EDITAR COMPRA
=============================================*/
$(".tablaListadoCompras").on("click", ".btnEditarCompra", function () {
  var idCompra = $(this).attr("idCompra");
  window.location = "index.php?ruta=editar-compra&idCompra="+idCompra;
})



/*=============================================
BORRAR Compra
=============================================*/
$(".tablaListadoCompras").on("click", ".btnEliminarCompra", function () {

  var idCompra = $(this).attr("idcompra");
  swal({
    title: '¿Está seguro de borrar la compra?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar Compra!'
  }).then(function (result) {
    if (result.value) {

      window.location = "index.php?ruta=compras&idCompra=" + idCompra;
    }
  })
})
