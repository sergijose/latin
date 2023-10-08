<?php

$item = null;
$valor = null;
$orden = "id";

$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
$totalUsuarios = count($usuarios);

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);

$empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
$totalEmpleados = count($empleados);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);

?>




<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">

    <div class="inner">

      <h3><?php echo number_format($totalCategorias); ?></h3>

      <p>Categorías</p>

    </div>

    <div class="icon">

      <i class="ion ion-clipboard"></i>

    </div>

    <a href="categorias" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-yellow">

    <div class="inner">

      <h3><?php echo number_format($totalEmpleados); ?></h3>

      <p>Empleados</p>

    </div>

    <div class="icon">

      <i class="ion ion-person-add"></i>

    </div>

    <a href="empleados" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">

    <div class="inner">

      <h3><?php echo number_format($totalProductos); ?></h3>

      <p>Productos</p>

    </div>

    <div class="icon">

      <i class="ion ion-ios-cart"></i>

    </div>

    <a href="productos" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">

    <div class="inner">

      <h3><?php echo number_format($totalUsuarios); ?></h3>

      <p>Usuarios</p>

    </div>

    <div class="icon">

      <i class="ion ion-ios-person-outline"></i>

    </div>

    <a href="usuarios" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>


<div class="row">




  <div class="card">

    <div class="card-body">
      <h4 class="card-title">BUSCAR PRODUCTOS POR OFICINA Y POSICION</h4>
      <div class="form-inline">

        <div class="form-group mr-2">
          <input type="text" class="form-control" placeholder="OFICINA" id="searchTerm">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="NUMERO POSICION" id="posicion">
        </div>
      </div>
      <br>
      <table id="resultsTable" class="table">
        <thead>
          <tr>
            <th>COD_PRODUCTO</th>
            <th>CATEGORIA</th>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>OFICINA</th>
            <th>POSICION</th>
            <th>REFERENCIA</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

  </div>

  <style>
    .card {
      margin: 20px;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      background-color: white;
    }

    .card-body {
      padding: 20px;
    }

    .card-title {
      margin-bottom: 20px;
      font-size: 1.25rem;
      font-weight: bold;
      text-align: center;
    }
    
  </style>


  <script type="text/javascript">
    $(document).ready(function() {
          var table = $('#resultsTable').DataTable({
              "autoWidth": false,
              "columnDefs": [{
                  "width": "10%",
                  "targets": 0
                },
                {
                  "width": "10%",
                  "targets": 1
                },
                {
                  "width": "10%",
                  "targets": 2
                },
                {
                  "width": "10%",
                  "targets": 3
                },
                {
                  "width": "10%",
                  "targets": 4
                },
                {
                  "width": "10%",
                  "targets": 5
                },
              ],
              language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
              },
              "responsive": true,
              ajax: {
                url: 'ajax/search.ajax.php',
                type: 'POST',
                data: function(d) {
                  // console.log(d);
                  d.searchTerm = $('#searchTerm').val();
                  d.posicion = $('#posicion').val();
                },
                dataSrc: ''
              },

              columns: [{
                  data: 'cod_producto'
                },
                {
                  data: 'categorias'
                },
                {
                  data: 'marcas'
                },
                {
                  data: 'modelos'
                },
                {
                  data: 'oficina'
                },
                {
                  data: 'posicion'
                },
                {
                  "data": null,
                 
                  "render": function(data, type, full, meta) {
                    if(data.direccion_ip) {

                    return data.referencia + " " +'<span class="badge badge-primary">'+"IP "+data.direccion_ip+ '</span>';
                    }
                    else{
                      return data.referencia;
                    }

                  }

                },

                ],
                searching: false
              });

            $('#searchTerm,#posicion').on('keyup', function() {
              table.ajax.reload();
            });
          });
  </script>







</div>






<div class="col-lg-12 col-xs-12">
  <h3 class="box-title">ESTADO FISICO DE PRODUCTOS</h3>
  <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

    <thead>

      <tr>

        <th style="width:10px">#</th>
        <th>CATEGORIA</th>
        <th>MARCA</th>
        <th>TOTAL</th>
        <th>OPERATIVOS</th>
        <th>MALOGRADOS</th>
        <th>REPARACION INTERNA</th>
        <th>REPARACION GARANTIA</th>

      </tr>

    </thead>

    <tbody>

      <?php


      $productosEstados = ControladorProductos::ctrMostrarTotalProductosPorEstados();


      foreach ($productosEstados  as $key => $value) {

        echo ' <tr>

                   <td>' . ($key + 1) . '</td>

                 
                   <td class="text-uppercase">' . $value["CATEGORIA"] . '</td>
                   <td class="text-uppercase">' . $value["MARCA"] . '</td>
                   <td class="text-uppercase">' . $value["TOTAL"] . '</td>

                  <td>' . $value["OPERATIVO"] . '</td>
                  <td>' . $value["MALOGRADO"] . '</td>
                  <td>' . $value["REPARACION_INTERNA"] . '</td>
                  <td>' . $value["REPARACION_GARANTIA"] . '</td>
                   

                 </tr>';
      }

      ?>

    </tbody>

  </table>




</div>


<div class="col-lg-12 col-xs-12  ">
  <h3 class="box-title">ESTADO DE PRESTAMO DE PRODUCTOS</h3>
  <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

    <thead>

      <tr>

        <th style="width:10px">#</th>
        <th>CATEGORIA</th>
        <th>MARCA</th>
        <th>TOTAL</th>
        <th>OCUPADO</th>
        <th>LIBRE</th>

      </tr>

    </thead>

    <tbody>

      <?php

      $productosTotal = ControladorProductos::ctrMostrarTotalProductos();



      foreach ($productosTotal  as $key => $value) {
        echo ' <tr>
 
                     <td>' . ($key + 1) . '</td>
 
                     <td class="text-uppercase">' . $value["CATEGORIA"] . '</td>
                     <td class="text-uppercase">' . $value["MARCA"] . '</td>

                    <td>' . $value["TOTAL"] . '</td>
                    <td>' . $value["OCUPADO"] . '</td>
                    <td>' . $value["LIBRE"] . '</td>
                     
 
                   </tr>';
      }

      ?>

    </tbody>

  </table>

</div>