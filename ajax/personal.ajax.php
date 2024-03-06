<?php

require_once "../controller/personal.controller.php";
require_once "../model/personal.model.php";
require_once "../functions/personal.functions.php";

class PersonalAjax
{
  //mostar todo el Personal DataTable
  public function ajaxMostrartodoElPersonalAdmin()
  {
    $todoElPersonal = ControllerPersonal::ctrGetAllPersonal();
    foreach ($todoElPersonal as &$personal) {
      $personal['tipe'] = FunctionPersonal::getTipoPersonal($personal["idTipoPersonal"]);
      $personal['buttons'] = FunctionPersonal::getBtnPersonal($personal["idPersonal"]);
    }
    echo json_encode($todoElPersonal);
  }
}
//mostar todo el Personal DataTable
if (isset($_POST["todoElPersonal"])) {
  $mostrartodoElPersonal = new PersonalAjax();
  $mostrartodoElPersonal->ajaxMostrartodoElPersonalAdmin();
}
