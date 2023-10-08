<?php


require_once "../controladores/productos-ubicacion.controlador.php";
require_once "../modelos/productos-ubicacion.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";



class AjaxProductosUbicacion{

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/	

	public $idProducto;
	public $traerProductosUbicacion;
	public $codigoProductosUbicacion;
	public $validarCodigo;


	public function ajaxValidarCodigoProductoUbicacion(){

		$item = "id_producto" ;
		$valor = $this->validarCodigo;

		$respuestacodigo = ControladorProductoUbicacion::ctrMostrarProductoUbicacion($item, $valor);

		echo json_encode($respuestacodigo);

	}

	

	public function ajaxEditarProductoUbicacion(){

		if($this->traerProductosUbicacion == "ok"){

			$item = null;
			$valor = null;
			
	  
			$respuesta = ControladorProductoUbicacion::ctrMostrarProductoUbicacion($item, $valor);
	  
			echo json_encode($respuesta);
	  
	  
		  }
		  
		 
		  else {

		$item = "id";
		$valor = $this->idProducto;
      
        $respuesta = ControladorProductoUbicacion::ctrMostrarProductoUbicacion($item, $valor);

		echo json_encode($respuesta);

		  }

		

	}
}

/*=============================================
EDITAR PRODUCTO CPU
=============================================*/	
if(isset($_POST["idProducto"])){

	$idProducto = new AjaxProductosUbicacion();
	$idProducto -> idProducto = $_POST["idProducto"];
	$idProducto -> ajaxEditarProductoUbicacion();
}


  /*=============================================
TRAER PRODUCTO
=============================================*/ 

if(isset($_POST["codigoProducto"])){

	$traerProductos = new AjaxProductosCpu();
	$traerProductos -> codigoProducto = $_POST["codigoProducto"];
	$traerProductos -> ajaxEditarProductoCpu();
  
  }
   /*=============================================
TRAER CODIGO PRODUCTO = PARA VALIDAR NO REGISTRAR VARIAS VECES UN PRODUCTO CPU
=============================================*/ 

  if(isset( $_POST["validarCodigo"])){

	$validarProducto = new AjaxProductosUbicacion();
	$validarProducto -> validarCodigo = $_POST["validarCodigo"];
	$validarProducto -> ajaxValidarCodigoProductoUbicacion();

}
 