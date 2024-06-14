<?php
require_once "../controller/tecnicaseInstrumentos.controller.php";
require_once "../model/tecnicaseInstrumentos.model.php";
require_once "../functions/tecnicaseInstrumentos.functions.php";

class TecnicaAjax
{
  //  Crear un nuevo año escolar
  public function ajaxAgregarTecnica($dataRegistrarTecnica)
  {
    $dataRegistrarTecnica = json_decode($dataRegistrarTecnica, true);
    $respuesta = ControllerTecnicaseInstrumentos::ctrCrearTecnicaeInstrumentos($dataRegistrarTecnica);
    echo json_encode($respuesta);
  }

  //  Listar todos los años escolares
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
}

//  Registrar un nuevo año escolar
if (isset($_POST["dataRegistrarTecnica"])) {
  $agregarTecnica = new TecnicaAjax();
  $agregarTecnica->ajaxAgregarTecnica($_POST["dataRegistrarTecnica"]);
}

//  Visualizar todos los años Escolares en el datatable
if (isset($_POST["todaslasTecnicas"])) {
  $mostrarTecnicas = new TecnicaAjax();
  $mostrarTecnicas->ajaxMostrarTodosLasTecnicas();
}
