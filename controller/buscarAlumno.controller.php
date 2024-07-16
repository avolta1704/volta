<?php
date_default_timezone_set('America/Lima');

class ControllerBuscarAlumno
{
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrGetAllBusquedaAlumno($buscarAlumnos)
  {
    $tabla = "alumno";
    $dataBusquedaAlumno = ModelBuscarAlumno::mdlGetAllBusquedaAlumno($tabla,$buscarAlumnos);
    return $dataBusquedaAlumno;
  }
}
