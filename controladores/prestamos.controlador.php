<?php



class ControladorPrestamos
{

	/*=============================================
	MOSTRAR Prestamos
	=============================================*/

	static public function ctrMostrarPrestamos($item, $valor)
	{

		$tabla = "prestamo";

		$respuesta = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);

		return $respuesta;
	}



	/*=============================================
	MOSTRAR PRESTAMOS PENDIENTES POR EMPLEADO
	=============================================*/

	static public function ctrMostrarPrestamosPendiente($item, $valor)
	{

		$tabla = "prestamo";

		$respuesta = ModeloPrestamos::mdlMostrarPrestamosPendiente($tabla, $item, $valor);

		return $respuesta;
	}
	/*=============================================
	CREAR PRESTAMOS
	=============================================*/

	static public function ctrCrearPrestamo()
	{

		if (isset($_POST["nuevoUsuario"])) {

			/*=============================================
			ACTUALIZAR LAS EL ESTADO DE PRESTAMO DE LOS PRODUCTOS 
			=============================================*/

			if ($_POST["listaProductos"] == "" or $_POST["listaProductos"] == "[]") {

				echo '<script>

				swal({
					  type: "error",
					  title: "El prestamo no procede si no se elige uno",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "crear-prestamo";

								}
							})

				</script>';

				return;
			}


			$listaProductos = json_decode($_POST["listaProductos"], true);
			//$listaProductos2 = json_decode($_POST["listaProductos2"], true);

			foreach ($listaProductos as $key => $value) {


				//con esto actualizo todos los productos que tienen ese id de la listaProductos
				$tablaPrestamo = "producto";
				$valor = $value["id"];
				$item1a = "estado_prestamo";
				$valor1a = "OCUPADO";
				$nuevoPrestamos = ModeloProductos::mdlActualizarProducto($tablaPrestamo, $item1a, $valor1a, $valor);
			}

			/*=============================================
			GUARDAR EL PRESTAMO
			=============================================*/

			$tabla = "prestamo";

			$datos = array(
				"idusuario" => $_POST["idUsuario"],
				"codigo_prestamo" => $_POST["nuevoPrestamo"],
				"productos" => $_POST["listaProductos"],
				"idempleado" => $_POST["nuevoEmpleado"],
				"observacion_prestamo" => $_POST["observacionPrestamo"],
				"estado_prestamo" => "PENDIENTE",
				"creado_por" => $_POST["creado_por"]
			);

			$respuesta = ModeloPrestamos::mdlIngresarPrestamo($tabla, $datos);



			if ($respuesta == "ok") {
				echo '<script>
                
				swal({
					  type: "success",
					  title: "El prestamo se ha guardado  correctamente",
					  showConfirmButton: true,
					  allowOutsideClick: false,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "prestamos";

								}
							})

				</script>';
			} else {

				echo '<script>

					
						alertify.error("No se pudo Prestar ");
						

			  	</script>';
			}
		}
	}


	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	static public function ctrEditarPrestamo()
	{

		if (isset($_POST["editarPrestamo"])) {

			/*=============================================
			//FORMATEAR TABLA PRODUCTOS
			=============================================*/

			$tabla = "prestamo";
			$item = "codigo_prestamo";
			$valor = $_POST["editarPrestamo"];

			$traerPrestamo = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);
			/*=============================================
			//REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if ($_POST["listaProductos"] == "") {

				$listaProductos = $traerPrestamo["productos"];
			} else {
				$listaProductos = $_POST["listaProductos"];
			}
			if ($listaProductos == "" or $listaProductos == "[]") {

				echo '<script>

				swal({
					  type: "error",
					  title: "este prestamo tiene pendiente productos! si deseas vaciar los productos prestados finalize este prestamo",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  })

				</script>';

				return;
			}



			$producto = json_decode($traerPrestamo["productos"], true);
			foreach ($producto as $key => $value) {
				$tablaProducto = "producto";
				$item1b_2 = "estado_prestamo";
				$valor1b_2 = "DISPONIBLE";
				$valor_2 = $value["id"];
				$actualizarEstado_2 = ModeloProductos::mdlActualizarProducto($tablaProducto, $item1b_2, $valor1b_2, $valor_2);
			}
			/*=============================================
			ACTUALIZAR LAS EL ESTADO DE PRESTAMO DE LOS PRODUCTOS 
			=============================================*/

		


			$listaProductos_2 = json_decode($listaProductos, true);
			//$listaProductos2 = json_decode($_POST["listaProductos2"], true);

			foreach ($listaProductos_2 as $key => $value) {


				//con esto actualizo todos los productos que tienen ese id de la listaProductos
				$tablaPrestamo = "producto";
				$valor = $value["id"];
				$item1a = "estado_prestamo";
				$valor1a = "OCUPADO";
				$nuevoPrestamos = ModeloProductos::mdlActualizarProducto($tablaPrestamo, $item1a, $valor1a, $valor);
			}
			date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha . ' ' . $hora;


			/*=============================================
				GUARDAR EL PRESTAMO
			=============================================*/

			//$tabla = "prestamo";

			$datos = array(
				"id_prestamo" => $_POST["idPrestamo"],
				"idusuario" => $_POST["idUsuario"],
				"codigo_prestamo" => $_POST["editarPrestamo"],
				"codigo_prestamo" => $_POST["editarPrestamo"],
				"productos" => $listaProductos,
				"idempleado" => $_POST["nuevoEmpleado"],
				"observacion_prestamo" => $_POST["observacionPrestamo"],
				"estado_prestamo" => "PENDIENTE",
				"observacion_devolucion" => null,
				"fecha_devolucion" => null,
				"actualizado_por" => $_POST["actualizado_por"],
				"fecha_actualizacion" => $fechaActual
			);

			$respuesta = ModeloPrestamos::mdlEditarPrestamo($tabla, $datos);



			if ($respuesta == "ok") {
				echo '<script>
                
				swal({
					  type: "success",
					  title: "El prestamo se ha guardado  correctamente",
					  showConfirmButton: true,
					  allowOutsideClick: false,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "prestamos";

								}
							})

				</script>';
			} else {

				echo '<script>

					
						alertify.error("No se pudo Prestar ");
						

			  	</script>';
			}
		}
	}






	static public function ctrFinalizarPrestamo()
		{
		if (isset($_POST["observacionDevolucion"])) {

			/*=============================================
			//FORMATEAR TABLA PRODUCTOS
			=============================================*/

			$tabla = "prestamo";
			$item = "codigo_prestamo";
			$valor = $_POST["editarPrestamoFinalizar"];

			$traerPrestamo = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);
			/*=============================================
			//REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if ($_POST["listaProductos"] == "") {

				$listaProductos = $traerPrestamo["productos"];
			} else {
				$listaProductos = $_POST["listaProductos"];
			}




			$producto = json_decode($traerPrestamo["productos"], true);
			foreach ($producto as $key => $value) {
				$tablaProducto = "producto";
				$item1b_2 = "estado_prestamo";
				$valor1b_2 = "DISPONIBLE";
				$valor_2 = $value["id"];
				$actualizarEstado_2 = ModeloProductos::mdlActualizarProducto($tablaProducto, $item1b_2, $valor1b_2, $valor_2);
			}
			/*=============================================
			ACTUALIZAR LAS EL ESTADO DE PRESTAMO DE LOS PRODUCTOS 
			=============================================*/




			$listaProductos_2 = json_decode($listaProductos, true);
			//$listaProductos2 = json_decode($_POST["listaProductos2"], true);

			foreach ($listaProductos_2 as $key => $value) {


				//con esto actualizo todos los productos que tienen ese id de la listaProductos
				$tablaPrestamo = "producto";
				$valor = $value["id"];
				$item1a = "estado_prestamo";
				$valor1a = "DISPONIBLE";
				$nuevoPrestamos = ModeloProductos::mdlActualizarProducto($tablaPrestamo, $item1a, $valor1a, $valor);
			}

			$tabla = "prestamo";
			$idprestamo = $_GET["idPrestamo"];

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha . ' ' . $hora;


			$datos = array(
				"id_prestamo" => $idprestamo,
				"fecha_devolucion" => $fechaActual,
				"observacion_devolucion" => $_POST["observacionDevolucion"],
				"estado_prestamo" => "FINALIZADO",
				"finalizado_por" => $_POST["finalizado_por"]

			);

			$respuesta = ModeloPrestamos::mdlFinalizarPrestamo($tabla, $datos);



			if ($respuesta == "ok") {
				echo '<script>

swal({
	  type: "success",
	  title: "El prestamo ha finalizado correctamente",
	  showConfirmButton: true,
	  allowOutsideClick: false,
	  confirmButtonText: "Cerrar"
	  }).then(function(result){
				if (result.value) {

				window.location = "prestamos";

				}
			})

</script>';
			} else {

				echo '<script>

	
		alertify.error("No se pudo Finalizar ");
		

  </script>';
			}
		}
	}





	//eliminar prestamo

	static public function ctrEliminarPrestamo()
	{

		if (isset($_GET["idPrestamo"])) {

			$tabla = "prestamo";
			$datos = $_GET["idPrestamo"];

			$respuesta = ModeloPrestamos::mdlEliminarPrestamos($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>
					
				swal({
					  type: "success",
					  title: "El prestamo ha sido borrado correctamente",
					  showConfirmButton: true,
					  allowOutsideClick: false,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "prestamos";

								}
							})

				</script>';
			}
		}
	}



	/*=============================================
	RANGO FECHAS
	=============================================*/

	static public function ctrRangoFechasPrestamos($fechaInicial, $fechaFinal)
	{

		$tabla = "prestamo";

		$respuesta = ModeloPrestamos::mdlRangoFechasPrestamos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
	}


	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte()
	{

		if (isset($_GET["prestamo"])) {

			$tabla = "prestamo";

			if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

				$prestamo = ModeloPrestamos::mdlRangoFechasPrestamos($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
			} else {

				$item = null;
				$valor = null;

				$prestamo = ModeloPrestamos::mdlMostrarPrestamos($tabla, $item, $valor);
			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["prestamo"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="' . $Name . '"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>COD PRODUCTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>EMPLEADO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NUM DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>F_PRESTAMO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>F_DEVOLUCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OBS_PRESTAMO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OBS_DEVOLUCION</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>ESTADO_PRESTAMO</td>		
					</tr>");

			foreach ($prestamo as $row => $item) {

				$usuario = ControladorUsuarios::ctrMostrarUsuarios("id", $item["idusuario"]);
				$empleados = ControladorEmpleados::ctrMostrarEmpleados("idempleado", $item["idempleado"]);
				$productos =  json_decode($item["productos"], true);
				//$producto = ControladorProductos::ctrMostrarProductos("id", $item["idproducto"], "id");

				echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $usuario["nombre"] . "</td>");

						 echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

						 foreach ($productos as $key => $valueProductos) {
								 
							 echo utf8_decode($valueProductos["codigo"]."<br>");
						 
						 }
		
						 echo utf8_decode("</td>
						 <td style='border:1px solid #eee;'>" . $empleados["nombres"] . " " . $empleados["ape_pat"] . " " . $empleados["ape_mat"] . "</td>
						 <td style='border:1px solid #eee;'>" . $empleados["num_documento"] . "</td>
						 <td style='border:1px solid #eee;'>" . substr($item["fecha_prestamo"], 0, 10) . "</td>
						 <td style='border:1px solid #eee;'>" . substr($item["fecha_devolucion"], 0, 10) . "</td>
						 <td style='border:1px solid #eee;'>" . $item["observacion_prestamo"] . "</td>
						 <td style='border:1px solid #eee;'>" . $item["observacion_devolucion"] . "</td>
						 <td style='border:1px solid #eee;'>" . $item["estado_prestamo"] . "</td>
						
						 </tr>");
			}

			echo "</table>";
		}
	}


}
