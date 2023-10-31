
<?php

if($_SESSION["perfil"] == "Visitante" ){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>




<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar contratos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar contratos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarContrato">
          
          Agregar contrato

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Codigo Cliente</th>
           <th>Nombre</th>
           <th>Dni</th>
           <th>Direccion</th>
           <th>Telefono</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $contratos = ControladorContratos::ctrMostrarContratos($item, $valor);

          foreach ($contratos as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["cod_cliente"].'</td>
                    <td class="text-uppercase">'.$value["nombre_completo"].'</td>
                    <td class="text-uppercase">'.$value["dni"].'</td>
                    <td class="text-uppercase">'.$value["direccion"].'</td>
                    <td class="text-uppercase">'.$value["telefono"].'</td>
                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarContrato" idContrato="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarContrato"><i class="fas fa-pencil-alt"></i></button>

                        <button class="btn btn-danger btnEliminarContrato" idContrato="'.$value["id"].'"><i class="fa fa-times"></i></button>

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
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarContrato" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Contrato</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL CODIGO DEL CLIENTE -->
            
            <div class="form-group">
                <label for="nuevoCodCliente">Codigo del Cliente</label>
                <input type="text" class="form-control input-lg" name="nuevoCodCliente" placeholder="Ingrese codigo del cliente" required>
                <!--<input type="hidden" class="form-control input-lg" name="creado_por" value="<?php echo $_SESSION["id"]; ?>" required>-->
             

            </div>


            <div class="form-group">
                <label for="nuevoNombreCompleto">Nombre del cliente</label>
                <input type="text" class="form-control input-lg" name="nuevoNombreCompleto" placeholder="Ingrese nombre completo del cliente" required>
            </div>

            <div class="form-group">
                <label for="nuevoDni">DNI del cliente</label>
                <input type="text" class="form-control input-lg" name="nuevoDni" placeholder="Ingrese dni del cliente" required>
            </div>

            <div class="form-group">
                <label for="nuevaDireccion">Direccion del cliente</label>
                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingrese direccion del cliente" required>
            </div>
            
            <div class="form-group">
                <label for="nuevoTelefono">Telefono del cliente</label>
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingrese telefono del cliente" required>
            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar contrato</button>

        </div>

        <?php

          $crearContrato = new ControladorContratos();
          $crearContrato -> ctrCrearContrato();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarCategoria" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar categoría</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarCategoria" id="editarCategoria" required>

                 <input type="hidden"  name="idCategoria" id="idCategoria" required>
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

      <?php

          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria -> ctrBorrarCategoria();

?>


