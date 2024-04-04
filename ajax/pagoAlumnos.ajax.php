<?php

require_once "../controller/admisionAlumno.controller.php";
require_once "../model/admisionAlumno.model.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../functions/pagos.functions.php";

require_once "../controller/pagos.controller.php";
require_once "../model/pagos.model.php";
require_once "../functions/pagoAlumnos.functions.php";

class AdmisionAlumnosAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosPagoAlumnos()
  {
    $registroPagoAlumnos = ControllerPagos::ctrGetAllPagoAlumnos();
    foreach ($registroPagoAlumnos as &$dataAdmision) {
      $dataAdmision['btnPagoAlumnos'] = FunctionPagoAlumnos::getBotonesPagoAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAlumno"]);
      $dataAdmision['estadoAlPag'] = FunctionPagoAlumnos::getEstadoAlumno($dataAdmision["estadoAlumno"]);
    }
    echo json_encode($registroPagoAlumnos);
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
}

// Mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registroPagoAlumnos"])) {
  $mostrarregistroPagoAlumnos = new AdmisionAlumnosAjax();
  $mostrarregistroPagoAlumnos->ajaxMostrarRegistrosPagoAlumnos();
}

// ver calendario cronograma pago de la tabla  admision_alumno
if (isset($_POST["codAdAlumCronograma"])) {
  $codAdAlumCronograma = new AdmisionAlumnosAjax();
  $codAdAlumCronograma->codAdAlumCronograma = $_POST["codAdAlumCronograma"];
  $codAdAlumCronograma->ajaxDataCronoPagoAdAlumEstado();
}
