<?php

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

class AjaxEmpleado{

	/*=============================================
	EDITAR ENPLEADO
	=============================================*/	

	public $idEmpleado;

	public function ajaxEditarEmpleado(){

		$item = "idempleado";
		$valor = $this->idEmpleado;

		$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

		echo json_encode($respuesta);


	}

	public $validarEmpleado;

	public function ajaxValidarEmpleado(){

		$item = "num_documento";
		$valor = $this->validarEmpleado;

		$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR EMPLEADO
=============================================*/	

if(isset($_POST["idEmpleado"])){

	$empleado = new AjaxEmpleado();
	$empleado -> idEmpleado = $_POST["idEmpleado"];
	$empleado -> ajaxEditarEmpleado();

}

/*=============================================
VALIDAR NO REPETIR ELIMINAR
=============================================*/

if(isset( $_POST["validarEmpleado"])){

	$valEmpleado = new AjaxEmpleado();
	$valEmpleado -> validarEmpleado = $_POST["validarEmpleado"];
	$valEmpleado -> ajaxValidarEmpleado();

}