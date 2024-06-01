<?php
date_default_timezone_set('America/Lima');

class ControllerBimestre
{
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrObtenerTodosLosBimestres()
  {
    $tabla = "bimestre";
    $dataBimestre = ModelBimestre::mdlObtenerTodosLosBimestres($tabla);
    return $dataBimestre;
  }
}
