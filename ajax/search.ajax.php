<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
$posicion = isset($_POST['posicion']) ? $_POST['posicion'] : '';


$results = ControladorProductos::search($searchTerm,$posicion);

echo json_encode($results);
?>
