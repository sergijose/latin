 <!-- Aplicamos estilo al Modal para darle mayor largo -->
 <style>
    #mdialTamanio{
      width: 85% !important;
    }
  </style>

<div class="content-wrapper">
  <section class="content-header">
        <h1>
       <strong>Gestion de Proveedores - Datos SUNAT</strong>
    </h1>
    <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Informacion de Proveedores</li>
        </ol>
  </section>
  <section class="content">
    <div class="box">
    
      <div class="box-header with-border">
    
<button class="btn btn-primary" data-toggle="modal" data-target="#modalProveedor">Registrar Proveedor</button>
      </div> 
      

       <!-- INICIA TABLA PARA MOSTRAR DATOS -->
    <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>

           <th>Nº R.U.C</th>
           <th>Razon_Social</th>
           <th>Nombre_Comercial</th>
           <th>Direccion</th>
           <th>Telefono</th>
           <th>Tipo_Empresa</th>
           <th>Estado</th>
           <th>Notas</th>
          
         </tr> 
        </thead>
        <tbody>

        <?php
          $item = null;
          $valor = null;
          $proveedor = ControladorProveedor::ctrMostrarProveedor($item, $valor);
          foreach ($proveedor as $key => $value) {
            echo ' <tr>
                     <td>'.($key+1).'</td>                   
                      
                      <td>'.$value["ruc"].'</td>
                      <td>'.$value["razon_social"].'</td>
                      <td>'.$value["nombre_comercial"].'</td>
                      <td>'.$value["direccion_fiscal"].'</td>
                      <td>'.$value["num_telefono"].'</td>
                      <td>'.$value["tipo_empresa"].'</td>
                      <td>'.$value["estado_empresa"].'</td>
                      <td>'.$value["descripcion"].'</td>

                  </tr>';
          }
        ?>


        </tbody>
       </table>
      </div>
<!-- TERMINA TABLA PARA MOSTRAR DATOS -->
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR PROVEEDORES
======================================-->
 <div id="modalProveedor" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
      <form role="form" method="post"> 
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
         <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Proveedores - Datos SUNAT</h4>
        </div> 
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
         <div class=
         "modal-body">
          <div class="box-body">       
            <!-- Agregar Numero RUC -->
             <div class="col-xs-6">
              <label>Nº RUC /DOCUMENTO:</label>
         <div class="input-group">
            <input type="text" autocomplete="off" minlength="11" maxlength="11" onkeypress="SoloNumeros()" class="form-control" id="nuevoRUC" name="nuevoRUC" placeholder="Nº de R.U.C." required>
               <span class="input-group-btn">
                   <a href="#" class="btn btn-info" onclick="consultaProvee()">Buscar <i class="fa fa-search"></i></a>
               </span>
         </div>
           </div>
            <!--  Agregando RAZON SOCIAL-->
            <div class="col-xs-12">
              <label>Razon Social:</label>
            <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nuevaRSocial" name="nuevaRSocial" required>
              </div>
            </div>
            </div>
            <!--  Agregando MARCA COMERCIAL-->
            <div class="col-xs-6">
              <label>Nombre Comercial:</label>
            <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nuevoNombreC" name="nuevoNombreC" >
              </div>
            </div>
            </div>
            
            <!--  Agregando Direccion -->
            <div class="col-xs-12">
              <label>Direccion:</label>
            <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nuevaDireccion" name="nuevaDireccion">
              </div>
            </div> 
           </div>
           <div class="col-xs-6">     
            <div class="form-group">
              <label>Telefono:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" autocomplete="off">
              </div>
            </div> 
        </div>
           <!-- Tipo de Empresa -->
           <div class="col-xs-6">
              <label>Tipo de Empresa:</label>
             <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-bars"></i></span> 
                <input type="text"  class="form-control" id="nuevoTipoEmp" name="nuevoTipoEmp" >
              </div>
            </div>
            </div>
            <!-- Estado de la  Empresa -->
            <div class="col-xs-6">
              <label>Estado de Empresa:</label>
             <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-bars"></i></span> 
                <input type="text"  class="form-control" id="estado" name="estado">
              </div>
            </div>
            </div>
            <!-- Condicion de la  Empresa -->
            <div class="col-xs-6">
              <label>Condicion de Empresa:</label>
             <div class="form-group">
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-bars"></i></span> 
                <input type="text"  class="form-control" id="condicion" name="condicion">
              </div>
            </div>
            </div>
            <div class="col-xs-6">     
            <div class="form-group">
              <label>Anotaciones:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nuevaDescripcion" name="nuevaDescripcion" autocomplete="off">
              </div>
            </div> 
        </div>
            <!-- Final de Cajas de Texto -->
            </div>
        </div> 
        <!--=====================================
        PIE DEL MODAL
        =====================================-->
          <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Grabar Informacion</button>
        </div> 
       <?php
           $crearProveedor = new ControladorProveedor();
           $crearProveedor -> ctrNuevoProveedor();
        ?>
      </form>
    </div>
  </div>
</div> 
