<?php
require_once "conexion.php";
class ModeloProductosLotes
{
  /*=============================================
  MOSTRAR PRODUCTOS LOTES
  =============================================*/
  static public function mdlMostrarProductosLotes($tabla, $item, $valor, $orden)
  {

    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha_registro  FROM $tabla ORDER BY $orden DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }

  /*=============================================
  Mostrar Productos sin Filtro de Orden
  =============================================*/
  static public function mdlMostrarProductoLotes2($tabla, $item, $valor)
  {

    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha  FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }

  /*========================= 
  Mostramos Productos  - Sucursal 
  =====================================*/
  static public function mdlMostrarProductoCategoria($tabla, $item, $valor, $orden)
  {

    if ($item != null) {

      // Aquí se compara con el valor que viene dinamico que vendria siendo id_vendedor
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      // Aquí se pasa el parametro con los valores...
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha  FROM $tabla ORDER BY $orden DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }
  /*========================= 
  Registrar Nuevo Producto 
  ===========================================*/
  static public function mdlIngresarProductoLotes($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcategoria,nombre,imagen,codigo,descripcion,unidad_medida,stock,precio_compra, precio_venta) VALUES (:idcategoria,:nombre,:imagen,:codigo,:descripcion,:unidad_medida,:stock,:precio_compra, :precio_venta)");

    $stmt->bindParam(":idcategoria",  $datos["idcategoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":nombre",        $datos["nombre"],        PDO::PARAM_STR);
    $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);
    $stmt->bindParam(":unidad_medida",   $datos["unidad_medida"],   PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_INT);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_INT);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_INT);
    

    if($stmt->execute()){
      return "ok";}
    else{
      return $stmt->errorInfo(); // Con esto me muestra el error en especifico
    }
    $stmt=null;

    
  }
  /*=============================== 
  Edicion de Productos 
  ========================================*/
  static public function mdlEditarProductoLotes($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idcategoria=:idcategoria,nombre=:nombre,imagen=:imagen,codigo=:codigo,descripcion=:descripcion,unidad_medida=:unidad_medida,stock=:stock, precio_compra=:precio_compra, precio_venta=:precio_venta where id=:id");

    $stmt->bindParam(":idcategoria",  $datos["idcategoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":nombre",        $datos["nombre"],        PDO::PARAM_STR);
    $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);
    $stmt->bindParam(":unidad_medida", $datos["unidad_medida"],        PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_STR);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_STR);
    $stmt->bindParam(":id",             $datos["id"],      PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
  Eliminar un Producto Existente
  =============================================*/
  static public function mdlEliminarProductoLotes($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
    if ($stmt->execute()) {

      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
  ACTUALIZAR PRODUCTO
  =============================================*/
  static public function mdlActualizarProductoLotes($tabla, $item1, $valor1, $valor)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
    $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
    $stmt->bindParam(":id", $valor, PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=======================
  Mostramos la Suma de las Ventas 
  =========================================*/
  static public function mdlMostrarSumaVentasProductosLotes($tabla)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();
    // $stmt->close();
    $stmt = null;
  }
}
