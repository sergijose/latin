<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Crear Compra
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear compra</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioCompras">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $ventas = ControladorCompras::ctrMostrarCompras($item, $valor);

                    if(!$ventas){

                      echo '<input type="text" class="form-control" id="nuevaCompra" name="nuevaCompra" value="10001" readonly>';
                  

                    }else{

                      foreach ($ventas as $key => $value) {
                        
                        
                      
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaCompra" name="nuevaCompra" value="'.$codigo.'" readonly>';
                  

                    }

                    ?>
                    
                    
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>

                    <option value="">Seleccionar proveedor</option>

                    <?php

                      $item = null;
                      $valor = null;

                      $categorias = ControladorProveedor::ctrMostrarProveedor($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["razon_social"].'</option>';

                       }

                    ?>

                    </select>
                    
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarProveedor" data-dismiss="modal">Agregar Proveedor</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                

                </div>

                <input type="hidden" id="listaProductosCompras" name="listaProductosCompras">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  
                  <div class="col-xs-8 pull-right">
                    
                    <table class="table">

                      <thead>

                        <tr>
                          <th>Impuesto</th>
                          <th>Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                          <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>

                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>

                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>

                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>

                              <input type="hidden" name="totalVenta" id="totalVenta">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

               <!-- <hr>   -->

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
                       <!--
                <div class="form-group row">
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">
                  
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>                  
                      </select>    

                    </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>
                      -->
                <!--<br>  -->      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar compra</button>

          </div>

        </form>

        <?php

          $guardarVenta = new ControladorCompras();
          $guardarVenta -> ctrCrearCompra();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaCompras">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>imagen</th>
                  <th>producto</th>
                  <th>unidad medida</th>
                  <th>stock</th>
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
MODAL AGREGAR PROVEEDOR
======================================-->

<div id="modalAgregarProveedor" class="modal fade" role="dialog">
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