<?php

require_once "../controller/reportesAdmisiones.controller.php";
require_once "../model/reportesAdmisiones.model.php";
require_once "../functions/reportesAdmisiones.functions.php";
require_once "../controller/nivelGrado.controller.php";
require_once "../model/nivelGrado.model.php";

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

  /**
   * Mostrar reportes por año lectivo
   * @param array $anioLectivo array de los años seleccionados
   * @return result json 
   */
  public function ajaxMostrarReportesPorAnioLectivo($aniosLectivo)
  {
    $reportesPorAnioLectivo = ControllerReportesAdmisiones::ctrGetReportesPorAnioLectivo($aniosLectivo);
    $grados = ControllerNivelGrado::ctrGetAllGradosByNivel();

    $data = [
      "reportesPorAnioLectivo" => $reportesPorAnioLectivo,
      "grados" => $grados
    ];

    echo json_encode($data);
  }

  /**
   * Mostrar reporte de nuevos y antiguos
   * @return result json
   */
  public function ajaxMostrarReporteNuevosAntiguos()
  {
    $reporteNuevosAntiguos = ControllerReportesAdmisiones::ctrGetReporteNuevosAntiguos();
    $grados = ControllerNivelGrado::ctrGetAllGradosByNivel();
    $data = [
      "reporteNuevosAntiguos" => $reporteNuevosAntiguos,
      "grados" => $grados
    ];
    echo json_encode($data);
  }

  /**
   * Mostrar reporte de edad y sexo
   * 
   * @return result json
   */
  public function ajaxMostrarReporteEdadSexo()
  {
    $reporteEdadSexo = ControllerReportesAdmisiones::ctrGetReporteEdadSexo();
    $grados = ControllerNivelGrado::ctrGetAllGradosByNivel();
    $data = [
      "reportePorEdadSexo" => $reporteEdadSexo,
      "grados" => $grados
    ];
    echo json_encode($data);
  }
}

if (isset($_POST["todosLasAdmisiones"])) {
  $mostrarReporteAdmisiones = new ReportesAdmisionesAjax();
  $mostrarReporteAdmisiones->ajaxMostrarReporteAdmisiones();
}

if (isset($_POST["anioLectivo"])) {
  $reportesPorAnioLectivo = new ReportesAdmisionesAjax();
  $reportesPorAnioLectivo->ajaxMostrarReportesPorAnioLectivo($_POST["anioLectivo"]);
}

if (isset($_POST["reportesNuevosAntiguos"])) {
  $reporteNuevosAntiguos = new ReportesAdmisionesAjax();
  $reporteNuevosAntiguos->ajaxMostrarReporteNuevosAntiguos();
}

if (isset($_POST["reportesPorEdadSexo"])) {
  $reporteEdadSexo = new ReportesAdmisionesAjax();
  $reporteEdadSexo->ajaxMostrarReporteEdadSexo();
}
