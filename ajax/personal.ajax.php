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
     /*  $personal['state'] = FunctionPersonal::getEstadoPersonal($personal["estadoUsuario"]); */
      $personal['tipe'] = FunctionPersonal::getTipoPersonal($personal["idTipoPersonal"]);
      $personal['buttons'] = FunctionPersonal::getBtnPersonal($personal["idPersonal"]);
    }
    echo json_encode($todoElPersonal);
  }
  //  Mostrar data para editar
  public $codUsuario;
  public function ajaxEditarUsuario()
  {
    $codUsuario = $this->codUsuario;
    $response = ControllerPersonal::ctrGetUsuarioEdit($codUsuario);
    echo json_encode($response);
  }
  //  Actualizar data del usuario
  public $codUsuarioActualizar;
  public function ajaxActualizarEstado()
  {
    $codUsuarioActualizar = $this->codUsuarioActualizar;
    $response = ControllerPersonal::ctrActualizarEstado($codUsuarioActualizar);
    echo json_encode($response);
  }
}
//mostar todo el Personal DataTable
if (isset($_POST["todoElPersonal"])) {
  $mostrartodoElPersonal = new PersonalAjax();
  $mostrartodoElPersonal->ajaxMostrartodoElPersonalAdmin();
}

//  Mostrar data para editar
if (isset($_POST["codUsuario"])) {
  $editarUsuario = new PersonalAjax();
  $editarUsuario->codUsuario = $_POST["codUsuario"];
  $editarUsuario->ajaxEditarUsuario();
}

//  Actualizar data del usuario
if (isset($_POST["codUsuarioActualizar"])) {
  $actualizarEstado = new PersonalAjax();
  $actualizarEstado->codUsuarioActualizar = $_POST["codUsuarioActualizar"];
  $actualizarEstado->ajaxActualizarEstado();
}