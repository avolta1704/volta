<?php

require_once "../controller/reportesPensiones.controller.php";
require_once "../controller/pagos.controller.php";
require_once "../model/reportesPensiones.model.php";
require_once "../model/pagos.model.php";
require_once "../functions/reportesPensiones.functions.php";
require_once "../functions/pagos.functions.php";

class ReportesPensionesAjax
{
  /**
   * Función para mostrar todos los reportes.
   *
   * @return void
   */
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

  /**
   * Función para mostrar los pendientes de un alumno mediante una petición AJAX.
   */
  public function ajaxMostrarPendientesAlumno()
  {

    $todosLosPensionesPendientesPorAlumno = ControllerReportesPensiones::ctrGetCronogramasPagoPendientesPorAlumno();
    echo json_encode($todosLosPensionesPendientesPorAlumno);
  }

  /**
   * Función para mostrar los pagos generales.
   *
   * @return void
   */
  public function ajaxMostrarPagosGenerales()
  {

    $todosLosPagosGeneral = ControllerReportesPensiones::ctrGetCronogramasPagosGeneral();
    echo json_encode($todosLosPagosGeneral);
  }

  /**
   * Función para mostrar los pagos por rango.
   *
   * @return void
   */
  public function ajaxMostrarPagosPorRango()
  {
    $todosLosPagosPorRango = ControllerReportesPensiones::ctrGetCronogramasPagosPorRango();
    echo json_encode($todosLosPagosPorRango);
  }
}

if (isset($_POST["todosLosPensionesPendientes"])) {
  $mostrarTodosLosPagosAdmin = new ReportesPensionesAjax();
  $mostrarTodosLosPagosAdmin->ajaxMostrarTodosLosReportes();
}

if (isset($_POST["todosLosPagosGeneral"])) {
  $mostrarPagosGeneral = new ReportesPensionesAjax();
  $mostrarPagosGeneral->ajaxMostrarPagosGenerales();
}
if (isset($_POST["todosLosPagosPorRango"])) {
  $mostrarPagosRango = new ReportesPensionesAjax();
  $mostrarPagosRango->ajaxMostrarPagosPorRango();
}

if (isset($_POST["todosLosPensionesPendientesPorAlumno"])) {
  $mostrarPendientesAlumno = new ReportesPensionesAjax();
  $mostrarPendientesAlumno->ajaxMostrarPendientesAlumno();
}
