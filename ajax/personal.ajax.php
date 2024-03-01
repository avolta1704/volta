<?php

require_once "../controller/personal.controller.php";
require_once "../model/personal.model.php";
require_once "../functions/personal.functions.php";

class UsuariosAjax
{
  //mostar todos los usuarios DataTable
  public function ajaxMostrarTodosLosUsuarios()
  {
    $todosLosUsuarios = ControllerUsuarios::ctrGetAllUsuarios();
    foreach ($todosLosUsuarios as &$usuario) {
      $usuario['state'] = FunctionUsuario::getEstadoUsuarios($usuario["estadoUsuario"]);
      $usuario['buttons'] = FunctionUsuario::getBtnUsuarios($usuario["idUsuario"]);
    }
    echo json_encode($todosLosUsuarios);
  }
  //  Mostrar data para editar
  public $codUsuario;
  public function ajaxEditarUsuario()
  {
    $codUsuario = $this->codUsuario;
    $response = ControllerUsuarios::ctrGetUsuarioEdit($codUsuario);
    echo json_encode($response);
  }
  //  Actualizar data del usuario
  public $codUsuarioActualizar;
  public function ajaxActualizarEstado()
  {
    $codUsuarioActualizar = $this->codUsuarioActualizar;
    $response = ControllerUsuarios::ctrActualizarEstado($codUsuarioActualizar);
    echo json_encode($response);
  }
}
//mostar todos los usuarios DataTable
if (isset($_POST["todosLosUsuarios"])) {
  $mostrarTodosLosUsuarios = new UsuariosAjax();
  $mostrarTodosLosUsuarios->ajaxMostrarTodosLosUsuarios();
}

//  Mostrar data para editar
if (isset($_POST["codUsuario"])) {
  $editarUsuario = new UsuariosAjax();
  $editarUsuario->codUsuario = $_POST["codUsuario"];
  $editarUsuario->ajaxEditarUsuario();
}

//  Actualizar data del usuario
if (isset($_POST["codUsuarioActualizar"])) {
  $actualizarEstado = new UsuariosAjax();
  $actualizarEstado->codUsuarioActualizar = $_POST["codUsuarioActualizar"];
  $actualizarEstado->ajaxActualizarEstado();
}