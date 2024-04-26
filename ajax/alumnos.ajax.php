<?php

require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../functions/alumnos.functions.php";
require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";
require_once "../controller/admisionalumno.controller.php";
require_once "../model/admisionalumno.model.php";

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
