<?php
require_once "conexion.php";
class ModeloProveedor{
  
  /*=============================================
  MOSTRAR PROVEEDORES
  =============================================*/
  static public function  mdlMostrarProveedor($tabla, $item, $valor){
    if($item != null){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();

    }else{
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }

    //$stmt -> close();
    $stmt = null; // obligado para cerrar la conexión
  
  }
    /*=============================================
  Nuevo Proveedor
  =============================================*/
  static public function mdlNuevoProveedor($tabla, $datos){
    $stmt =Conexion::conectar()->prepare("INSERT INTO $tabla(ruc,razon_social,nombre_comercial,direccion_fiscal,num_telefono,tipo_empresa,estado_empresa,descripcion) VALUES (:ruc,:razon_social,:nombre_comercial,:direccion_fiscal,:num_telefono,:tipo_empresa,:estado_empresa,:descripcion)");

    $stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);
    $stmt->bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
    $stmt->bindParam(":nombre_comercial", $datos["nombre_comercial"], PDO::PARAM_STR);
    $stmt->bindParam(":direccion_fiscal", $datos["direccion"], PDO::PARAM_STR);
    $stmt->bindParam(":num_telefono", $datos["telefono"], PDO::PARAM_STR);
    $stmt->bindParam(":tipo_empresa", $datos["tipo_empresa"], PDO::PARAM_STR);
    $stmt->bindParam(":estado_empresa", $datos["estado_empresa"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        
    if($stmt->execute()){

			return "ok";

		}else{
      echo $stmt->errorInfo();
		//	return "error";
		
		}

		
		$stmt = null;

	}
  
}