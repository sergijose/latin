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
					$template = new \PhpOffice\PhpWord\TemplateProcessor('../extensiones/tcpdf/pdf/contratos/contrato.docx');

					 // Recupera los datos del contrato desde la base de datos
					 $nombre = "John Doe"; // Reemplaza con los datos reales
					 $telefono = "123456789";
					 $direccion = "123 Main St";
					 $tipoPlan = "Plan A";
					 // Llena la plantilla con los datos
					 $template->setValue('nombre', $nombre);
					 $template->setValue('telefono', $telefono);
					 $template->setValue('direccion', $direccion);
					 $template->setValue('tipo_plan', $tipoPlan);

					 $nombre_archivo = 'contrato_llenado.docx';
					 $template->saveAs($nombre_archivo);
					 // Envía el contrato al navegador para su descarga
    readfile($nombre_archivo);

    // Detén la ejecución del script
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
