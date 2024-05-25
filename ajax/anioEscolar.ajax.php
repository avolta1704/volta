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
      $anio['botonesAnio'] = FunctionAnioEscolar::getButtonsAnioEscolar($anio["idAnioEscolar"], $anio["estadoAnio"]);
      $anio['estadoAnio'] = FunctionAnioEscolar::getEstadoAnioEscolar($anio['estadoAnio']);
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

  //  Buscar año escolar para luego editarlo
  public function ajaxBuscarAnio($codAnioBuscar)
  {
    $codAnioBuscar = json_decode($codAnioBuscar, true);
    $respuesta = ControllerAnioEscolar::ctrBuscarAnioEscolar($codAnioBuscar);
    echo json_encode($respuesta);
  }

  //  Editar un año escolar
  public function ajaxEditarAnio($dataEditarAnioEscolar)
  {
    $dataEditarAnioEscolar = json_decode($dataEditarAnioEscolar, true);
    $respuesta = ControllerAnioEscolar::ctrEditarAnioEscolar($dataEditarAnioEscolar);
    echo json_encode($respuesta);
  }

  //  Activar o Desactivar año escolar
  public function ajaxActivarAnio($dataActivarAnioEscolar)
  {
    $dataActivarAnioEscolar = json_decode($dataActivarAnioEscolar, true);
    $respuesta = ControllerAnioEscolar::ctrActivarAnioEscolar($dataActivarAnioEscolar);
    echo json_encode($respuesta);
  }

  //  Eliminar un año escolar
  public function ajaxEliminarAnio($codAnioEliminar)
  {
    $codAnioEliminar = json_decode($codAnioEliminar, true);
    $respuesta = ControllerAnioEscolar::ctrEliminarAnioEscolar($codAnioEliminar);
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

//  Otener los datos del año escolar
if (isset($_POST["codAnioBuscar"])) {
  $buscarAnio = new AnioEscolarAjax();
  $buscarAnio->ajaxBuscarAnio($_POST["codAnioBuscar"]);
}

//  Editar un año escolar
if (isset($_POST["dataEditarAnioEscolar"])) {
  $editarAnio = new AnioEscolarAjax();
  $editarAnio->ajaxEditarAnio($_POST["dataEditarAnioEscolar"]);
}

//  Activar o desactivar un año escolar
if (isset($_POST["dataActivarAnioEscolar"])) {
  $activarAnioEscolar = new AnioEscolarAjax();
  $activarAnioEscolar->ajaxActivarAnio($_POST["dataActivarAnioEscolar"]);
}

//  Eliminar un año escolar
if (isset($_POST["codAnioEliminar"])) {
  $eliminarAnio = new AnioEscolarAjax();
  $eliminarAnio->ajaxEliminarAnio($_POST["codAnioEliminar"]);
}
