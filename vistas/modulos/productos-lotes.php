<?php
if($_SESSION["perfil"] == "Visitante"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <span><i class="fa fa-product-hunt"></i></span>
       Modulo de Productos Generales
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Administrar productos generales</li>
    </ol>
  </section>
  <section class="content">

    <div class="box box-success">
      <div class="box-header with-border">
        <button class="btn btn-flat btn-default" data-toggle="modal" data-target="#modalAgregarProductoLotes"> Agregar productos</button>
      </div>
      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablaProductosLotes text-center" width="100%">
          
          <thead>
            <tr>
              
              <th style="width:10px">#</th>
              <th>Categoria</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Unidad Medida</th>
              <th>Stock</th>
              <th>Precio_Compra</th>
              <th>Precio_Venta</th>
              <th>Fecha Registro</th>
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
<div id="modalAgregarProductoLotes" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" >
  <!--=====================================
    CABEZA DEL MODAL
    ======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Productos Generales</h4>
        </div>
<!--=====================================
  CUERPO DEL MODAL
  ======================================-->
        <div class="modal-body">
          <div class="box-body">
            
            <div class="form-group">    
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>                 
                  <option value="">Categorias</option>

                  <?php
                  $item = null;
                  $valor = null;

                  $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  foreach ($categoria as $key => $value) {                   
                    echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

           
    <!-- ENTRADA PARA NOMBRE PRODUCTO LOTES-->
          <div class="form-group">           
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoNombre"  id="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>

 <!-- ENTRADA PARA LA DESCRIPCIÓN -->
 <div class="form-group">             
              <div class="input-group">           
                <span class="input-group-addon"><i class="fa fa-clipboard"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" iddiv="nuevaDescripcion" placeholder="Ingresar descripción o notas">
              </div>
            </div>

             <!-- ENTRADA PARA UNIDAD DE MEDIDA PRODUCTO LOTES-->
          <div class="form-group">           
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaUnidadMedida" id="nuevaUnidadMedida" placeholder="Ingresar unidad de medida">
              </div>
            </div>

    <!-- ENTRADA PARA STOCK -->
            <div class="form-group">           
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                <input type="number" class="form-control input-lg" id="nuevoStock" name="nuevoStock" min="0" placeholder="Stock" required>
              </div>
            </div>
    <!-- ENTRADA PARA PRECIO COMPRA / VENTA-->                                
            <div class="form-group row">
                <div class="col-xs-12 col-sm-6">              
                  <div class="input-group">                 
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" >
                  </div>
                </div>
    <!-- ENTRADA PARA PRECIO VENTA -->
                <div class="col-xs-12 col-sm-6">          
                  <div class="input-group">                
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" min="0" step="any" placeholder="Precio de venta" >
                  </div>             
                  <br>
                  
                </div>
            </div>
   
        
            

          </div>
        </div>
  <!--=====================================
    PIE DEL MODAL
    ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-dark">Guardar producto</button>
        </div>
      </form>
        <?php
          $crearProductoLotes = new ControladorProductosLotes();
          $crearProductoLotes -> ctrCrearProductoLotes();
        ?>  
    </div>
  </div>
</div>

<!--=====================================
  MODAL EDITAR PRODUCTO
  ======================================-->
<div id="modalEditarProductoLotes" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
<!--=====================================
  CABEZA DEL MODAL
  ======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar productos Generales</h4>
        </div>
<!--=====================================
  CUERPO DEL MODAL 
  ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg"  name="editarCategoria" id="editarCategoria"required>
                  <option value="">Seleccionar Categoria</option>
                  <?php
                  $item = null;
                  $valor = null;

                  $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  foreach ($categoria as $key => $value) {                   
                    echo '<option value="'.$value["id"].'">'.$value["descripcion"].'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          
            <!-- ENTRADA PARA EL NOMBRE -->           
            <div class="form-group">
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" required>
                <input type="hidden" class="form-control input-lg" id="id" name="id" readonly required>
              </div>
            </div> 
         
            <!-- ENTRADA PARA LA DEESCRIPCION-->
            <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion">
              </div>
            </div>

             <!-- ENTRADA PARA EDITAR UNIDAD DE MEDIDA-->
             <div class="form-group">             
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 
                <input type="text" class="form-control input-lg" id="editarUnidadMedida" name="editarUnidadMedida">
              </div>
            </div>
            <!-- ENTRADA PARA STOCK -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>
              </div>
            </div>
            <!-- ENTRADA PARA PRECIO COMPRA -->
            <div class="form-group row">
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>
                  </div>
                </div>
                <!-- ENTRADA PARA PRECIO VENTA -->
                <div class="col-xs-6">                
                  <div class="input-group">                 
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" required>
                  </div>
                  <br>
                </div>
            </div>
         
          </div>
        </div>
<!--=====================================PIE DEL MODAL======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-flat btn-dark">Guardar cambios</button>
        </div>
      </form>

        <?php
          $editarProductoLotes = new ControladorProductoslotes();
          $editarProductoLotes -> ctrEditarProductoLotes();

        ?>      
    </div>
  </div>
</div>

<?php

  $eliminarProductoLotes = new ControladorProductoslotes();
  $eliminarProductoLotes -> ctrEliminarProductoLotes();

?>   
