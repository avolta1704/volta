<?php
require_once "../controller/tecnicaseInstrumentos.controller.php";
require_once "../model/tecnicaseInstrumentos.model.php";

class TecnicaAjax
{
  //  Crear un nuevo año escolar
  public function ajaxAgregarTecnica($dataRegistrarTecnica)
  {
    $dataRegistrarTecnica = json_decode($dataRegistrarTecnica, true);
    $respuesta = ControllerTecnicaseInstrumentos::ctrCrearTecnicaeInstrumentos($dataRegistrarTecnica);
    echo json_encode($respuesta);
  }
}

//  Registrar un nuevo año escolar
if (isset($_POST["dataRegistrarTecnica"])) {
  $agregarTecnica = new TecnicaAjax();
  $agregarTecnica->ajaxAgregarTecnica($_POST["dataRegistrarTecnica"]);
}
