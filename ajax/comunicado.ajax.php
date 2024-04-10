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
  // Borrar Registro de detalle comunicado de pago
  public $codComunicadoDetalle;
  public $codComunicado;
  public function ajaxBorrarRegistrosComunicado()
  {
    $codComunicadoDetalle = $this->codComunicadoDetalle;
    $codComunicado = $this->codComunicado;
    $borrarRegistroComunicado = ControllerComunicado::ctrBorrarRegistroComunicado($codComunicadoDetalle, $codComunicado);
    echo json_encode($borrarRegistroComunicado);
  }
  // editar Registro de detalle comunicado de pago
  public $codComunicadoEdit;
  public $tituloComunicado;
  public $fechaComunicado;
  public $textoComunicado;

  public function ajaxEditarRegistrosComunicado()
  {
    $dataEdit = array(
      "codComunicadoEdit" => $this->codComunicadoEdit,
      "tituloComunicado" => $this->tituloComunicado,
      "fechaComunicado" => $this->fechaComunicado,
      "textoComunicado" => $this->textoComunicado
    );

    $editarRegistroComunicado = ControllerComunicado::ctrEditarRegistroComunicado($dataEdit);
    echo json_encode($editarRegistroComunicado);
  }
}

// Mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registroComunicadoPago"])) {
  $mostrarRegistroComunicadoPago = new ComunicadoAjax();
  $mostrarRegistroComunicadoPago->ajaxMostrarRegistrosComunicadoPago();
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

// Borrar Registro de detalle comunicado de pago
if (isset($_POST["codDetallComunicadoDelet"], $_POST["codComunicadoDelet"])) {
  $codComunicadoDetalle = $_POST["codDetallComunicadoDelet"];
  $codComunicado = $_POST["codComunicadoDelet"];
  $borrarRegistroComunicado = new ComunicadoAjax();
  $borrarRegistroComunicado->codComunicadoDetalle = $codComunicadoDetalle;
  $borrarRegistroComunicado->codComunicado = $codComunicado;
  $borrarRegistroComunicado->ajaxBorrarRegistrosComunicado();
}

// editar Registro de detalle comunicado de pago
if (isset($_POST["codComunicadoEdit"])) {
  $codComunicadoEdit = $_POST["codComunicadoEdit"];
  $tituloComunicado = $_POST["tituloComunicado"];
  $fechaComunicado = $_POST["fechaComunicado"];
  $textoComunicado = $_POST["textoComunicado"];

  $editarRegistroComunicado = new ComunicadoAjax();
  $editarRegistroComunicado->codComunicadoEdit = $codComunicadoEdit;
  $editarRegistroComunicado->tituloComunicado = $tituloComunicado;
  $editarRegistroComunicado->fechaComunicado = $fechaComunicado;
  $editarRegistroComunicado->textoComunicado = $textoComunicado;

  $editarRegistroComunicado->ajaxEditarRegistrosComunicado();
}

