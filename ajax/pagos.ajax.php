<?php

require_once "../controller/pagos.controller.php";
require_once "../model/pagos.model.php";
require_once "../functions/pagos.functions.php";

class PagosAjax
{
  // vista de pagos buscar alumno por el dni
  public function ajaxMostrarDatosPagoDniAlumno($dniAlumno)
  {
    $mostrarDatosPagoDniAlumno = ControllerPagos::ctrGetDataPagoDniAlumno($dniAlumno);
    if ($mostrarDatosPagoDniAlumno === false) {
      echo json_encode(false);
      return;
    }
    $mostrarDatosPagoDniAlumno['nivelAlumno'] = FunctionPagos::getNivelAlumnoGrado($mostrarDatosPagoDniAlumno["idNivel"]);
    echo json_encode($mostrarDatosPagoDniAlumno);
  }
}
// vista de pagos buscar alumno por el dni
if (isset ($_POST["dniAlumno"])) {
  $mostrarDatosPagoDniAlumno = new PagosAjax();
  $mostrarDatosPagoDniAlumno->ajaxMostrarDatosPagoDniAlumno($_POST["dniAlumno"]);
}