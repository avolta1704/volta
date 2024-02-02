<?php

class ControllerFunciones
{
  //  Estados de los usuarios
  public static function getEstadoUsuarios($stateValue)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-danger">Desactivado</span>';
    }
    if ($stateValue > 2) {
      $state = '<span class="badge rounded-pill bg-secondary">Sin Estado</span>';
    }

    return $state;
  }

  //  Estados de los postulantes
  public static function getEstadoPostulantes($stateValue)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Aceptado & 4 = Rechazado
    if ($stateValue == 1) {
      $state = '<span class="badge rounded-pill bg-primary">Registrado</span>';
    }
    if ($stateValue == 2) {
      $state = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }
    if ($stateValue == 3) {
      $state = '<span class="badge rounded-pill bg-success">Aprobado</span>';
    }
    if ($stateValue == 4) {
      $state = '<span class="badge rounded-pill bg-danger">Rechazado</span>';
    } 
    if ($stateValue > 4){
      $state = '<span class="badge rounded-pill bg-secondary">Sin Estado</span>';
    }
    return $state;
  }

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
