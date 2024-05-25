<?php

require_once "../controller/anioescolar.controller.php";
require_once "../model/anioescolar.model.php";
require_once "../functions/anioescolar.functions.php";

class AnioEscolarAjax
{
  //  Listar todos los años escolares
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

  //  Crear un nuevo año escolar
  public function ajaxAgregarAnio($dataRegistrarAnio)
  {
    $dataRegistrarAnio = json_decode($dataRegistrarAnio, true);
    $respuesta = ControllerAnioEscolar::ctrCrearAnioEscolar($dataRegistrarAnio);
    echo json_encode($respuesta);
  }
}

//  Visualizar todos los años Escolares en el datatable
if (isset($_POST["todoslosAnios"])) {
  $mostrarAnios = new AnioEscolarAjax();
  $mostrarAnios->ajaxMostrarTodosLosAnios();
}

//  Registrar un nuevo año escolar
if (isset($_POST["dataRegistrarAnio"])) {
  $agregarAnio = new AnioEscolarAjax();
  $agregarAnio->ajaxAgregarAnio($_POST["dataRegistrarAnio"]);
}
