<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class AjaxProductos{

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/	

	public $idProducto;


	

	public function ajaxMostrarProducto(){
		$valor = $this->idProducto;
		$respuesta = ControladorProductos::ctrMostrarProductosDetalleXid($valor);
		echo json_encode($respuesta);

	}
}


 /*=============================================
MOSTRAR PRODUCTO
=============================================*/	
if(isset($_POST["idProducto"])){

	$producto = new AjaxProductos();
	$producto -> idProducto = $_POST["idProducto"];
	$producto -> ajaxMostrarProducto();
}

