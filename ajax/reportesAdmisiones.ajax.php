<?php

require_once "../controller/reportesAdmisiones.controller.php";
require_once "../model/reportesAdmisiones.model.php";
require_once "../functions/reportesAdmisiones.functions.php";

class ReportesAdmisionesAjax
{
  public function ajaxMostrarReporteAdmisiones()
  {
    $reporteAdmisiones = ControllerReportesAdmisiones::ctrGetReporteAdmisiones();
    foreach ($reporteAdmisiones as &$reporte) {
      $reporte['estadoAdmisionAlumno'] = FunctionReportesAdmisiones::getEstadoAdmisionAlumno($reporte['estadoAdmisionAlumno']);
      $reporte['acciones'] = FunctionReportesAdmisiones::getAccionesAdmisionAlumno($reporte['idAdmisionAlumno']);
    }

    echo json_encode($reporteAdmisiones);
  }
}

if (isset($_POST["todosLasAdmisiones"])) {
  $mostrarReporteAdmisiones = new ReportesAdmisionesAjax();
  $mostrarReporteAdmisiones->ajaxMostrarReporteAdmisiones();
}
