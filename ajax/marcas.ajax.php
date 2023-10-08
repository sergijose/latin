<?php

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";

class AjaxMarcas{

	/*=============================================
	EDITAR Marca
	=============================================*/	

	public $idMarca;

	public function ajaxEditarMarca(){

		$item = "id";
		$valor = $this->idMarca;

		$respuesta = ControladorMarcas::ctrMostrarMarca($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR MARCA
=============================================*/	
if(isset($_POST["idMarca"])){

	$marca = new AjaxMarcas();
	$marca -> idMarca = $_POST["idMarca"];
	$marca -> ajaxEditarMarca();
}
