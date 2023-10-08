<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Sistema de Prestamo</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/logo-07.jpg">
  <!-- Barcode-->
  <script src="vistas/plugins/barcode/JsBarcode.all.min.js"></script>


  <!--=====================================
  PLUGINS DE CSS
  ======================================-->



  <!-- Alertify  css-->
  <link rel="stylesheet" href="vistas/plugins/alertifyjs/css/alertify.css">
  <link rel="stylesheet" href="vistas/plugins/alertifyjs/css/themes/default.css">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <!--<link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">

  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">


  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">


  <!-- select 2 -->
  <link rel="stylesheet" href="vistas/bower_components/select2/dist/css/select2.min.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->


  <!-- Alertify  js-->
  <script src="vistas/plugins/alertifyjs/alertify.js"></script>
  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>

  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>

  <!-- Barcode-->
  <script src="vistas/plugins/barcode/JsBarcode.all.min.js"></script>

  <!-- Select 2 -->
  <script src="vistas/bower_components/select2/dist/js/select2.full.js"></script>

  <!-- MASCARA IP -->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/inputmask/dist/jquery.inputmask.bundle.js"></script>


  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/chart.js/Chart.js"></script>

  

</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page skin-green-light">

  <?php

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

    echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "modulos/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if (isset($_GET["ruta"])) {

      if (
        $_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "categorias" ||
        $_GET["ruta"] == "proveedores" ||
        $_GET["ruta"] == "productos" ||
        $_GET["ruta"] == "productos-cpu" ||
        $_GET["ruta"] == "productos-lotes" ||
        $_GET["ruta"] == "empleados" ||
        $_GET["ruta"] == "marcas" ||
        $_GET["ruta"] == "modelo" ||
        $_GET["ruta"] == "crear-prestamo" ||
        $_GET["ruta"] == "editar-prestamo" ||
        $_GET["ruta"] == "crear-pedido" ||
        $_GET["ruta"] == "editar-pedido" ||
        $_GET["ruta"] == "crear-compra" ||
        $_GET["ruta"] == "editar-compra" ||
        $_GET["ruta"] == "compras" ||
        $_GET["ruta"] == "prestamos" ||
        $_GET["ruta"] == "pedidos" ||
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "ubicacion-productos" ||
        $_GET["ruta"] == "salir"
      ) {

        include "modulos/" . $_GET["ruta"] . ".php";
      } else {

        include "modulos/404.php";
      }
    } else {

      include "modulos/inicio.php";
    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';
  } else {

    include "modulos/login.php";
  }

  ?>


  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/categorias.js"></script>
  <script src="vistas/js/marcas.js"></script>
  <script src="vistas/js/modelo.js"></script>
  <script src="vistas/js/proveedores.js"></script>
  <script src="vistas/js/productos.js"></script>
  <script src="vistas/js/productos-cpu.js"></script>
  <script src="vistas/js/productos-lotes.js"></script>
  <script src="vistas/js/productos-ubicacion.js"></script>
  <script src="vistas/js/prestamos.js"></script>
  <script src="vistas/js/pedidos.js"></script>
  <script src="vistas/js/pedidos2.js"></script>
  <script src="vistas/js/empleados.js"></script>
  <script src="vistas/js/consultas.js"></script>
  <script src="vistas/js/compras.js"></script>
  <script src="vistas/js/compras2.js"></script>


</body>

</html>