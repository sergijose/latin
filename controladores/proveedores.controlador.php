<?php

class ControladorProveedor{

  /*=============================================
  MOSTRAR PROVEEDORES
  =============================================*/
  static public function ctrMostrarProveedor($item, $valor){
    $tabla = "proveedor";
    $respuesta = ModeloProveedor::mdlMostrarProveedor($tabla, $item, $valor);
    return $respuesta;
  }

  /*=============================================
  REGISTRAR PROVEEDORES
  =============================================*/

static public function ctrNuevoProveedor(){
    if(isset($_POST["nuevoRUC"])){ // Inicia llave isset

      
         $tabla = "proveedor";
          $datos = array(
                       "ruc"=>$_POST["nuevoRUC"],
                       "razon_social"=>$_POST["nuevaRSocial"],
                       "nombre_comercial"=>$_POST["nuevoNombreC"],
                       "direccion"=>$_POST["nuevaDireccion"],
                       "telefono"=>$_POST["nuevoTelefono"],
                       "tipo_empresa"=>$_POST["nuevoTipoEmp"],
                       "estado_empresa"=>$_POST["estado"],
                       "descripcion"=>$_POST["nuevaDescripcion"]
                       
                      );
      $respuesta = ModeloProveedor::mdlNuevoProveedor($tabla, $datos);
          if($respuesta == "ok"){

          echo'<script>
          swal({
              type: "success",
              title: "Nuevo Proveedor Grabado Exitosamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {
                  window.location = "proveedores";
                  }
                })
          </script>';
        }
        else{
               echo'<script>
                swal({
                   type: "error",
                    title: "¡Error. No se puede grabar. Consulte con el Soporte del Sistema!",
                   showConfirmButton: true,
                   confirmButtonText: "Cerrar"
                    }).then(function(result){
                    if (result.value) {
                   window.location = "proveedores";
                    }
                  })
                </script>';
             }
      }
  }







}
