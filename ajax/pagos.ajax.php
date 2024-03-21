<?php

require_once "../controller/pagos.controller.php";
require_once "../model/pagos.model.php";
require_once "../functions/pagos.functions.php";

class PagosAjax
{
  //mostar todos los Pagos DataTableAlumnosAdmin
  public function ajaxMostrarTodosLosPagosAdmin()
  {
    $todosLosPagosAdmin = ControllerPagos::ctrGetAllPagos();
   foreach ($todosLosPagosAdmin as &$dataPago) {
      $dataPago['nivelAlum'] = FunctionPagos::getNivelAlumno($dataPago["idNivel"]);
      $dataPago['tipoPago'] = FunctionPagos::getTipoPago($dataPago["idTipoPago"]);
      $dataPago['cantidadTotal'] = FunctionPagos::getCantidadPago($dataPago["cantidadPago"]);
      $dataPago['statePago'] = FunctionPagos::getEstadoCronogramaPago($dataPago["estadoCronograma"]);
      $dataPago['buttonsPago'] = FunctionPagos::getBotonesPagos($dataPago["idPago"], $dataPago["estadoCronograma"]);
    } 
    echo json_encode($todosLosPagosAdmin);
  }
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
//mostar todos los Pagos DataTableAlumnosAdmin
if (isset ($_POST["todosLosPagosAdmin"])) {
  $mostrarTodosLosPagosAdmin = new PagosAjax();
  $mostrarTodosLosPagosAdmin->ajaxMostrarTodosLosPagosAdmin();
}
// vista de pagos buscar alumno por el dni
if (isset ($_POST["dniAlumno"])) {
  $mostrarDatosPagoDniAlumno = new PagosAjax();
  $mostrarDatosPagoDniAlumno->ajaxMostrarDatosPagoDniAlumno($_POST["dniAlumno"]);
}
