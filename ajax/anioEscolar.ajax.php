<?php

require_once "../controller/anioescolar.controller.php";
require_once "../model/anioescolar.model.php";
require_once "../functions/anioescolar.functions.php";


class anioEscolarAjax
{
  /**
   * Método para mostrar todos los años escolares mediante una petición AJAX.
   *
   */
  public static function ajaxMostrarTodosLosAnios()
  {
    $listaAnios = ControllerAnioEscolar::ctrGetTodosAniosEscolar();

    foreach ($listaAnios as &$anio) {
      $anio['descripcionAnio'] = strval($anio['descripcionAnio']);
      $anio['cuotaInicial'] = strval($anio['cuotaInicial']);
      $anio['estadoAnio'] = FunctionAnioEscolar::getEstadoAnioEscolar($anio['estadoAnio']);
      $anio['botonesAnio'] = FunctionAnioEscolar::getButtonsAnioEscolar($anio["idAnioEscolar"]);
    }
    echo json_encode($listaAnios);
  }
}

if (isset($_POST["todoslosAnios"])) {
  $mostrarAnios = new anioEscolarAjax();
  $mostrarAnios->ajaxMostrarTodosLosAnios();
}
