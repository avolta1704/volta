<?php

require_once "../controller/unidad.controller.php";
require_once "../model/unidad.model.php";
require_once "../functions/unidad.functions.php";
require_once "../model/bimestre.model.php";
require_once "../model/alumnoAnioEscolar.model.php";
require_once "../controller/competencia.controller.php";
require_once "../model/competencia.model.php";

class UnidadAjax
{
  // Obtener todas las unidades
  public $idBimestre;
  public function ajaxObtenerTodasLasUnidades()
  {
    $idBimestre = $this->idBimestre;
    $response = ControllerUnidad::ctrObtenerTodasLasUnidades($idBimestre);
    echo json_encode($response);

  }
  // Cerrar Unidad
  public $idUnidadCerrar;
  public $idBimestreCerrar;
  public $idCursoCerrar;
  public $idGradoCerrar;
  public function ajaxCerrarUnidad()
  {
    $idUnidadCerrar = $this->idUnidadCerrar;
    $idBimestreCerrar = $this->idBimestreCerrar;
    $idCursoCerrar = $this->idCursoCerrar;
    $idGradoCerrar = $this->idGradoCerrar;

    // Obtener todos los alumnos de un curso y grado específicos
    $todoslosAlumnosdelCurso = ModelAlumnoAnioEscolar::mdlObtnerTodosLosAlumnosDeUnGradoCurso("alumno_anio_escolar", $idCursoCerrar, $idGradoCerrar);

    $validacionsiexistenotas = ControllerCompetencia::ctrValidarNotasCompetencias($idUnidadCerrar, $todoslosAlumnosdelCurso);
    if ($validacionsiexistenotas == "error") {
      echo json_encode($validacionsiexistenotas);
    } else {
      // Obtener solo los IDs de los alumnos
      $idsAlumnos = array_map(function ($alumno) {
        return $alumno['idAlumnoAnioEscolar'];
      }, $todoslosAlumnosdelCurso);

      $response = ControllerUnidad::ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar, $idCursoCerrar, $idGradoCerrar, $idsAlumnos);
      echo json_encode($response);
    }
  }
}
// Obtener todas las unidades
if (isset($_POST["idBimestre"])) {
  $todaslasUnidades = new UnidadAjax();
  $todaslasUnidades->idBimestre = $_POST["idBimestre"];
  $todaslasUnidades->ajaxObtenerTodasLasUnidades();
}
// Cerrar Unidad
if (isset($_POST["idUnidadCerrar"]) && isset($_POST["idBimestreCerrar"]) && isset($_POST["idCursoCerrar"]) && isset($_POST["idGradoCerrar"])) {
  $unidadCerrar = new UnidadAjax();
  $unidadCerrar->idUnidadCerrar = $_POST["idUnidadCerrar"];
  $unidadCerrar->idBimestreCerrar = $_POST["idBimestreCerrar"];
  $unidadCerrar->idCursoCerrar = $_POST["idCursoCerrar"];
  $unidadCerrar->idGradoCerrar = $_POST["idGradoCerrar"];
  $unidadCerrar->ajaxCerrarUnidad();
}
