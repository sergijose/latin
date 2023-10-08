<div class="content-wrapper">
  <section class="content">
    <div class="row">

      <!--================================== 
        EL FORMULARIO 
  ====================================-->
      <div class="col-lg-6 col-xs-12">
        <div class="box box-success">
          <section class="content-header">
            <h1>Registro de Pedidos</h1>
          </section>
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioPedido">
            <div class="box-body">
              <div class="box">
                <!--==================================== 
                  ENTRADA DEL VENDEDOR 
          ======================================-->
                <!-- primera fila-->
                <div class="row">
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label>Responsable de entrega:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                        <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                      </div>
                    </div>
                  </div>

                  <!--=====================================
                  DESTINO
                  ======================================-->

                  <div class="col-xs-5">
                    <div class="form-group">
                      <label>Area Solicitante:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                        <select class="form-control input-md mi-selector" id="nuevaArea" name="nuevaArea" required>

                      <option value="">Seleccionar Area</option>

                      <?php

                      $item = null;
                      $valor = null;

                      $modelo = ControladorPedidos::ctrMostrarArea($item, $valor);

                      foreach ($modelo as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] .'</option>';
                      }

                      ?>

                    </select>
                      </div>
                    </div>
                  </div>

                  <!--=====================================
      CORRELATIVO DEL COMPROBANTE
======================================-->
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label>Correlativo:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <?php
                        $item = null;
                        $valor = null;
                        $order="asc";
                        $pedido = ControladorPedidos::ctrMostrarPedido($item, $valor,$order);

                        if (!$pedido) {
                          echo '<input type="text" class="form-control" id="nuevoPedido" name="nuevoPedido"  value="10001" readonly>';
                        } else {

                          foreach ($pedido as $key => $value) {
                          }

                          $codigo =$value["codigo"] + 1;
                       

                          echo '<input type="text" class="form-control" id="nuevoPedido" name="nuevoPedido" value="' . $codigo . '" readonly>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>

                </div>

                <!--fin de primera fila-->

                <!--========================================================= 
        ENTRADA DEL CLIENTE 
==========================================================-->
                <div class="row">
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label>Entregado a:</label>
                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-users"></i></span>

                        <select class="form-control input-md mi-selector" id="nuevoEmpleado" name="nuevoEmpleado" required>

                          <option value="">Seleccionar Empleado</option>

                          <?php

                          $item = null;
                          $valor = null;

                          $modelo = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                          foreach ($modelo as $key => $value) {

                            echo '<option value="' . $value["idempleado"] . '">' . $value["nombres"] . " " . $value["ape_pat"] . " " . $value["ape_mat"] . "-[D.N.I:" . $value["num_documento"] . ']</option>';
                          }

                          ?>

                        </select>
                        <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarEmpleado" data-dismiss="modal">Agregar Empleado</button></span>

                      </div>


                    </div>
                  </div>

                </div>



                <!--======================================= 
      ENTRADA PARA AGREGAR PRODUCTO  
=========================================-->
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaProductosPedidos" name="listaProductosPedidos">

                <div class="form-group">
              <p><strong> Escriba algun comentario para este pedidos</strong></p>
                <div class="input-group">
               

                  <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>

                  <textarea class="form-control" id="nuevaObservacion" name="nuevaObservacion" cols="5" rows="2" placeholder="observaciones del prestamo"></textarea>



                </div>

              </div>
               
                <!--=================================== 
        BOTÓN PARA AGREGAR PRODUCTO 
======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                <hr>



              </div>
            </div>


            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-dark pull-right">Guardar Pedido</button>
            </div>
           
          </form>
          <?php
          $guardarPedido = new ControladorPedidos();
          $guardarPedido->ctrCrearPedido();
          ?>
        </div>

      
      </div>


      <!--=====================================
      LA TABLA DE PRODUCTOS 
======================================-->
      <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaN text-center">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
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


<!--=====================================
MODAL CLIENTES DNI
======================================-->
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