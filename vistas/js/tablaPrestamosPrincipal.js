
/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRango") != null){

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));


}else{

	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}

//esto nos servira para comprobar si nuestro json esta bien estructurado
/*
var perfilOculto = $("#perfilOculto").val();
$.ajax({
  url: "ajax/datatable-prestamos-principal.ajax.php?perfilOculto=" + perfilOculto,
  success: function (respuesta) {
   // console.log("respuestaPrincipal", respuesta);
  },
});
*/
$(".tablaPrestamoPrincipal").DataTable({
  //ajax:"ajax/datatable-prestamos-principal.ajax.php?perfilOculto=" + perfilOculto,
  ajax: {
    url: "ajax/datatable-prestamos-principal.ajax.php?perfilOculto=" + perfilOculto,
    data: function (d) {
      // Agregar lógica para obtener las fechas desde la URL
      var urlParams = new URLSearchParams(window.location.search);
      d.fechaInicial = urlParams.get('fechaInicial');
      d.fechaFinal = urlParams.get('fechaFinal');
      //d.perfilOculto = perfilOculto; // Asegúrate de definir perfilOculto antes de usarlo
    },
  },
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

//traer datos para generar la devolucion del producto

$(".tablaPrestamoPrincipal").on("click", ".btnEditarPrestamo", function () {
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


//traer datos para pintar en la asignacion

$(".tablaPrestamoPrincipal").on("click", ".btn-asignar", function () {
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
      $("#idPrestamoAsignar").val(idPrestamo);
      $("#codigo_cliente").val(respuesta["codigo_cliente"]);
      $("#comentario_asignado").val(respuesta["comentario_asignado"]);
    },
  });

 
});

//TRAER DATOS PARA VER TECNICOS QUE INSTALO
$(".tablaPrestamoPrincipal").on("click", ".btnVerTecnicoInstalacion", function () {
  var idPrestamo = $(this).attr("idPrestamo");
  var datos = new FormData();
  datos.append("idPrestamo", idPrestamo);
  $.ajax({
    url: "ajax/instalaciones.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      $("#idPrestamoInstalacion").val(idPrestamo);
     $("#nombre_tecnico1").val(respuesta[0]['tecnico_uno']);
     $("#nombre_tecnico2").val(respuesta[0]['tecnico_dos']);
    },
  });

 
});




/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablaPrestamoPrincipal tbody").on(
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

$(".tablaPrestamoPrincipal").on("click", ".btnImprimirPrestamo", function(){

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

  $('.selector2').select2()
  ;
})

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
		var anio = d.getFullYear();

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

    if (dia < 10 ) {

      dia = '0'+dia;
      
      } else {
      
      dia = dia;
      
      }
      
      
      
      if(mes<10){
      
      mes = '0'+mes;
      
      } else {
      
      mes = mes;
      
      }

		//dia = ("0"+dia).slice(-2);
		//mes = ("0"+mes).slice(-2);

		var fechaInicial = anio+"-"+mes+"-"+dia;
		var fechaFinal = anio+"-"+mes+"-"+dia;	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=prestamos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})


//BOTON EDITAR PRESTAMO
$(".tablaPrestamoPrincipal").on("click", ".btnEditarPrestamo", function(){
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

//PARA CAPTURAR EL ID DEL PRESTAMO
document.addEventListener('DOMContentLoaded', function () {
  // Obtén una referencia al botón
  var botonEditarPrestamo = document.querySelectorAll('.btn-asignar');
  // Agrega un evento click al botón

  // Itera sobre cada botón y agrega el evento click
  botonEditarPrestamo.forEach(function (botonEditarPrestamo) {
  botonEditarPrestamo.addEventListener('click', function () {
      // Obtén el valor del atributo idPrestamo
      var idPrestamo = botonEditarPrestamo.getAttribute('idPrestamo');
      idPrestamoAsignar.value = idPrestamo;
    
      
  });
});
});
