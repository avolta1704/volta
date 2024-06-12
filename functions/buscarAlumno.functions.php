<?php
class FunctionBuscarAlumno
{
  //  Estados para los alumnos
  public static function getEstadoAlumnoBuscar($estadoAlumno)
  {
    if (empty($estadoAlumno)) {
      return $estadoAlumno;
    }

    switch ($estadoAlumno) {
      case 1:
        return "Anulado";
      case 2:
        return "Matriculado";
      case 3:
        return "Trasladado";
      case 4:
        return "Retirado";
      default:
        return "Sin Estado";
    }
  }
  public static function getEstadoNuevoAntigup($estadoNA)
  {
    if (empty($estadoNA)) {
      return $estadoNA;
    } else if ($estadoNA == 1) {
      $estado = "Nuevo";
    } else if ($estadoNA == 2) {
      $estado = "Antiguo";
    } else {
      $estado = "Sin Estado";
    }
    return $estado;
  }
  public static function getEstadosBuscarSiagiue($estadoSiagiue)
  {
    if (empty($estadoSiagiue)) {
      return $estadoSiagiue;
    }
    if ($estadoSiagiue == 1) {
      $estadoSia = "Activo";
    }
    if ($estadoSiagiue == 2) {
      $estadoSia = "Inactivo";
    }
    if ($estadoSiagiue == 3) {
      $estadoSia = "En revisión";
    }
    return $estadoSia;
  }

}
