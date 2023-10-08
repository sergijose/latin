<div class="content-wrapper">
  <section class="content-header">
    <h1><strong>Listado de Compras del Usuario : <?php  echo $_SESSION["nombre"]; ?></strong></h1>
    <div class="box">
      <div class="box-header with-border">

        <div class="box-header with-border">
      <a href="crear-compra">
        <button class="btn btn-primary">Nueva Compra</button>
      </a>
      <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span><i class="fa fa-calendar"></i> Rango de fecha</span><i class="fa fa-caret-down"></i>
         </button> -->
    </div>
        <!-- Inicio de Boton de Fechas -->
        <!-- Final de Boton de Fechas -->
       <!-- Inicio de codigo para DESCARGA EN EXCEL -->
        <div class="box-tools pull-right">
        <?php            
        ?>
           

          </a>
        </div>
      </div>
      <div class="box-body"> 
       <table class="table table-bordered table-striped dt-responsive tablaListadoCompras text-center" width="100%">
      
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <!-- <th>Codigo_Factura</th> -->
           <th>Proveedor</th>
           <th>Registra:</th>
           <th>Cantidad</th>
           <th>Producto</th>
           <th>Precio Unidad</th>
           <th>TotalXProducto</th>
           <th>Neto</th>
           <th>Impuesto</th>
           <th>Total</th> 
           <th>Fecha</th>
           <th>Acciones</th>
        
          

         </tr> 
        </thead>
        <tbody>
          <?php

           /* $item=null;
            $valor=null;
            $respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

            foreach ($respuesta as $key => $value) {
                 echo '<tr>

                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';

                  $itemProveedor = "id";
                  $valorProveedor = $value["id_proveedor"];
                  $respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
                  echo ' <td>'.$respuestaProveedor["nombre"].'</td>';

                  $itemSucursal = "id";
                  $valorSucursal = $value["idSucursal"];
                  $respuestaSucursal = ControladorSucursal::ctrMostrarSucursal($itemSucursal, $valorSucursal);
                  echo ' <td>'.$respuestaSucursal["sede"].'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_usuario"];
                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                  echo '<td>'.$respuestaUsuario["nombre"].'</td><td>';


                  $productos =  json_decode($value["productos"], true);
                  foreach ($productos as $key => $valueProductos)
                   {
                   echo ($valueProductos["cantidad"].'<br>');
                   } 
                   
                  echo '</td><td>'; 
                  $productos = json_decode($value["productos"], true);
                  foreach ($productos as $key2 => $value2) {
                   echo $value2["nombre"] . '<br>';
                  }echo '</td>';

                  echo '</td><td>'; 
                  $productos = json_decode($value["productos"], true);
                  foreach ($productos as $key2 => $value2) {
                  echo "$ ".number_format($value2["total"],2)."<br>";
                  }echo '</td>';
                  
                  echo'</td><td>'.$value["metodo_pago"].'</td></td>';

                  echo '</td><td>$ '.number_format($value["neto"],2).'</td>
                  <td>$ '.number_format($value["total"],2).'</td>
                  <td>'.$value["fecha"].'</td>
                  
                   
                 
                </tr>';
            }*/
        ?>

        </tbody>
        <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idUsuario">
      <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto" class="perfilOculto">

      </table>

    </div>
    
</div>
</section>
</div>
<?php
$eliminarCompra = new ControladorCompras();
$eliminarCompra->ctrEliminarCompra();
?>



