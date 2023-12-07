<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


require_once "../controladores/modelos.controlador.php";
require_once "../modelos/modelos.modelo.php";


class TablaProductosPrestamos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosPrestamos(){

		$item = "estado_prestamo";
    	$valor = "NO APLICA";
    	$orden = "id";

          $productos = ControladorProductos::ctrMostrarProductosParaPrestamo($item, $valor, $orden);
          


 		
  		if(count($productos) == 0){

  			echo '{"data": []}';

		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($productos); $i++){



            /*=============================================
 	 		TRAEMOS IMAGEN DEL MODELO
  			=============================================*/ 

              $item = "id";
              $valor = $productos[$i]["idmodelo"];
  
              $modelos = ControladorModelos::ctrMostrarModelo($item, $valor);
              $imagenProducto = "<img src='".$modelos["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		TRAEMOS EL MODELO
  			=============================================*/ 

              $item = "id";
              $valor = $productos[$i]["idmodelo"];
  
              $modelos = ControladorModelos::ctrMostrarModelo($item, $valor);


              /*=============================================
 	 		TRAEMOS ESTADO DEL PRODUCTO
              =============================================*/ 
              
              $item = "id";
              $valor = $productos[$i]["idestado"];
              $order="id";
  
              $estadoProducto = ControladorProductos::ctrMostrarEstadoProducto($item, $valor,$order);

              if($estadoProducto["descripcion"] =="MALOGRADO"){

                $estado = "<button class='btn btn-danger  btn-xs'>".$estadoProducto["descripcion"]."</button>";

            }else if($estadoProducto["descripcion"]=="REPARACION GARANTIA" or $estadoProducto["descripcion"]=="REPARACION INTERNA" ){

                $estado = "<button class='btn btn-warning  btn-xs'>".$estadoProducto["descripcion"]."</button>";

            }else{

                $estado = "<button class='btn btn-success  btn-xs'>".$estadoProducto["descripcion"]."</button>";

            }

		  	/*=============================================
 	 		TRAEMOS ESTADO DEL PRESTAMO DEL PRODUCTO
              =============================================*/ 
        

  			if($productos[$i]["estado_prestamo"] =="OCUPADO"){

                $estadoPrestamoProducto = "<button class='btn btn-danger  btn-xs'>".$productos[$i]["estado_prestamo"]."</button>";

  			}
			  else if($productos[$i]["estado_prestamo"] =="NO APLICA"){

                $estadoPrestamoProducto = "<button class='btn btn-warning  btn-xs'>".$productos[$i]["estado_prestamo"]."</button>";

  			} 
			  else{

                $estadoPrestamoProducto = "<button class='btn btn-success  btn-xs'>".$productos[$i]["estado_prestamo"]."</button>";

  			}

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Prestar</button></div>"; 

		  	$datosJson .='[
				"' . ($i + 1) . '",
                "'.$imagenProducto.'",
			      "'.$modelos["descripcion"].'",
			      "'.$productos[$i]["cod_producto"].'",
				  "'.$productos[$i]["num_serie"].'",
			      "'.$estado.'",
			      "'.$estadoPrestamoProducto.'",
			      "'.$botones.'"
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
$activarProductosPrestamos -> mostrarTablaProductosPrestamos();

