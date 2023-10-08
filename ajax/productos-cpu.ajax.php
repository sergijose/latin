<?php


require_once "../controladores/productos-cpu.controlador.php";
require_once "../modelos/productos-cpu.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";



class AjaxProductosCpu{

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/	

	public $idProducto;
	public $traerProductosCpu;
	public $codigoProductoCpu;
	public $validarCodigo;


	public function ajaxValidarCodigoProductoCpu(){

		$item = "idproducto" ;
		$valor = $this->validarCodigo;

		$respuestacodigo = ControladorProductosCpu::ctrMostrarProductosRepetidosCpu($item, $valor);

		echo json_encode($respuestacodigo);

	}

	

	public function ajaxEditarProductoCpu(){

		if($this->traerProductosCpu == "ok"){

			$item = null;
			$valor = null;
			$orden = "id";
	  
			$respuesta = ControladorProductosCpu::ctrMostrarProductosCpu($item, $valor,
			  $orden);
	  
			echo json_encode($respuesta);
	  
	  
		  }else if($this->codigoProductoCpu != ""){

			$item ="cod_producto";
			$valor = $this->codigoProductoCpu;
			$orden = "id";
	  
			$respuesta = ControladorProductosCpu::ctrMostrarProductosCpu($item, $valor,
			  $orden);
	  
			echo json_encode($respuesta);
	  
		  }
		  
		 
		  else {

		$item = "id";
		$valor = $this->idProducto;
        $orden = "id";
		$respuesta = ControladorProductosCpu::ctrMostrarProductosCpu($item, $valor,$orden);

		echo json_encode($respuesta);

		  }

		

	}
}

/*=============================================
EDITAR PRODUCTO CPU
=============================================*/	
if(isset($_POST["idProductoCpu"])){

	$idProducto = new AjaxProductosCpu();
	$idProducto -> idProducto = $_POST["idProductoCpu"];
	$idProducto -> ajaxEditarProductoCpu();
}
/*=============================================
TRAER PRODUCTO
=============================================*/ 

if(isset($_POST["traerProductos"])){

	$traerProductos = new AjaxProductosCpu();
	$traerProductos -> traerProductos = $_POST["traerProductos"];
	$traerProductos -> ajaxEditarProductoCpu();
  
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

	$valiProducto = new AjaxProductosCpu();
	$valiProducto -> validarCodigo = $_POST["validarCodigo"];
	$valiProducto -> ajaxValidarCodigoProductoCpu();

}
 