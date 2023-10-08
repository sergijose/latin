<?php

require_once "../controladores/prestamos.controlador.php";
require_once "../modelos/prestamos.modelo.php";

class AjaxEditarPrestamos{

	/*=============================================
	EDITAR Marca
	=============================================*/	

	public $idPrestamo;

	public function ajaxEditarPrestamo(){

		$item = "id";
		$valor = $this->idPrestamo;

		$respuesta = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR MARCA
=============================================*/	
if(isset($_POST["idPrestamo"])){

	$marca = new AjaxEditarPrestamos();
	$marca -> idPrestamo = $_POST["idPrestamo"];
	$marca -> ajaxEditarPrestamo();
}
