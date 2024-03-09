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
      $apoderado['tipe'] = FunctionApoderado::getTipoApoderado($apoderado["tipoApoderado"]);
      $apoderado['buttons'] = FunctionApoderado::getBtnApoderado($apoderado["idApoderado"]);
    }
    echo json_encode($todosLosApoderados);
  }
}
//mostar todos los Apoderados DataTable
if (isset($_POST["todosLosApoderados"])) {
  $mostrartodosLosApoderados = new ApoderadoAjax();
  $mostrartodosLosApoderados->ajaxMostrartodosLosApoderadosAdmin();
}
