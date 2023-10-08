<?php

require_once "../../controladores/prestamos.controlador.php";
require_once "../../modelos/prestamos.modelo.php";

require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";

$prestamo = new ControladorPrestamos();
$prestamo -> ctrDescargarReporte();