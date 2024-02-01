<?php
date_default_timezone_set('America/Lima');

class ControllerGradoAlumno
{
  //  Asignar grado a alumno
  public static function ctrAsignarGradoAlumno($dataAlumnoGrado)
  {
    $tabla = "alumno_grado";
    $response = ModelGradoAlumno::mdlAsignarGradoAlumno($tabla, $dataAlumnoGrado);
    return $response;
  }
}