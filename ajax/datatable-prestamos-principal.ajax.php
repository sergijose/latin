<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


require_once "../controladores/modelos.controlador.php";
require_once "../modelos/modelos.modelo.php";

require_once "../controladores/prestamos.controlador.php";
require_once "../modelos/prestamos.modelo.php";

class TablaProductosPrestamosPrincipal
{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaProductosPrestamosPrincipal()
	{

		if (isset($_GET["fechaInicial"])) {

			$fechaInicial = $_GET["fechaInicial"];
			$fechaFinal = $_GET["fechaFinal"];
		} else {

			$fechaInicial = null;
			$fechaFinal = null;
		}

		$respuesta = ControladorPrestamos::ctrRangoFechasPrestamos($fechaInicial, $fechaFinal);

		if (count($respuesta) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($respuesta); $i++) {


			//$item = "id";
			//$valor = $respuesta[$i]["idproducto"];
			//$order = "id";
			$respuesta_tecnicos = ControladorPrestamos::ctrMostrarInstalacionesTecnicos("id_prestamo",$respuesta[$i]["id"]);
			
			$empleado= strtoupper($respuesta[$i]["empleado"]);
			if ($respuesta[$i]["estado_prestamo"] == "INSTALADO") {

				if (empty($respuesta_tecnicos)) {

					$empleado.= "<br><button class='btn btn-danger btn-xs'>no se registro que tecnico instalo</button>";

				}	
				else{
					$empleado.= "<br><button class='btn btn-info btn-xs btnVerTecnicoInstalacion' idPrestamo='" . $respuesta[$i]["id"] . "' data-toggle='modal' data-target='#modalVerTecnicoInstalacion' data-toggle='tooltip' title='Tecnico que instalo'><i class='fas fa-eye'></i> ver tecnico que instalo</button>";
				}
				
			}	
		
			$codigoCliente= strtoupper($respuesta[$i]['codigo_cliente']) . " " . strtoupper($respuesta[$i]['nombre_cliente']);
			
	

			if ($respuesta[$i]["equipo_reserva"]) {
			$tipoServicio = "<span class='badge badge-secondary'>" . strtoupper($respuesta[$i]["tipo_servicio"])."<br>(con equipo reserva)" ."</span>";
		}
		else
		{
			$tipoServicio = "<span class='badge badge-secondary'>" . strtoupper($respuesta[$i]["tipo_servicio"])."</span>";
		}


			$productos = json_decode($respuesta[$i]["productos"], true);
			$productos_lotes = json_decode($respuesta[$i]["productos_lotes"], true);
			$fecha_devolucion = $respuesta[$i]["fecha_devolucion"];

			if (!empty($fecha_devolucion) && $fecha_devolucion !== '0000-00-00') {
				// Si la fecha no está vacía y no es '0000-00-00', formatearla
				$fecha_devolucion=date("d/m/Y", strtotime($fecha_devolucion));
			} else {
				// Si la fecha está vacía o es '0000-00-00', imprimir algo diferente o dejarlo en blanco
				$fecha_devolucion="sin devolucion";
			}



			$cantidad = '';
			if (!is_null($productos_lotes) && is_array($productos_lotes)) {
				foreach ($productos_lotes as $key2 => $value2) {
					$cantidad .= "<span style='color:blue;'>" . $value2["cantidad"] . " " . strtoupper($value2["descripcion"]) . "</span><br>";
				}
			}
			$codigoProducto = '';
			$categoriaProducto = ''; // Inicializamos la variable
			if (!is_null($productos) && is_array($productos)) {
				foreach ($productos as $key => $valueProductos) {


					if (substr($valueProductos["codigo"], 0, 1) === 'M' or substr($valueProductos["codigo"], 0, 1) === 'm') {
						$categoriaProducto = 'MULTIPLEXOR';
					} elseif (substr($valueProductos["codigo"], 0, 2) === 'ON') {
						$categoriaProducto = 'ONU';
					} else {
						$categoriaProducto = '';
					}
					$codigoProducto .= $categoriaProducto . ' ' . ($valueProductos["codigo"]) . '<br>';
				}
			}


			$resumenProducto = $codigoProducto . '' . $cantidad;
			$botones = "";

			if ($respuesta[$i]["estado_prestamo"] == "PENDIENTE") {


				$estado = "<button class='btn btn-danger btn-xs btn-asignar' data-toggle='modal' idPrestamo='" . $respuesta[$i]["id"] . "' idEmpleado='" .  $respuesta[$i]["idempleado"] . "'   data-target='#modalAsignarPrestamo'>" . $respuesta[$i]["estado_prestamo"] . "</button>";
			} else {

				$estado = "<button class='btn btn-success btn-xs'>" . $respuesta[$i]["estado_prestamo"] . "</button>";
			}

			$botones = "<div class='btn-group'><button class='btn btn-info btn-xs btnImprimirPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "'><i class='fa fa-print'></i></button>";

			if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador") {
				if ($respuesta[$i]["estado_prestamo"] == "FINALIZADO") {

					$botones .= "<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled ><i class='fas fa-pencil-alt'></i></button>";
				} else {
					$botones .= "<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' data-toggle='modal' data-target='#modalDevolverProducto' data-toggle='tooltip' title='Editar Producto'><i class='fas fa-pencil-alt'></i></button>";
				}

				if ($respuesta[$i]["estado_prestamo"] == "PENDIENTE" || $respuesta[$i]["estado_prestamo"] == "INSTALADO") {
					$botones .= "<button class='btn btn-danger btn-xs btnEliminarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled><i class='fa fa-times'></i></button>";
				} else {
					$botones .= "<button class='btn btn-danger btn-xs btnEliminarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "'><i class='fa fa-times'></i></button>";
				}
			} else {
				if ($respuesta[$i]["estado_prestamo"] == "FINALIZADO") {
					$botones .= "<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' disabled ><i class='fas fa-pencil-alt'></i></button>";
				} else {
					$botones .= "<button class='btn btn-warning btn-xs btnEditarPrestamo' idPrestamo='" . $respuesta[$i]["id"] . "' data-toggle='modal' data-target='#modalDevolverProducto' data-toggle='tooltip' title='Editar Producto'><i class='fas fa-pencil-alt'></i></button>";
				}
			}
			$botones .= '</div>';

			$datosJson .= '[
				"' . ($i + 1) . '",
				"' . $empleado . '",
				"' .  $codigoCliente .'",
				"' . $tipoServicio . '",
				"' . $resumenProducto . '",
				"' . date("d/m/Y", strtotime($respuesta[$i]["fecha_prestamo"])) . '",
				"' . $fecha_devolucion.'",
				"' . $respuesta[$i]["observacion_prestamo"] . '",
				"' . $respuesta[$i]["observacion_devolucion"] . '",
				"' . $estado . '",
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
$activarProductosPrestamosPrincipal->mostrarTablaProductosPrestamosPrincipal();
