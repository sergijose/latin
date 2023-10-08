<?php

if ($_SESSION["perfil"] == "Especial") {

    echo '<script>

    window.location = "inicio";

  </script>';

    return;
}

?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>

            Administrar empleado

        </h1>

        <ol class="breadcrumb">

            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar empleado</li>

        </ol>

    </section>

    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEmpleado">

                    Agregar empleado

                </button>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                    <thead>

                        <tr>

                            <th style="width:10px">#</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Nombres</th>
                            <th>Numero de Documento</th>
                            <th>Estado</th>
                            <th>Fecha_registro</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $item = null;
                        $valor = null;

                        $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                        foreach ($empleados as $key => $value) {


                            echo '<tr>

                    <td>' . ($key + 1) . '</td>

                    <td>' . $value["ape_pat"] . '</td>

                    <td>' . $value["ape_mat"] . '</td>

                    <td>' . $value["nombres"] . '</td>

                    <td>' . $value["num_documento"] . '</td>';

                    if($value["estado"] == 1){

                        echo '<td><button class="btn btn-success btn-xs ">Activado</button></td>';
    
                      }else{
    
                        echo '<td><button class="btn btn-danger btn-xs" >Desactivado</button></td>';
    
                      }             

                    echo '<td>' . $value["fecha_registro"] . '</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarEmpleado" data-toggle="modal" data-target="#modalEditarEmpleado" idEmpleado="' . $value["idempleado"] . '"><i class="fas fa-pencil-alt"></i></button>';

                            if ($_SESSION["perfil"] == "Administrador") {

                                echo '<button class="btn btn-danger btnEliminarEmpleado" idEmpleado="' . $value["idempleado"] . '"><i class="fa fa-times"></i></button>';
                            }

                            echo '</div>  

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
MODAL AGREGAR CLIENTE
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
                                <input type="hidden" class="form-control input-lg" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>
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

<!--=====================================
MODAL EDITAR CLIENTE
======================================-->

<div id="modalEditarEmpleado" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Editar Empleado</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                <div class="box-body">
                        <!-- ENTRADA PARA EDITAR EL APELLIDO PATERNO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarApePat" id="editarApePat" placeholder="Editar apellido paterno" required>
                                <input type="text" id="idEmpleado" name="idEmpleado" hidden required>
                            </div>

                        </div>
                        <!-- ENTRADA PARA EL APELLIDO MATERNO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarApeMat"  id="editarApeMat" placeholder="Editar apellido materno" required>
                                <input type="hidden" class="form-control input-lg" name="actualizado_por" value="<?php echo $_SESSION["id"]; ?>" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL NOMBRE -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" class="form-control input-lg" name="editarNombres"  id="editarNombres" placeholder="Editar nombre" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL DOCUMENTO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                                <input type="number" min="0" class="form-control input-lg" name="editarNumDocumento" id="editarNumDocumento" placeholder="Editar documento" required>

                            </div>

                        </div>

                        <!-- ENTRADA PARA EL ESTADO -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>


                                <select class="form-control input-lg" id="editarEstado" name="editarEstado" required>

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

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>

                </div>

            </form>

            <?php

            $editarEmpleado = new ControladorEmpleados();
            $editarEmpleado->ctrEditarEmpleado();

            ?>



        </div>

    </div>

</div>

<?php

$eliminarEmpleado= new ControladorEmpleados();
$eliminarEmpleado->ctrEliminarEmpleado();

?>