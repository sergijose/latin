<?php
require_once "../../../controladores/pedidos.controlador.php";
require_once "../../../modelos/pedidos.modelo.php";

require_once "../../../controladores/empleados.controlador.php";
require_once "../../../modelos/empleados.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos-lotes.controlador.php";
require_once "../../../modelos/productos-lotes.modelo.php";
require_once("phpqrcode/qrlib.php");



class imprimirTicket{

public $codigo;

public function traerImpresionTicket(){ // Funcion par Impresion de Datos

	ob_start();
	set_time_limit(250);
	ini_set("memory_limit", "256M");
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemVenta = "codigo";
$codigoPedido = $this->codigo;
//PARA QR
$text_qr = $this->codigo; 
$ruta_qr = "./images/qr/ticket-".$text_qr.'.png';

//Recorremos la tabla de ventas para sacar la informacion
$respuestaVenta = ControladorPedidos::ctrMostrarPedido($itemVenta, $codigoPedido,"ASC");
//Sacamos la fecha de la venta
// Le asignamos el siguiente formato a la fecha: dia/mes/año
//$fecha = date('d/m/Y',strtotime(substr($respuestaVenta[0]["fecha_registro"],0,-8)));
$fecha = substr($respuestaVenta["fecha_registro"],0,-8);
//Decodificamos el JSON productos que se grabó en la tabla ventas
$productos = json_decode($respuestaVenta["productos"], true);

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
$valorEmpleado = $respuestaVenta["id_empleado"];

$respuestaEmpleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_usuario"];
$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//TRAEMOS EL AREA
$itemArea = "id";
$valorArea = $respuestaVenta["id_area"];
$respuestaArea = ControladorPedidos::ctrMostrarArea($itemArea,$valorArea);




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

<img src="images/logo-prueba.png"  >
<table style="font-size:8px; text-align:left;">
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
	<td style="width:50px;">#########</td>
	</tr>


	<tr>
	<td style="width:40px;"><b>Ticket:</b></td>
	<td style="width:50px;">$codigoPedido</td>
	<td style="width:40px;"><b>Fecha:</b></td>
	<td style="width:50px;">$fecha</td>
	</tr>
	<br>

	<tr>
	<div style="font-size:8px; text-align:left;">
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
	
	<tr>
	<td style="width:40px;"><b>Area:</b></td>
	<td style="width:100px;">$respuestaArea[descripcion]</td>
	</tr>

	

</table>

<div  style="text-align:center;font-size:10px">**************************************</div>
<b style="font-size:7.5px; text-align:left">LISTA DE PRODUCTOS</b>
<br>
<table style="font-size:6.5px; text-align:left">
	<tr style="text-align:left; font-weight: bold">
		<td style="width:40px;">CANTIDAD</td>
		<td style="width:75px;">PRODUCTO</td>
		
	</tr>
</table>

EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
// Aca colocamos losdatos de la tabla de arriba CANT DETALLE P.U y TOTAL
foreach ($productos as $key => $item) {
$valorQr=$item["cantidad"]." ". $item["descripcion"]."\n";
$listaPedido.=$valorQr;

$bloque2 = <<<EOF
<table id="valoresProducto" style="font-size:10px;">
	<tr style="text-align:left;">
		<td style="width:40px;text-align: center;">$item[cantidad]</td>
		<td style="width:75px;">$item[descripcion]</td>
		
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
<table style="font-size:6.5px; text-align:right; padding-right: 5px;align:center">
<br>
<br>
<br>
<br>

<tr>
<td style="width:30px;"></td>
<td style="width:100px;">---------------------------------------</td>
</tr>


<tr>
<td style="width:30px;"></td>


<td style="width:100px;"><b>FIRMA DE CONFORMIDAD</b></td>

</tr>

<tr>
<td style="width:16px;"></td>
<td style="width:100px;"><b>Solicitud atendida</b></td>
</tr>

</table>
<div  style="text-align:center;font-size:7px;">*************************************************************</div>

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
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionTicket();
?>