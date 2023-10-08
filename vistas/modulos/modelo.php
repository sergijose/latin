<?php
if ($_SESSION["perfil"] == "Visitante" || $_SESSION["perfil"] == "Especial") {

  echo '<script>

  window.location = "inicio";

</script>';

  return;
}

?>

<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar modelo

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar modelo</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarModelo">

          Agregar modelo

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Categoria</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Detalles</th>
              <th>Imagen</th>
              <th>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

            $item = null;
            $valor = null;

            $modelo = ControladorModelos::ctrMostrarModelo($item, $valor);

            foreach ($modelo as $key => $value) {

              echo ' <tr>

                    <td>' . ($key + 1) . '</td>

                    <td class="text-uppercase">' . $value["categoria"] . '</td>
                    <td class="text-uppercase">' . $value["marca"] . '</td>
                    <td class="text-uppercase">' . $value["descripcion"] . '</td>
                    <td class="text-uppercase">' . $value["informacion"] . '</td>';

              if ($value["imagen"] != "") {

                echo '<td><img src="' . $value["imagen"] . '" class="img-thumbnail btnMostrarImagen" width="100px" data-toggle="modal"  data-target="#modalMostrar" id="' . $value["id"] . '"></td>';
              } else {

                echo '<td><img src="vistas/img/modelos/default/anonymous.png" class="img-thumbnail btnMostrarImagen"  width="100px" data-toggle="modal"  data-target="#modalMostrar" id="' . $value["id"] . '"></td>';
              }


              echo '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarModelo" idModelo="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarModelo"><i class="fas fa-pencil-alt"></i></button>

                        <button class="btn btn-danger btnEliminarModelo" idModelo="' . $value["id"] . '" fotoModelo="' . $value["imagen"] . '"  modelo="' . $value["descripcion"] . '"><i class="fa fa-times"></i></button>

                      </div>  

                    </td>

                  </tr>';
            }

            ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL MOSTRAR MOSTRARIMAGEN MARCAS
======================================-->
<div id="modalMostrar" class="modal fade" role="dialog">
  <div class="modal-header" style="background:#129F9B; color:white">

    <button type="button" class="close" data-dismiss="modal">&times;</button>



  </div>

  <div class="modal-dialog modal-sm">

    <div class="modal-content">

      <h4 align="center" class="modal-title"><b>IMAGEN</b></h4>

      <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

      <div class="modal-body" width="80px">

        <div class="box-body modal-xs" align="center">

          <!-- ENTRADA PARA EL NOMBRE -->
          <img src="vistas/img/modelos/default/anonymous.png" class="img-thumbnail previsualizarimagen" width="800px">


        </div>

      </div>

    </div>

  </div>

</div>


<!--=====================================
MODAL AGREGAR MODELO
======================================-->

<div id="modalAgregarModelo" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar modelo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA LA CATEGORIA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>

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

            </div>

            <!-- ENTRADA PARA LA MARCA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="nuevaMarca" name="nuevaMarca" required>

                  <option value="">Selecionar marca</option>

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


            <!-- ENTRADA PARA EL DESCRIPCION DEL MODELO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoModelo" placeholder="Ingresar Modelo" required>

              </div>

            </div>
            <!-- ENTRADA PARA LA NOTA O OBSERVACION DEL MODELO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>


                <input type="text" class="form-control input-lg" name="nuevaInformacion" placeholder="Ingresar Nota o Modelo">

              </div>

            </div>
            <!-- ENTRADA PARA FOTO DEL MODELO -->
            <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaFoto" name="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/modelos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <br>
              <br>
            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar modelo</button>

        </div>

        <?php

        $crearModelo = new ControladorModelos();
        $crearModelo->ctrCrearModelo();

        ?>

      </form>

    </div>

  </div>

</div>






<!--=====================================
MODAL EDITAR MODELO
======================================-->

<div id="modalEditarModelo" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar modelo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EDITAR LA CATEGORIA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="editarCategoria" name="editarCategoria" required>

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

            </div>

            <!-- ENTRADA PARA EDITAR LA MARCA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="editarMarca" name="editarMarca" required>

                  <option value="">Selecionar marca</option>

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


            <!-- ENTRADA PARA EDITAR DESCRIPCION DEL MODELO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" readonly class="form-control input-lg" name="editarModelo" id="editarModelo" require>
                <input type="hidden" name="id" id="id" require>
              </div>

            </div>
            <!-- ENTRADA PARA EDITAR LA INFORMACIONDEL MODELO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>


                <input type="text" class="form-control input-lg" name="editarInformacion" id="editarInformacion" placeholder="Ingresar Informacion/detalle">

              </div>

            </div>


            <!-- ENTRADA PARA EDITAR FOTO DEL MODELO -->
            <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaFoto" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/modelos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">actualizar cambios</button>

        </div>
        <?php

        $editarModelos = new ControladorModelos();
        $editarModelos->ctrEditarModelo();

        ?>
      </form>


    </div>

  </div>

</div>
<?php

$eliminarModelo = new ControladorModelos();
$eliminarModelo->ctrEliminarModelo();

?>