<?php

require_once "conexion.php";

class ModeloPedidos
{

  /*======================================= 
  MOSTRAR VENTAS 
  =============================================*/
  // static public function mdlMostrarVentas($tabla, $item, $valor, $idUsuario)
  // {
  //   if ($item != null) {
  //     $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $idUsuario = :$idUsuario $item = :$item ORDER BY id ASC");
  //     $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
  //     $stmt->bindParam(":" . $idUsuario, $idUsuario, PDO::PARAM_INT);
  //     $stmt->execute();
  //     return $stmt->fetch();
  //   } else {
  //     $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla");
  //     $stmt->execute();
  //     return $stmt->fetchAll();
  //   }
  //   // $stmt -> close();
  //   $stmt = null;
  // }
/*======================================= 
MOSTRAR VENTAS CON FILTRO DE VENDEDOR 
=============================================*/
  static public function mdlMostrarPedido($tabla, $item, $valor,$order)
  {

    if ($item != null) {

      // Aquí se compara con el valor que viene dinamico que vendria siendo id_vendedor
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ");
      // Aquí se pasa el parametro con los valores...
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      // Esto no sirve acá
      // $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha_registro FROM $tabla ORDER BY id $order");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt -> close();
    $stmt = null;
  }


  /*=============================================
	MOSTRAR AREA
	=============================================*/

	static public function mdlMostrarArea($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt = null;

	}



  /*=============================================
	REGISTRO DE PEDIDO
	=============================================*/
  static public function mdlIngresarPedido($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo,id_usuario,id_empleado,productos,id_area,descripcion) VALUES (:codigo,:id_usuario, :id_empleado,:productos,:id_area, :descripcion)");

    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
    $stmt->bindParam(":id_empleado", $datos["id_empleado"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":id_area", $datos["id_area"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }

  /*=============================================
  EDITAR PEDIDO
  =============================================*/
  static public function mdlEditarPedido($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo=:codigo,  id_usuario = :id_usuario, id_empleado = :id_empleado,id_area=:id_area,productos = :productos,descripcion = :descripcion,fecha_actualizacion=:fecha_actualizacion WHERE id = :id");
    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
    $stmt->bindParam(":id_empleado", $datos["id_empleado"], PDO::PARAM_INT);
    $stmt->bindParam(":id_area", $datos["id_area"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);   
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha_actualizacion", $datos["fecha_actualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }

  /*=============================================
  ELIMINAR VENTA
  =============================================*/
  static public function mdlEliminarPedido($tabla, $datos)
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
  /*================================ 
  RANGO FECHAS 
  =============================================*/
  
  /*=============================================
  SUMAR EL TOTAL DE VENTAS
  =============================================
  static public function mdlSumaTotalVentas($tabla)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();

    // $stmt -> close();
    $stmt = null;
  }
  */

 
}
