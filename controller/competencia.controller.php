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
  public static function ctrCrearCompetencia($idUnidad, $competencia)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayCompetencias = array(
      "idUnidad" => $idUnidad,
      "descripcionCompetencia" => $competencia["descripcionCompetenciaCrear"],
      "capacidadesCompetencia" => $competencia["capacidades"],
      "estandarCompetencia" => $competencia["estandar"],
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $response = ModelCompetencia::mdlCrearCompetencia($tabla, $arrayCompetencias);
    return $response;
  }

  // Modificar Competencia
  public static function ctrModificarCompetencia($idCompetencia, $competenciaModificada)
  {
    $tabla = "competencias";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $arrayCompetenciaMoficiada = array(
      "descripcionCompetencia" => $competenciaModificada["descripcionCompetenciaEditar"],
      "capacidadesCompetencia" => $competenciaModificada["capacidadesCompetenciaEditar"],
      "estandarCompetencia" => $competenciaModificada["estandarCompetenciaEditar"],
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

      $tablaCompetencia = "competencias";
      $competencia = ModelCompetencia::mdlObtenerCompetenciaPorId($tablaCompetencia, $checkboxValue["idCompetencia"]);

      if ($competencia == "error") {
        return "error";
      }

      $arrayCompetencias = array(
        "idUnidad" => $idUnidadDuplicado,
        "descripcionCompetencia" => $competencia["descripcionCompetencia"],
        "capacidadesCompetencia" => $competencia["capacidadesCompetencia"] == null ? "" : $competencia["capacidadesCompetencia"],
        "estandarCompetencia" => $competencia["estandarCompetencia"] == null ? "" : $competencia["estandarCompetencia"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );

      // Primero verificar si la competencia ya existe
      $checkResponse = ModelCompetencia::mdlVerificarCompetencia($tabla, $arrayCompetencias);


      if ($checkResponse != "error") {
        // Si la competencia no existe, se inserta
        $insertResponse = ModelCompetencia::mdlCrearCompetencia($tabla, $arrayCompetencias);

        if ($insertResponse == "error") {
          return "error";
        }

        $obtenerElUltimoCompetencia = ModelCompetencia::mdlObtenerUltimaCompetencia($tabla);

        if ($obtenerElUltimoCompetencia == "error") {
          return "error";
        }

        // obtener los criterios de dicha competencia y guardarlos en la tabla competencias_criterios
        $tablaCriterios = "criterios_competencia";
        $criterios = ModelCriterios::mdlObtenerCriteriosPorIdCompetencia($tablaCriterios, $checkboxValue["idCompetencia"]);

        if ($criterios != "error") {
          foreach ($criterios as $criterio) {
            $arrayCriterios = array(
              "idCompetencia" => $obtenerElUltimoCompetencia["idCompetencia"],
              "descripcionCriterio" => $criterio["descripcionCriterio"],
              "idTecnicaEvaluacion" => $criterio["idTecnicaEvaluacion"],
              "idInstrumento" => $criterio["idInstrumento"],
              "fechaCreacion" => date("Y-m-d H:i:s"),
              "fechaActualizacion" => date("Y-m-d H:i:s"),
              "usuarioCreacion" => $_SESSION["idUsuario"],
              "usuarioActualizacion" => $_SESSION["idUsuario"]
            );

            $tablaCriterios = "criterios_competencia";
            $insertCriterio = ModelCriterios::mdlCrearCriterio($tablaCriterios, $obtenerElUltimoCompetencia["idCompetencia"], $arrayCriterios);

            if ($insertCriterio == "error") {
              return "error";
            }
          }
        }

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

    // Eliminar los criterios de la competencia
    $tablaCriterios = "criterios_competencia";

    $responseCriterios = ModelCriterios::mdlEliminarCriteriosPorIdCompetencia($tablaCriterios, $idCompetenciaEliminar);

    if ($responseCriterios == "ok") {
      $response = ModelCompetencia::mdlEliminarCompetencia($tabla, $idCompetenciaEliminar);
      if ($response == "error") {
        return "error";
      }
      return "ok";
    }

    return "error";
  }

  // Validar si el alumno tiene competencia asignada y nota asignada
  public static function ctrValidarNotasCompetencias($idUnidadValidacion, $todoslosAlumnosdelCurso)
  {
    foreach ($todoslosAlumnosdelCurso as $alumno) {
      $response = ModelCompetencia::mdlValidarNotasCompetencias("competencias", $idUnidadValidacion, $alumno['idAlumnoAnioEscolar']);

      // Verificar si $response está vacío
      if (empty($response)) {
        return "error";
      }
      foreach ($response as $notaCompetencia) {
        if ($notaCompetencia['notaCompetencia'] == null || $notaCompetencia['idCompetencia'] == null) {
          return "error";
        }
      }
    }
    return "ok";
  }
}
