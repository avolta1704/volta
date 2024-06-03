<?php
date_default_timezone_set('America/Lima');

class ControllerUnidad
{
  // Obtener todas las unidades
  public static function ctrObtenerTodasLasUnidades($idBimestre)
  {
    $tabla = "unidad";
    $dataUnidad = ModelUnidad::mdlObtenerTodasLasUnidades($tabla, $idBimestre);
    return $dataUnidad;
  }

  // Obtener todas las competencias
  public static function ctrObtenerCompetencia($idUnidad)
  {
    $tabla = "competencias";
    $dataUnidad = ModelUnidad::mdlObtenerCompetencia($tabla, $idUnidad);
    return $dataUnidad;
  }

  // Obtener todas las competencias
  public static function ctrCrearCompetencia($idUnidad, $descripcionCompetenciaCrear)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayCompetencias = array(
      "idUnidad" => $idUnidad,
      "descripcionCompetencia" => $descripcionCompetenciaCrear,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelUnidad::mdlCrearCompetencia($tabla, $arrayCompetencias);
    return $response;
  }
}
