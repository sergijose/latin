<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductosPrestamos

{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaProductosPrestamos()
	{
		$productos = ControladorProductos::ctrMostrarProductosParaPrestamo();




		if (count($productos) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($productos); $i++) {



			/*=============================================
 	 		TRAEMOS IMAGEN DEL MODELO
  			=============================================*/
			$imagenProducto = "<img src='" . $productos[$i]["imagen"] . "' width='40px'>";

			/*=============================================
 	 		TRAEMOS EL MODELO
  			=============================================*/

			$modelos = $productos[$i]["modelo"];


			/*=============================================
 	 		TRAEMOS ESTADO DEL PRODUCTO
              =============================================*/

			$estadoProducto =  $productos[$i]["estado_producto"];

			if ($estadoProducto == "MALOGRADO") {

				$estado = "<span class='label label-danger  btn-xs'>" . $estadoProducto . "</span>";
			} else if ($estadoProducto == "REPARACION GARANTIA" or $estadoProducto == "REPARACION INTERNA") {

				$estado = "<span class='label label-warning btn-xs'>" . $estadoProducto . "</span>";
			} else {

				$estado = "<span class='label label-primary   btn-xs'>" . $estadoProducto . "</span>";
			}

			/*=============================================
 	 		TRAEMOS ESTADO DEL PRESTAMO DEL PRODUCTO
              =============================================*/


			if ($productos[$i]["estado_prestamo"] == "OCUPADO") {

				$estadoPrestamoProducto = "<span class='label label-danger  btn-xs'>" . $productos[$i]["estado_prestamo"] . "</span>";
			} else if ($productos[$i]["estado_prestamo"] == "NO APLICA") {

				$estadoPrestamoProducto = "<span class='label label-warning btn-xs'>" . $productos[$i]["estado_prestamo"] . "</span>";
			} else {

				$estadoPrestamoProducto = "<span class='label label-success  btn-xs'>" . $productos[$i]["estado_prestamo"] . "</span>";
			}

			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/

			$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Prestar</button></div>";

			$datosJson .= '[
				"' . ($i + 1) . '",
                "' . $imagenProducto . '",
			      "' . $modelos . '",
			      "' . $productos[$i]["cod_producto"] . '",
				  "' . $productos[$i]["num_serie"] . '",
			      "' . $estado . '",
			      "' . $estadoPrestamoProducto . '",
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
$activarProductosPrestamos = new TablaProductosPrestamos();
$activarProductosPrestamos->mostrarTablaProductosPrestamos();
