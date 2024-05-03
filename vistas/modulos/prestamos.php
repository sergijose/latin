<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administracion de Instalaciones - Control de Equipos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar Prestamo</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">



      <div class="box-header with-border">
        <?php
        if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial") {

          echo '<a href="crear-prestamo">

          <button class="btn btn-primary">

            Agregar Servicio

          </button>


        </a>';
        }
        ?>

        <?php

        if (isset($_GET["fechaInicial"])) {

          echo '<a href="vistas/modulos/descargar-prestamo.php?prestamo=prestamo&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
        } else {

          echo '<a href="vistas/modulos/descargar-prestamo.php?prestamo=prestamo">';
        }

        ?>

        <button class="btn btn-success">Descargar reporte en Excel</button>

        </a>



        <button type="button" class="btn btn-default pull-right" id="daterange-btn">

          <span>
            <i class="fa fa-calendar"></i>

            <?php

            if (isset($_GET["fechaInicial"])) {

              echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
            } else {

              echo 'Rango de fecha';
            }

            ?>
          </span>

          <i class="fa fa-caret-down"></i>

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaPrestamoPrincipal" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <!--<th>Usuario</th>-->
              <th>Tecnico</th>
              <th>Cod_Cliente</th>
              <th>Tipo Servicio</th>
              <th>Productos</th>
              <th>F_Prestamo</th>
              <th>F_Devolucion</th>
              <th>observacion_prestamo</th>
              <th>observacion_devolucion</th>
              <th style="width:10px">estado</th>
              <th style="width:10px">Acciones</th>
            </tr>
          </thead>
        </table>
        <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
      </div>

    </div>


  </section>

</div>
<?php

$eliminarPrestamo = new ControladorPrestamos();
$eliminarPrestamo->ctrEliminarPrestamo();

?>

<!-- MODAL VER UBICACION DE PRODUCTO -->
<div class="modal fade" id="modalAsignarPrestamo" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form role="form" method="post" class="formularioPrestamo" id="formularioPrestamo">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalProductoLabel">Asignar Prestamo</h4>
        </div>
        <div class="modal-body">

          <input type="hidden" name="idPrestamoAsignar" id="idPrestamoAsignar" value="">
          <input type="hidden" class="form-control input-md" name="asignado_por" value="<?php echo $_SESSION["id"]; ?>" required>
        
          <div class="form-group">
            <label for="codigoCliente">Código de Cliente:</label>
            <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente">
          </div>
          <div class="form-group">
            <label for="comentario">Comentario:</label>
            <textarea class="form-control" id="comentario_asignado" name="comentario_asignado" rows="2"></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary pull-right">Asignar Prestamo</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>

        </div>

       

         
              
    </form>

    <?php

    $asignarPrestamo = new ControladorPrestamos();
    $asignarPrestamo->ctrAsignarPrestamo();

    ?>
  </div>
</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$(document).ready(function() {
	
 
 
  $('.asignarEmpleado').select2({
   width: '250px'
 
  });
 });
 
</script>