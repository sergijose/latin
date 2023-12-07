<?php
require_once "../../../controladores/pedidos.controlador.php";
require_once "../../../modelos/pedidos.modelo.php";

require_once "../../../controladores/empleados.controlador.php";
require_once "../../../modelos/empleados.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/prestamos.controlador.php";
require_once "../../../modelos/prestamos.modelo.php"
;
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/modelos.controlador.php";
require_once "../../../modelos/modelos.modelo.php";

require_once "../../../controladores/categorias.controlador.php";
require_once "../../../modelos/categorias.modelo.php";

require_once "../../../controladores/marcas.controlador.php";
require_once "../../../modelos/marcas.modelo.php";
require_once("phpqrcode/qrlib.php");



class imprimirTicket{

public $id;

public function traerImpresionPrestamo(){ // Funcion par Impresion de Datos

	ob_start();
	set_time_limit(250);
	ini_set("memory_limit", "256M");
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemPrestamo = "id";
$valorPrestamo = $this->id;
//PARA QR
$text_qr = $this->id; 
$ruta_qr = "./images/qr/ticket-".$text_qr.'.png';

//Recorremos la tabla de ventas para sacar la informacion
//$respuestaLotes = ControladorPedidos::ctrMostrarPedido($itemVenta, $codigoPedido,"ASC");
$respuestaPrestamo = ControladorPrestamos::ctrMostrarPrestamos($itemPrestamo, $valorPrestamo,"ASC");
$codigoPrestamo = $respuestaPrestamo["codigo_prestamo"];
//Sacamos la fecha de la venta
// Le asignamos el siguiente formato a la fecha: dia/mes/año
$fecha = substr($respuestaPrestamo["fecha_prestamo"],0,10);
//$fecha = substr($respuestaPrestamo["fecha_prestamo"],0,-8);
//Decodificamos el JSON productos que se grabó en la tabla ventas
$productosLotes = json_decode($respuestaPrestamo["productos_lotes"], true);
$productosPrestamos = json_decode($respuestaPrestamo["productos"], true);

//Sacamos los datos que queremos mostrar 
//$neto = number_format($respuestaVenta[0]["neto"],2);
//$impuesto = number_format($respuestaVenta[0]["impuesto"],2);
//$pagado = number_format($respuestaVenta[0]["pagocon"],2);
//$devuelto = number_format($respuestaVenta[0]["vuelto"],2);
//$total = number_format($respuestaVenta[0]["total"],2);
//$metodopago = $respuestaVenta[0]["metodo_pago"];
//$codigotransaccion = $respuestaVenta[0]["codigoTransaccion"];


//TRAEMOS LA INFORMACIÓN DEL CLIENTE
$itemEmpleado = "idempleado";
$valorEmpleado = $respuestaPrestamo["idempleado"];

$respuestaEmpleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
$itemVendedor = "id";
$valorVendedor = $respuestaPrestamo["idusuario"];
$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);


//TRAEMOS EL AREA
/*
$itemArea = "id";
$valorArea = $respuestaPrestamos["id_area"];
$respuestaArea = ControladorPedidos::ctrMostrarArea($itemArea,$valorArea);
*/

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$medidas = array(80, 217); // Ajustar aqui segun los milimetros necesarios;
$pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false); // En el objeto PDF colocamos los valores

$pdf->setPrintHeader(false); // Para que no exista Cabecera
$pdf->setPrintFooter(false); // Para que no exista Pie de Pagina

$pdf->AddPage(); // Añadimos la pagina en PDF
$pdf->SetXY(7, 12); // el numero 2 representa el tamaño de la letra
//---------------------------------------------------------
$bloque1 = <<<EOF

<img src="images/logo-prueba.png">
<table style="font-size:8px; text-align:left">
	<tr>
	<td>
	<strong style="text-align:center;font-size:8px">ENTREGA DE PEDIDOS</strong>		
	</td>
	</tr>
	<br>

	<tr>
	<td style="width:40px;"><b>Ruc:</b></td>
	<td style="width:100px;">999999999999</td>
	</tr>
	
	<tr>
	<td style="width:40px;"><b>Celular:</b></td>
	<td style="width:100px;">########</td>
	</tr>


	<tr>
	<td style="width:40px;"><b>Dir:</b></td>
	<td style="width:100px;">#########</td>
	</tr>


	<tr>
	<td style="width:40px;"><b>Ticket:</b></td>
	<td style="width:40px;">$codigoPrestamo</td>
	<td style="width:40px;"><b>Fecha:</b></td>
	<td style="width:50px;">$fecha</td>
	</tr>
	<br>

	<tr>
	<div style="font-size:7px; text-align:left;">
	<b>DATOS DEL SOLICITANTE</b>
	</div>
	</tr>

	<br>

	<tr>
	<td style="width:40px;"><b>Nombre:</b></td>
	<td style="width:100px;">$respuestaEmpleado[nombres] $respuestaEmpleado[ape_pat] $respuestaEmpleado[ape_mat]</td>
	</tr>

	<tr>
	<td style="width:40px;"><b>DNI:</b></td>
	<td style="width:100px;">$respuestaEmpleado[num_documento]</td>
	</tr>
</table>

<div  style="text-align:center;font-size:7px;">*******************************************************</div>

<tr>
<b style="font-size:7px; text-align:left;padding:0px">LISTA DE PRODUCTOS</b>
</tr>

<br>
<table style="font-size:7px; text-align:left">
	<tr style="text-align:left; font-weight: bold">
	<td style="width:30px; text-align:center">CAT.</td>
		<td style="width:30px; text-align:center">MOD.</td>
		<td style="width:40px; text-align:center">MAR.</td>
		<td style="width:80px; text-align:center">COD.</td>
		
	</tr>
</table>


EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
// Aca colocamos losdatos de la tabla de arriba CANT DETALLE P.U y TOTAL

foreach ($productosLotes as $key2 => $value2) {	
	$cantidad .="CANT:"." ".$value2["cantidad"]." DESC: ".strtoupper($value2["descripcion"]).'<br>';
}

foreach ($productosPrestamos as $key => $item) {

	


	//TRAEMOS LA INFORMACIÓN DEL PRODUCTO
	$itemProducto = "id";
	$valorProducto = $item["id"];
	$orden = null;
	
	$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

//TRAEMOS LA INFORMACIÓN DEL MODELO
$itemModelo = "id";
$valorModelo = $respuestaProducto["idmodelo"];

$respuestaModelo = ControladorModelos::ctrMostrarModelo($itemModelo, $valorModelo);
$nombreModelo=strtoupper($respuestaModelo["descripcion"]);

//TRAEMOS LA INFORMACIÓN DE LA CATEGORIA
$itemCategoria = "id";
$valorCategoria = $respuestaModelo["idcategoria"];

$respuestaCategoria = ControladorCategorias::ctrMostrarCategorias($itemCategoria, $valorCategoria);
$nombreCategoria=strtoupper($respuestaCategoria["descripcion"]);

//TRAEMOS LA INFORMACIÓN DE LA MARCA
$itemMarca = "id";
$valorMarca = $respuestaModelo["idmarca"];

$respuestaMarca = ControladorMarcas::ctrMostrarMarca($itemMarca, $valorMarca);
$nombreMarca=strtoupper($respuestaMarca["descripcion"]);
$valorQr=$item1["cantidad"]." ". $item1["descripcion"]."\n";
$listaPedido.=$valorQr;

$bloque2 = <<<EOF
<table id="valoresProducto" style="font-size:8px;">
	<tr style="text-align:center;">

		<td style="width:30px">$nombreCategoria</td>
		<td style="width:30px">$nombreModelo</td>
		<td style="width:40px">$nombreMarca</td>
		<td style="width:80px">$respuestaProducto[cod_producto] S/N $respuestaProducto[num_serie]</td>
	</tr>

	
	
</table>

EOF;

//OCULTAMOS LA LISTA DE PRODCUTOS PARA QUE NO APAREZCA EN EL TICKET PARA
//UTILIZAR EL DODIGO QR
$pdf->writeHTML($bloque2, false, false, false, false, '');
}

// ---------------------------------------------------------
$bloque3 = <<<EOF
<div  style="text-align:center;font-size:7px;">*******************************************************</div>
<table style="font-size:7px; text-align:right; padding-right: 5px">
<tr style="text-align:left;font-weight: bold">
<td style="width:200px">$cantidad</td>
</tr>
<br>
<br>
<br>
<br>

<tr>
<td style="width:40px;"></td>
<td style="width:100px;">---------------------------------------</td>
</tr>


<tr>
<td style="width:40px;"></td>


<td style="width:100px;"><b>FIRMA DE CONFORMIDAD</b></td>

</tr>

<tr>
<td style="width:30px;"></td>
<td style="width:100px;"><b>Solicitud atendida</b></td>
</tr>

</table>
<div  style="text-align:center;font-size:7px;">**********************************************************</div>

EOF;


//$pdf->SetXY(7, 30);
$pdf->writeHTML($bloque3, false, false, false, false, '');

//CREACION DE CODIGO QR Y GUARDAR EN IMAGEN
QRcode::png($listaPedido, $ruta_qr, 'Q',15, 0);
$pdf->Image($ruta_qr, 28 , $pdf->GetY(),25,25);
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
//$pdf->Output('factura.pdf', 'D');
ob_end_clean();

$pdf->Output('factura.pdf');
}
}

$factura = new imprimirTicket();
$factura -> id = $_GET["id"];
$factura -> traerImpresionPrestamo();
?>