<?php

require_once "conexion.php";

class ModeloPrestamos{

	/*=============================================
	MOSTRAR PRESTAMO
	=============================================*/

	static public function mdlMostrarPrestamos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
	
		$stmt = null;

	}

	/*=============================================
	MOSTRAR PRESTAMO PENDIENTES POR EMPLEADO
	=============================================*/

	static public function mdlMostrarPrestamosPendiente($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item ORDER BY idempleado ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
	
		$stmt = null;

	}

	/*=============================================
	REGISTRO DE PRESTAMO
	=============================================*/

	static public function mdlIngresarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idusuario,codigo_prestamo,productos,productos_lotes,idempleado,observacion_prestamo,estado_prestamo,tipo_servicio,creado_por,codigo_cliente,comentario_asignado) VALUES (:idusuario,:codigo_prestamo,:productos,:productos_lotes,:idempleado,:observacion_prestamo,:estado_prestamo,:tipo_servicio,:creado_por,:codigo_cliente,:comentario_asignado)");

		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_prestamo", $datos["codigo_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":productos_lotes", $datos["productos_lotes"], PDO::PARAM_STR);
		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion_prestamo", $datos["observacion_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_servicio", $datos["tipo_servicio"], PDO::PARAM_STR);
		$stmt->bindParam(":creado_por", $datos["creado_por"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_cliente", $datos["codigo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario_asignado", $datos["comentario_asignado"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	static public function mdlEditarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idusuario=:idusuario,codigo_prestamo=:codigo_prestamo,productos=:productos,productos_lotes=:productos_lotes,idempleado=:idempleado,observacion_prestamo=:observacion_prestamo,estado_prestamo=:estado_prestamo,observacion_devolucion=:observacion_devolucion,fecha_devolucion=:fecha_devolucion,actualizado_por=:actualizado_por,fecha_actualizacion=:fecha_actualizacion,codigo_cliente=:codigo_cliente,comentario_asignado=:comentario_asignado,tipo_servicio=:tipo_servicio WHERE id=:id_prestamo");

		$stmt->bindParam(":id_prestamo", $datos["id_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_prestamo", $datos["codigo_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":productos_lotes", $datos["productos_lotes"], PDO::PARAM_STR);
		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion_prestamo", $datos["observacion_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion_devolucion", $datos["observacion_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_servicio", $datos["tipo_servicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_devolucion", $datos["fecha_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_cliente", $datos["codigo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario_asignado", $datos["comentario_asignado"], PDO::PARAM_STR);
		$stmt->bindParam(":actualizado_por", $datos["actualizado_por"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_actualizacion", $datos["fecha_actualizacion"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	static public function mdlFinalizarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_devolucion=:fecha_devolucion,observacion_devolucion=:observacion_devolucion,estado_prestamo=:estado_prestamo,finalizado_por=:finalizado_por	WHERE id=:id_prestamo");

		$stmt->bindParam(":id_prestamo", $datos["id_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_devolucion", $datos["fecha_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion_devolucion", $datos["observacion_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":finalizado_por", $datos["finalizado_por"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}


	static public function mdlAsignarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo_cliente=:codigo_cliente,comentario_asignado=:comentario_asignado,estado_prestamo=:estado_prestamo,asignado_por=:asignado_por,fecha_asignado=:fecha_asignado	WHERE id=:id_prestamo");

		$stmt->bindParam(":id_prestamo", $datos["id_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_cliente", $datos["codigo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario_asignado", $datos["comentario_asignado"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":asignado_por", $datos["asignado_por"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_asignado", $datos["fecha_asignado"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}
	/*=============================================
	ELIMINAR PRESTAMO
	=============================================*/

	static public function mdlEliminarPrestamos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt = null;

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasPrestamos($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_prestamo like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha_prestamo", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_prestamo BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_prestamo BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	
	

	
}