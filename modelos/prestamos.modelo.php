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
	MOSTRAR INSTALACIONES POR TECNICO
	=============================================*/

	static public function mdlMostrarInstalacionesTecnicos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT inst.id_prestamo,inst.id_instalacion_tecnico AS id_instalacion,UPPER(concat(emp1.nombres,' ',emp1.ape_pat,' ',emp1.ape_mat))AS tecnico_uno,UPPER(concat(emp2.nombres,' ',emp2.ape_pat,' ',emp2.ape_mat))AS tecnico_dos,UPPER(pres.codigo_cliente) as cod_cliente,UPPER(pres.nombre_cliente) as nombre_cliente,pres.documento_cliente
			FROM instalacion_tecnico inst
			INNER JOIN prestamo pres
			ON inst.id_prestamo=pres.id
			INNER JOIN empleado as emp1
			ON emp1.idempleado=inst.tecnico_uno
			LEFT JOIN empleado as emp2
			ON emp2.idempleado=inst.tecnico_dos WHERE $item = :$item ORDER BY id_instalacion ASC");
			
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

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

		 
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idusuario,codigo_prestamo,productos,productos_lotes,idempleado,observacion_prestamo,estado_prestamo,tipo_servicio,equipo_reserva,creado_por,codigo_cliente,comentario_asignado,nombre_cliente,documento_cliente) VALUES (:idusuario,:codigo_prestamo,:productos,:productos_lotes,:idempleado,:observacion_prestamo,:estado_prestamo,:tipo_servicio,:equipo_reserva,:creado_por,:codigo_cliente,:comentario_asignado,:nombre_cliente,:documento_cliente)");

		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_prestamo", $datos["codigo_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":productos_lotes", $datos["productos_lotes"], PDO::PARAM_STR);
		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion_prestamo", $datos["observacion_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_prestamo", $datos["estado_prestamo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_servicio", $datos["tipo_servicio"], PDO::PARAM_STR);
		$stmt->bindParam(":equipo_reserva",$datos["equipo_reserva"], PDO::PARAM_BOOL);
		$stmt->bindParam(":creado_por", $datos["creado_por"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_cliente", $datos["codigo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario_asignado", $datos["comentario_asignado"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":documento_cliente", $datos["documento_cliente"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	}

	/*=============================================
	REGISTRO DE INSTALACIONES POR TECNICO
	=============================================*/

	static public function mdlIngresarInstalacionTecnico($tabla, $datos){

		 
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_prestamo,tecnico_uno,tecnico_dos,agregado_por) VALUES (:id_prestamo,:tecnico_uno,:tecnico_dos,:agregado_por)");

		$stmt->bindParam(":id_prestamo", $datos["id_prestamo"], PDO::PARAM_INT);
		$stmt->bindParam(":tecnico_uno", $datos["tecnico_uno"], PDO::PARAM_STR);
		$stmt->bindParam(":tecnico_dos", $datos["tecnico_dos"], PDO::PARAM_STR);
		$stmt->bindParam(":agregado_por", $datos["agregado_por"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	}

	/*=============================================
	EDITAR PRESTAMO
	=============================================*/

	static public function mdlEditarPrestamo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idusuario=:idusuario,codigo_prestamo=:codigo_prestamo,productos=:productos,productos_lotes=:productos_lotes,idempleado=:idempleado,observacion_prestamo=:observacion_prestamo,estado_prestamo=:estado_prestamo,observacion_devolucion=:observacion_devolucion,fecha_devolucion=:fecha_devolucion,actualizado_por=:actualizado_por,fecha_actualizacion=:fecha_actualizacion,codigo_cliente=:codigo_cliente,comentario_asignado=:comentario_asignado,tipo_servicio=:tipo_servicio,equipo_reserva=:equipo_reserva,nombre_cliente=:nombre_cliente,documento_cliente=:documento_cliente WHERE id=:id_prestamo");

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
		$stmt->bindParam(":equipo_reserva", $datos["equipo_reserva"], PDO::PARAM_BOOL);
		$stmt->bindParam(":fecha_devolucion", $datos["fecha_devolucion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_cliente", $datos["codigo_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario_asignado", $datos["comentario_asignado"], PDO::PARAM_STR);
		$stmt->bindParam(":actualizado_por", $datos["actualizado_por"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_actualizacion", $datos["fecha_actualizacion"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":documento_cliente", $datos["documento_cliente"], PDO::PARAM_STR);
		
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

	static public function mdlRangoFechasPrestamos($fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT pre.id,usu.nombre AS usuario,concat(emp.nombres,' ',emp.ape_pat,' ',emp.ape_mat)AS empleado,emp.idempleado,emp.num_documento AS dni_empleado,
			pre.codigo_prestamo AS codigo_prestamo,pre.tipo_servicio,pre.equipo_reserva,pre.productos,pre.productos_lotes,pre.fecha_prestamo,pre.fecha_devolucion,
			pre.observacion_prestamo,pre.observacion_devolucion,pre.codigo_cliente,pre.estado_prestamo,pre.nombre_cliente,pre.documento_cliente
				FROM prestamo pre
			 INNER JOIN usuarios usu
			 ON pre.idusuario=usu.id
			 INNER JOIN empleado emp
			 ON pre.idempleado=emp.idempleado
			 ORDER BY pre.id desc");
			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT pre.id,usu.nombre AS usuario,concat(emp.nombres,' ',emp.ape_pat,' ',emp.ape_mat)AS empleado,emp.idempleado,emp.num_documento AS dni_empleado,
			pre.codigo_prestamo AS codigo_prestamo,pre.tipo_servicio,pre.equipo_reserva,pre.productos,pre.productos_lotes,pre.fecha_prestamo,pre.fecha_devolucion,
			pre.observacion_prestamo,pre.observacion_devolucion,pre.codigo_cliente,pre.estado_prestamo,pre.nombre_cliente,pre.documento_cliente
				FROM prestamo pre
			 INNER JOIN usuarios usu
			 ON pre.idusuario=usu.id
			 INNER JOIN empleado emp
			 ON pre.idempleado=emp.idempleado
			 WHERE pre.fecha_prestamo =:fecha_prestamo
			 ORDER BY pre.id desc");

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

				$stmt = Conexion::conectar()->prepare("SELECT pre.id,usu.nombre AS usuario,concat(emp.nombres,' ',emp.ape_pat,' ',emp.ape_mat)AS empleado,emp.idempleado,emp.num_documento AS dni_empleado,
				pre.codigo_prestamo AS codigo_prestamo,pre.tipo_servicio,pre.equipo_reserva,pre.productos,pre.productos_lotes,pre.fecha_prestamo,pre.fecha_devolucion,
				pre.observacion_prestamo,pre.observacion_devolucion,pre.codigo_cliente,pre.estado_prestamo,pre.nombre_cliente,pre.documento_cliente
					FROM prestamo pre
				 INNER JOIN usuarios usu
				 ON pre.idusuario=usu.id
				 INNER JOIN empleado emp
				 ON pre.idempleado=emp.idempleado
				WHERE pre.fecha_prestamo BETWEEN :fechaInicial AND :fechaFinal
				ORDER BY pre.id desc");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT pre.id,usu.nombre AS usuario,concat(emp.nombres,' ',emp.ape_pat,' ',emp.ape_mat)AS empleado,emp.idempleado,emp.num_documento AS dni_empleado,
				pre.codigo_prestamo AS codigo_prestamo,pre.tipo_servicio,pre.equipo_reserva,pre.productos,pre.productos_lotes,pre.fecha_prestamo,pre.fecha_devolucion,
				pre.observacion_prestamo,pre.observacion_devolucion,pre.codigo_cliente,pre.estado_prestamo,pre.nombre_cliente,pre.documento_cliente
					FROM prestamo pre
				 INNER JOIN usuarios usu
				 ON pre.idusuario=usu.id
				 INNER JOIN empleado emp
				 ON pre.idempleado=emp.idempleado
				WHERE pre.fecha_prestamo BETWEEN :fechaInicial AND :fechaFinal
				ORDER BY pre.id desc");

			}
			$stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
       		 $stmt->bindParam(":fechaFinal", $fechaFinalMasUno, PDO::PARAM_STR);
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	
	

	
}