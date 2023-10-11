<?php

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorPedidos
{
  /*=============================================
  MOSTRAR VENTAS
  =============================================*/
  // Aqui se debe quitar $idUsuario
  // static public function ctrMostrarVentas($item, $valor, $idUsuario)
  static public function ctrMostrarPedido($item, $valor, $order)
  {

    $tabla = "pedidos";

    // $respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor, $idUsuario);
    $respuesta = ModeloPedidos::mdlMostrarPedido($tabla, $item, $valor, $order);
    return $respuesta;
  }

  /*=============================================
	MOSTRAR AREA
	=============================================*/

  static public function ctrMostrarArea($item, $valor)
  {

    $tabla = "area";

    $respuesta = ModeloPedidos::mdlMostrarArea($tabla, $item, $valor);

    return $respuesta;
  }


  /*=============================================
	CREAR VENTA
	=============================================*/
  static public function ctrCrearPedido()
  {

    if (isset($_POST["nuevoEmpleado"])) {
      /*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

      if ($_POST["listaProductosPedidos"] == "") { // Si no hay productos en la lista de ventas
        echo '<script>
				swal({
					  type: "error",
					  title: "El pedido no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "pedidos";
								}
							})
				</script>';
        return;
      }


      $listaProductos = json_decode($_POST["listaProductosPedidos"], true);
      $totalProductosComprados = array();

      foreach ($listaProductos as $key => $value) {

        array_push($totalProductosComprados, $value["cantidad"]);
        $tablaProductos = "producto_lotes";

        $item = "id";
        $valor = $value["id"];
        $orden = "id";

        $traerProducto = ModeloProductosLotes::mdlMostrarProductosLotes($tablaProductos, $item, $valor, $orden);
        $item1a = "salidas";
        $valor1a = $value["cantidad"] + $traerProducto["salidas"];

        $nuevasVentas = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1a, $valor1a, $valor);
        $item1b = "stock";
        $valor1b = $value["stock"];

        $nuevoStock = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1b, $valor1b, $valor);
      }




      //$item1a = "compras";

      //      $valor1a = ($totalProductosComprados) + $traerCliente["compras"];

      //    $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

      //  $item1b = "ultima_compra";


      // date_default_timezone_set('America/Lima');
      //$fecha = date('Y-m-d');
      //$hora = date('H:i:s');
      //$valor1b = $fecha . ' ' . $hora;

      /*=============================================
			GUARDAR PEDIDO
			=============================================*/
      $tabla = "pedidos";
      $datos = array(
        "codigo" => $_POST["nuevoPedido"],
        "id_usuario" => $_POST["idVendedor"],
        "id_empleado" => $_POST["nuevoEmpleado"],
        "productos" => $_POST["listaProductosPedidos"],
        "id_area" => $_POST["nuevaArea"],
        "descripcion" => $_POST["nuevaObservacion"],
      );

      $respuesta = ModeloPedidos::mdlIngresarPedido($tabla, $datos);
      if ($respuesta == "ok") {

        echo '<script>
        swal({
            type: "success",
            title: "El pedido ha sido guardada correctamente",
            showConfirmButton: true,
					  allowOutsideClick: false,
					  confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                  window.location = "pedidos";
                }
              })
        </script>';
      }
    }
  }

  /*=============================================
	EDITAR PEDIDOS
	=============================================*/
  static public function ctrEditarPedido()
  {

    if (isset($_POST["editarPedido"])) {
      /*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
      $tabla = "pedidos";
      $item = "codigo";
      $valor = $_POST["editarPedido"];

      $traerPedido = ModeloPedidos::mdlMostrarPedido($tabla, $item, $valor, null);
      /*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
      if ($_POST["listaProductosPedidos"] == "") {

        $listaProductos = $traerPedido["productos"];
        $cambioProducto = false;
      } else {

        $listaProductos = $_POST["listaProductosPedidos"];
        $cambioProducto = true;
      }

      if ($cambioProducto) {

        $productos =  json_decode($traerPedido["productos"], true);
        $totalProductosComprados = array();

        foreach ($productos as $key => $value) {

          array_push($totalProductosComprados, $value["cantidad"]);

          $tablaProductos = "producto_lotes";

          $item = "id";
          $valor = $value["id"];
          $orden = "id";
          //TRAER PRODUCTOS LOTES
          $traerProducto = ModeloProductosLotes::mdlMostrarProductosLotes($tablaProductos, $item, $valor, $orden);

          $item1a = "salidas";
          $valor1a = $traerProducto["salidas"] - $value["cantidad"];

          $nuevasSalidas = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1a, $valor1a, $valor);

          $item1b = "stock";
          $valor1b = $value["cantidad"] + $traerProducto["stock"];

          $nuevoStock = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1b, $valor1b, $valor);
        }

        //$tablaClientes = "clientes";

        //$itemCliente = "id";
        //$valorCliente = $_POST["seleccionarCliente"];

        //$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

        //$item1a = "compras";
        //$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);

        //$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
        /*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/
        $listaProductos_2 = json_decode($listaProductos, true);

        $totalProductosComprados_2 = array();

        foreach ($listaProductos_2 as $key => $value) {

          array_push($totalProductosComprados_2, $value["cantidad"]);

          $tablaProductos_2 = "producto_lotes";

          $item_2 = "id";
          $valor_2 = $value["id"];
          $orden = "id";

          $traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2, $orden);

          $item1a_2 = "salidas";
          $valor1a_2 = $value["cantidad"] + $traerProducto_2["salidas"];

          $nuevasSalidas_2 = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

          $item1b_2 = "stock";
          $valor1b_2 = $traerProducto_2["stock"] - $value["cantidad"];

          $nuevoStock_2 = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
        }

        //$tablaClientes_2 = "empleados";

        //$item_2 = "id";
        //$valor_2 = $_POST["editarEmpleado"];

        //$traerCliente_2 = ModeloEmpleado::mdlMostrarEmpleado($tablaClientes_2, $item_2, $valor_2);
        //PARA LAS COMPRAS

        //$item1a_2 = "compras";

        //$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];

        //$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

        // $item1b_2 = "ultima_compra";

        //date_default_timezone_set('America/Bogota');

        //$fecha = date('Y-m-d');
        //$hora = date('H:i:s');
        //$valor1b_2 = $fecha . ' ' . $hora;

        //$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

        // ACTUALIZACIÓN DEL STOCK DE PRODUCTOS ELIMINADOS
        //if($_POST["listaProdEliminados"]!="") {
        //$listaProdEliminados=json_decode($_POST["listaProdEliminados"],true);
        //foreach ($listaProdEliminados as $key=>$value){
        //  $infoP=ModeloProductos::mdlMostrarProductos("productos","id",$value["id"],null);
        //$nuevoInv=$infoP["stock"]+$value["cantidad"];
        //ModeloProductos::mdlActualizarProducto("producto_lotes","stock",$nuevoInv,$value["id"]);
        //}
        //  }

      }
      date_default_timezone_set('America/Bogota');

      $fecha = date('Y-m-d');
      $hora = date('H:i:s');
      $fechaActual = $fecha . ' ' . $hora;

      /*=============================================
			GUARDAR CAMBIOS DE LOS PEDIDOS
			=============================================*/
      $datos = array(
        "codigo" => $_POST["editarPedido"],
        "id_usuario" => $_POST["idVendedor"],
        "id_empleado" => $_POST["editarEmpleado"],
        "id_area" => $_POST["editarArea"],
        "codigo" => $_POST["editarPedido"],
        "productos" => $listaProductos,
        "descripcion" => $_POST["editarDescripcion"],
        "fecha_actualizacion" => $fechaActual,
        "id" => $_POST["idPedido"]
      );

      $respuesta = ModeloPedidos::mdlEditarPedido($tabla, $datos);
      if ($respuesta == "ok") {
        echo '<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: " pedido actualizado",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "pedidos";
								}
							})
				</script>';
      } else {

        echo '<script>

					
						alertify.error("No se pudo Prestar ");
						

			  	</script>';
      }
    }
  }


  /*=============================================
	ELIMINAR VENTA
	=============================================*/
  static public function ctrEliminarPedido()
  {

    if (isset($_GET["idPedido"])) {

      $tabla = "pedidos";

      $item = "id";
      $valor = $_GET["idPedido"];
      $order = "DESC";

      $traerPedido = ModeloPedidos::mdlMostrarPedido($tabla, $item, $valor, $order);



      //var_dump($traerPedido);

      /*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
      foreach ($traerPedido as $key => $value) {
        $productos =  json_decode($traerPedido["productos"], true);
      };
       // var_dump($productos);

      $totalProductosComprados = array();

      foreach ($productos as $key => $value) {

        array_push($totalProductosComprados, $value["cantidad"]);

        $tablaProductos = "producto_lotes";

        $item = "id";
        $valor = $value["id"];
        $orden = "id";

        $traerProductoLotes = ModeloProductosLotes::mdlMostrarProductosLotes($tablaProductos, $item, $valor, $orden);

        $item1a = "salidas";
        $valor1a = $traerProductoLotes["salidas"] - $value["cantidad"];

        //var_dump($valor1a);
        $nuevosPedidos = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1a, $valor1a, $valor);

        $item1b = "stock";
        $valor1b = $value["cantidad"] + $traerProductoLotes["stock"];

        $nuevoStock = ModeloProductosLotes::mdlActualizarProductoLotes($tablaProductos, $item1b, $valor1b, $valor);
      }



      /*=============================================
			ELIMINAR VENTA
			=============================================*/

      $respuesta = ModeloPedidos::mdlEliminarPedido($tabla, $_GET["idPedido"]);

      if ($respuesta == "ok") {

        echo '<script>

				swal({
					  type: "success",
					  title: "El pedido ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "pedidos";

								}
							})

				</script>';
      }
    }
  }
}
