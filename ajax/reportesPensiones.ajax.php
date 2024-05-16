<?php

require_once "../controller/reportesPensiones.controller.php";
require_once "../model/reportesPensiones.model.php";
require_once "../functions/reportesPensiones.functions.php";

class ReportesPensionesAjax
{
  public function ajaxMostrarTodosLosReportes()
  {
    $todosLosPensionesPendientes = ControllerReportesPensiones::ctrGetCronogramasPagoPendientes();
    foreach ($todosLosPensionesPendientes as &$dataPensiones) {
      $dataPensiones['nombreAlumno'] = $dataPensiones["nombresAlumno"] . " " . $dataPensiones["apellidosAlumno"];
      $dataPensiones['dniAlumno'] = $dataPensiones["dniAlumno"];
      $dataPensiones['gradoAlumno'] = $dataPensiones["descripcionGrado"];
      $dataPensiones['nivelAlumno'] = $dataPensiones["descripcionNivel"];
      $dataPensiones['mesPendientePago'] = $dataPensiones["mesPago"];
      $dataPensiones['montoDeuda'] = $dataPensiones["montoPago"];
      $dataPensiones['fechaLimitePago'] = strval($dataPensiones["fechaLimite"]);
      $dataPensiones['acciones'] = FunctionReportesPensiones::getBotonesOpciones($dataPensiones["idCronogramaPago"], $dataPensiones["idAlumno"]);
    }
    echo json_encode($todosLosPensionesPendientes);
  }
}
if (isset($_POST["todosLosPensionesPendientes"])) {
  $mostrarTodosLosPagosAdmin = new ReportesPensionesAjax();
  $mostrarTodosLosPagosAdmin->ajaxMostrarTodosLosReportes();
}
