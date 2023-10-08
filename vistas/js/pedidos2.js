

/*
 $.ajax({
  url: "ajax/datatable-listado-pedidos.ajax.php",
  success:function(respuesta){
  console.log("res", respuesta);
  }
});

*/
var perfilOculto = $("#perfilOculto").val();
var idUsuario = $("#idUsuario").val();
$('.tablaListadoPedidos').dataTable({
  "ajax": "ajax/datatable-listado-pedidos.ajax.php?perfilOculto=" +perfilOculto,
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

	}

} );
/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablaListadoPedidos").on("click", ".btnEditarPedido", function () {
  var idPedido = $(this).attr("idPedido");
  window.location = "index.php?ruta=editar-pedido&idPedido=" + idPedido;
})
/*=============================================IMPRIMIR FACTURA=============================================*/
$(".tablaListadoPedidos").on("click", ".btnImprimirPedido", function () {
  var codigoPedido = $(this).attr("codigoPedido");
  window.open("extensiones/tcpdf/pdf/ticket.php?codigo=" + codigoPedido, "_blank");
})

/*=============================================
BORRAR VENTA
=============================================*/
$(".tablaListadoPedidos").on("click", ".btnEliminarPedido", function () {

  var idPedido = $(this).attr("idpedido");
console.log(idPedido);
  swal({
    title: '¿Está seguro de borrar el Pedido?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar pedido!'
  }).then(function (result) {
    if (result.value) {

      window.location = "index.php?ruta=pedidos&idPedido=" + idPedido;
    }
  })
})
