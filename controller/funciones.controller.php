<?php

class ControllerFunciones
{
  public static function getEstadoUsuarios($stateValue)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-danger">Desactivado</span>';
    }
    return $state;
  }

  public static function mostrarAlerta($type, $title, $message, $route)
  {
    $alert =
      '<script>
            Swal.fire({
              icon: "' . $type . '",
              title: "' . $title . '",
              text: "' . $message . '",
            }).then(function(result){
              if(result.value){
                window.location = "' . $route . '";
              }
            });
          </script>';
    return $alert;
  }
}
