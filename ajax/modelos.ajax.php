<?php

require_once "../controladores/modelos.controlador.php";
require_once "../modelos/modelos.modelo.php";

class AjaxModelos{

	/*=============================================
	EDITAR MODELOS
	=============================================*/	

	public $idModelo;

	public function ajaxEditarModelo(){

		$item = "id";
		$valor = $this->idModelo;

		$respuesta = ControladorModelos::ctrMostrarModelo($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR MODELO
=============================================*/	
if(isset($_POST["idModelo"])){

	$categoria = new AjaxModelos();
	$categoria -> idModelo = $_POST["idModelo"];
	$categoria -> ajaxEditarModelo();
}


