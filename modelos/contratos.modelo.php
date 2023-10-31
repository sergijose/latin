<?php

require_once "conexion.php";

class ModeloContratos{
//comentario prueba
	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarContrato($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cod_cliente,nombre_completo,dni,direccion,telefono) VALUES (:cod_cliente,:nombre_completo,:dni,:direccion,:telefono)");

		$stmt->bindParam(":cod_cliente",$datos["cod_cliente"],PDO::PARAM_STR);
		$stmt->bindParam(":nombre_completo", $datos["nombre_completo"], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

		if($stmt->execute()){
			
			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR CONTRATO
	=============================================*/

	static public function mdlMostrarContratos($tabla, $item, $valor){

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

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion = :categoria,actualizado_por=:actualizado_por,fecha_actualizacion=:fecha_actualizacion WHERE id = :id");

		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":actualizado_por", $datos["actualizado_por"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_actualizacion", $datos["fecha_actualizacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}

