<?php

if ($_SESSION["perfil"] == "Visitante") {

    echo '<script>

    window.location = "inicio";

  </script>';

    return;
}

?>




<div class="content-wrapper">

    <div class="row">

        <div class="col-lg-7 col-xs-12">

            <section class="content-header">

                <h1>

                    Ubicacion de Productos
                </h1>


            </section>

            <section class="content">


                <div class="box">

                    <div class="box-header with-border">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProductoUbicacion">

                            Agregar Ubicacion

                        </button>

                    </div>

                    <div class="box-body">

                        <table class="table table-bordered table-striped dt-responsive tablaProductosUbicacion" width="100%">

                            <thead>

                                <tr>
                                <th style="width:10px">#</th>
                                    <th>Categoria</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Producto</th>
                                    <th>Oficina</th>
                                    <th>Posicion</th>
                                    <th>Referencia</th>
                                    <th>Acciones</th>

                                </tr>

                            </thead>

                        </table>

                    </div>

                </div>
            </section>

        </div>


        <div class="col-lg-5 col-xs-12">

            <section class="content-header">

                <h1>

                    Estructura de la Ubicacion
                </h1>


            </section>

            <section class="content">


                <div class="box">

                    <div class="box-header with-border">
                        <!-- ENTRADA LISTA DE UBICACION-->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>

                                <select class="form-control input-md" id="ubicacion" name="ubicacion" onchange="ShowSelected(this);" required>

                                    <option value="">Seleccionar Ubicacion</option>

                                    <?php

                                    $item = null;
                                    $valor = null;


                                    $productoUbicacionLista = ControladorProductoUbicacion::ctrMostrarUbicacionLista($item, $valor);

                                    foreach ($productoUbicacionLista as $key => $value) {

                                        echo '<option value="' . $value["id"] . '"  ruta="' . $value["imagen"] . '">' . $value["descripcion"] . '</option>';
                                    }


                                    ?>

                                </select>


                            </div>


                        </div>




                    </div>

                    <div class="box-body">

                        <div class="col-md-12 .img-responsive center-block">
                            <img src="vistas/img/plantilla/default.png" alt="" id="previsualizar" class="img-responsive">
                        </div>

                    </div>

                </div>
            </section>

        </div>




    </div>





</div>



<!--=====================================
MODAL AGREGAR PRODUCTO UBICACION
======================================-->

<div id="modalAgregarProductoUbicacion" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Agregar Ubicacion de Productos</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA AGREGAR PRODUCTO UBICACION-->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                                <select class="form-control input-md mi-selector3" id="nuevoProductoUbicacion" name="nuevoProductoUbicacion" required>

                                    <option value="">Seleccionar Producto</option>

                                    <?php

                                    $item = null;
                                    $valor = null;
                                    $order = "id";

                                    $productoUbicacion = ControladorProductos::ctrMostrarProductos($item, $valor, $order);

                                    foreach ($productoUbicacion as $key => $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["cod_producto"] . '</option>';
                                    }

                                    ?>

                                </select>


                            </div>


                        </div>

                        <!-- ENTRADA LISTA DE UBICACION-->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>

                                <select class="form-control input-md mi-selector4" id="nuevaUbicacion" name="nuevaUbicacion" required>

                                    <option value="">Seleccionar Ubicacion</option>

                                    <?php

                                    $item = null;
                                    $valor = null;


                                    $productoUbicacionLista = ControladorProductoUbicacion::ctrMostrarUbicacionLista($item, $valor);

                                    foreach ($productoUbicacionLista as $key => $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                                    }


                                    ?>

                                </select>


                            </div>


                        </div>


                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></span>

                                <input type="number" class="form-control input-md" name="nuevaPosicion" placeholder="Ingresar Posicion" required>
                                <input type="hidden" class="form-control input-lg" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>
                            </div>

                        </div>
                        <!--CAMPO REFERENCIA-->
                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-product-hunt" aria-hidden="true"></i></span>

                                <input type="text" class="form-control input-md" name="nuevaReferencia" id="nuevaReferencia" placeholder="Ingresar Referencia">

                            </div>

                        </div>

                    </div>

                </div>

                <!--=====================================
        PIE DEL MODAL
        ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary">Guardar ubicacion</button>

                </div>

                <?php

                $crearProductosUbicacion = new ControladorProductoUbicacion();
                $crearProductosUbicacion->ctrCrearProductoUbicacion();

                ?>

            </form>

        </div>

    </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO UBICACION
======================================-->

<div id="modalEditarProductoUbicacion" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Editar Ubicacion de Productos</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA AGREGAR PRODUCTO UBICACION-->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                                <input type="text" class="form-control input-md" id="editarProductoUbicacion" name="editarProductoUbicacion" required readonly>




                            </div>


                        </div>

                        <!-- ENTRADA LISTA DE UBICACION-->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>

                                <select class="form-control input-md" id="editarUbicacion" name="editarUbicacion" required>

                                    <option value="">Seleccionar Ubicacion</option>

                                    <?php

                                    $item = null;
                                    $valor = null;


                                    $productoUbicacionLista = ControladorProductoUbicacion::ctrMostrarUbicacionLista($item, $valor);

                                    foreach ($productoUbicacionLista as $key => $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["descripcion"] . '</option>';
                                    }


                                    ?>

                                </select>


                            </div>


                        </div>

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i></span>

                                <input type="number" class="form-control input-md" id="editarPosicion" name="editarPosicion" placeholder="Ingresar Posicion" required>
                                <input type="hidden" class="form-control input-lg" name="actualizado_por" value="<?php echo $_SESSION["id"]; ?>" required>
                                <!--oculto id para poder editar -->
                                <input type="hidden" id="id" name="id" require>
                            </div>

                        </div>

                        <!--CAMPO REFERENCIA-->
                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-product-hunt" aria-hidden="true"></i></span>

                                <input type="text" class="form-control input-md" id="editarReferencia" name="editarReferencia" placeholder="Ingresar Referencia">

                            </div>

                        </div>

                    </div>
                                    
                    <!--=====================================
        PIE DEL MODAL
        ======================================-->

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                        <button type="submit" class="btn btn-primary">Actualizar Ubicacion de Producto</button>

                    </div>

                    <?php

                    $editarProductosUbicacion = new ControladorProductoUbicacion();
                    $editarProductosUbicacion->ctrEditarProductoUbicacion();

                    ?>

            </form>

        </div>

    </div>
    </div>

</div>

<?php

$borrarProductoUbicacion = new ControladorProductoUbicacion();
$borrarProductoUbicacion->ctrBorrarProductoUbicacion();

?>