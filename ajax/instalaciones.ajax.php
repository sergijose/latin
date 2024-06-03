<?php

require_once "../controladores/prestamos.controlador.php";
require_once "../modelos/prestamos.modelo.php";

class AjaxEditarInstalaciones{

	/*=============================================
	EDITAR INSTALACIOENS
	=============================================*/	

	public $idPrestamo;

	public function ajaxEditarInstalaciones(){

		$item = "id_prestamo";
		$valor = $this->idPrestamo;

		$respuesta = ControladorPrestamos::ctrMostrarInstalacionesTecnicos($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
=============================================*/	
if(isset($_POST["idPrestamo"])){

	$marca = new AjaxEditarInstalaciones();
	$marca -> idPrestamo = $_POST["idPrestamo"];
	$marca -> ajaxEditarInstalaciones();
}
