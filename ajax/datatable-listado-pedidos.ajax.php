<?php

/*==========================================================================
REQUERIR CONTROLADORES Y MODELOS IMPLICADOS EN EL PROCESO
==========================================================================*/

require_once "../controladores/productos-lotes.controlador.php";
require_once "../modelos/productos-lotes.modelo.php";

require_once "../controladores/pedidos.controlador.php";
require_once "../modelos/pedidos.modelo.php";

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";



class TablaListadoPedidos
{

  /*===================================================
  MOSTRAR LA TABLA DE LISTADO VENTAS
  ===================================================*/
  public function mostrarTablaListadoPedidos()
  {
    // Definir que item se quiere consultar en la base de datos
    $item = null;
    // Definir el valor que se va a comparar en la consulta en la base de datos PARA COMPRAS ES ID VENDEDOR
    $valor = null;
    // Se pide la respuesta para todas las ventas filtradas por id_vendedor
    $order="DESC";
    $respuesta = ControladorPedidos::ctrMostrarPedido($item, $valor,$order);

    if (!$respuesta) {
      // Si no hay respuesta se manda la estructura json vacía
      echo '{"data": []}';
      // Se detiene el script
      return;
    }
    // Si, sí encontro datos entonces se empieza a crear la estructura JSON
    $datosJson = '{"data": [';
    // Se hace un ciclo por cada respuesta para traer sus valores correctos
    foreach ($respuesta as $key => $value) {

      /*=================================
      TRAER EL CLIENTE
      =================================*/
      $itemEmpleado = "idempleado";
      $valorEmpleado = $value["id_empleado"];
      $respuestaEmpleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);
      $empleado = $respuestaEmpleado["nombres"]." ".$respuestaEmpleado["ape_pat"]." ".$respuestaEmpleado["ape_mat"];
     
      /*==================================
      TRAER EL VENDEDOR
      ==================================*/
      $itemUsuario = "id";
      $valorUsuario = $value["id_usuario"];
      $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
      $usuario = $respuestaUsuario["nombre"];


/*==================================
      TRAER AREA
      ==================================*/
      $itemArea = "id";
      $valorArea = $value["id_area"];
      $respuestaArea= ControladorPedidos::ctrMostrarArea($itemArea, $valorArea);
      $area = $respuestaArea["descripcion"];

      /*==============================
      DETALLES DE LOS PRODUCTOS
      ==============================*/
      $productos =  json_decode($value["productos"], true);
      // Cantidad
      $cantidad = '';
      foreach ($productos as $key2 => $value2) {
        $cantidad .= $value2["cantidad"] . '<br>';
      }
      // Codigo de Factura
      //$codigo = '';
      //foreach ($productos as $key2 => $value2) {
        //$cantidad .= $value2["cantidad"] . '<br>';
      //}

      // Listado de productos
      $listadoProductos = '';
      foreach ($productos as $key2 => $value2) {
        $listadoProductos .= $value2["descripcion"] . '<br>';
      }
      // Precio por producto
     // $precioProducto = '';
     // foreach ($productos as $key2 => $value2) {
       // $precioProducto .= "$ " . number_format($value2["precio"], 2) . "<br>";
      //}
      // Total
      //$total = '';
      //foreach ($productos as $key2 => $value2) {
        //$total .= "S/  " . number_format($value2["total"], 2) . "<br>";
     // }
      // Metódo de pago
    
      // Fecha venta
      //$fecha = date('d/m/Y',strtotime($value["fecha_registro"]));

      /*==================================
      BOTONES DE ACCIÓN
      ==================================*/

     /* $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button>
      <button class='btn btn-danger btnEliminarVenta' idVenta='" . $value["id"] . "'><i class='fa fa-times'></i></button></div>";
      */
      if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador") {
        $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirPedido' codigoPedido='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-warning btnEditarPedido' idPedido='".$value["id"]."' data-toggle='modal' data-target='#modalEditarPedido'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarPedido' idPedido='" . $value["id"] . "'><i class='fa fa-times'></i></button></div>";
    } else {
      
      $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirPedido' codigoPedido='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-warning btnEditarPedido' idPedido='".$value["id"]."' data-toggle='modal' data-target='#modalEditarPedido'><i class='fas fa-pencil-alt'></i></button></div>";
    }
      /*$botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-warning btnEditarVenta' idVenta='".$value["id"]."' data-toggle='modal' data-target='#modalEditarVenta'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarVenta' idventa='" . $value["id"] . "'><i class='fa fa-times'></i></button>";*/
      /*===================================
      DEVOLVER LOS DATOS
      ===================================*/
      $datosJson   .= '[
        "' . ($key + 1) . '",
        "' . $empleado . '",
        "' . $usuario . '",
        "' . $cantidad . '",
        "' . $listadoProductos . '",
        "' . $area. '",
        "' . $value["descripcion"] . '",
        "' . $value["fecha_registro"] . '",
        "' . $botones . '"
        ],';
    }
    // Remover la última coma
   

    
    $datosJson = substr($datosJson, 0, -1);

   $datosJson .=   '] 

    }';
   
      echo $datosJson;
  }

}




/*=============================================
ACTIVAR TABLA DE PEDIDOS
=============================================*/
$tablaListadoPedidos = new TablaListadoPedidos();
$tablaListadoPedidos->mostrarTablaListadoPedidos();
