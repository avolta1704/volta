<?php

require_once "../controller/apoderado.controller.php";
require_once "../model/apoderado.model.php";
require_once "../functions/apoderado.functions.php";

class ApoderadoAjax
{
  //mostar todos los Apoderados DataTable
  public function ajaxMostrartodosLosApoderadosAdmin()
  {
    $todosLosApoderados = ControllerApoderados::ctrGetAllApoderados();
    foreach ($todosLosApoderados as &$apoderado) {
      $apoderado['buttons'] = FunctionApoderado::getBtnApoderado($apoderado);
      $apoderado['cuentaCreada'] = FunctionApoderado::getEstadoCuentaCreada($apoderado['cuentaCreada']);
      
    }
    echo json_encode($todosLosApoderados);
  }
  public $idApoderadoPostulanteHermano;
  public function ajaxObtenerDatosApoderadoPostulanteHermano(){
    $idApoderadoPostulanteHermano = $this->idApoderadoPostulanteHermano;
    $datosApoderado = ControllerApoderados::ctrObtenerDatosApoderadoPostulanteHermano($idApoderadoPostulanteHermano);
    echo json_encode($datosApoderado);
  }
}
//mostar todos los Apoderados DataTable
if (isset($_POST["todosLosApoderados"])) {
  $mostrartodosLosApoderados = new ApoderadoAjax();
  $mostrartodosLosApoderados->ajaxMostrartodosLosApoderadosAdmin();
}
if (isset($_POST["idApoderadoPostulanteHermano"])){
  $mostrarDatosApoderadoHermano = new ApoderadoAjax();
  $mostrarDatosApoderadoHermano -> idApoderadoPostulanteHermano = $_POST["idApoderadoPostulanteHermano"];
  $mostrarDatosApoderadoHermano ->ajaxObtenerDatosApoderadoPostulanteHermano();
}
