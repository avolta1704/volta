<?php

require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../functions/alumnos.functions.php";
require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";
require_once "../controller/admisionalumno.controller.php";
require_once "../model/admisionalumno.model.php";
require_once "../functions/cursosDocente.functions.php";

class AlumnosAjax
{
  //mostar todos los Alumno DataTableAlumnosAdmin
  public function ajaxMostrarTodosLosAlumnosAdmin()
  {
    $todosLosAlumnosAdmin = ControllerAlumnos::ctrGetAlumnos();
    foreach ($todosLosAlumnosAdmin as &$alumno) {
      $alumno['stateAlumno'] = FunctionAlumnos::getEstadosAlumnos($alumno["estadoAlumno"]);
      $alumno['buttonsAlumno'] = FunctionAlumnos::getBotonesAlumnos($alumno["idAlumno"], $alumno["estadoAlumno"]);
    }
    echo json_encode($todosLosAlumnosAdmin);
  }

  public $codALumnoVisualizar;
  //  Obtener los datos del alumno para el modal visualizar
  public function ajaxMostrarDatosAlumno()
  {
    $codALumnoVisualizar = $this->codALumnoVisualizar;
    $response = ControllerUsuarios::ctrGetUsuarioEdit($codALumnoVisualizar);
    echo json_encode($response);
  }

  //  Obtener los datos del alumno para realizar el pago
  public $codAlumnoPago;
  public function ajaxMostrarDatosAlumnoPago()
  {
    $codAlumnoPago = $this->codAlumnoPago;
    $response = ControllerAlumnos::ctrGetDataAlumnoPago($codAlumnoPago);
    echo json_encode($response);
  }
  //  Cambiar estado del alumno
  public $cambiarEstadoAlumno;
  public $codAlumnoEstado;
  public function ajaxCambiarEstadoAlumno()
  {
    $cambiarEstadoAlumno = $this->cambiarEstadoAlumno;
    $codAlumnoEstado = $this->codAlumnoEstado;
    $response = ControllerAlumnos::ctrCambiarEstadoAlumno($codAlumnoEstado, $cambiarEstadoAlumno);
    echo json_encode($response);
  }
  /**
   * Método para mostrar todos los alumnos de un curso mediante una petición AJAX.
   */
  public function ajaxMostrarTodosLosAlumnosCurso($data)
  {
    $data = json_decode($data, true);
    $todosLosAlumnosCurso = ControllerAlumnos::ctrGetAlumnosCurso($data["idCurso"], $data["idGrado"], $data["idPersonal"]);
    foreach ($todosLosAlumnosCurso as &$alumno) {
      $alumno['acciones'] = FunctionCursosDocente::getAccionesAlumnosPorCurso($alumno["idAlumno"]);
    }
    echo json_encode($todosLosAlumnosCurso);
  }
  // Metod para mostrar todos los alumnos de un curso mediante una petición AJAX en la vista para ver notas.
  public function ajaxMostrarTodosLosAlumnosCursoNotas($data)
  {
    $data = json_decode($data, true);
    $todosLosAlumnosCurso = ControllerAlumnos::ctrGetAlumnosCursoNotas($data["idCurso"], $data["idGrado"], $data["idPersonal"], $data["idBimestre"], $data["idUnidad"]);
    foreach ($todosLosAlumnosCurso as &$alumno) {
      $alumno['acciones'] = FunctionCursosDocente::getAccionesAlumnosPorCursoNotas($alumno["idAlumno"]);
    }
    echo json_encode($todosLosAlumnosCurso);
  }
}


//mostar todos los Alumnos DataTableAdmin
if (isset($_POST["todosLosAlumnosAdmin"])) {
  $mostrarTodosLosAlumnosAdmin = new AlumnosAjax();
  $mostrarTodosLosAlumnosAdmin->ajaxMostrarTodosLosAlumnosAdmin();
}

//  Obtener el id del alumno para visualizar sus datos en el modal ---> FALTA
if (isset($_POST["codAlumnoVisualizar"])) {
  $getDatosModalAlumnos = new AlumnosAjax();
  //$getDatosModalAlumnos->codAlumnoVisualizar = $_POST["codAlumnoVisualizar"];
  $getDatosModalAlumnos->ajaxMostrarDatosAlumno();
}

//  Obtener los datos del alumno para realizar el pago
if (isset($_POST["codAlumnoPago"])) {
  $obtenerAlumnoData = new AlumnosAjax();
  $obtenerAlumnoData->codAlumnoPago = $_POST["codAlumnoPago"];
  $obtenerAlumnoData->ajaxMostrarDatosAlumnoPago();
}

//  Cambiar estado del alumno
if (isset($_POST["codAlumnoEstado"]) && isset($_POST["AlumnoEstado"])) {
  $cambiarEstadoAlumno = new AlumnosAjax();
  $cambiarEstadoAlumno->codAlumnoEstado = $_POST["codAlumnoEstado"];
  $cambiarEstadoAlumno->cambiarEstadoAlumno = $_POST["AlumnoEstado"];
  $cambiarEstadoAlumno->ajaxCambiarEstadoAlumno();
}

if (isset($_POST["todosLosAlumnosCurso"])) {
  $mostrarTodosLosAlumnosCurso = new AlumnosAjax();
  $mostrarTodosLosAlumnosCurso->ajaxMostrarTodosLosAlumnosCurso($_POST["todosLosAlumnosCurso"]);
}

if (isset($_POST["todosLosAlumnosCursoNotas"])) {
  $mostrarTodosLosAlumnosCursoNotas = new AlumnosAjax();
  $mostrarTodosLosAlumnosCursoNotas->ajaxMostrarTodosLosAlumnosCursoNotas($_POST["todosLosAlumnosCursoNotas"]);
}
