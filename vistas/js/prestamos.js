

/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRango") != null){

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));


}else{

	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}









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

//traer datos para generar la devolucion del producto

$(".tablas").on("click", ".btnEditarPrestamo", function () {
  var idPrestamo = $(this).attr("idPrestamo");
  console.log(idPrestamo);
  var datos = new FormData();
  datos.append("idPrestamo", idPrestamo);

  $.ajax({
    url: "ajax/prestamos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idPrestamo").val(respuesta["id"]);
      $("#idProducto").val(respuesta["idproducto"]);
    },
  });

 
});



/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablas tbody").on(
	"click",
	"button.btnEliminarPrestamo",
	function () {
		var idPrestamo = $(this).attr("idPrestamo");
		swal({
			title: "¿Está seguro de eliminar este registro?",
			text: "¡Si no lo está puede cancelar la accíón!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Si, borrar registro!",
		}).then(function (result) {
			if (result.value) {
				window.location =
					"index.php?ruta=prestamos&idPrestamo=" +
					idPrestamo;
			}
		});
	}
);


/*=============================================
IMPRIMIR PRESTAMO
=============================================*/

$(".tablas").on("click", ".btnImprimirPrestamo", function(){

	var idPrestamo = $(this).attr("idPrestamo");

	window.open("extensiones/tcpdf/pdf/prestamo.php?id="+idPrestamo, "_blank");

})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    var capturarRango = $("#daterange-btn span").html();
   
   	localStorage.setItem("capturarRango", capturarRango);

   	window.location = "index.php?ruta=prestamos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)


//select2 para listar empleados
$(document).ready(function() {
  $('.mi-selector').select2();
});

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "prestamos";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		 //if(mes < 10){

		// 	var fechaInicial = año+"-0"+mes+"-"+dia;
		 //	var fechaFinal = año+"-0"+mes+"-"+dia;

		// }else //(dia < 10){

		//	var fechaInicial = año+"-"+mes+"-0"+dia;
		//	var fechaFinal = año+"-"+mes+"-0"+dia;

		//}else if(mes < 10 && dia < 10){

		// 	var fechaInicial = año+"-0"+mes+"-0"+dia;
		// 	var fechaFinal = año+"-0"+mes+"-0"+dia;

		// }else{

		// 	var fechaInicial = año+"-"+mes+"-"+dia;
	   //  	var fechaFinal = año+"-"+mes+"-"+dia;

		// }

		dia = ("0"+dia).slice(-2);
		mes = ("0"+mes).slice(-2);

		var fechaInicial = año+"-"+mes+"-"+dia;
		var fechaFinal = año+"-"+mes+"-"+dia;	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=prestamos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})


//BOTON EDITAR PRESTAMO
$(".tablas").on("click", ".btnEditarPrestamo", function(){
var idPrestamo=$(this).attr("idPrestamo");
window.location="index.php?ruta=editar-prestamo&idPrestamo="+idPrestamo;

})

//PARA ACTIVAR CAHJAS EN EL CHECBOX PARA FINALIZAR PRESTAMO
function comprobar(obj)
{   
    if (obj.checked){
      
document.getElementById('observacionDevolucion').style.display = "";
document.getElementById('observacionDevolucion').readOnly=false;
document.getElementById('observacionPrestamo').readOnly=true;
document.getElementById('caja').style.display = "";
document.getElementById('btnFinalizar').style.display = "";

//para no manipular las cajas al finalizar el prestamo
document.getElementById('guardarPrestamo').disabled = true;

//document.getElementById('cajaPadre').disabled=true;
$("div #cajaPadre").find("*").prop('disabled', true);
$("div #tablaProductos").find("*").prop('disabled', true);

   } else{
      
document.getElementById('observacionDevolucion').style.display = "none";
document.getElementById('observacionPrestamo').readOnly=false;
document.getElementById('caja').style.display = "none";
document.getElementById('btnFinalizar').style.display = "none";

document.getElementById('observacionPrestamo').readOnly=false;
document.getElementById('cajaPadre').disabled=false;

document.getElementById('guardarPrestamo').disabled = false;
$("div #cajaPadre").find("*").prop('disabled', false);
$("div #tablaProductos").find("*").prop('disabled', false);
   }     
}