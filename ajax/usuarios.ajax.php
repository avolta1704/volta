<?php

require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";
require_once "../functions/usuarios.functions.php";

class UsuariosAjax
{
  //mostar todos los usuarios DataTable
  public function ajaxMostrarTodosLosUsuarios()
  {
    $TodosLosUsuarios = ControllerUsuarios::ctrGetAllUsuarios();
    foreach ($TodosLosUsuarios as &$Usuario) {
      $Usuario['State'] = FunctionUsuario::getEstadoUsuarios($Usuario["estadoUsuario"]);
      $Usuario['Buttons'] = FunctionUsuario::getBtnUsuarios($Usuario["idUsuario"]);  
    }
    echo json_encode($TodosLosUsuarios);
  }

  public $codUsuario;
  public function ajaxEditarUsuario()
  {
    $codUsuario = $this->codUsuario;
    $response = ControllerUsuarios::ctrGetUsuarioEdit($codUsuario);
    echo json_encode($response);
  }

  public $codUsuarioActualizar;
  public function ajaxActualizarEstado()
  {
    $codUsuarioActualizar = $this->codUsuarioActualizar;
    $response = ControllerUsuarios::ctrActualizarEstado($codUsuarioActualizar);
    echo json_encode($response);
  }
}
//mostar todos los usuarios DataTable
if (isset($_POST["TodosLosUsuarios"])) {
  $mostrarNotasPedido = new UsuariosAjax();
  $mostrarNotasPedido->ajaxMostrarTodosLosUsuarios();
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