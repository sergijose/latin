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

      Crear Servicio

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear Servicio</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-4 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioPrestamo formularioPedido">

            <div class="box-body">

              <div class="box">

                <!-- TIPO DE SERVICIO
-->
                <div class="form-group">
                  <label for="reserva">Usa reserva:</label>
                  <input type="checkbox" id="equipo_reserva" name="equipo_reserva">
                </div>
                <div class="form-group">
                  <label>Servicio:</label>
                  <label class="radio-inline">
                    <input type="radio" name="servicio" value="instalacion" checked> Instalación
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="servicio" value="cambio de plan"> Cambio de Plan
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="servicio" value="averia"> Avería
                  </label>



                </div>




                <!--=====================================
                ENTRADA DEL USUARIO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoUsuario" name="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id"]; ?>">
                    <input type="hidden" class="form-control input-lg" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>
                  </div>

                </div>
                <!--=====================================
                ENTRADA DEL CODIGO DE PRESTAMO
                ======================================-->

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $prestamo = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);

                    if (!$prestamo) {

                      echo '<input type="text" class="form-control" id="nuevoPrestamo" name="nuevoPrestamo" value="10001" readonly>';
                    } else {

                      foreach ($prestamo as $key => $value) {
                      }

                      $codigo = $value["codigo_prestamo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevoPrestamo" name="nuevoPrestamo" value="' . $codigo . '" readonly>';
                    }

                    ?>


                  </div>

                </div>

                <!--=====================================
                ENTRADA PARA REGISTRAR A QUIEN SE LE ESTA HACIENDO EL PRESTAMO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <select class="form-control input-md mi-selector" id="nuevoEmpleado" name="nuevoEmpleado" required>

                      <option value="">--SELECCIONAR--</option>

                      <?php

                      $item = null;
                      $valor = null;

                      $modelo = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                      foreach ($modelo as $key => $value) {


                        echo '<option value="' . $value["idempleado"] . '">' . strtoupper($value["nombres"] . " " . $value["ape_pat"] . " " . $value["ape_mat"]) . "-[D.N.I:" . $value["num_documento"] . ']</option>';
                      }

                      ?>

                    </select>
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarEmpleado" data-dismiss="modal">Agregar Empleado</button></span>

                  </div>


                </div>


                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">


                </div>

                <input type="hidden" id="listaProductosPrestamos" name="listaProductos">
                <input type="hidden" id="listaProductosPedidos" name="listaProductosPedidos">



                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>



              </div>

              <div class="form-group">
                <label for="codigoCliente">Código del Cliente:</label>
                <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente">
              </div>

              <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente">
              </div>
              <div class="form-group">
                <label for="documento_cliente">Nro. Documento del Cliente:</label>
                <input type="text" class="form-control" id="documento_cliente" name="documento_cliente">
              </div>
              <!--=====================================
               ENTRADA PARA INGRESAR LAS OBSERVACIONES DEL PRESTAMO
                ======================================-->

              <div class="form-group">
                <p><strong>Comentario Plan del Cliente </strong></p>
                <div class="input-group">


                  <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>

                  <textarea class="form-control" id="observacionPrestamo" name="observacionPrestamo" cols="2" rows="2" placeholder="comentario del prestamo"></textarea>



                </div>

              </div>

              <div class="form-group">
                <label for="comentario">Comentario del Prestamo:</label>
                <textarea class="form-control" id="comentario_asignado" name="comentario_asignado" rows="2"></textarea>
              </div>


            </div>

            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right">Guardar prestamo</button>

            </div>

          </form>

          <?php

          $guardarPrestamo = new ControladorPrestamos();
          $guardarPrestamo->ctrCrearPrestamo();

          ?>

        </div>

      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-8 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaPrestamos">

              <thead>

                <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Modelo</th>
                  <th>Código del Producto</th>
                  <th>Serie</th>
                  <th>Estado Producto</th>
                  <th>Estado del Prestamo</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

      <!--prueba
 <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-8 hidden-md hidden-sm hidden-xs">
        <div class="box  box-warning">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <p>PRODUCTOS POR STOCK</p>
            <table class="table table-bordered table-striped dt-responsive tablaN tablaProductoLotes text-center">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Categoria</th>
                  <th>Producto</th>
                  <th>Medida</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>
              </thead>


            </table>
          </div>
        </div>
      </div>



    </div>

  </section>

</div>

<div id="modalAgregarEmpleado" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Empleado</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
            <!-- ENTRADA PARA EL APELLIDO PATERNO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoApePat" placeholder="Ingresar apellido paterno" required>

              </div>

            </div>
            <!-- ENTRADA PARA EL APELLIDO MATERNO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoApeMat" placeholder="Ingresar apellido materno" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoNombres" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="number" min="0" class="form-control input-lg" name="nuevoNumDocumento" id="nuevoNumDocumento" placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL ESTADO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>


                <select class="form-control input-lg" id="nuevoEstado" name="nuevoEstado" required>

                  <option value="">Seleccionar estado del empleado</option>
                  <option value="1">ACTIVADO</option>
                  <option value="2">DESACTIVADO</option>
                </select>

              </div>

            </div>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar empleado</button>

        </div>

      </form>

      <?php

      $crearEmpleado = new ControladorEmpleados();
      $crearEmpleado->ctrCrearEmpleados();

      ?>

    </div>

  </div>

</div>