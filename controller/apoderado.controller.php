<?php
date_default_timezone_set('America/Lima');

class ControllerApoderados
{
  //  Listar alumnos
  public static function ctrCrearApoderadoAlumno($dataApoderado)
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlCrearApoderadoAlumno($tabla, $dataApoderado);
    return $response;
  }

  //  Obtener ultimo apoderado creado
  public static function ctrObtenerUltimoApoderado()
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlObtenerUltimoApoderado($tabla);
    return $response;
  }

}