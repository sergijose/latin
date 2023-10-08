<?php

class ControladorProductosCpu
{

	/*=============================================
	MOSTRAR DETALLE PRODUCTOS-CPU
	=============================================*/

	static public function ctrMostrarProductosCpu($item, $valor, $orden)
	{

		$tabla = "producto_cpu";

		$respuesta = ModeloProductosCpu::mdlMostrarProductosCpu($tabla, $item, $valor, $orden);

		return $respuesta;
	}

		/*=============================================
	MOSTRAR CODIGO DE PRODUCTOS DE LA CATEGORIA CPU
	=============================================*/

	static public function ctrMostrarCodigoProductoCpu($cat,$cat2)
	{

		

		$respuesta = ModeloProductosCpu::mdlMostrarCodigoProductoCpu($cat,$cat2);

		return $respuesta;
	}



	/*=============================================
	MOSTRAR PRODUCTOS REPETIDOS CODIGO 
	=============================================*/

	static public function ctrMostrarProductosRepetidosCpu($item, $valor)
	{

		$tabla = "producto_cpu";

		$respuesta = ModeloProductosCpu::mdlMostrarProductosRepetidosCpu($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	MOSTRAR ESTADO DEL PRODUCTO
	=============================================*/
	static public function ctrMostrarEstadoProducto($item, $valor, $orden)
	{

		$tabla = "estado";
		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);

		return $respuesta;
	}

		/*=============================================
	MOSTRAR LISTA DE PROCESADOREDS
	=============================================*/
	static public function ctrMostrarListaProcesadores($item, $valor)
	{

		$tabla = "tipo_procesador";
		$respuesta = ModeloProductosCpu::mdlMostrarListaProcesadores($tabla, $item, $valor);

		return $respuesta;
	}

	
		/*=============================================
	MOSTRAR LISTA DE SISTEMA OPERATIVO
	=============================================*/
	static public function ctrMostrarListaSistemaOperativo($item, $valor)
	{

		$tabla = "tipo_sistema_operativo";
		$respuesta = ModeloProductosCpu::mdlMostrarListaSistemaOperativo($tabla, $item, $valor);

		return $respuesta;
	}


	/*=============================================
	MOSTRAR TOTAL DE PRODUCTOS
	=============================================*/

	static public function ctrMostrarTotalProductos()
	{

		$respuesta = ModeloProductos::mdlMostrarTotalProductos();

		return $respuesta;
	}

	/*=============================================
	MOSTRAR SISTEMA OPERATIVO DE PRODUCTOS CPU
	=============================================*/

	static public function ctrMostrarSistemaOperativo()
	{

		$respuesta = ModeloProductosCpu::mdlMostrarSistemaOperativo();

		return $respuesta;
	}




	/*=============================================
	MOSTRAR TOTAL DE ESTADOS DEPRODUCTOS POR CATEGORIA PARA EL REPORTE
	=============================================*/

	static public function ctrMostrarTotalProductosPorEstados($categoria)
	{

		$respuesta = ModeloProductos::mdlMostrarTotalProductosPorEstados($categoria);

		return $respuesta;
	}

	/*=============================================
	MOSTRAR TOTAL DE ESTADOS  DE PRESTAMOS  DEPRODUCTOS POR CATEGORIA PARA EL REPORTE
	=============================================*/

	static public function ctrMostrarTotalProductosPorEstadoDePrestamo($categoria)
	{

		$respuesta = ModeloProductos::mdlMostrarTotalProductosPorEstadosDePrestamo($categoria);

		return $respuesta;
	}

	/*=============================================
	CREAR PRODUCTO DE LA CATEGORIA CPU
	=============================================*/

	static public function ctrCrearProductoCpu()
	{
	


		if (isset($_POST["nuevoCodProductoCpu"])) {

			if (
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCodProductoCpu"]) 
				
				

				
			) {

				$tabla = "producto_cpu";


				$datos = array(
					"idproducto" => $_POST["nuevoCodProductoCpu"],
					"tipo_disco" =>$_POST["nuevoTipoDisco"],
					"cant_disco" => $_POST["nuevaCantDisco"],
					"tipo_memoria" => $_POST["nuevoTipoRam"],
					"cant_memoria" => $_POST["nuevaCantRam"],
					"procesador" => $_POST["nuevoProcesador"],
					"sistema_operativo" => $_POST["nuevoSistemaOperativo"],
					"direccion_ip" => $_POST["nuevoIp"],
					"modelo_placa" => $_POST["nuevoModeloPlaca"],
					"observaciones" => $_POST["nuevaObservacion"],
					"generacion" => $_POST["nuevaGeneracion"],
					"mac" => $_POST["nuevaMac"],
					"edicion_so" => $_POST["nuevaEdicion"],
					"creado_por" => $_POST["creado_por"]
				);
				

				$respuesta = ModeloProductosCpu::mdlIngresarProductoCpu($tabla, $datos);
				
				if ($respuesta == "ok") {

					echo '<script>

					alertify.success("Agregado con exito");

						</script>';
				}
			} else {

				echo '<script>

				alertify.error("No se pudo agregar ");
						

			  	</script>';
			}
		}
	}

	/*=============================================
	EDITAR DETALLE PRODUCTO CPU
	=============================================*/

	static public function ctrEditarProductoCpu()
	{

		if (isset($_POST["editarTipoDisco"])) {

			if (
			
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTipoDisco"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCantDisco"]) &&	
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTipoRam"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCantRam"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarProcesador"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarSistemaOperativo"])
				

				
			) {

				$tabla = "producto_cpu";
				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha . ' ' . $hora;

				$datos = array(
					"tipo_disco" => $_POST["editarTipoDisco"],
					"cant_disco" => $_POST["editarCantDisco"],
					"tipo_ram" => $_POST["editarTipoRam"],
					"cant_ram" => $_POST["editarCantRam"],
					"procesador" => $_POST["editarProcesador"],
					"sistema_operativo" => $_POST["editarSistemaOperativo"],
					"direccion_ip" => $_POST["editarIp"],
					"modelo_placa" => $_POST["editarModeloPlaca"],
					"observaciones" => $_POST["editarObservacion"],
					"generacion" => $_POST["editarGeneracion"],
					"mac" => $_POST["editarMac"],
					"edicion_so" => $_POST["editarEdicion"],
					"actualizado_por" => $_POST["actualizado_por"],
					"fecha_actualizacion" => $fechaActual,
					"id" => $_POST["id"]
				);
				

				$respuesta = ModeloProductosCpu::mdlEditarProductoCpu($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					alertify.success("Actualizado con exito");

						</script>';
				}
			} else {

				echo '<script>

					
						alertify.error("No se pudo Actualizar");
						

			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR PRODUCTO CPU
	=============================================*/
	static public function ctrEliminarProductoCpu()
	{

		if (isset($_GET["idProductoCpu"])) {

			$tabla = "producto_cpu";
			$datos = $_GET["idProductoCpu"];

			$respuesta = ModeloProductosCpu::mdlEliminarProductoCpu($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>
					
				swal({
					  type: "success",
					  title: "EL detalle de este producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "productos-cpu";

								}
							})

				</script>';
			}
		}
	}
}
