<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Editar Ingreso
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Editar Ingreso</li>
    
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

                <?php

                    $item = "id";
                    $valor = $_GET["idCompra"];

                    $compra = ControladorCompras::ctrMostrarCompras($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $compra["id_usuario"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemProveedor = "id";
                    $valorProveedor = $compra["id_proveedor"];

                    $proveedor = ControladorProveedor::ctrMostrarProveedor($itemProveedor, $valorProveedor);

                    $porcentajeImpuesto = $compra["impuesto"] * 100 / $compra["neto"];


                ?>

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">
                    <input type="hidden" name="id" value="<?php echo $_GET["idCompra"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                   <input type="text" class="form-control" id="nuevaCompra" name="editarCompra" value="<?php echo $compra["codigo"]; ?>" readonly>
               
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="id_proveedor" name="seleccionarProveedor" required>

                    <option value="<?php echo $proveedor["id"]; ?>"><?php echo $proveedor["razon_social"]; ?></option>

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

                <?php

                $listaProducto = json_decode($compra["productos"], true);

                foreach ($listaProducto as $key => $value) {

                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";

                  $respuesta = ControladorProductosLotes::ctrMostrarProductosLotes($item, $valor, $orden);

                  $stockAntiguo = $respuesta["stock"] - $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-3">
              
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>

                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_compra"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
   
                          </div>
               
                        </div>

                      </div>';
                }


                ?>

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
                           
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo $porcentajeImpuesto; ?>" required>

                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $compra["impuesto"]; ?>" required>

                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $compra["neto"]; ?>" required>

                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $compra["neto"]; ?>"  value="<?php echo $compra["total"]; ?>" readonly required>

                              <input type="hidden" name="totalVenta" value="<?php echo $compra["total"]; ?>" id="totalVenta">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

               <hr>
               <div class="form-group">
                  <p><strong>Escriba algun comentario para este ingreso</strong></p>
                  <div class="input-group">


                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>

                    <textarea class="form-control" id="editarDescripcionIngreso" name="editarDescripcionIngreso" cols="5" rows="2" placeholder="escriba aqui"><?php echo $compra["descripcion_ingreso"]; ?></textarea>



                  </div>

                </div>
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
                <br>
              
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>

          </div>

        </form>

        <?php

          $editarVenta = new ControladorCompras();
          $editarVenta -> ctrEditarCompra();
          
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