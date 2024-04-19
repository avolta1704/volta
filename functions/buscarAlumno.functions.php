<?php
class FunctionBuscarAlumno
{
  //  Estados para los alumnos
  public static function getEstadoAlumnoBuscar($estadoAlumno)
  {
    if (empty($estadoAlumno)) {
      return $estadoAlumno;
    }
    if ($estadoAlumno == 1) {
      $estado = "Activo";
    }
    if ($estadoAlumno == 2) {
      $estado = "Inactivo";
    }
    if ($estadoAlumno == 3) {
      $estado = "En revisión";
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
