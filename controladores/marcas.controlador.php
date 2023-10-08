<?php

class ControladorMarcas{

	/*=============================================
	CREAR MARCA
	=============================================*/

	static public function ctrCrearMarca(){

		if(isset($_POST["nuevaMarca"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaMarca"])){

				$tabla = "marca";

				$datos = $_POST["nuevaMarca"];

				$respuesta = ModeloMarcas::mdlIngresarMarca($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La nueva MARCA ha sido guardada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "marcas";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La marca no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "marcas";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR MARCA
	=============================================*/

	static public function ctrMostrarMarca($item, $valor){

		$tabla = "marca";

		$respuesta = ModeloMarcas::mdlMostrarMarca($tabla, $item, $valor);

		return $respuesta;
	
	}


	/*=============================================
	MOSTRAR ESTADOS PARA EDITAR EL PRODUCTO
	=============================================*/

	static public function ctrMostrarEstadoProducto($item, $valor){

		$tabla = "estado";

		$respuesta = ModeloMarcas::mdlMostrarMarca($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR MARCA
	=============================================*/

	static public function ctrEditarMarca(){

		if(isset($_POST["editarMarca"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMarca"])){

				$tabla = "marca";

				$datos = array("marca"=>$_POST["editarMarca"],
							   "id"=>$_POST["idMarca"]);

				$respuesta = ModeloMarcas::mdlEditarMarca($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La  MARCA ha sido cambiada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "marcas";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La MARCA no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "marcas";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR MARCA
	=============================================*/

	static public function ctrBorrarMarca(){

		if(isset($_GET["idMarca"])){

			$tabla ="marca";
			$datos = $_GET["idMarca"];

			$respuesta = ModeloMarcas::mdlBorrarMarca($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "La marca ha sido borrada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "marcas";

									}
								})

					</script>';
			}
		}
		
	}
}
