<?php
if ($_SESSION["perfil"] == "Visitante") {

  echo '<script>

  window.location = "inicio";

</script>';

  return;
}

?>



<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar productos

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar productos</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">

          Agregar producto

        </button>

        <!--
        <a href="productos-cpu">

           
          <button class="btn btn-primary">

            Agregar Detalle de CPU's y Laptop's <i class="fa fa-laptop" aria-hidden="true"></i>

          </button>
        </a>
-->
        <button class="btn btn-dark" id="limpiarFiltrosButton"><i class="fas fa-times-circle"></i> Eliminar Filtro</button>

        <div class="card" style="margin-top:15px;">
          <div class="card-body">
            
          <!--
            <div class="form-group row">
              <div class="col-md-3">
                <label for="categoria">Categoria</label>
                <select class="form-control input-md busquedaCategoria" id="busquedaCategoria" name="categoria">

                  <option value="">Seleccionar Categoria</option>
                  <?php

                  $item = null;
                  $valor = null;

                  $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categoria as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                  }

                  ?>

                </select>
              </div>
              <div class="col-md-3">
                <label for="marca">Marca</label>
                <select class="form-control input-md busquedaMarca" id="busquedaMarca" name="marca">

                  <option value="">Seleccionar Marca</option>
                  <?php

                  $item = null;
                  $valor = null;

                  $marca = ControladorMarcas::ctrMostrarMarca($item, $valor);

                  foreach ($marca as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                  }

                  ?>

                </select>
              </div>

            </div>
                -->
            <div class="form-group row">

              <div class="col-md-2">
                <label for="codigo">Codigo de Producto</label>
                <input type="text" id="busquedaCodigoProducto" class="form-control busquedaCodigoProducto" placeholder="Codigo Producto">
              </div>

              <div class="col-md-2">
                <label for="posicion">Numero de Serie</label>
                <input type="text" id="busquedaSerie" class="form-control busquedaSerie" placeholder="numero de serie">
              </div>

              <div class="col-md-2">
                <label for="oficina">Numero de Mac</label>
                <input type="text" id="busquedaMac" class="form-control busquedaMac" placeholder="numero de mac">
              </div>


            </div>
          </div>
        </div>



      </div>


      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Codigo</th>
              <th>Imagen</th>
              <th>Detalle Producto</th>
              <th>Estado Fisico</th>
              <th>Equipo</th>
              <th>Nota</th>
              <th>Prestamo</th>
              <th>Fecha_Registro</th>
              <th>Acciones</th>

            </tr>

          </thead>

        </table>
        <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">


      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->

<div id="modalAgregarProducto" class="modal fade" role="dialog">


  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA SELECCIONAR MODELO -->
            <div class="form-group">
              <label for="nuevoModelo">MODELO DEL PRODUCTO</label>
              <select class="form-control input-md" id="nuevoModelo" name="nuevoModelo" required>

                <option value="">Seleccionar Modelo</option>

                <?php

                $item = null;
                $valor = null;


                $modelo = ControladorModelos::ctrMostrarModelo($item, $valor);

                foreach ($modelo as $key => $value) {

                  echo '<option value="' . $value["id"] . '">' . $value["categoria"] . "| " . $value["marca"] . "| " . $value["descripcion"] . '</option>';
                }

                ?>

              </select>

            </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <label for="nuevoCodigo">CODIGO INTERNO DEL PRODUCTO</label>
              <!--<span class="input-group-addon"><i class="fa fa-code"></i></span>-->
              <input type="text" class="form-control input-md" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingrese Codigo" required>
              <input type="hidden" class="form-control input-md" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>
            </div>
            <!-- ENTRADA PARA EL NUMERO DE SERIE -->
            <div class="form-group">

              <label for="nuevoNumSerie">NUMERO DE SERIE</label>
              <input type="text" class="form-control input-md" id="nuevoNumSerie" name="nuevoNumSerie" placeholder="Ingrese numero de serie">

            </div>

            <!-- ENTRADA PARA LA MAC-->
            <div class="form-group">
              <label for="nuevaMac">NUMERO DE MAC</label>
              <input type="text" class="form-control input-md" id="nuevaMac" name="nuevaMac" placeholder="Ingrese numero de mac">

            </div>
            <!-- ENTRADA PARA EL ESTADO -->
            <div class="form-group">



              <label for="nuevoEstado">ESTADO FISICO DEL PRODUCTO</label>

              <select class="form-control input-md" id="nuevoEstado" name="nuevoEstado" required>

                <option value="">--SELECCIONAR--</option>

                <?php

                $item = null;
                $valor = null;



                $estado = ControladorProductos::ctrMostrarEstadoFisicoProducto($item, $valor);

                foreach ($estado as $key => $value) {


                  echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                }

                ?>

              </select>



            </div>

            <!-- ENTRADA PARA ESTADO DE PRESTAMO DEL PRODUCTO -->
            <div class="form-group">


              <label for="nuevoEstadoPrestamo">ESTADO DE PRESTAMO DEL PRODUCTO</label>
              <select class="form-control input-md" id="nuevoEstadoPrestamo" name="nuevoEstadoPrestamo" required>
                <option value="">--SELECCIONAR--</option>
                <option value="DISPONIBLE" selected>DISPONIBLE</option>
                <option value="OCUPADO">OCUPADO</option>
                <option value="NO APLICA">NO APLICA</option>
              </select>



            </div>

            <!-- ENTRADA PARA SITUACION ACTUAL DEL PRODUCTO -->
            <div class="form-group">
              <label for="comentario">SITUACION ACTUAL DEL PRODUCTO</label>
              <select class="form-control input-md" id="nuevaSituacionActual" name="nuevaSituacionActual" required>
                <option value="">--SELECCIONAR--</option>
                <option value="nuevo" selected>NUEVO</option>
                <option value="usado">USADO</option>

              </select>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
            <div class="form-group">
              <label for="comentario">NOTA/OBERVACION</label>
              <textarea cols="30" rows="2" class="form-control input-md" id="nuevaObservaciones" name="nuevaObservaciones" placeholder="Ingresar observaciones o notas"></textarea>

            </div>
           </div>     
       </div>
            <!--=====================================
        PIE DEL MODAL
        ======================================-->
            <div class="modal-footer">

              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

              <button type="submit" class="btn btn-primary">Guardar producto</button>

            </div>

      </form>

      <?php

      $crearProducto = new ControladorProductos();
      $crearProducto->ctrCrearProducto();

      ?>

    

  </div>

</div>
</div>


<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarProducto" class="modal fade" role="dialog">


  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA LISTA DE UBICACION-->
            <!-- ENTRADA PARA EDITAR  SELECCIONAR MODELO -->

            <div class="form-group">
            <label for="editarModelo">MODELO DEL PRODUCTO</label>
            

                <select class="form-control input-md" id="editarModelo" name="editarModelo" required>

                  <option value="">--SELECCIONAR</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $modelo = ControladorModelos::ctrMostrarModelo($item, $valor);

                  foreach ($modelo as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["categoria"] . "| " . $value["marca"] . "| " . $value["descripcion"] . '</option>';
                  }

                  ?>

                </select>

             

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->

            <div class="form-group">
            <label for="editarModelo">CODIGO INTERNO DEL PRODUCTO</label>
                <input type="text" class="form-control input-md" id="editarCodigo" name="editarCodigo" placeholder="Ingrese Codigo" required>
                <!-- oculto el id del producto para poder editar -->
                <input type="hidden" id="id" name="id" require>
                <input type="hidden" class="form-control input-md" name="actualizado_por" value="<?php echo $_SESSION["id"]; ?>" required>

            </div>
            <!-- ENTRADA PARA EL NUMERO DE SERIE -->

            <div class="form-group">
            <label for="editarNumSerie">NUMERO DE SERIE</label>
                <input type="text" class="form-control input-md" id="editarNumSerie" name="editarNumSerie" placeholder="editar numero de serie">

             

            </div>

             <!-- ENTRADA PARA EL NUMERO DE MAC -->

             <div class="form-group">
            <label for="editarMac">NUMERO DE MAC</label>
            
                <input type="text" class="form-control input-md" id="editarMac" name="editarMac" placeholder="editar numero de mac">

             

            </div>

            <!-- ENTRADA PARA EL ESTADO -->

            <div class="form-group">
            <label for="editarEstado">ESTADO FISICO DEL PRODUCTO</label>
                <select class="form-control input-md" id="editarEstado" name="editarEstado" required>

                  <option value="">--SELECCIONAR</option>

                  <?php

                  $item = null;
                  $valor = null;



                  $estado = ControladorProductos::ctrMostrarEstadoFisicoProducto($item, $valor);

                  foreach ($estado as $key => $value) {


                    echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                  }

                  ?>

                </select>

             

            </div>


            <!-- ENTRADA PARA ESTADO DE PRESTAMO DEL PRODUCTO -->

            <div class="form-group">
            <label for="editarEstadoPrestamo">ESTADO DE PRESTAMO DEL PRODUCTO</label>
                <select class="form-control input-md" id="editarEstadoPrestamo" name="editarEstadoPrestamo" required>

                  <option value="">--SELECCIONAR--</option>
                  <option value="DISPONIBLE">DISPONIBLE</option>
                  <option value="OCUPADO">OCUPADO</option>
                  <option value="NO APLICA">NO APLICA</option>
                </select>

             

            </div>

             <!-- ENTRADA PARA SITUACION ACTUAL DEL PRODUCTO -->

             <div class="form-group">
            <label for="editarSituacionActual">SITUACION ACTUAL DEL PRODUCTO</label>
                <select class="form-control input-md" id="editarSituacionActual" name="editarSituacionActual" required>

                  <option value="">--SELECCIONAR--</option>
                  <option value="nuevo">NUEVO</option>
                  <option value="usado">USADO</option>
                </select>

             

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">
            <label for="editarObservaciones">NOTA/OBSERVACION</label>
                <textarea cols="30" rows="2" class="form-control input-md" id="editarObservaciones" name="editarObservaciones" placeholder="Ingresar descripción o notas"></textarea>
                
            </div>


          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Actualizar producto</button>

        </div>

      </form>

      <?php

      $editarProducto = new ControladorProductos();
      $editarProducto->ctrEditarProducto();

      ?>

    </div>

  </div>

</div>



<!-- MODAL VER UBICACION DE PRODUCTO -->
<div class="modal fade" id="modalVerUbicacionProducto" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalProductoLabel">Ubicacion del Producto</h4>
      </div>
      <div class="modal-body">
        <!-- Contenido del modal con la información del producto -->
        <p><strong>Oficina:</strong> <span id="oficinaProducto"></span></p>
        <p><strong>Posicion:</strong><span id="posicionProducto"></p>
        <p><strong>Referencia:</strong> <span id="referenciaProducto"></p>
        <!-- Agregar más detalles del producto según tus necesidades -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Para Caracteristicas de cpu -->
<!-- Modal -->
<div class="modal fade" id="modalVerCaracteristicasCpu" tabindex="-1" role="dialog" aria-labelledby="modalCPULabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalCPULabel"> <i class="fas fa-barcode"> </i><span id="cod_producto"></span></h4>

      </div>
      <div class="modal-body">

        <div class="col-sm-12">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-memory"></i><span id="ram"></span>
            </li>
          </ul>
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-microchip"></i> <span id="procesador"></span>
            </li>
          </ul>
        </div>

        <div class="col-sm-12">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-hdd"></i> <span id="disco_duro"></span>
            </li>
          </ul>
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fab fa-windows"></i><i class="fab fa-linux"></i><span id="sistema_operativo"></span>
            </li>
          </ul>
        </div>

        <div class="col-sm-6">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-network-wired"></i><span id="mac"></span>
            </li>

          </ul>
        </div>

        <div class="col-sm-6">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-laptop"></i><span id="direccion_ip"></span>
            </li>
          </ul>
        </div>


        <div class="col-sm-6">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-microchip"></i><span id="modelo_placa"></span>
            </li>

          </ul>
        </div>

        <div class="col-sm-6">
          <ul class="list-group">
            <li class="list-group-item">
              <i class="fas fa-pencil-alt"></i></i><span id="notas"></span>
            </li>

          </ul>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

$eliminarProducto = new ControladorProductos();
$eliminarProducto->ctrEliminarProducto();

?>