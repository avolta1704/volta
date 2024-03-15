<?php

require_once "../controller/admisionAlumno.controller.php";
require_once "../model/admisionAlumno.model.php";
require_once "../functions/admisionAlumno.functions.php";

class AdmisionAlumnosAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosAdmisionAlumnos()
  {
    $registrosAdmisionAlumnos = ControllerAdmisionAlumno::ctrGetAdmisionAlumnos();
    foreach ($registrosAdmisionAlumnos as &$dataAdmision) {
      $dataAdmision['tipoAdmision'] = FunctionAdmisionAlumnos::getEstadoTipoAdmision($dataAdmision["tipoAdmision"]);
      $dataAdmision['estadoAdmisionAlumn'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($dataAdmision["estadoAdmisionAlumno"]);

      $dataAdmision['buttonsAdmisionAlumno'] = FunctionAdmisionAlumnos::getBotonesAdmisionAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAdmisionAlumno"]);
    }
    echo json_encode($registrosAdmisionAlumnos);
  }
  // Actualizar estado admision_alumno
  public $codAdmisionAlumno;
  public function ajaxActualizarEstado()
  {
    $codAdmisionAlumno = $this->codAdmisionAlumno;
    $response = ControllerAdmisionAlumno::ctrActualizarestadoAdmisionAlumno($codAdmisionAlumno);
    echo json_encode($response);
  }
  // ver calendario cronograma pago de la tabla  admision_alumno
  public $codAdAlumCalendario;
  public function ajaxDataCronoPagoAdAlumEstado()
  {
    $codAdAlumCalendario = $this->codAdAlumCalendario;
    $response = ControllerAdmisionAlumno::ctrDataCronoPagoAdAlumEstado($codAdAlumCalendario);
    echo json_encode($response);
  }
}
//mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registrosAdmisionAlumnos"])) {
  $mostrarRegistrosAdmisionAlumnos = new AdmisionAlumnosAjax();
  $mostrarRegistrosAdmisionAlumnos->ajaxMostrarRegistrosAdmisionAlumnos();
}
// Actualizar estado admision_alumno
if (isset($_POST["codAdmisionAlumno"])) {
  $codAdmisionAlumno = new AdmisionAlumnosAjax();
  $codAdmisionAlumno->codAdmisionAlumno = $_POST["codAdmisionAlumno"];
  $codAdmisionAlumno->ajaxActualizarEstado();
}
 // ver calendario cronograma pago de la tabla  admision_alumno
if (isset($_POST["codAdAlumCalendario"])) {
  $codAdAlumCalendario = new AdmisionAlumnosAjax();
  $codAdAlumCalendario->codAdAlumCalendario = $_POST["codAdAlumCalendario"];
  $codAdAlumCalendario->ajaxDataCronoPagoAdAlumEstado();
}
