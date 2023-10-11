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
                <?php

                $item = "id";
                $valor = $_GET["idPedido"];


                $pedidos = ControladorPedidos::ctrMostrarPedido($item, $valor, null);

                $itemUsuario = "id";
                $valorUsuario = $pedidos["id_usuario"];
                $usuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                //var_dump($pedido["id_usuario"]);

                $itemEmpleado = "idempleado";
                $valorEmpleado = $pedidos["id_empleado"];
                $empleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);

                $itemArea = "id";
                $valorArea = $pedidos["id_area"];
                $area = ControladorPedidos::ctrMostrarArea($itemArea, $valorArea);

                ?>

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
                        <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $usuario["nombre"]; ?>" readonly>
                        <input type="hidden" name="idVendedor" value="<?php echo $usuario["id"]; ?>">
                        <input type="hidden" name="idPedido" value="<?php echo $valor; ?>">
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
                        <select class="form-control input-md mi-selector" id="editarArea" name="editarArea" required>

                          <option value="<?php echo $area["id"]; ?>"><?php echo $area["descripcion"]; ?></option>

                          <?php

                          $item = null;
                          $valor = null;

                          $mostrarArea = ControladorPedidos::ctrMostrarArea($item, $valor);

                          foreach ($mostrarArea as $key => $value) {

                            echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
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



                        <input type="text" class="form-control" id="nuevoPedido" name="editarPedido" value="<?php echo $pedidos["codigo"]; ?>" readonly>

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

                          <select class="form-control input-md mi-selector" id="editarEmpleado" name="editarEmpleado" required>
                            <option value="<?php echo $empleado["idempleado"]; ?>"><?php echo $empleado["nombres"] . " " . $empleado["ape_pat"] . " " . $empleado["ape_mat"]; ?></option>

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

                    <?php
                    $listaProducto = json_decode($pedidos["productos"], true);

                    foreach ($listaProducto as $key => $value) {
                      $item = "id";
                      $valor = $value["id"];
                      $orden = "id";
                      $respuesta = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);
                      $stockAntiguo = $respuesta["stock"] + $value["cantidad"];

                      echo '<div class="row" style="padding:5px 15px">
  <!-- Descripción del producto -->
  <div class="col-xs-6" style="padding-right:0px">
  <div class="input-group">
  <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' . $value["id"] . '">
  <i class="fa fa-times"></i></button></span>
  <input type="text" class="form-control nuevaDescripcionProducto" idProducto="' . $value["id"] . '" name="agregarProducto" value="' . $value["descripcion"] .  '" readonly required>
  </div>
  </div>
  <!-- Cantidad del producto -->
  <div class="col-xs-3">
  <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="' . $value["cantidad"] . '" stock="' . $stockAntiguo . '" nuevoStock="' . $value["stock"] . '" required>
  </div>
  <!-- Precio del producto -->
  <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
  <div class="input-group">
  <span class="input-group-addon"><i class="">stock</i></span>
  <input type="text" class="form-control nuevoPrecioProducto" precioReal="' . $respuesta["precio_venta"] . '" name="nuevoPrecioProducto" value="' . $value["stock"] . '" readonly required>
  </div>
  </div>
  </div>';
                    }



                    ?>

                  </div>

                </div>
                <input type="hidden" id="listaProductosPedidos" name="listaProductosPedidos">

                <div class="form-group">
                  <p><strong> Escriba algun comentario para este pedidos</strong></p>
                  <div class="input-group">


                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>

                    <textarea class="form-control" id="editarDescripcion" name="editarDescripcion" cols="5" rows="2" placeholder="observaciones del prestamo"><?php echo $pedidos["descripcion"]; ?></textarea>



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
              <button type="submit" class="btn btn-flat btn-dark pull-right">Editar Venta</button>
            </div>

          </form>
          <?php
          $editarPedido = new ControladorPedidos();
          $editarPedido->ctrEditarPedido();
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