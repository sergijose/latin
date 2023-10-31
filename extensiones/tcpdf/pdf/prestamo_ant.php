<?php

require_once "../../../controladores/prestamos.controlador.php";
require_once "../../../modelos/prestamos.modelo.php";

require_once "../../../controladores/empleados.controlador.php";
require_once "../../../modelos/empleados.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/modelos.controlador.php";
require_once "../../../modelos/modelos.modelo.php";

require_once "../../../controladores/categorias.controlador.php";
require_once "../../../modelos/categorias.modelo.php";

require_once "../../../controladores/marcas.controlador.php";
require_once "../../../modelos/marcas.modelo.php";

class imprimirPrestamo{

public $id;

public function traerImpresionPrestamo(){

//TRAEMOS LA INFORMACIÓN DEL PRESTAMO

$itemPrestamo = "id";
$valorPrestamo = $this->id;
$respuestaPrestamo = ControladorPrestamos::ctrMostrarPrestamos($itemPrestamo, $valorPrestamo);
$codigoPrestamo = $respuestaPrestamo["codigo_prestamo"];
$fechaPrestamo = substr($respuestaPrestamo["fecha_prestamo"],0,-8);
$fechaDevolucion = substr($respuestaPrestamo["fecha_devolucion"],0,-8);
$observacionPrestamo = $respuestaPrestamo["observacion_prestamo"];
$observacionDevolucion = $respuestaPrestamo["observacion_devolucion"];
$estadoPrestamo = $respuestaPrestamo["estado_prestamo"];
//$empleado = $respuestaPrestamo["idempleado"];
//TRAEMOS LA INFORMACIÓN DEL USUARIO
$itemUsuario = "id";
$valorUsuario = $respuestaPrestamo["idusuario"];

$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
$nombreUsuario=strtoupper($respuestaUsuario["nombre"]);

$productos = json_decode($respuestaPrestamo["productos"], true);


//TRAEMOS LA INFORMACIÓN DEL CLIENTE
$itemEmpleado = "idempleado";
$valorEmpleado = $respuestaPrestamo["idempleado"];

$respuestaEmpleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);
$nombreEmpleado=strtoupper($respuestaEmpleado["nombres"]." ".$respuestaEmpleado["ape_pat"]." ".$respuestaEmpleado["ape_mat"]);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:90px"><img src="images/logo-geincos-actual.jpg"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					Dirección:Jr camana #780 of 611 lima lima
					

				</div>

			</td>

			<td style="background-color:white; width:100px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					soporte@geincos.com
					<br>
					Teléfono:941 524 646	
								
					
				</div>
				
			</td>

			<td style="background-color:white; width:140px; text-align:center; color:red"><br><br>PRESTAMO N.<br>$codigoPrestamo</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


// ---------------------------------------------------------


$bloque2 = <<<EOF
	<table>
		
	<tr>
		
		<td style="width:540px"><img src="images/back.jpg"></td>
	
	</tr>

</table>
	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:220px">

				Empleado:  $nombreEmpleado

			</td>
			<td style="border: 1px solid #666; background-color:white; width:150px">

				Num Documento:  $respuestaEmpleado[num_documento]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:170px; ">
			
				Fecha prestamo  :$fechaPrestamo

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:370px">Responsable Prestamo:$nombreUsuario</td>
			<td style="border: 1px solid #666; background-color:white; width:170px">Fecha devolucion:$fechaDevolucion</td>

		</tr>

		<tr>

			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

		

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');


$bloque3 = <<<EOF


		<table>
	
	<tr>
		
		<td style="width:540px">Descripcion del Producto</td>
	
	</tr>

		</table>

		<table>

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:200px; text-align:center">CATEGORIA</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">MODELO</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">MARCA</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">COD PRODUCTO</td>
		</tr>

		</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

//TRAEMOS LA INFORMACIÓN DEL PRODUCTO

foreach ($productos as $key => $item) {

	$itemProducto = "id";
	$valorProducto = $item["id"];
	$orden = null;
	
	$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);
	
	//TRAEMOS LA INFORMACION DE PRODUCTOS CPU
	$respuestaProductoCpu = ControladorProductos::ctrMostrarProductosDetalleXid($respuestaProducto["id"]);
//TRAEMOS LA INFORMACIÓN DEL MODELO
$itemModelo = "id";
$valorModelo = $respuestaProducto["idmodelo"];

$respuestaModelo = ControladorModelos::ctrMostrarModelo($itemModelo, $valorModelo);


//TRAEMOS LA INFORMACIÓN DE LA CATEGORIA
$itemCategoria = "id";
$valorCategoria = $respuestaModelo["idcategoria"];

$respuestaCategoria = ControladorCategorias::ctrMostrarCategorias($itemCategoria, $valorCategoria);
$nombreCategoria=strtoupper($respuestaCategoria["descripcion"]);

//TRAEMOS LA INFORMACIÓN DE LA MARCA
$itemMarca = "id";
$valorMarca = $respuestaModelo["idmarca"];

$respuestaMarca = ControladorMarcas::ctrMostrarMarca($itemMarca, $valorMarca);

if($respuestaCategoria["descripcion"]=="cpu" ||$respuestaCategoria["descripcion"]=="laptop" ){
	$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:200px; text-align:center">$nombreCategoria
		<b>Procesador:</b> $respuestaProductoCpu[procesador] $respuestaProductoCpu[generacion]<br>
		<b>S.O:</b>$respuestaProductoCpu[sistema_operativo] $respuestaProductoCpu[edicion_so]  
		<b>Disco:</b>$respuestaProductoCpu[tipo_disco] $respuestaProductoCpu[cantidad_disco]GB <br>
		<b>Ram:</b> $respuestaProductoCpu[tipo_ram] $respuestaProductoCpu[cant_ram]GB 
		</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">$respuestaModelo[descripcion]</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$respuestaMarca[descripcion]</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">$respuestaProducto[cod_producto]</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');
}

else{
	$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:200px; text-align:center">$nombreCategoria</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">$respuestaModelo[descripcion]</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$respuestaMarca[descripcion]</td>
		<td style="border: 1px solid #666; background-color:white; width:120px; text-align:center">$respuestaProducto[cod_producto]</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');
}


}

// ---------------------------------------------------------

$bloque5 = <<<EOF
	<table>
		
		<tr>
			
			<td style="width:540px;">Observaciones</td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">

				Inicio del Prestamo: $observacionPrestamo

			</td>
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:540px;">
			
				Final del Prestamo: $observacionDevolucion

			</td>

		</tr>
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:540px;">
		
			Estado del Prestamo: $estadoPrestamo

		</td>

	</tr>
	
	</table>
	
	

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

$bloque6 = <<<EOF

	
	<div style="font-size:12px; text-align:left;">
	<b style="font-size:10px">AVISO IMPORTANTE</b>
	<p>quien recibe los bienes de la empresa se compromete a garantizar el estado fisico de lo prestado,al momento de la devolucion,la entrega es personal y en las instalaciones de la empresa GEINCOS</p>
	<b style="font-size:10px">EVIDENCIA DE ENTREGA</b>
	</div>
	<br>
	<br>
	<br>
	<table>
	<tr>
	<td style="width:280px; text-align:center">entregado por</td>
	<td style="width:170px; text-align:center;pa-left: 30px;">recibido por</td>
	</tr>
	<tr>
	
	<td style="width:280px; text-align:center">firma y nombre completo</td>
	
	<td style="width:170px; text-align:center;pa-left: 30px;">firma y nombre completo</td>
	</tr>
	</table>
	<br>
	<br>
	<b style="font-size:10px">EVIDENCIA DE RECEPCION</b>
	<br>
	<br>
	<br>
	<br>
	<table>
	<tr>
	<td style="width:280px; text-align:center">entregado por</td>
	<td style="width:170px; text-align:center;pa-left: 30px;">recibido por</td>
	</tr>

	<tr>
	<td style="width:280px; text-align:center">firma y nombre completo</td>
	<td style="width:170px; text-align:center;pa-left: 30px;">firma y nombre completor</td>
	</tr>
	</table>
	

	
	
	
	

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');


//SALIDA DEL ARCHIVO 

$pdf->Output('prestamo.pdf', 'D');

}

}

$factura = new imprimirPrestamo();
$factura -> id = $_GET["id"];
$factura -> traerImpresionPrestamo();

?>