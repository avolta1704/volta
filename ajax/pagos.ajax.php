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

      //$dataPago['nivelAlum'] = FunctionPagos::getNivelAlumno($dataPago["idNivel"]);

      $dataPago['nivelAlum'] = FunctionPagos::getNivelAlumno($dataPago["idNivel"]);

      $dataPago['tipoPago'] = FunctionPagos::getTipoPago($dataPago["idTipoPago"]);
      $dataPago['cantidadTotal'] = FunctionPagos::getCantidadPago($dataPago["cantidadPago"]);
      $dataPago['statePago'] = FunctionPagos::getEstadoCronogramaPago($dataPago["estadoCronograma"]);
      $dataPago['buttonsPago'] = FunctionPagos::getBotonesPagos($dataPago["idPago"], $dataPago["estadoCronograma"]);
    }
    echo json_encode($todosLosPagosAdmin);
  }
  // vista de pagos buscar alumno por el dni
  public function ajaxMostrarDatosPagoAlumno($codCajaAlumno)
  {
    $datosPagoAlumno = ControllerPagos::ctrGetDataPagoCodAlumno($codCajaAlumno);
    if ($datosPagoAlumno == false) {
      echo json_encode(false);
      return;
    }
    $datosPagoAlumno['nivelAlumno'] = FunctionPagos::getNivelAlumno($datosPagoAlumno["idNivel"]);
    echo json_encode($datosPagoAlumno);
  }
  // vista de pagos detalles de pago
  public function ajaxMostrarDetallesPago($codPago)
  {
    $mostrarDetallesPago = ControllerPagos::ctrGetIdEditPago($codPago);
    $mostrarDetallesPago['nivelAlumno'] = FunctionPagos::getNivelAlumno($mostrarDetallesPago["idNivel"]);
    //$mostrarDetallesPago['mesPagoDet'] = FunctionPagos::getMesEdit($mostrarDetallesPago["mesPago"]);
    echo json_encode($mostrarDetallesPago);
  }
  // eliminar registro de pago
  public function ajaxEliminarRegistroPago($codPagoDelet)
  {
    $eliminarRegistroPago = ControllerPagos::ctrDeleteRegistroPago($codPagoDelet);
    echo json_encode($eliminarRegistroPago);
  }
}
//mostar todos los Pagos DataTableAlumnosAdmin
if (isset($_POST["todosLosPagosAdmin"])) {
  $mostrarTodosLosPagosAdmin = new PagosAjax();
  $mostrarTodosLosPagosAdmin->ajaxMostrarTodosLosPagosAdmin();
}
// vista de pagos buscar alumno por el dni
if (isset($_POST["codCajaAlumno"])) {
  $mostrarDatosPagoDniAlumno = new PagosAjax();
  $mostrarDatosPagoDniAlumno->ajaxMostrarDatosPagoAlumno($_POST["codCajaAlumno"]);
}
// vista de pagos detalles de pago
if (isset ($_POST["codPago"])) {
  $mostrarDetallesPago = new PagosAjax();
  $mostrarDetallesPago->ajaxMostrarDetallesPago($_POST["codPago"]);
}
// eliminar registro de pago
if (isset ($_POST["codPagoDelet"])) {
  $eliminarRegistroPago = new PagosAjax();
  $eliminarRegistroPago->ajaxEliminarRegistroPago($_POST["codPagoDelet"]);
}


