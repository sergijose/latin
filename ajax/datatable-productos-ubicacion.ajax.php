
<?php

require_once "../controladores/productos-ubicacion.controlador.php";
require_once "../modelos/productos-ubicacion.modelo.php";

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


class TablaProductosUbicacion
{

    /*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/

    public function mostrarTablaProductosUbicacion()
    {




        $item = null;
        $valor = null;


        $productosUbicacion = ControladorProductoUbicacion::ctrMostrarProductoUbicacion($item, $valor);


        if (count($productosUbicacion) == 0) {

            echo '{"data": []}';

            return;
        }

        $datosJson = '{
		  "data": [';

        for ($i = 0; $i < count($productosUbicacion); $i++) {



            /*=============================================
 	 		TRAEMOS LOS PRODUCTOS
  			=============================================*/

            $item = "id";
            $valor = $productosUbicacion[$i]["id_producto"];
            $order = "id";
            $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $order);

            /*=============================================
 	 		TRAEMOS LOS DETALLES DE PRODUCTOS CPU
  			=============================================*/

            $item1 = "idproducto";
            $valor1 = $productos["id"];
            $order1 = "id";
            $productos_cpu = ControladorProductosCpu::ctrMostrarProductosCpu($item1, $valor1, $order1);
            $ip = $productos_cpu["direccion_ip"]?? null;
            if ($ip!=null) {
                $ip ="<span class='badge badge-primary'>$ip</span>";
            }


            /*=============================================
 	 		TRAEMOS LAS UBICACIONES
  			=============================================*/

            $item = "id";
            $valor = $productosUbicacion[$i]["id_ubicacion"];
            $ubicacion = ControladorProductoUbicacion::ctrMostrarUbicacionLista($item, $valor);




            /*=============================================
 	 		TRAEMOS MODELOS, MARCA,CATEGORTIA
  			=============================================*/


            $item = "id";
            $valor = $productos["idmodelo"];

            $modelos = ControladorModelos::ctrMostrarModelo($item, $valor);

            $idcategoria = $modelos["idcategoria"];
            $idMarca = $modelos["idmarca"];

            $categoria = ControladorCategorias::ctrMostrarCategorias($item, $idcategoria);



            $marca = ControladorMarcas::ctrMostrarMarca($item, $idMarca);



            /*=============================================
 	 		TRAEMOS LAS ACCIONES
			  =============================================*/

            if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial") {
                $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProductoUbicacion' idProductoUbicacion='" . $productosUbicacion[$i]["id"] . "'  data-toggle='modal' data-target='#modalEditarProductoUbicacion'><i class='fas fa-pencil-alt'></i></button></div>";
            } else {
                $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProductoUbicacion' idProductoUbicacion='" . $productosUbicacion[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProductoUbicacion'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarProductoUbicacion' idProductoUbicacion='" . $productosUbicacion[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
            }

            $datosJson .= '[
			      "' . ($i + 1) . '",
                  "' . $categoria["descripcion"] . '",
                  "' . $marca["descripcion"] . '",
                  "' . $modelos["descripcion"] . '",
                  "' . $productos["cod_producto"] .'",
				  "' . $ubicacion["descripcion"] . '",
				  "' . $productosUbicacion[$i]["posicion"] . '",
                  "' . $productosUbicacion[$i]["referencia"].$ip.'",
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
ACTIVAR TABLA DE PRODUCTOS UBICACION
=============================================*/
$activarProductosUbicacion = new TablaProductosUbicacion();
$activarProductosUbicacion->mostrarTablaProductosUbicacion();
