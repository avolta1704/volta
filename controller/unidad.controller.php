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

  // Crear Competencia
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

  // Modificar Competencia
  public static function ctrModificarCompetencia($idCompetencia, $notaTextModificada)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayCompetenciaMoficiada = array(
      "descripcionCompetencia" => $notaTextModificada,
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelUnidad::mdlModificarCompetencia($tabla, $arrayCompetenciaMoficiada, $idCompetencia);
    return $response;
  }

  // Modificar Competencia
  public static function ctrDuplicarCompetencia($idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar)
  {
    $tabla = "competencias";
    $response = ModelUnidad::mdlDuplicarCompetencia($tabla, $idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar);
    return $response;
  }

  // Insertar Competencia Duplicada
  public static function ctrInsertarDuplicadosCompetencia($idUnidadDuplicado, $checkboxValue)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayCompetencias = array(
      "idUnidad" => $idUnidadDuplicado,
      "descripcionCompetencia" => $checkboxValue,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelUnidad::mdlInsertarDuplicadosCompetencia($tabla, $arrayCompetencias);
    return $response;
  }
}

