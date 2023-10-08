<?php
require_once "../controladores/productos-lotes.controlador.php";
require_once "../modelos/productos-lotes.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
class ajaxProductosLotes
{ // Inicia la clase AjaxProductos
  
/*================================EDITAR PRODUCTO==========================================*/
  public $idProducto;
  public $traerProductos;
  public $nombreProducto;

  public function ajaxEditarProductoLotes()
  {

    if ($this->traerProductos == "ok") {

      $item = null;
      $valor = null;
      $orden = "id";
      $respuesta = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
      echo json_encode($respuesta);
    } else if ($this->nombreProducto != "") {

      $item = "nombre";
      $valor = $this->nombreProducto;
      $orden = "id";

      $respuesta = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
      echo json_encode($respuesta);
    } else {

      $item = "id";
      $valor = $this->idProducto;
      $orden = "id";
      $respuesta = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
      echo json_encode($respuesta);
    }
  }

/*=============================================
  Validacion para No Repetir Codigo
  =============================================*/
  

} // Finaliza la clase AjaxProductos

/*=============================================
EDITAR PRODUCTO
=============================================*/
if (isset($_POST["idProducto"])) {

  $editarProductoLotes = new ajaxProductosLotes();
  $editarProductoLotes->idProducto = $_POST["idProducto"];
  $editarProductoLotes->ajaxEditarProductoLotes();
}
/*=============================================
TRAER PRODUCTO
=============================================*/
if (isset($_POST["traerProductos"])) {

  $traerProductos = new ajaxProductosLotes();
  $traerProductos->traerProductos = $_POST["traerProductos"];
  $traerProductos->ajaxEditarProductoLotes();
}
/*=============================================
TRAER PRODUCTO
=============================================*/
if (isset($_POST["nombreProducto"])) {

  $traerProductos = new ajaxProductosLotes();
  $traerProductos->nombreProducto = $_POST["nombreProducto"];
  $traerProductos->ajaxEditarProductoLotes();
}
/*=============================================
Validacion para No Repetir Codigo
=============================================*/

