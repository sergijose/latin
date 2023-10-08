<?php

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";

class AjaxEstado{

	/*=============================================
	EDITAR ESTADO
	=============================================*/	

	public $idEstado;

	public function ajaxEditarEstado(){

		$item = "id";
		$valor = $this->idEstado;

		$respuesta = ControladorMarcas::ctrMostrarEstadoProducto($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR ESTADO
=============================================*/	
if(isset($_POST["idEstado"])){

	$estados = new AjaxEstado();
	$estados -> idEstado = $_POST["idEstado"];
	$estados -> ajaxEditarEstado();
}

