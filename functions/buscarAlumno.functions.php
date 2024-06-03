<?php
class FunctionBuscarAlumno
{
  //  Estados para los alumnos
  public static function getEstadoAlumnoBuscar($estadoAlumno)
  {
    if (empty($estadoAlumno)) {
      return $estadoAlumno;
    }else
    if ($estadoAlumno == 2) {
      $estado = "Activo";
    }else
    if ($estadoAlumno == 3) {
      $estado = "Inactivo";
    }
    return $estado;
  }
  public static function getEstadoMatriculaBuscar($estadoMatricula)
  {
    if (empty($estadoMatricula)) {
      return $estadoMatricula;
    }
    if ($estadoMatricula == 1) {
      $estadoMat = "Registrado";
    }
    if ($estadoMatricula == 2) {
      $estadoMat = "Matriculado";
    }
    if ($estadoMatricula == 3) {
      $estadoMat = "En revisión";
    }
    return $estadoMat;
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
