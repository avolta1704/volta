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

  /**
   * Obtiene un bimestre por su id
   * 
   * @param int $idBimestre id de un bimestre
   * @return array $dataBimestre datos de un bimestre
   */
  public static function ctrObtenerBimestreById($idBimestre)
  {
    $tabla = "bimestre";
    $dataBimestre = ModelBimestre::mdlObtenerBimestreById($tabla, $idBimestre);
    return $dataBimestre;
  }
}
