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

      Administrar detalles de CPU's y Laptop's <i class="fa fa-desktop" aria-hidden="true"></i>

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar detalles de productos</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProductoCpu">

          Agregar informacion

        </button>




      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive
          tablaProductosCpu" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Codigo</th>
              <th>Tipo Disco</th>
              <th>Disco</th>
              <th>Tipo Ram</th>
              <th>Ram</th>
              <th>Procesador</th>
              <th>Sistema O.</th>
              <th>Direccion ip</th>
              <th>Mac</th>
              <th>Modelo Placa</th>
              <th>Observaciones</th>

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
MODAL AGREGAR PRODUCTO CPU
======================================-->
<div id="modalAgregarProductoCpu" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#0e0302; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar informacion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">

          <div class="box-body">



            <div class="row">
              <div class="col-lg-6 col-xs-12">
                <!-- ENTRADA PARA SELECCIONAR CODIGO DE PRODUCTO DE LA CATEGORIA CPU -->
                <div class="form-group">
                  <label for="nuevoCodProductoCpu">Ingrese Codigo CPU o Laptop</label>
                  <div class="input-group">


                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md mi-selector2" id="nuevoCodProductoCpu" name="nuevoCodProductoCpu" required>

                      <option value="">Seleccionar Codigo</option>

                      <?php


                      $categoria1 = "CPU";
                      $categoria2 ="laptop";


                      $codProducto = ControladorProductosCpu::ctrMostrarCodigoProductoCpu($categoria1, $categoria2);

                      foreach ($codProducto as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' .
                          $value["cod_producto"] . '</option>';
                      }

                      ?>

                    </select>

                  </div>
                </div>
              </div>



            </div> <!-- FIN DE LA PRIMERA FILA -->





            <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DISCO DURO -->
            <div class="row">
              <div class="col-lg-4 col-xs-12">

                <div class="form-group">
                  <label for="nuevoTipoDisco">Ingrese tipo de disco</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="nuevoTipoDisco" name="nuevoTipoDisco" required>
                      <option value="">--Seleccionar--</option>
                      <option value="MECANICO">MECANICO</option>
                      <option value="SOLIDO">SOLIDO</option>


                    </select>

                  </div>

                </div>

              </div>

              <!-- ENTRADA PARA CANTIDAD DE DISCO -->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="nuevaCantDisco">Ingrese cantidad de disco</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-signal"></i></span>
                    <input type="number" class="form-control input-md" id="nuevaCantDisco" min="1" name="nuevaCantDisco" placeholder="Ingrese GB de disco duro" required>
                  </div>

                </div>

              </div>

            </div> <!-- FIN DE ROW SEGUNDA FILA -->

            <div class="row">

              <!-- ENTRADA PARA SELECCIONAR EL TIPO DE PROCESADOR-->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="nuevoProcesador">Ingrese Procesador</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="nuevoProcesador" name="nuevoProcesador" required>
                      <option value="">--Seleccionar--</option>
                      <?php

                      $item = null;
                      $valor = null;

                      $procesador = ControladorProductosCpu::ctrMostrarListaProcesadores($item, $valor);

                      foreach ($procesador as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                      }

                      ?>
                    </select>

                  </div>

                </div>

              </div>
              <div class="col-lg-6 col-xs-12">
                <div class="form-group">
                  <label>Generacion del Procesador</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="nuevaGeneracion" id="nuevaGeneracion">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>


            </div>
            <!-- fin de fila -->


            <div class="row">
              <!-- ENTRADA PARA SELECCIONAR EL TIPO DE MEMORIA RAM -->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="nuevoTipoRam">Ingrese tipo de memoria</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="nuevoTipoRam" name="nuevoTipoRam" required>

                      <option value="">--Seleccionar--</option>
                      <option value="DDR4">DDR4</option>
                      <option value="DDR3">DDR3</option>
                      <option value="DDR2">DDR2</option>
                      <option value="DDR">DDR</option>


                    </select>

                  </div>

                </div>
              </div>


              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA CANTIDAD DE MEMORIA RAM -->

                <div class="form-group">
                  <label for="nuevaCantRam">Ingrese cantidad de memoria</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-signal"></i></span>
                    <input type="number" class="form-control input-md" id="nuevaCantRam" min="1" name="nuevaCantRam" placeholder="Ingrese GB de Memoria Ram" required>
                  </div>

                </div>

              </div>
            </div> <!-- FIN DE ROW DE LA TERCERA FILA-->

            <div class="row">
              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA SELECCIONAR EL SISTEMA OPERATIVO-->

                <div class="form-group">
                  <label for="nuevoSistemaOperativo">Ingrese Sistema
                    Operativo</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="nuevoSistemaOperativo" name="nuevoSistemaOperativo" required>

                      <option value="">--Seleccionar--</option>
                      <?php

                      $item = null;
                      $valor = null;

                      $sistemaOperativo = ControladorProductosCpu::ctrMostrarListaSistemaOperativo($item, $valor);

                      foreach ($sistemaOperativo as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                      }

                      ?>

                    </select>

                  </div>

                </div>
              </div>

              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label>Edicion de S.O</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="nuevaEdicion" id="nuevaEdicion">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>

              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label>MAC.</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="nuevaMac" id="nuevaMac">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>


            </div>
            <!--fin de fila-->

            <div class="row">




              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label>Direccion Ip</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" name="nuevoIp" id="nuevoIp">
                    <input type="hidden" class="form-control input-lg" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>
                  </div>
                  <!-- /.input group -->
                </div>

              </div>
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="nuevoModeloPlaca">Modelo Placa</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i></span>

                    <input type="text" class="form-control input-md" name="nuevoModeloPlaca" id="nuevoModeloPlaca">
                  </div>
                  <!-- /.input group -->
                </div>

              </div>





              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA LAS OBSERVACIONES-->


                <div class="form-group">
                  <label for="nuevaObservacion">Nota</label>
                <textarea class="form-control" id="nuevaObservacion" cols="50" rows="4"  name="nuevaObservacion"></textarea>
                  </div>
                </div>

              </div>



            </div> <!-- FIN DE FILA-->
          </div>



          <!--=====================================
        PIE DEL MODAL
        ======================================-->
          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar Informacion</button>
          </div>

      </form>

      <?php

      $crearProductoCpu = new ControladorProductosCpu();
      $crearProductoCpu->ctrCrearProductoCpu();

      ?>

    </div>

  </div>
</div>







<!--=====================================
MODAL EDITAR PRODUCTO CPU
======================================-->
<div id="modalEditarProductoCpu" class="modal fade" role="dialog">


  <div class="modal-dialog  modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#0e0d0d; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar informacion del CPU</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">


          <div class="box-body">



            <div class="row">
              <div class="col-lg-6 col-xs-12">
                <!-- ENTRADA PARA SELECCIONAR CODIGO DE PRODUCTO DE LA CATEGORIA CPU -->
                <div class="form-group">
                  <label for="editarCodProductoCpu">Ingrese Codigo</label>
                  <div class="input-group">


                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <input type="text" class="form-control input-md" id="editarCodProductoCpu" name="editarCodProductoCpu" required readonly>



                  </div>

                </div>

              </div>




            </div> <!-- FIN DE LA PRIMERA FILA -->





            <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DISCO DURO -->
            <div class="row">
              <div class="col-lg-4 col-xs-12">

                <div class="form-group">
                  <label for="editarTipoDisco">Ingrese tipo de disco</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="editarTipoDisco" name="editarTipoDisco" required>
                      <option value="">Seleccionar tipo de disco</option>
                      <option value="MECANICO">MECANICO</option>
                      <option value="SOLIDO">SOLIDO</option>


                    </select>

                  </div>

                </div>

              </div>






              <!-- ENTRADA PARA CANTIDAD DE DISCO -->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="editarTipoDisco">Ingrese cantidad de disco</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-signal"></i></span>
                    <input type="number" class="form-control input-md" id="editarCantDisco" min="1"  name="editarCantDisco" placeholder="Ingrese GB de disco duro" required>
                  </div>

                </div>

              </div>

            </div>
            <!--FIN DE FILA -->

            <div class="row">
              <!-- ENTRADA PARA SELECCIONAR EL TIPO DE PROCESADOR-->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="editarProcesador">Ingrese Procesador</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="editarProcesador" name="editarProcesador" required>
                      <option value="">Seleccionar tipo de Procesador</option>
                      <?php

                      $item = null;
                      $valor = null;

                      $procesador = ControladorProductosCpu::ctrMostrarListaProcesadores($item, $valor);

                      foreach ($procesador as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                      }

                      ?>
                    </select>

                  </div>

                </div>

              </div>
              <div class="col-lg-6 col-xs-12">
                <div class="form-group">
                  <label>Generacion del Procesador</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="editarGeneracion" id="editarGeneracion">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>

            </div> <!-- FIN DE ROW SEGUNDA FILA -->



            <div class="row">
              <!-- ENTRADA PARA SELECCIONAR EL TIPO DE MEMORIA RAM -->
              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="editarTipoDisco">Ingrese tipo de memoria</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="editarTipoRam" name="editarTipoRam" required>

                      <option value="">--Seleccionar--</option>
                      <option value="DDR4">DDR4</option>
                      <option value="DDR3">DDR3</option>
                      <option value="DDR2">DDR2</option>
                      <option value="DDR">DDR</option>


                    </select>

                  </div>

                </div>
              </div>


              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA CANTIDAD DE MEMORIA RAM -->

                <div class="form-group">
                  <label for="editarCantRam">Ingrese cantidad de memoria</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-signal"></i></span>
                    <input type="number" class="form-control input-md" id="editarCantRam" min="1" name="editarCantRam" placeholder="Ingrese GB de Memoria Ram" required>
                  </div>

                </div>

              </div>

            </div>
            <!-- FIN DE FILA-->

            <div class="row">
              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA SELECCIONAR EL SISTEMA OPERATIVO-->

                <div class="form-group">
                  <label for="editarSistemaOperativo">Ingrese Sistema
                    Operativo</label>
                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-md" id="editarSistemaOperativo" name="editarSistemaOperativo" required>

                      <?php

                      $item = null;
                      $valor = null;

                      $sistemaOperativo = ControladorProductosCpu::ctrMostrarListaSistemaOperativo($item, $valor);

                      foreach ($sistemaOperativo as $key => $value) {

                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                      }

                      ?>

                    </select>




                  </div>

                </div>
              </div>

              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label>Edicion de S.O</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="editarEdicion" id="editarEdicion">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>

              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label>MAC.</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" name="editarMac" id="editarMac">

                  </div>
                  <!-- /.input group -->
                </div>

              </div>

            </div> <!-- FIN DE ROW DE LA TERCERA FILA-->


            <div class="row">





              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="editarIp">DIreccion IP

                  </label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-laptop" aria-hidden="true"></i></span>

                    <input type="text" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" name="editarIp" id="editarIp">
                    <input type="hidden" class="form-control input-lg" name="actualizado_por" value="<?php echo $_SESSION["id"]; ?>" required>
                    <input type="hidden" id="id" name="id" require> <!-- /.id pára editar -->
                  </div>
                  <!-- /.input group -->
                </div>

              </div>


              <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                  <label for="editarModeloPlaca">Modelo Placa</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i></span>

                    <input type="text" class="form-control input-md" name="editarModeloPlaca" id="editarModeloPlaca">
                  </div>
                  <!-- /.input group -->
                </div>

              </div>



              <div class="col-lg-4 col-xs-12">
                <!-- ENTRADA PARA LAS OBSERVACIONES-->


                <div class="form-group">
                  <label for="editarObservacion">Nota/Observacion</label>
                  <div class="input-group">
           <textarea class="form-control" id="editarObservacion" name="editarObservacion" rows="4" cols="50"></textarea>

                </div>

                </div>
              </div>

            </div>
            </div> <!-- FIN DE FILA-->
          </div>

          <!--=====================================
        PIE DEL MODAL
        ======================================-->
          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Actualizar Informacion</button>
          </div>

      </form>

      <?php

      $editarProductoCpu = new ControladorProductosCpu();
      $editarProductoCpu->ctrEditarProductoCpu();

      ?>

    </div>

  </div>

</div>


<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<?php

$eliminarProductoCpu = new ControladorProductosCpu();
$eliminarProductoCpu->ctrEliminarProductoCpu();

?>