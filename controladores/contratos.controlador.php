<?php

class ControladorContratos{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearContrato(){

		if(isset($_POST["nuevoCodCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCodCliente"])){

				$tabla = "contrato";
			
			

				$datos = array(
					"cod_cliente" => strtolower($_POST["nuevoCodCliente"]),
					"nombre_completo" => strtolower($_POST["nuevoNombreCompleto"]),
					"dni" => strtolower($_POST["nuevoDni"]),
					"direccion" => strtolower($_POST["nuevaDireccion"]),
					"telefono" => $_POST["nuevoTelefono"]
				);


				$respuesta = ModeloContratos::mdlIngresarContrato($tabla, $datos);

				if($respuesta == "ok"){

					require 'vendor/autoload.php'; // Asegúrate de cargar PHPWord
					$templatePath = 'extensiones/tcpdf/pdf/contratos/contrato.docx'; // Ruta a la plantilla
					$phpWord = \PhpOffice\PhpWord\IOFactory::load($templatePath);
		

					   // Configurar las cabeceras HTTP para la descarga
					   header('Content-Description: File Transfer');
					   header('Content-Type: application/octet-stream');
					   header('Content-Disposition: attachment; filename=contrato_generado.docx');
		   

					// Crear estructura del contrato y reemplazar marcadores aquí
					$section = $phpWord->addSection();
					$section->addText('CONTRATO DE SERVICIOS', array('bold' => true));
					$section->addText('Nombre del cliente: ' . $_POST['nuevoNombreCompleto']);
					$section->addText('DNI del cliente: ' . $_POST['nuevoDni']);
					$section->addText('Dirección del cliente: ' . $_POST['nuevaDireccion']);
					$section->addText('Fecha: ' . date('Y-m-d'));
		
					// Guardar y ofrecer la descarga del contrato
					$nombreArchivo = 'php://output';
					$phpWord->save($nombreArchivo);
					exit; 
		
					// Configurar las cabeceras HTTP para la descarga
					
					
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($nombreArchivo));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($nombreArchivo));
					// Leer y enviar el archivo
					readfile($nombreArchivo);
		
					// Eliminar el archivo temporal
					unlink($nombreArchivo);
					exit;







					echo'<script>

					swal({
						  type: "success",
						  title: "El contrato se guardo con exito",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "contratos";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El contrato no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "contratos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarContratos($item, $valor){

		$tabla = "contrato";

		$respuesta = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarCategoria(){

		if(isset($_POST["editarCategoria"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"])){

				$tabla = "categoria";
				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$fechaActual = $fecha . ' ' . $hora;

				$datos = array("categoria"=>$_POST["editarCategoria"],
				"actualizado_por"=>$_POST["actualizado_por"],
				"fecha_actualizacion"=>$fechaActual,
				  "id"=>$_POST["idCategoria"]);

				$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido cambiada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarCategoria(){

		if(isset($_GET["idCategoria"])){

			$tabla ="Categoria";
			$datos = $_GET["idCategoria"];

			$respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';
			}
		}
		
	}
}
