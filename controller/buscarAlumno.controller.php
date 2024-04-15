<?php
date_default_timezone_set('America/Lima');

class ControllerBuscarAlumno
{
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrGetAllBusquedaAlumno()
  {
    $tabla = "alumno";
    $dataBusquedaAlumno = ModelBuscarAlumno::mdlGetAllBusquedaAlumno($tabla);
    return $dataBusquedaAlumno;
  }
}
