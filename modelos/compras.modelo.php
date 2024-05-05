<?php
require_once "conexion.php";
class ModeloCompras
{
  // =====================================    
  // MOSTRAR COMPRAS 
  // ====================================== 
  static public function mdlMostrarCompras($tabla, $item, $valor)
  {
    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id desc");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla ORDER BY id desc");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }

  // =====================================    
  // MOSTRAR COMPRAS2 
  // ====================================== 
  static public function mdlMostrarCompras2($tabla, $item, $valor)
  {
    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id asc");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla ORDER BY id asc");
    }

    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null;
  }

  // ===================================== 
  //    REGISTRO DE COMPRAS
  // ====================================== 

  static public function mdlIngresarCompra($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_proveedor,id_usuario, productos,descripcion_ingreso, impuesto, neto, total) VALUES (:codigo, :id_proveedor,:id_usuario, :productos,:descripcion_ingreso, :impuesto, :neto, :total)");

    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion_ingreso", $datos["descripcion_ingreso"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_INT);
    $stmt->bindParam(":total", $datos["total"], PDO::PARAM_INT);
  

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }
  // =====================================
  // //EDITAR COMPRAS// 
  // ====================================== 

  static public function mdlEditarCompra($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_proveedor=:id_proveedor, id_usuario = :id_usuario, productos = :productos,descripcion_ingreso=:descripcion_ingreso, impuesto = :impuesto, neto = :neto, total = :total,codigo=:codigo WHERE id=:id");

    $stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion_ingreso", $datos["descripcion_ingreso"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
    $stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }
/*================================ 
  RANGO FECHAS 
  =============================================*/
  static public function mdlRangoFechasCompras($tabla, $fechaInicial, $fechaFinal)
  {

    if ($fechaInicial == null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
      $stmt->execute();
      return $stmt->fetchAll();
    } else if ($fechaInicial == $fechaFinal) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");
      $stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {

      $fechaActual = new DateTime();
      $fechaActual->add(new DateInterval("P1D"));
      $fechaActualMasUno = $fechaActual->format("Y-m-d");

      $fechaFinal2 = new DateTime($fechaFinal);
      $fechaFinal2->add(new DateInterval("P1D"));
      $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

      if ($fechaFinalMasUno == $fechaActualMasUno) {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
      } else {


        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
      }

      // $stmt -> execute();
      return $stmt->fetchAll();
    }
  }

  /*=============================================
  SUMAR EL TOTAL DE COMPRAS
  =============================================*/
  static public function mdlSumaTotalCompras($tabla)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();
    // $stmt->close();
    $stmt = null;
  }


    /*=============================================
  ELIMINAR COMPRA
  =============================================*/
  static public function mdlEliminarCompra($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }
    // $stmt -> close();
    $stmt = null;
  }
}
