<?php
require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class AjaxProveedores
{
  /*=============================================EDITAR PROVEEDOR=============================================*/
  public $idProveedor;
  public function ajaxEditarProveedor()
  {

    $item = "id";
    $valor = $this->idProveedor;
    $respuesta = ControladorProveedor::ctrMostrarProveedor($item, $valor);
    echo json_encode($respuesta);
  }
}
/*=============================================EDITAR PROVEEDOR=============================================*/
if (isset($_POST["idProveedor"])) {

  $cliente = new AjaxProveedores();
  $cliente->idProveedor = $_POST["idProveedor"];
  $cliente->ajaxEditarProveedor();
}
