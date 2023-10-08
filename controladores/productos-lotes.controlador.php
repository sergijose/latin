<?php
class ControladorProductosLotes
{
  /*=============================================
  MOSTRAR PRODUCTOS
  =============================================*/
  static public function ctrMostrarProductosLotes($item, $valor, $orden)
  {
    $tabla = "producto_lotes";
    $respuesta = ModeloProductosLotes::mdlMostrarProductosLotes($tabla, $item, $valor, $orden);
    return $respuesta;
  }
  /*=============================================
  Mostrar Producto sin Orden
  =============================================*/
  static public function ctrMostrarProductosLotes2($item, $valor)
  {
    $tabla = "producto_lotes";
    $respuesta = ModeloProductosLotes::mdlMostrarProductoLotes2($tabla, $item, $valor);
    return $respuesta;
  }
  /*==================== 
  Mostramos Productos por Sucursal 
  =======================================*/
  static public function ctrMostrarProductoCategoria($item, $valor, $orden)
  {
    $tabla = "producto_lotes";
    $respuesta = ModeloProductosLotes::mdlMostrarProductoCategoria($tabla, $item, $valor, $orden);
    return $respuesta;
  }

  /*=============================================
  CREAR PRODUCTO
  =============================================*/
  static public function ctrCrearProductoLotes()
  {
    if (isset($_POST["nuevoNombre"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\- %\()#\.]+$/', $_POST["nuevoNombre"]) &&
        preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&
        preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
        preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])
      ) {
      
        $tabla = "producto_lotes";
        $datos = array(
          "idcategoria" => $_POST["nuevaCategoria"],
          "nombre" => $_POST["nuevoNombre"],
          "descripcion" => $_POST["nuevaDescripcion"],
          "unidad_medida" => $_POST["nuevaUnidadMedida"],
          "stock" => $_POST["nuevoStock"],
          "precio_compra" => $_POST["nuevoPrecioCompra"],
          "precio_venta" => $_POST["nuevoPrecioVenta"],
        );

        $respuesta = ModeloProductosLotes::mdlIngresarProductoLotes($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos-lotes";

										}
									})
						</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos-lotes";

							}
						})

			  	</script>';
      }
    }
  }
  /*=============================================
  EDITAR PRODUCTO
  =============================================*/
  static public function ctrEditarProductoLotes()
  {

    if (isset($_POST["editarNombre"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\- %\()#\.]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
        preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
        preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])
      ) {

      
        $tabla = "producto_lotes";

        $datos = array(
          "idcategoria" => $_POST["editarCategoria"],
          "nombre" => $_POST["editarNombre"],
          "descripcion" => $_POST["editarDescripcion"],
          "unidad_medida" => $_POST["editarUnidadMedida"],
          "stock" => $_POST["editarStock"],
          "precio_compra" => $_POST["editarPrecioCompra"],
          "precio_venta" => $_POST["editarPrecioVenta"],   
          "id" => $_POST["id"]);

        $respuesta = ModeloProductosLotes::mdlEditarProductoLotes($tabla, $datos);
     

        if ($respuesta == "ok") {

          echo '<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos-lotes";

										}
									})

						</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos-lotes";

							}
						})

			  	</script>';
      }
    }
  }
  /*=============================================
  BORRAR PRODUCTO
  =============================================*/
  static public function ctrEliminarProductoLotes()
  {

    if (isset($_GET["idProducto"])) {

      $tabla = "producto_lotes";
      $datos = $_GET["idProducto"];

      $respuesta = ModeloProductosLotes::mdlEliminarProductoLotes($tabla, $datos);

      if ($respuesta == "ok") {

        echo '<script>

				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "productos-lotes";

								}
							})

				</script>';
      }
    }
  }
  /*=============================================
  MOSTRAR SUMA VENTAS
  =============================================*/
  static public function ctrMostrarSumaVentasLotes()
  {

    $tabla = "producto_lotes";
    $respuesta = ModeloProductosLotes::mdlMostrarSumaVentasProductosLotes($tabla);
    return $respuesta;
  }
}
