<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/modelos.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/productos-cpu.controlador.php";
require_once "controladores/productos-lotes.controlador.php";
require_once "controladores/prestamos.controlador.php";
require_once "controladores/pedidos.controlador.php";
require_once "controladores/empleados.controlador.php";
require_once "controladores/productos-ubicacion.controlador.php";
require_once "controladores/compras.controlador.php";
require_once "controladores/contratos.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/modelos.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/productos-cpu.modelo.php";
require_once "modelos/productos-lotes.modelo.php";
require_once "modelos/prestamos.modelo.php";
require_once "modelos/pedidos.modelo.php";
require_once "modelos/empleados.modelo.php";
require_once "modelos/productos-ubicacion.modelo.php";
require_once "modelos/compras.modelo.php";
require_once "modelos/contratos.modelo.php";
$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();