<?php
require_once "../controladores/productos-lotes.controlador.php";
require_once "../modelos/productos-lotes.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
class TablaProductosPedidos
{

  /*===================================================
  MOSTRAR LA TABLA DE PRODUCTOS
  ===================================================*/
  public function mostrarTablaProductosPedidos()
  {

    // Definir que item se quiere consultar en la base de datos
    $item = null;
    // Definir el valor que se va a comparar en la consulta en la base de datos
    $valor = null;
    $orden = "id";
    

    $productos = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
    if (count($productos) == 0) {

      echo '{"data": []}';
      return;
    }
    $datosJson = '{
		  "data": [';

    for ($i = 0; $i < count($productos); $i++) {
      /*=======================================Traemos la imagen =============================================*/
      $imagen = "<img src='" . $productos[$i]["imagen"] . "' width='40px'>";
     
      /*=============================================Traemos la Sucursal=============================================*/
     $item = "id";
      $valor = $productos[$i]["idcategoria"];
      $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);
      /*=============================================Stock del producto/*=============================================*/
      if ($productos[$i]["stock"] <= 10) {
        $stock = "<button class='btn btn-danger'>" . $productos[$i]["stock"] . "</button>";
      } else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 19) {
        $stock = "<button class='btn btn-warning'>" . $productos[$i]["stock"] . "</button>";
      } else {
        $stock = "<button class='btn btn-success'>" . $productos[$i]["stock"] . "</button>";
      }
      /*=============================================Traemos las acciones=============================================*/
      $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Agregar</button></div>";

      $datosJson .= '[
			      "' . ($i + 1) . '",
            "'.$imagen.'",
            "' . $categoria["descripcion"] . '",
			      "' . $productos[$i]["nombre"] . '",
            "' . $productos[$i]["unidad_medida"] . '",
			      "' . $stock . '",
			      "' . $botones . '"
			    ],';
    }
    $datosJson = substr($datosJson, 0, -1);
    $datosJson .=   '] 

		 }';
    echo $datosJson;
  }
}
/*=============================================ACTIVAR TABLA DE PRODUCTOS=============================================*/
$activarProductosPedidos = new TablaProductosPedidos();
$activarProductosPedidos->mostrarTablaProductosPedidos();
