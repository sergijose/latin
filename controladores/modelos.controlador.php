<?php

class ControladorModelos{

	/*=============================================
	CREAR MODELOS
	=============================================*/

	static public function ctrCrearModelo(){

		if(isset($_POST["nuevaMarca"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaMarca"])
			
			){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = "vistas/img/modelos/default/anonymous.png";

				if(isset($_FILES["nuevaImagen"]["tmp_name"])&& $_FILES["nuevaImagen"]["tmp_name"]!=""){

				 list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

				 $nuevoAncho = 500;
				 $nuevoAlto = 500;

				 /*=============================================
				 CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
				 =============================================*/

				 $directorio = "vistas/img/modelos/".$_POST["nuevoModelo"];

				 mkdir($directorio, 0755);

				 /*=============================================
				 DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
				 =============================================*/

				 if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

					 /*=============================================
					 GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					 =============================================*/

					 $aleatorio = mt_rand(100,999);

					 $ruta = "vistas/img/modelos/".$_POST["nuevoModelo"]."/".$aleatorio.".jpg";

					 $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						

					 $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					 imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					 imagejpeg($destino, $ruta);

				 }

				 if($_FILES["nuevaImagen"]["type"] == "image/png"){

					 /*=============================================
					 GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					 =============================================*/

					 $aleatorio = mt_rand(100,999);

					 $ruta = "vistas/img/modelos/".$_POST["nuevoModelo"]."/".$aleatorio.".png";

					 $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						

					 $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					 imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					 imagepng($destino, $ruta);

				 }

			 }


				$tabla = "modelo";
				
				$datos = array("idcategoria" => $_POST["nuevaCategoria"],
					           "idmarca" => $_POST["nuevaMarca"],
					           "descripcion" =>$_POST["nuevoModelo"],
							   "informacion" =>$_POST["nuevaInformacion"],
					           "imagen" => $ruta
					          );
				

				$respuesta = ModeloModelos::mdlIngresarModelo($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "el nuevo Modelo ha sido guardada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "modelo";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡el MODELO no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "modelos";

							}
						})

			  	</script>';

			}

		}

	}


	/*=============================================
	MOSTRAR MODELOS
	=============================================*/

	static public function ctrMostrarModelo($item, $valor){

		$tabla = "modelo";

		$respuesta = ModeloModelos::mdlMostrarModelos($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR MODELO
	=============================================*/

	
	static public function ctrEditarModelo(){

		if(isset($_POST["editarModelo"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarModelo"])){

				
							$ruta = $_POST["imagenActual"];

			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/modelos/".$_POST["editarModelo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["imagenActual"])&& $_POST["imagenActual"] != "vistas/img/modelos/default/anonymous.png" ){

						unlink($_POST["imagenActual"]);

					}else{

						mkdir($directorio, 0755);	
					
					}
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/modelos/".$_POST["editarModelo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/modelos/".$_POST["editarModelo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}	
				$tabla = "modelo";

				$datos = array("idcategoria"=>$_POST["editarCategoria"],
							   "idmarca"=>$_POST["editarMarca"],
							   "descripcion"=>$_POST["editarModelo"],
							   "informacion"=>$_POST["editarInformacion"],
							   "imagen"=>$ruta,
							   "id"=>$_POST["id"]);


				$respuesta = ModeloModelos::mdlEditarModelo($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El MODELO ha sido actualizada correctamente",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "modelo";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El MODELO no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  allowOutsideClick: false,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "modelo";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR MODELO
	=============================================*/
	static public function ctrEliminarModelo(){

		if(isset($_GET["idModelo"])){

			$tabla ="modelo";
			$datos = $_GET["idModelo"];

			if($_GET["imagen"] !="" && $_GET["imagen"] != "vistas/img/modelos/default/anonymous.png"){

				unlink($_GET["imagen"]);
				rmdir('vistas/img/modelos/'.$_GET["modelo"]);

				
			}

			$respuesta = ModeloModelos::mdlBorrarModelo($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El modelo ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "modelo";

								}
							})

				</script>';

			}		
		}


	}

	
	
	
}
