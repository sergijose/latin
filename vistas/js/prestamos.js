


//esto nos servira para comprobar si nuestro json esta bien estructurado
$.ajax({
  url: "ajax/datatable-prestamos.ajax.php",
  success: function (respuesta) {
    //console.log("respuesta", respuesta);
  },
});

$(".tablaPrestamos").DataTable({
  ajax: "ajax/datatable-prestamos.ajax.php",
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

// tablaN es el nombre e la tabla de productoslotes en crear pedido;
$('.tablaProductoLotes').DataTable({
  "ajax": "ajax/datatable-pedidos.ajax.php",
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
AGREGANDO PRODUCTOS PARA EL PRESTAMO DESDE LA TABLA

=============================================*/
var contadorObs = 0;
$(".tablaPrestamos tbody").on("click", "button.agregarProducto", function () {
  contadorObs = contadorObs + 1;
  var idProducto = $(this).attr("idProducto");

  $(this).removeClass("btn-primary agregarProducto");

  $(this).addClass("btn-default");

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

    
      var codigo = respuesta["cod_producto"];
      var estado_prestamo = respuesta["estado_prestamo"];

      /*=============================================
					  EVITAR AGREGAR PRODUTO CUANDO EL ESTADO DEL PRESTAMO ESTÁ OCUPADO
       =============================================*/

      if (estado_prestamo == "OCUPADO") {
        swal({
          title: "Este producto esta ocupado",
          type: "error",
          confirmButtonText: "¡Cerrar!",
        });

        $("button[idProducto='" + idProducto + "']").addClass(
          "btn-primary agregarProducto"
        );

        return;
      }

      $(".nuevoProducto").append(
        '<div class="row" style="padding:5px 15px">' +
          "<!-- Codigo del producto -->" +
          '<div class="col-xs-6" style="padding-right:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><button type="button"  class="btn btn-danger btn-xs eliminarBoton quitarProducto" idProducto="' +
          idProducto +
          '"><i class="fa fa-times"></i></button></span>' +
          '<input type="text" class="form-control nuevoCodigoProducto " idProducto="' +
          idProducto +
          '" name="agregarProducto" value="' +
          codigo +
          '" readonly required>' +
          "</div>" +
          "</div>" +
          "<!-- Estado del producto -->" +
          '<div class="col-xs-6 estadoProducto" style="padding-left:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><i class="fa fa-thumbs-o-up"></i></span>' +
          '<input type="text" class="form-control nuevoEstadoProducto"name="nuevoEstadoProducto" value="' +
          estado_prestamo +
          '" readonly required>' +
          "</div>" +
          "</div>" +
          "<!-- Agregar OBSERVACION DE PRESTAMO-->" +
          "</div>"
      );
      listarProductosPrestamos();
      listarProductos2();
      localStorage.removeItem("quitarProducto");
    },
  });
});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaPrestamos").on("draw.dt", function () {
  if (localStorage.getItem("quitarProducto") != null) {
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

    for (var i = 0; i < listaIdProductos.length; i++) {
      $(
        "button.recuperarBoton[idProducto='" +
          listaIdProductos[i]["idProducto"] +
          "']"
      ).removeClass("btn-default");
      $(
        "button.recuperarBoton[idProducto='" +
          listaIdProductos[i]["idProducto"] +
          "']"
      ).addClass("btn-primary agregarProducto");
    }
  }
});

/*=============================================
QUITAR PRODUCTOS DEL PRESTAMO Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(".formularioPrestamo").on("click", "button.quitarProducto", function () {
  $(this).parent().parent().parent().parent().remove();

  var idProducto = $(this).attr("idProducto");
  /*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
  =============================================*/
  if (localStorage.getItem("quitarProducto") == null) {
    idQuitarProducto = [];
  } else {
    idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
  }
  idQuitarProducto.push({ idProducto: idProducto });
  localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

  $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass(
    "btn-default"
  );

  $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass(
    "btn-primary agregarProducto"
  );

  listarProductosPrestamos();
  listarProductos2();
});

/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0;

$(".btnAgregarProducto").click(function () {
  numProducto++;

  var datos = new FormData();
  datos.append("traerProductos", "ok");

  $.ajax({
    url: "ajax/productos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $(".nuevoProducto").append(
        '<div class="row" style="padding:5px 15px">' +
          "<!-- Codigo del producto -->" +
          '<div class="col-xs-6" style="padding-right:0px">' +
          '<div class="input-group">' +
          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" id="eliminarBoton" idProducto=" "' +
          '"><i class="fa fa-times"></i></button></span>' +
          '<select class="form-control nuevoCodigoProducto"  id="producto' +
          numProducto +
          '" idProducto name="nuevaDescripcionProducto" required>' +
          "<option>Seleccione el producto</option>" +
          "</select>" +
          "</div>" +
          "</div>" +
          "</div>"
      );

      // AGREGAR LOS PRODUCTOS AL SELECT

      respuesta.forEach(funcionForEach);

      function funcionForEach(item, index) {
        if (item.estado_prestamo != "OCUPADO") {
          $("#producto" + numProducto).append(
            '<option idProducto="' +
              item.id +
              '" value="' +
              item.cod_producto +
              '">' +
              item.cod_producto +
              "</option>"
          );
        }
      }
    },
  });
});

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioPrestamo").on(
  "change",
  "select.nuevoCodigoProducto",
  function () {
    var codigoProducto = $(this).val();

    var nuevaDescripcionProducto = $(this)
      .parent()
      .parent()
      .parent()
      .children()
      .children()
      .children(".nuevoCodigoProducto");

    var datos = new FormData();
    datos.append("codigoProducto", codigoProducto);

    $.ajax({
      url: "ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        //console.log(respuesta);
        $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductosPrestamos();
        // listarProductos2();
      },
    });
  }
);

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosPrestamos() {
  var listaProductosPrestamos = [];

  var codigo = $(".nuevoCodigoProducto");

  for (var i = 0; i < codigo.length; i++) {
    listaProductosPrestamos.push({
      id: $(codigo[i]).attr("idProducto"),
      codigo: $(codigo[i]).val(),
    });
  }

  $("#listaProductosPrestamos").val(JSON.stringify(listaProductosPrestamos));
 
}
/*=============================================
LISTAR TODOS LOS PRODUCTOS PARA GENERAR PRESTAMOS
=============================================*/
function listarProductos2() {
  var listaProductosPrestamos2 = [];

  var observacion = $(".nuevaObservacion");

  //para llenar lista de productos 2
  for (var i = 0; i < observacion.length; i++) {
    listaProductosPrestamos2.push({
      id: $(observacion[i]).attr("idproducto"),
      observacion: $(observacion[i]).val(),
    });
  }
  $("#listaProductosPrestamos2").val(JSON.stringify(listaProductosPrestamos2));
}
/*
//aparecer swal para llenar observaciones
$(".formularioPrestamo").on("click", "button.btnObservacion", function () {
  $(this).attr("disabled", true);
  $(this).removeClass("btn-warning");
  $(this).addClass("btn-success");
  //aparecer swal para llenar observaciones
  var capturarCaja = $(this).parent().children(".nuevaObservacion");

  swal({
    title: "Ingrese Observacion sobre el prestamo de este producto",
    input: "text",
    type: "info",
    inputPlaceholder: "campo obligatorio",
    showCancelButton: true,
    confirmButtonText: "Guardar",
    allowEscapeKey: false,
    allowOutsideClick: false,
    closeOnClickOutside: false,
    showCancelButton: false,
    inputValidator: (value) => {
      if (!value) {
        return "Este campo es obligatorio!";
      }
    },
  }).then(function (result) {
    if (result.value) {
      let nombre = result.value;

      $(capturarCaja).val(nombre);
      listarProductos2();
    }
  });
});
*/
