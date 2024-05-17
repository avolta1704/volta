<?php

require_once "../controller/admisionAlumno.controller.php";
require_once "../model/admisionAlumno.model.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../functions/pagos.functions.php";
require_once "../controller/admision.controller.php";
require_once "../model/admision.model.php";
class AdmisionAlumnosAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosAdmisionAlumnos()
  {
    $registrosAdmisionAlumnos = ControllerAdmisionAlumno::ctrGetAdmisionAlumnos();
    foreach ($registrosAdmisionAlumnos as &$dataAdmision) {
      //$dataAdmision['tipoAdmision'] = FunctionAdmisionAlumnos::getEstadoTipoAdmision($dataAdmision["tipoAdmision"]);
      $dataAdmision['estadoAdmisionAlumn'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($dataAdmision["estadoAdmisionAlumno"]);
      $dataAdmision['buttonsAdmisionAlumno'] = FunctionAdmisionAlumnos::getBotonesAdmisionAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAdmisionAlumno"], $dataAdmision["idAlumno"]);
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
  public $codAdAlumCronograma;
  public function ajaxDataCronoPagoAdAlumEstado()
  {
    $codAdAlumCronograma = $this->codAdAlumCronograma;
    $responseCronoPago = ControllerAdmisionAlumno::ctrDataCronoPagoAdAlumEstado($codAdAlumCronograma);
    foreach ($responseCronoPago as &$dataCronoPago) {
      $dataCronoPago['estadoCronogramaPago'] = FunctionPagos::getEstadoCronogramaPago($dataCronoPago["estadoCronograma"]);
    }
    echo json_encode($responseCronoPago);
  }
  //  eliminar Postulante Matriculado
  public $codAlumnoEliminar;
  public function ajaxElimnarAlumno()
  {
    $codAlumnoEliminar = $this->codAlumnoEliminar;
    $response = ControllerAdmision::ctrElimarDataMatriculaPostulante($codAlumnoEliminar);
    echo json_encode($response);
  }
}

// Mostar todos los registros de admision  dataTableAdmisionAlumnos
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
if (isset($_POST["codAdAlumCronograma"])) {
  $codAdAlumCronograma = new AdmisionAlumnosAjax();
  $codAdAlumCronograma->codAdAlumCronograma = $_POST["codAdAlumCronograma"];
  $codAdAlumCronograma->ajaxDataCronoPagoAdAlumEstado();
}

  //  eliminar Postulante Matriculado
if (isset($_POST["codAlumnoEliminar"])) {
  $obtenerAlumnoDataEliminar = new AdmisionAlumnosAjax();
  $obtenerAlumnoDataEliminar->codAlumnoEliminar = $_POST["codAlumnoEliminar"];
  $obtenerAlumnoDataEliminar->ajaxElimnarAlumno();
}