<?php
/*==========================================================================
REQUERIR CONTROLADORES Y MODELOS IMPLICADOS EN EL PROCESO
==========================================================================*/
require_once "../controladores/productos-lotes.controlador.php";
require_once "../modelos/productos-lotes.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";




class TablaProductosLotes
{

  /*===================================================
  MOSTRAR LA TABLA DE PRODUCTOS
  ===================================================*/
  public function mostrarTablaProductosLotes()
  {

  
		$item = null;
		$valor = null;
		$orden = "id";

		$productosLotes = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);

		if (count($productosLotes) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($productosLotes); $i++) {

      $imagen = "<img src='".$productosLotes[$i]["imagen"]."' width='40px'>";
      
        /*============================================ 
        TRAEMOS LA CATEGORÍA 
        =============================================*/
        $item = "id";
        $valor = $productosLotes[$i]["idcategoria"];
        $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
       
        /*=============================================
        STOCK
        =============================================*/
        if ($productosLotes[$i]["stock"] <= 10) {
          $stock = "<button class='btn btn-danger'>" . $productosLotes[$i]["stock"] . "</button>";
        } else if ($productosLotes[$i]["stock"] > 11 && $productosLotes[$i]["stock"] <= 19) {
          $stock = "<button class='btn btn-warning'>" . $productosLotes[$i]["stock"] . "</button>";
        } else {
          $stock = "<button class='btn btn-success'>" . $productosLotes[$i]["stock"] . "</button>";
        }
        /*============================================= 
        TRAEMOS LAS ACCIONES 
        =============================================*/
        if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
          $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProductoLotes' idProducto='" . $productosLotes[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProductoLotes'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarProductoLotes ' idProducto='" . $productosLotes[$i]["id"]."'codigo='".$productosLotes[$i]["codigo"]."' imagen='".$productosLotes[$i]["imagen"]. "'><i class='fa fa-times'></i></button></div>";
        }
        else{
          $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProductoLotes' idProducto='" . $productosLotes[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProductoLotes'><i class='fas fa-pencil-alt'></i></button></div>";
        }
       
        $datosJson .= '[
						"' . ($i + 1) . '",
            "'.$imagen.'",
			      "'.$productosLotes[$i]["codigo"].'",
            "' . $categorias["descripcion"] . '",
            "' . $productosLotes[$i]["nombre"] . '",
            "' . $productosLotes[$i]["descripcion"] . '",
						"' . $productosLotes[$i]["unidad_medida"] . '",
            "' . $stock . '",
            "S/ ' . number_format($productosLotes[$i]["precio_compra"], 2) . '",
			      "S/ ' . number_format($productosLotes[$i]["precio_venta"], 2) . '",
            "' . $productosLotes[$i]["fecha_registro"] . '",
						"' . $botones . '"
			    	],';
      }
    	$datosJson = substr($datosJson, 0, -1);

		$datosJson .=   '] 

		 }';

		echo $datosJson;
	}
}

/*===============================
ACTIVAR TABLA DE PRODUCTOS
=================================*/
$activarProductos = new TablaProductosLotes();
$activarProductos->mostrarTablaProductosLotes();
