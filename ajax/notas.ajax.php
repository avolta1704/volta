<?php
require_once "../controller/notas.controller.php";
require_once "../controller/competencia.controller.php";
require_once "../controller/alumnos.controller.php";
require_once "../model/notas.model.php";
require_once "../model/alumnos.model.php";
require_once "../model/competencia.model.php";
require_once "../functions/notas.functions.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../functions/usuarios.functions.php";

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
  // Consulta ajax para obtener los alumnos de un apoderado
  public $idUsuarioAlumnoNotasApoderado;
  public function ajaxObtenerAlumnosApoderadoNotas()
  {
    $idUsuarioAlumnoNotasApoderado = $this->idUsuarioAlumnoNotasApoderado;
    $response = ControllerNotas::ctrObtenerAlumnosApoderado($idUsuarioAlumnoNotasApoderado);
    foreach ($response as &$alumno) {
      $alumno['acciones'] = FunctionNotas::getBtnNotasAlumnoApoderado($alumno["idAlumno"]);
      $alumno['status'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($alumno["estadoAdmisionAlumno"]);
    }
    echo json_encode($response);
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
  public $idAlumnoNotasApoderado;
  public function ajaxObtenerListadoNotasAlumnoApoderado()
  {
    $idAlumnoNotasApoderado = $this->idAlumnoNotasApoderado;
    $response = ControllerNotas::ctrObtenerListadoNotasAlumnoApoderado($idAlumnoNotasApoderado);
    echo json_encode($response);
  }
  public $idCursoAlumnoNotasDocente;
  public $idGradoAlumnoNotasDocente;
  public $idPersonalAlumnoNotasDocente;
  public function ajaxObtenerListadoNotasAlumnosDocente()
  {
    $idCursoAlumnoNotasDocente = $this->idCursoAlumnoNotasDocente;
    $idGradoAlumnoNotasDocente = $this->idGradoAlumnoNotasDocente;
    $idPersonalAlumnoNotasDocente = $this->idPersonalAlumnoNotasDocente;
    $response = ControllerNotas::ctrObtenerListadoNotasAlumnosDocente($idCursoAlumnoNotasDocente, $idGradoAlumnoNotasDocente, $idPersonalAlumnoNotasDocente);
    echo json_encode($response);
  }
  /**
   * Obtener todas la notas del bimestre, unidad, competencias y criterios
   * 
   * @param string $idBimestre
   */
  public function ajaxObtenerNotasAlumnosBimestre($idBimestre, $idCurso)
  {
    $response = ControllerNotas::ctrObtenerNotasAlumnosBimestre($idBimestre, $idCurso);
    echo json_encode($response);
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
if (isset($_POST["idUsuarioAlumnoNotasApoderado"])) {
  $alumnosNotasApoderado = new NotasAjax();
  $alumnosNotasApoderado->idUsuarioAlumnoNotasApoderado = $_POST["idUsuarioAlumnoNotasApoderado"];
  $alumnosNotasApoderado->ajaxObtenerAlumnosApoderadoNotas();
}
if (isset($_POST["idAlumnoNotasApoderado"])) {
  $notasAlumnoApoderado = new NotasAjax();
  $notasAlumnoApoderado->idAlumnoNotasApoderado = $_POST["idAlumnoNotasApoderado"];
  $notasAlumnoApoderado->ajaxObtenerListadoNotasAlumnoApoderado();
}
if (isset($_POST["idCursoAlumnoNotasDocente"]) && isset($_POST["idGradoAlumnoNotasDocente"]) && isset($_POST["idPersonalAlumnoNotasDocente"])) {
  $notasAlumnosDocente = new NotasAjax();
  $notasAlumnosDocente->idCursoAlumnoNotasDocente = $_POST["idCursoAlumnoNotasDocente"];
  $notasAlumnosDocente->idGradoAlumnoNotasDocente = $_POST["idGradoAlumnoNotasDocente"];
  $notasAlumnosDocente->idPersonalAlumnoNotasDocente = $_POST["idPersonalAlumnoNotasDocente"];
  $notasAlumnosDocente->ajaxObtenerListadoNotasAlumnosDocente();
}

if (isset($_POST["todasLasNotasDeAlumnosBimestre"]) && isset($_POST["idBimestre"]) && isset($_POST["idCurso"])) {
  $todasNotasAlumnosBimestre = new NotasAjax();
  $todasNotasAlumnosBimestre->ajaxObtenerNotasAlumnosBimestre($_POST["idBimestre"], $_POST["idCurso"]);
}
