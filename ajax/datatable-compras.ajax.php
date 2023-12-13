<?php

require_once "../controladores/productos-lotes.controlador.php";
require_once "../modelos/productos-lotes.modelo.php";


class TablaProductosCompras
{
  /*=============================================
  MOSTRAR LA TABLA DE PRODUCTOS
  =============================================*/
  public function mostrarTablaProductosCompras()
  {


    $item = null;
    $valor = null;
    $orden = "id";

    $productosLotes = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
    //SI LA TABLA ESTA VACIA SE MOSTRARA DE IGUAL FORMA LOS PRODUCTOS CON ESTA CONDICIONAL
    if (count($productosLotes) != 0) {
      $datosJson = '{
			"data": [';

      for ($i = 0; $i < count($productosLotes); $i++) {
        /*=============================================
        TRAEMOS LA IMAGEN
        =============================================*/
         $imagen = "<img src='" . $productosLotes[$i]["imagen"] . "' width='40px'>";

        /*=============================================
        Traemos la Sucursal
        ============================================*/

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
        $botones = "<div clas='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productosLotes[$i]["id"] . "' >Agregar</button></div>";
        $datosJson .= '[
						"' . ($i + 1) . '",
            "' . $imagen. '",
					     "' . $productosLotes[$i]["nombre"] . '",
					    "' . $productosLotes[$i]["unidad_medida"] . '",
              "' . $productosLotes[$i]["stock"] . '",
						"' . $botones . '"
					],';
      }
      $datosJson = substr($datosJson, 0, -1);
      $datosJson .=   ']}';
      echo $datosJson;
    } else {
      echo '{
        	"data":[]
        }';
    }
  }
}
/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=========================================*/
$activarProductosCompras = new TablaProductosCompras();
$activarProductosCompras->mostrarTablaProductosCompras();
