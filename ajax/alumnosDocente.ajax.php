<?php
require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../functions/docentes.functions.php";
require_once "../controller/docentes.controller.php";
require_once "../model/docentes.model.php";

class AlumnosDocenteAjax
{
  /**
   * Método para mostrar todos los alumnos de un curso mediante una petición AJAX.
   * 
   * @param int $idCurso Identificador del curso.
   * @param int $idGrado Identificador del grado.
   * @param int $idPersonal Identificador del personal.
   */
  public function ajaxMostrarAlumnosDocente($idCurso, $idGrado, $idPersonal)
  {
    $todosLosAlumnosDocente = ControllerAlumnos::ctrGetAlumnosCurso($idCurso, $idGrado, $idPersonal);
    foreach ($todosLosAlumnosDocente as &$alumno) {
      $alumno['acciones'] = FunctionDocente::getAccionesDocenteIniPrim($alumno["idAlumno"]);
    }
    echo json_encode($todosLosAlumnosDocente);
  }

  /**
   * Método para mostrar todos los grados que el docente tiene asignado
   * 
   */
  public function ajaxMostrarGradosDocente()
  {
    $todosLosGradosDocente = ControllerDocentes::ctrObtenerCursosAsignados();
    if(is_array($todosLosGradosDocente)) {
      foreach ($todosLosGradosDocente as &$grado) {
        if (isset($_POST["todosLosGradosAsistencia"])) {
          $grado['acciones'] = FunctionDocente::getButtonVerAsistenciaAlumnos($grado["idCurso"], $grado["idGrado"], $grado["idPersonal"]);
        } else if (isset($_POST["todosLosGradosNotasDocentes"])){
          $grado['acciones'] = FunctionDocente::getButtonVerNotasAlumnos($grado["idCurso"], $grado["idGrado"], $grado["idPersonal"]);
        } 
        else if (isset($_POST["todosLosGrados"])){
          $grado['acciones'] = FunctionDocente::getButtonVerAlumnos($grado["idCurso"], $grado["idGrado"], $grado["idPersonal"]);
        }
      }
      echo json_encode($todosLosGradosDocente);
      return;
    }
    echo json_encode(array("error" => "No se recibieron los datos esperados."));
  }
}


if (isset($_POST["todosLosAlumnosDocente"])) {
  $mostrarAlumnosDocente = new AlumnosDocenteAjax();
  $mostrarAlumnosDocente->ajaxMostrarAlumnosDocente($_POST["idCurso"], $_POST["idGrado"], $_POST["idPersonal"]);
}

if (isset($_POST["todosLosGrados"]) || isset($_POST["todosLosGradosAsistencia"]) || isset($_POST["todosLosGradosNotasDocentes"])) {
  $mostrarAlumnosDocente = new AlumnosDocenteAjax();
  $mostrarAlumnosDocente->ajaxMostrarGradosDocente();
}
