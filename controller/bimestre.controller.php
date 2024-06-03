<?php
date_default_timezone_set('America/Lima');

class ControllerBimestre
{
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrObtenerTodosLosBimestres($idCurso, $idGrado)
  {
    $tabla = "bimestre";
    $dataBimestre = ModelBimestre::mdlObtenerTodosLosBimestres($tabla, $idCurso, $idGrado);
    return $dataBimestre;
  }
}
