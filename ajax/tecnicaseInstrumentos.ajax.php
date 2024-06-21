<?php
require_once "../controller/tecnicaseInstrumentos.controller.php";
require_once "../model/tecnicaseInstrumentos.model.php";
require_once "../functions/tecnicaseInstrumentos.functions.php";

class TecnicaAjax
{
  //  Crear una nueva técnica
  public function ajaxAgregarTecnica($dataRegistrarTecnica)
  {
    $dataRegistrarTecnica = json_decode($dataRegistrarTecnica, true);
    $respuesta = ControllerTecnicaseInstrumentos::ctrCrearTecnicaeInstrumentos($dataRegistrarTecnica);
    echo json_encode($respuesta);
  }

  //  Listar todas las técnicas
  public static function ajaxMostrarTodosLasTecnicas()
  {
    $listaTecnicas = ControllerTecnicaseInstrumentos::ctrGetTodasLasTecnicas();

    foreach ($listaTecnicas as &$tecnica) {
      $tecnica['descripcionTecnica'] = strval($tecnica['descripcionTecnica']);
      $tecnica['codTecnica'] = strval($tecnica['codTecnica']);
      $tecnica['botonesTecnica'] = FunctionTecnicaseInstrumentos::getButtonsTecnica($tecnica["idTecnicaEvaluacion"]);
    }
    echo json_encode($listaTecnicas);
  }

  //  Visualizar una técnica
  public function ajaxVisualizarTecnica($codTecnicaVisualizar)
  {
    $respuesta = ControllerTecnicaseInstrumentos::ctrVisualizarTecnica($codTecnicaVisualizar);
    echo json_encode($respuesta);
  }

  //  Eliminar instrumento
  public function ajaxEliminarInstrumento($codInstrumentoEliminar) {
    $respuesta = ControllerTecnicaseInstrumentos::ctrEliminarInstrumento($codInstrumentoEliminar);
    echo json_encode($respuesta);
  }
}

//  Registrar un nueva técnica
if (isset($_POST["dataRegistrarTecnica"])) {
  $agregarTecnica = new TecnicaAjax();
  $agregarTecnica->ajaxAgregarTecnica($_POST["dataRegistrarTecnica"]);
}

//  Visualizar todas las técnicas
if (isset($_POST["todaslasTecnicas"])) {
  $mostrarTecnicas = new TecnicaAjax();
  $mostrarTecnicas->ajaxMostrarTodosLasTecnicas();
}

//  Visualizar una técnica
if (isset($_POST["codTecnicaVisualizar"])) {
  $visualizartecnica = new TecnicaAjax();
  $visualizartecnica->ajaxVisualizarTecnica($_POST["codTecnicaVisualizar"]);
}

//  Visualizar una técnica
if (isset($_POST["codInstrumentoEliminar"])) {
  $eliminarInstrumento = new TecnicaAjax();
  $eliminarInstrumento->ajaxEliminarInstrumento($_POST["codInstrumentoEliminar"]);
}
