<?php
require_once "../controller/notas.controller.php";
require_once "../controller/competencia.controller.php";
require_once "../controller/alumnos.controller.php";
require_once "../model/notas.model.php";
require_once "../model/alumnos.model.php";
require_once "../model/competencia.model.php";
require_once "../functions/notas.functions.php";

class NotasAjax
{

  /**
   * Consulta ajax para obtener todas las notas de los alumnos
   * 
   */
  public static function ajaxTodasLasNotasDeAlumnos($data)
  {
    $dataNotas = json_decode($data, true);
    $idCurso = $dataNotas["idCurso"];
    $idGrado = $dataNotas["idGrado"];
    $idPersonal = $dataNotas["idPersonal"];
    $idUnidad = $dataNotas["idUnidad"];
    $idBimestre = $dataNotas["idBimestre"];
    $respuesta = ControllerNotas::ctrTodasLasNotasUnidadDeAlumnos($idCurso, $idGrado, $idPersonal, $idUnidad, $idBimestre);

    // Agregar el select para cada criterio de evaluación para cada alumno
    $alumnosConNotas = $respuesta["alumnosConNotas"];

    foreach ($alumnosConNotas as $key => $alumno) {
      $notas = $alumno["notas"];
      $htmlNotas = [];
      foreach ($notas as $idCompetencia => $criterios) {
        foreach ($criterios as $idCriterio => $nota) {

          $idNotaCriterio = $nota["idNotaCriterio"] ?? 0;
          $notaCriterio = $nota["notaCriterio"] ?? 0;

          // obtenemos el select de las notas
          $htmlNotas[$idCompetencia][$idCriterio] = FunctionNotas::selectNotas($idCriterio, $alumno["idAlumnoAnioEscolar"], $idNotaCriterio, $notaCriterio);
        }
      }
      $alumnosConNotas[$key]["htmlNotas"] = $htmlNotas;
    }
    $respuesta["alumnosConNotas"] = $alumnosConNotas;
    echo json_encode($respuesta);
  }

  /**
   * Consulta ajax para crear o actualizar una nota
   * 
   * @param string $data
   */

  public static function ajaxCrearActualizarNota($data)
  {
    $dataNota = json_decode($data, true);
    $idAlumnoAnioEscolar = $dataNota["idAlumnoAnioEscolar"];
    $idCriterioCompetencia = $dataNota["idCriterioCompetencia"];
    $idNotaCriterio = $dataNota["idNotaCriterio"];
    $nota = $dataNota["nota"];
    $respuesta = ControllerNotas::ctrCrearActualizarNota($idAlumnoAnioEscolar, $idCriterioCompetencia, $idNotaCriterio, $nota);
    echo json_encode($respuesta);
  }
}

if (isset($_POST["todasLasNotasDeAlumnos"])) {
  $notasAjax = new NotasAjax();
  $notasAjax->ajaxTodasLasNotasDeAlumnos($_POST["todasLasNotasDeAlumnos"]);
}

if (isset($_POST["crearActualizarNota"])) {
  $crearNota = new NotasAjax();
  $crearNota->ajaxCrearActualizarNota($_POST["crearActualizarNota"]);
}