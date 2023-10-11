
<?php
require_once "../controladores/productos-cpu.controlador.php";
require_once "../modelos/productos-cpu.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/modelos.controlador.php";
require_once "../modelos/modelos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";





class TablaProductos
{

	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

	public function mostrarTablaProductos()
	{
		
		
		$categoria = $_POST['categoria'];
		$busqueda = $_POST['busqueda'] ;
		$marca = $_POST['marca'];
		//$oficina = $_POST['oficina'];
		//$posicion = $_POST['posicion'];
		//$referencia = $_POST['referencia'];
		//$direccion_ip = $_POST['direccion_ip'];
		
		//$item = null;
		//$valor =9;

		$productos = ControladorProductos::ctrMostrarProductosDetalle($categoria,$busqueda,$marca);
		//return var_dump($productos);
		if (count($productos) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($productos); $i++) {

			/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/

			$imagen = "<img src='".$productos[$i]["imagen"]."' width='70px'>";

			/*=============================================*/
 	 		
			//RESULTADOS DE ESTADO DE PRODUCTO
			if ($productos[$i]["estado_fisico"] == "operativo") {

				$estadoFisicoProducto= "<span class='label label-success'>Operativo <i class='fas fa-thumbs-up'></i></span> ";
			} else if ($productos[$i]["estado_fisico"] == "malogrado") {
				$estadoFisicoProducto = "<span class='label label-danger'>Malogrado <i class='fas fa-thumbs-down'></i></span> ";
			}
			else if ($productos[$i]["estado_fisico"] == "en revision") {
				$estadoFisicoProducto = "<span class='label label-warning'>En Revision</i></span> ";
			}
			

			//VALIDAR SI TRAE INFORMACION NUMERO DE SERIE DEL PRODUCTO
			if(empty($productos[$i]["num_serie"])){
				$num_serie="sin dato";
			}else{
				$num_serie=$productos[$i]["num_serie"];
				
			}
			//INFORMACION DE CARACTERISTICAS DEL PRODUCTO
			$caracteristica="<b>Categoria:</b>". strtoupper($productos[$i]["categoria"])."<br><b>Marca:</b>". strtoupper($productos[$i]["marca"])."<br>"."<b>Modelo:</b>".$productos[$i]["modelo"]."<br>"."<b>Serie:</b>".$num_serie ;

			//UBICACION DE PRODUCTO
			$TooltipUbicacion=$productos[$i]['observaciones']. "<button class='btn btn-secondary'href='#' data-toggle='modal' data-target='#modalVerUbicacionProducto'> <i class='fas fa-map-marker-alt'> Ver Ubicacion</i> </button>";
			/*=============================================
 	 		ESTADO DEL PRESTAMO DEL PRODUCTO
  			=============================================*/

			if ($productos[$i]["estado_prestamo"] == "DISPONIBLE") {

				$estado = "<span class='label label-success'>Disponible</span>";
			} 
			
			else if($productos[$i]["estado_prestamo"] == "NO APLICA"){

				$estado = "<span class='label label-warning'>No Aplica</span>";
			}
			else {

				$estado = "<span class='label label-danger'>Ocupado</span>";
			}

			/*=============================================
 	 		TRAEMOS LAS ACCIONES
			  =============================================*/

			if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial") {
				$botones ="<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Seleccionar opción <span class='caret'></span></button><ul class='dropdown-menu'><li><a style='cursor:pointer;' class='btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' idModelo='" . $productos[$i]["idmodelo"] . "'idEstado='" . $productos[$i]["idestado"]. "' data-toggle='modal' data-target='#modalEditarProducto'> <i class='fas fa-pencil-alt'></i>Editar Producto</a></li><li><a style='cursor:pointer;'class='btnMostrarDetalleProducto' data-toggle='modal'  idProducto='" . $productos[$i]["id"] . "'data-target='#modalVerUbicacionProducto'><i class='fas fa-map-marker-alt'></i> Ver Ubicacion</a></li><li><a style='cursor:pointer;'class='btnMostrarCaracteristicasCpu' data-toggle='modal'  idProducto='" . $productos[$i]["id"] . "'data-target='#modalVerCaracteristicasCpu'> <i class='fas fa-microchip'></i>Caracteristica CPU</a></li></ul></div>";
			} 
			else if ( $productos[$i]["categoria"]=="cpu" ||  $productos[$i]["categoria"]=="laptop"){
				$botones ="<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Seleccionar opción <span class='caret'></span></button><ul class='dropdown-menu'><li><a style='cursor:pointer;' class='btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' idModelo='" . $productos[$i]["idmodelo"] . "'idEstado='" . $productos[$i]["idestado"]. "' data-toggle='modal' data-target='#modalEditarProducto'> <i class='fas fa-pencil-alt'></i>Editar Producto</a></li<li><a  style='cursor:pointer;' class='btnEliminarProducto' idProducto='" . $productos[$i]["id"] . "'><i class='fas fa-trash-alt'></i>Eliminar</a></li><li><a style='cursor:pointer;'class='btnMostrarDetalleProducto' data-toggle='modal'  idProducto='" . $productos[$i]["id"] . "'data-target='#modalVerUbicacionProducto'><i class='fas fa-map-marker-alt'></i> Ver Ubicacion</a></li><li><a style='cursor:pointer;'class='btnMostrarCaracteristicasCpu' data-toggle='modal'  idProducto='" . $productos[$i]["id"] . "'data-target='#modalVerCaracteristicasCpu'> <i class='fas fa-microchip'></i>Caracteristica CPU</a></li></ul></div>";

			}
			
			else {
				$botones ="<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Seleccionar opción <span class='caret'></span></button><ul class='dropdown-menu'><li><a style='cursor:pointer;' class='btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' idModelo='" . $productos[$i]["idmodelo"] . "'idEstado='" . $productos[$i]["idestado"]. "' data-toggle='modal' data-target='#modalEditarProducto'> <i class='fas fa-pencil-alt'></i>Editar Producto</a></li<li><a  style='cursor:pointer;' class='btnEliminarProducto' idProducto='" . $productos[$i]["id"] . "'><i class='fas fa-trash-alt'></i>Eliminar</a></li><li><a style='cursor:pointer;'class='btnMostrarDetalleProducto' data-toggle='modal'  idProducto='" . $productos[$i]["id"] . "'data-target='#modalVerUbicacionProducto'><i class='fas fa-map-marker-alt'></i> Ver Ubicacion</a></li></ul></div>";
				
			}
			
			$datosJson .= '[
			      "' . ($i + 1) . '",
				  "' . $productos[$i]["codigo"] . '",
				  "' . $productos[$i]["referencia"] . '",
				  "' . $imagen.'",
				  "' . $caracteristica.'",
				  "' .$estadoFisicoProducto. '",
				  "' . $productos[$i]["observaciones"] .'",
				  "' . $estado . '",
				  "' . $productos[$i]["fecha"] . '",
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
$activarProductos = new TablaProductos();
$activarProductos->mostrarTablaProductos();
