<?php

require_once "../controller/admisionAlumno.controller.php";
require_once "../model/admisionAlumno.model.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../functions/pagos.functions.php";

require_once "../controller/comunicado.controller.php";
require_once "../model/comunicado.model.php";
require_once "../functions/comunicado.functions.php";

class ComunicadoAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosComunicadoPago()
  {
    $registroComunicadoPago = ControllerComunicado::ctrGetAllComunicadoPago();
    foreach ($registroComunicadoPago as &$dataAdmision) {
      $dataAdmision['btnPagoAlumnos'] = FunctionComunicado::getBotonesPagoAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["idAlumno"], $dataAdmision["estadoAlumno"]);
      $dataAdmision['estadoAlPag'] = FunctionComunicado::getEstadoAlumno($dataAdmision["estadoAlumno"]);
    }
    echo json_encode($registroComunicadoPago);
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
  // Registro de comunicado de pago
  public $registroComunicado;
  public function ajaxRegistrosComunicado()
  {
    $registroComunicado = $this->registroComunicado;
    $responseComunicado = ControllerComunicado::ctrRegistrosComunicado($registroComunicado);
    echo json_encode($responseComunicado);
  }
}

// Mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registroComunicadoPago"])) {
  $mostrarregistroComunicadoPago = new ComunicadoAjax();
  $mostrarregistroComunicadoPago->ajaxMostrarRegistrosComunicadoPago();
}

// ver calendario cronograma pago de la tabla  admision_alumno
if (isset($_POST["codAdAlumCronograma"])) {
  $codAdAlumCronograma = new ComunicadoAjax();
  $codAdAlumCronograma->codAdAlumCronograma = $_POST["codAdAlumCronograma"];
  $codAdAlumCronograma->ajaxDataCronoPagoAdAlumEstado();
}

// Registro de comunicado de pago
$datosJson = file_get_contents("php://input");
$datos = json_decode($datosJson, true);
if (isset($datos["datos"])) {
  $registroComunicado = new ComunicadoAjax();
  $registroComunicado->registroComunicado = $datos["datos"];
  $registroComunicado->ajaxRegistrosComunicado();
}
