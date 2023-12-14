<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


require_once "../controladores/modelos.controlador.php";
require_once "../modelos/modelos.modelo.php";

require_once "../controladores/prestamos.controlador.php";
require_once "../modelos/prestamos.modelo.php";

class TablaProductosPrestamosPrincipal{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosPrestamosPrincipal(){

		if (isset($_GET["fechaInicial"])) {

			$fechaInicial = $_GET["fechaInicial"];
			$fechaFinal = $_GET["fechaFinal"];
		  } else {

			$fechaInicial = null;
			$fechaFinal = null;
		  }

		  $respuesta = ControladorPrestamos::ctrRangoFechasPrestamos($fechaInicial, $fechaFinal);
          
  		if(count($respuesta) == 0){

  			echo '{"data": []}';

		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($respuesta); $i++){
          
		
			//$item = "id";
			//$valor = $respuesta[$i]["idproducto"];
			//$order = "id";

			//$respuestaProducto = ControladorProductos::ctrMostrarProductos($item, $valor, $order);
			$codigoCliente=strtoupper($respuesta[$i]['codigo_cliente'])." ".strtoupper($respuesta[$i]['nombre_cliente']);
		$tipoServicio= "<span class='badge badge-secondary'>".strtoupper($respuesta[$i]["tipo_servicio"]) ."</span>";
			$productos = json_decode( $respuesta[$i]["productos"], true);
			$productos_lotes = json_decode( $respuesta[$i]["productos_lotes"], true);


			$cantidad = '';
			if (!is_null($productos_lotes) && is_array($productos_lotes)) {
			 foreach ($productos_lotes as $key2 => $value2) {
			$cantidad .= "<span style='color:blue;'>".$value2["cantidad"]." ".$value2["descripcion"] ."</span><br>";
			}
		  }
		  $codigoProducto='';
			if (!is_null($productos) && is_array($productos)) {
			foreach ($productos as $key => $valueProductos) {
				$codigoProducto .=($valueProductos["codigo"]).'<br>';
		   
			  
			}
		  }
		  $resumenProducto=$codigoProducto.''.$cantidad;
		  $botones="";
			
			 if ($respuesta[$i]["estado_prestamo"] == "PENDIENTE") {


			  $estado="<button class='btn btn-danger btn-xs btn-asignar' data-toggle='modal' idPrestamo='" .$respuesta[$i]["id"] . "' idEmpleado='" .  $respuesta[$i]["idempleado"] . "'   data-target='#modalAsignarPrestamo'>" . $respuesta[$i]["estado_prestamo"] . "</button>";
			} else  {

				$estado="<button class='btn btn-success btn-xs'>" . $respuesta[$i]["estado_prestamo"] . "</button>";
			}

			$botones= "<div class='btn-group'><button class='btn btn-info btn-xs btnImprimirPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "'><i class='fa fa-print'></i></button>";

			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador") {
			  if ($respuesta[$i]["estado_prestamo"] == "FINALIZADO") {

				$botones.="<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled ><i class='fas fa-pencil-alt'></i></button>";
			  } else {
				$botones.="<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' data-toggle='modal' data-target='#modalDevolverProducto' data-toggle='tooltip' title='Editar Producto'><i class='fas fa-pencil-alt'></i></button>";
			  }

			  if ($respuesta[$i]["estado_prestamo"] == "PENDIENTE" ||$respuesta[$i]["estado_prestamo"] == "INSTALADO" ) {
				$botones.="<button class='btn btn-danger btn-xs btnEliminarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled><i class='fa fa-times'></i></button>";
			  } else {
				$botones.="<button class='btn btn-danger btn-xs btnEliminarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "'><i class='fa fa-times'></i></button>";
			  }
			} else {
			  if ($respuesta[$i]["estado_prestamo"] == "FINALIZADO") {
				$botones.="<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled ><i class='fas fa-pencil-alt'></i></button>";
			  } else {
				$botones.= "<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' data-toggle='modal' data-target='#modalDevolverProducto' data-toggle='tooltip' title='Editar Producto'><i class='fas fa-pencil-alt'></i></button>";
			  }
			}
			$botones.='</div>' ;

			$datosJson .= '[
				"' . ($i + 1) . '",
				"' . strtoupper($respuesta[$i]["empleado"]) . '",
				"' .  $codigoCliente.'",
				"' . $tipoServicio.'",
				"' . $resumenProducto.'",
				"' . date("d/m/Y", strtotime($respuesta[$i]["fecha_prestamo"])) . '",
				"' . date("d/m/Y", strtotime($respuesta[$i]["fecha_devolucion"])) . '",
				"' . $respuesta[$i]["observacion_prestamo"] .'",
				"' . $respuesta[$i]["observacion_devolucion"] .'",
				"' . $estado .'",
				"' . $botones . '"
			  ],';

	}
	$datosJson = substr($datosJson, 0, -1);

		$datosJson .=   '] 

		 }';

		echo $datosJson;



}
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductosPrestamosPrincipal = new TablaProductosPrestamosPrincipal();
$activarProductosPrestamosPrincipal -> mostrarTablaProductosPrestamosPrincipal();

