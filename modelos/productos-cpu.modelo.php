<?php

require_once "conexion.php";

class ModeloProductosCpu
{

	/*=============================================
	CREAR  PRODUCTO-CPU
	=============================================*/

	static public function mdlIngresarProductoCpu($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idproducto,tipo_disco,cant_disco,tipo_ram,cant_ram,procesador,sistema_operativo,direccion_ip,modelo_placa,observaciones,generacion,mac,edicion_so,creado_por) VALUES (:idproducto,:tipo_disco,:cant_disco,:tipo_ram,:cant_ram,:procesador,:sistema_operativo,:direccion_ip,:modelo_placa,:observaciones,:generacion,:mac,:edicion_so,:creado_por)");

		$stmt->bindParam(":idproducto", $datos["idproducto"], PDO::PARAM_INT);
		//$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo_disco", $datos["tipo_disco"], PDO::PARAM_STR);
		$stmt->bindParam(":cant_disco", $datos["cant_disco"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo_ram", $datos["tipo_memoria"], PDO::PARAM_STR);
		$stmt->bindParam(":cant_ram", $datos["cant_memoria"], PDO::PARAM_INT);
		$stmt->bindParam(":procesador", $datos["procesador"], PDO::PARAM_INT);
		$stmt->bindParam(":sistema_operativo", $datos["sistema_operativo"], PDO::PARAM_INT);
		$stmt->bindParam(":direccion_ip", $datos["direccion_ip"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo_placa", $datos["modelo_placa"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":generacion", $datos["generacion"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":edicion_so", $datos["edicion_so"], PDO::PARAM_STR);
		$stmt->bindParam(":creado_por", $datos["creado_por"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt = null;
	}

	/*=============================================
	MOSTRAR PRODUCTOS DE LA CATEGORIA CPU
	=============================================*/

	static public function mdlMostrarProductosCpu($tabla, $item, $valor, $orden)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id asc");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY $orden DESC");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt = null;
	}

	//MOSTRAR LISTA DE CODIGOS DE PRODUCTOS DE LA CATEGORIA CPU
	static public function mdlMostrarCodigoProductoCpu($cat,$cat2)
	{
		$stmt = Conexion::conectar()->prepare("SELECT pro.id,pro.cod_producto FROM producto pro
				INNER JOIN modelo mo
				ON pro.idmodelo=mo.id
				INNER JOIN categoria cat
				ON mo.idcategoria=cat.id 
				WHERE cat.descripcion=:$cat or cat.descripcion=:$cat2");

		$stmt->bindParam(":" . $cat, $cat, PDO::PARAM_STR);
		$stmt->bindParam(":" . $cat2, $cat2, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}








	//para validar no repetir codigo del producto,asi no registramos detalles del mismo producto
	static public function mdlMostrarProductosRepetidosCpu($tabla, $item, $valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();
	}

	/*=============================================
	EDITAR DETALLE DEL PRODUCTO CPU
	=============================================*/

	static public function mdlEditarProductoCpu($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipo_disco=:tipo_disco,cant_disco=:cant_disco,tipo_ram=:tipo_ram,cant_ram=:cant_ram,procesador=:procesador,sistema_operativo=:sistema_operativo,direccion_ip=:direccion_ip,modelo_placa=:modelo_placa,observaciones=:observaciones,generacion=:generacion,mac=:mac,edicion_so=:edicion_so,actualizado_por=:actualizado_por,fecha_actualizacion=:fecha_actualizacion WHERE id=:id");

		//$stmt->bindParam(":id_empleado", $datos["id_empleado"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo_disco", $datos["tipo_disco"], PDO::PARAM_STR);
		$stmt->bindParam(":cant_disco", $datos["cant_disco"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo_ram", $datos["tipo_ram"], PDO::PARAM_STR);
		$stmt->bindParam(":cant_ram", $datos["cant_ram"], PDO::PARAM_INT);
		$stmt->bindParam(":procesador", $datos["procesador"], PDO::PARAM_INT);
		$stmt->bindParam(":sistema_operativo", $datos["sistema_operativo"], PDO::PARAM_INT);
		$stmt->bindParam(":direccion_ip", $datos["direccion_ip"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo_placa", $datos["modelo_placa"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":generacion", $datos["generacion"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":edicion_so", $datos["edicion_so"], PDO::PARAM_STR);
		$stmt->bindParam(":actualizado_por", $datos["actualizado_por"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_actualizacion", $datos["fecha_actualizacion"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt = null;
	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarProductoCpu($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt = null;
	}



	/*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/

	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":id", $valor, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}



		$stmt = null;
	}




	/*=============================================
	MOSTRAR TOTAL DE PRODCUTOS POR CATEGORIA
	=============================================*/

	static public function mdlMostrarTotalProductos()
	{



		$stmt = Conexion::conectar()->prepare(
			"SELECT  cat.descripcion AS CATEGORIA,mar.descripcion AS MARCA,COUNT(pro.idestado) AS STOCK FROM producto pro 
			inner JOIN modelo mo
			ON pro.idmodelo=mo.id
			INNER JOIN marca mar
			ON mar.id=mo.idmarca
			INNER JOIN categoria cat
			ON  cat.id=mo.idcategoria
			GROUP BY cat.descripcion,mar.descripcion"
		);

		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}


		/*=============================================
	MOSTRAR SISTEMA OPERATIVO PRODUCTO CPU
	=============================================*/

	static public function mdlMostrarSistemaOperativo()
	{



		$stmt = Conexion::conectar()->prepare(
			"SELECT COUNT(*) AS TOTAL,tso.descripcion AS sistema_operativo FROM producto_cpu 
			INNER JOIN tipo_sistema_operativo tso
			ON producto_cpu.sistema_operativo=tso.id
			GROUP BY tso.descripcion  ORDER BY TOTAL DESC"
		);

		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}

	/*=============================================
	MOSTRAR ESTADOS DEPRODCUTOS POR CATEGORIA
	=============================================*/

	static public function mdlMostrarTotalProductosPorEstados($categoria)
	{

		$stmt = Conexion::conectar()->prepare(
			"SELECT  cat.descripcion AS CATEGORIA,mar.descripcion AS MARCA,es.descripcion AS ESTADO,COUNT(pro.idestado) AS CANTIDAD FROM producto pro 
		inner JOIN modelo mo
		ON pro.idmodelo=mo.id
		INNER JOIN marca mar
		ON mar.id=mo.idmarca
		INNER JOIN categoria cat
		ON  cat.id=mo.idcategoria
		INNER JOIN estado es
		ON pro.idestado=es.id
		GROUP BY cat.descripcion,mar.descripcion,pro.idestado
		HAVING cat.descripcion=:categoria"
		);
		$stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}
	/*=============================================
	MOSTRAR ESTADOS DE PRESTAMOS DE PRODCUTOS POR CATEGORIA
	=============================================*/

	static public function mdlMostrarTotalProductosPorEstadosDePrestamo($categoria)
	{

		$stmt = Conexion::conectar()->prepare(
			"SELECT  cat.descripcion AS CATEGORIA,mar.descripcion AS MARCA,pro.estado_prestamo,COUNT(cat.descripcion) AS STOCK FROM producto pro 
		inner JOIN modelo mo
		ON pro.idmodelo=mo.id
		INNER JOIN marca mar
		ON mar.id=mo.idmarca
		INNER JOIN categoria cat
		ON  cat.id=mo.idcategoria
		GROUP BY cat.descripcion,mar.descripcion,pro.estado_prestamo
		HAVING cat.descripcion=:categoria"
		);
		$stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}



	//MOSTRAR LISTA DE PROCESADORES
	static public function mdlMostrarListaProcesadores($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id asc");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY id asc");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt = null;
	}


	//MOSTRAR LISTA DE SISTEMA OPERATIVO
	static public function mdlMostrarListaSistemaOperativo($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id asc");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY id asc");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt = null;
	}

}
