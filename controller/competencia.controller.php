<?php
date_default_timezone_set('America/Lima');

class ControllerCompetencia
{
  // Obtener todas las competencias
  public static function ctrObtenerCompetencia($idUnidad)
  {
    $tabla = "competencias";
    $dataUnidad = ModelCompetencia::mdlObtenerCompetencia($tabla, $idUnidad);
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
    $response = ModelCompetencia::mdlCrearCompetencia($tabla, $arrayCompetencias);
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
    $response = ModelCompetencia::mdlModificarCompetencia($tabla, $arrayCompetenciaMoficiada, $idCompetencia);
    return $response;
  }

  // Modificar Competencia
  public static function ctrDuplicarCompetencia($idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar)
  {
    $tabla = "competencias";
    $response = ModelCompetencia::mdlDuplicarCompetencia($tabla, $idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar);
    return $response;
  }
  // Insertar Competencia Duplicada
  public static function ctrInsertarDuplicadosCompetencia($idUnidadDuplicado, $checkboxValues)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $responses = [];
    foreach ($checkboxValues as $checkboxValue) {
      $arrayCompetencias = array(
        "idUnidad" => $idUnidadDuplicado,
        "descripcionCompetencia" => $checkboxValue,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );

      // Primero verificar si la competencia ya existe
      $checkResponse = ModelCompetencia::mdlVerificarCompetencia($tabla, $arrayCompetencias);

      if ($checkResponse == "ok") {
        // Si la competencia no existe, se inserta
        $insertResponse = ModelCompetencia::mdlCrearCompetencia($tabla, $arrayCompetencias);
        // Guarda las repsuesta en las respuestasobtenidas de las funciones
        $responses[] = $insertResponse;
      } else {
        // Si la competencia ya existe, agregar "duplicado" a las respuestas
        $responses[] = "duplicado";
      }
    }
    // Si en las respuestas obtenidas de las funciones hay al menos un "ok", entonces retorna "ok"
    if (in_array("ok", $responses)) {
      return "ok";
    } else {
      return "duplicado";
    }
  }
  public static function ctrEliminarCompetencia($idCompetenciaEliminar)
  {
    $tabla = "competencias";
    $response = ModelCompetencia::mdlEliminarCompetencia($tabla, $idCompetenciaEliminar);
    return $response;
  }

  // Validar si el alumno tiene competencia asignada y nota asignada
  public static function ctrValidarNotasCompetencias($idUnidadValidacion, $idCursoValidar, $idGradoValidar)
  {
    $tablaalumnoanioescolar = "alumno_anio_escolar";
    $todoslosAlumnosdelCurso = ModelAlumnoAnioEscolar::mdlObtnerTodosLosAlumnosDeUnGradoCurso($tablaalumnoanioescolar, $idCursoValidar, $idGradoValidar);
    $todosLosAlumnosTienenNotaId = true;
    foreach ($todoslosAlumnosdelCurso as $alumno) {
      $idAlumnoAnioEscolar = $alumno['idAlumnoAnioEscolar'];
      $tabla = "competencias";
      $response = ModelCompetencia::mdlValidarNotasCompetencias($tabla, $idUnidadValidacion, $idAlumnoAnioEscolar);
      // Verificar si $response está vacío
      if (empty($response)) {
        $todosLosAlumnosTienenNotaId = false;
        break;
      }
      foreach ($response as $notaCompetencia) {
        if ($notaCompetencia['notaCompetencia'] == null || $notaCompetencia['idCompetencia'] == null) {
          $todosLosAlumnosTienenNotaId = false;
          break;
        }
      }
      if (!$todosLosAlumnosTienenNotaId) {
        break;
      }
    }
    if (!$todosLosAlumnosTienenNotaId) {
      return "error";
    }
    return "ok";
  }
}

