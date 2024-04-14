<?php

require_once "conexion.php";

class ModeloProductos
{

	/*=============================================
	CREAR PRODUCTO
	=============================================*/

	static public function mdlIngresarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idmodelo,cod_producto,num_serie,mac,idestado,estado_prestamo,observaciones,situacion_actual,creado_por) VALUES (:idmodelo,:cod_producto,:num_serie,:mac,:idestado,:estado_prestamo,:observaciones,:situacion_actual,:creado_por)");

		$stmt->bindParam(":idmodelo", $datos["idmodelo"], PDO::PARAM_INT);
		$stmt->bindParam(":cod_producto", $datos["cod_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":num_serie", $datos["num_serie"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":idestado", $datos["idestado"], PDO::PARAM_INT);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":situacion_actual", $datos["situacion_actual"], PDO::PARAM_STR);
		$stmt->bindParam(":creado_por", $datos["creado_por"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt = null;
	}
	/*=============================================
	MOSTRAR PRODUCTOS DETALLE CARACTERISTICAS
	=============================================*/

	static public function mdlMostrarProductosDetalle($codigoProducto, $serie, $mac)
	{
		if ($serie!= null || $mac != null || $codigoProducto != null) {
			$stmt = Conexion::conectar()->prepare("SELECT pro.id,pro.idmodelo,pro.idestado,pro.cod_producto as codigo,pro.num_serie,pro.mac,pro.situacion_actual,pro.observaciones,pro.fecha,cat.descripcion AS categoria,mar.descripcion AS marca,mo.descripcion AS modelo,mo.imagen as imagen,
		 pro.estado_prestamo,est.descripcion AS estado_fisico,
		pro.estado_prestamo AS estado_prestamo
		FROM producto pro
		 INNER  JOIN modelo mo
		 ON pro.idmodelo=mo.id
		 INNER JOIN estado est
		 ON pro.idestado=est.id
		 INNER JOIN categoria cat
		 ON mo.idcategoria=cat.id
		 INNER JOIN marca mar
		 ON mo.idmarca=mar.id
		 WHERE  (pro.cod_producto LIKE :codigo_producto)
		 AND (pro.num_serie LIKE :serie)
		 AND( pro.mac LIKE  :mac )
		 ORDER BY pro.id desc");
			//$stmt->bindValue(":categoria", $categoria !== '' ? $categoria : null, PDO::PARAM_INT);
			//$stmt->bindValue(":marca", $marca !== '' ? $marca : null, PDO::PARAM_INT);
			$stmt->bindValue(":codigo_producto", '%' . $codigoProducto . '%' !== '' ? '%' . $codigoProducto . '%' : null, PDO::PARAM_STR);
			$stmt->bindValue(":serie", '%' . $serie . '%', PDO::PARAM_STR);
			$stmt->bindValue(":mac", '%' . $mac . '%', PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT pro.id,pro.idmodelo,pro.idestado,pro.cod_producto as codigo,pro.num_serie,pro.mac,pro.situacion_actual,pro.observaciones,pro.fecha,cat.descripcion AS categoria,mar.descripcion AS marca,mo.descripcion AS modelo,mo.imagen as imagen,
			pro.estado_prestamo,est.descripcion AS estado_fisico,
		   pro.estado_prestamo AS estado_prestamo
		   FROM producto pro
			INNER  JOIN modelo mo
			ON pro.idmodelo=mo.id
			INNER JOIN estado est
			ON pro.idestado=est.id
			INNER JOIN categoria cat
			ON mo.idcategoria=cat.id
			INNER JOIN marca mar
			ON mo.idmarca=mar.id ORDER BY pro.id desc");
			$stmt->execute();

			return $stmt->fetchAll();
		}
	}

	//BUSCAR PRODUCTOS POR ID CON CARACTERISTICAS DE CPU Y LAPTOP FUNCIONARA CON AJAX 

	static public function mdlMostrarProductosDetalleXid($valor)
	{

		if ($valor != null) {
			$stmt = Conexion::conectar()->prepare("SELECT pro.id,pro.cod_producto,pro.idmodelo,pro.idestado,pro.cod_producto as codigo,pro.num_serie,pro.mac as mac,pro.observaciones,pro.fecha,cat.descripcion AS categoria,mar.descripcion AS marca,mo.descripcion AS modelo,est.descripcion AS estado_fisico,
		pro.estado_prestamo AS estado_prestamo
		FROM producto pro
		 INNER  JOIN modelo mo
		 ON pro.idmodelo=mo.id
		 INNER JOIN estado est
		 ON pro.idestado=est.id
		 INNER JOIN categoria cat
		 ON mo.idcategoria=cat.id
		 INNER JOIN marca mar
		 ON mo.idmarca=mar.id
		 WHERE pro.id= :$valor ORDER BY pro.id desc");


			$stmt->bindParam(":" . $valor, $valor, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch();
		};
	}

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function mdlMostrarProductos($tabla, $item, $valor, $orden)
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
	}

	/*=============================================
	MOSTRAR LISTA DE ESTADOS DE PRODUCTOS
	=============================================*/

	static public function mdlMostrarEstadoFisicoProducto($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt = null;
	}


	//para validar no repetir codigo y numero de serie del producto
	static public function mdlMostrarProductosRepetidos($tabla, $item, $valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();
	}

	static public function mdlMostrarProductosParaPrestamo()
	{
		$stmt = Conexion::conectar()->prepare("SELECT pro.id,mo.imagen,mo.descripcion AS modelo,pro.cod_producto,pro.num_serie,est.descripcion as estado_producto,pro.estado_prestamo
		FROM producto pro
				 INNER  JOIN modelo mo
				 ON pro.idmodelo=mo.id
				 INNER JOIN estado est
				 ON pro.idestado=est.id
				 INNER JOIN categoria cat
				 ON mo.idcategoria=cat.id
				 INNER JOIN marca mar
				 ON mo.idmarca=mar.id
		WHERE pro.estado_prestamo <> 'NO APLICA' ORDER BY id DESC");

		//$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();
	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/

	static public function mdlEditarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idmodelo=:idmodelo,cod_producto=:cod_producto,num_serie=:num_serie,mac=:mac, idestado=:idestado,estado_prestamo=:estado_prestamo,observaciones=:observaciones,situacion_actual=:situacion_actual,actualizado_por=:actualizado_por,fecha_actualizacion=:fecha_actualizacion WHERE id=:id");
		$stmt->bindParam(":idmodelo", $datos["idmodelo"], PDO::PARAM_INT);
		$stmt->bindParam(":cod_producto", $datos["cod_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":num_serie", $datos["num_serie"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":idestado", $datos["idestado"], PDO::PARAM_INT);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":situacion_actual", $datos["situacion_actual"], PDO::PARAM_STR);
		$stmt->bindParam(":actualizado_por", $datos["actualizado_por"], PDO::PARAM_STR);
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

	static public function mdlEliminarProducto($tabla, $datos)
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
			"SELECT  cat.descripcion AS CATEGORIA,mar.descripcion AS MARCA,mo.descripcion as MODELO,COUNT(pro.idestado) AS TOTAL,SUM(pro.estado_prestamo='OCUPADO') AS OCUPADO,
			sum(pro.estado_prestamo='DISPONIBLE') AS LIBRE,
			sum(pro.estado_prestamo='NO APLICA') AS NO_APLICA FROM producto pro
			inner JOIN modelo mo
			ON pro.idmodelo=mo.id
			INNER JOIN marca mar
			ON mar.id=mo.idmarca
			INNER JOIN categoria cat
			ON  cat.id=mo.idcategoria
			GROUP BY cat.descripcion,mar.descripcion,mo.descripcion"
		);

		$stmt->execute();

		return $stmt->fetchAll();


		$stmt = null;
	}

	/*=============================================
	MOSTRAR ESTADOS FISICOS DE PRODUCTOS 
	=============================================*/

	static public function mdlMostrarTotalProductosPorEstados()
	{

		$stmt = Conexion::conectar()->prepare("SELECT  cat.descripcion AS CATEGORIA,mar.descripcion AS MARCA,mo.descripcion as MODELO,COUNT(*) AS TOTAL,
		SUM(es.descripcion='OPERATIVO')AS OPERATIVO,
		SUM(es.descripcion='MALOGRADO')AS MALOGRADO,
		SUM(es.descripcion='REPARACION INTERNA')AS REPARACION_INTERNA,
		SUM(es.descripcion='REPARACION GARANTIA')AS REPARACION_GARANTIA
		 FROM producto pro 
			inner JOIN modelo mo
			ON pro.idmodelo=mo.id
			INNER JOIN marca mar
			ON mar.id=mo.idmarca
			INNER JOIN categoria cat
			ON  cat.id=mo.idcategoria
			INNER JOIN estado es
			ON pro.idestado=es.id
			GROUP BY cat.descripcion,mar.descripcion,mo.descripcion");

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
	/*
	public static function search($searchTerm)
	{
		$stmt = Conexion::conectar()->prepare(
			"SELECT pro.cod_producto,cat.descripcion AS categorias,mar.descripcion AS marcas,mo.descripcion AS modelos,
	tipopro.descripcion AS procesador, procpu.generacion,procpu.tipo_disco,procpu.cant_disco,procpu.tipo_ram,procpu.cant_ram,
	tso.descripcion AS sistema_operativo,procpu.edicion_so AS edicion_so,procpu.direccion_ip,procpu.mac, IF(pro.estado_prestamo='ocupado','EN PRESTAMO',ubi.descripcion) as oficina,ubipro.posicion,est.descripcion AS estado_fisico,
	pro.estado_prestamo AS estado_prestamo,procpu.observaciones AS nota_equipo,ubipro.referencia AS referencia
	FROM producto pro
	 LEFT JOIN producto_cpu procpu
	 ON pro.id=procpu.idproducto
	 LEFT JOIN tipo_procesador tipopro
	 ON procpu.procesador=tipopro.id
	 INNER  JOIN modelo mo
	 ON pro.idmodelo=mo.id
	 INNER JOIN estado est
	 ON pro.idestado=est.id
	 INNER JOIN categoria cat
	 ON mo.idcategoria=cat.id
	 INNER JOIN marca mar
	 ON mo.idmarca=mar.id
	 LEFT JOIN  ubicacion_productos ubipro
	 ON ubipro.id_producto=pro.id
	 LEFT JOIN tipo_sistema_operativo tso
	 ON procpu.sistema_operativo=tso.id
	 WHERE ubi.descripcion LIKE :searchTerm 
		);
		$stmt->bindValue(":searchTerm", '%' . $searchTerm . '%', PDO::PARAM_STR);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}
	*/
}
