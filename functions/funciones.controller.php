<?php

class ControllerFunciones
{
  //funciones para alertas
  
  //  Mensaje de alerta por acción
  public static function mostrarAlerta($tipo, $titulo, $mensaje, $ruta)
  {
    $alert =
      '<script>
            Swal.fire({
              icon: "' . $tipo . '",
              title: "' . $titulo . '",
              text: "' . $mensaje . '",
            }).then(function(result){
              if(result.value){
                window.location = "' . $ruta . '";
              }
            });
          </script>';
    return $alert;
  }

}
