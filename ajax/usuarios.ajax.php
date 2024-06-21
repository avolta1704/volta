<?php

require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";
require_once "../functions/usuarios.functions.php";

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
  //  Veficar si el correo ya existe
  public $validarCorreo;
  public function ajaxValidarCorreo()
  {
    $validarCorreo = $this->validarCorreo;
    $response = ControllerUsuarios::ctrValidarCorreo($validarCorreo);
    echo json_encode($response);
  }

  public $eliminarUsuario;
  public function ajaxEliminarUsuario()
  {
    $eliminarUsuario = $this->eliminarUsuario;
    $response = ControllerUsuarios::ctrEliminarUsuario($eliminarUsuario);
    echo json_encode($response);
  }

  public function ajaxTieneAcceso()
  {
    $response = ControllerUsuarios::ctrTieneAcceso();
    echo json_encode($response);
  }
}

//  Mostar todos los usuarios DataTable
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

//  Veficar si el correo ya existe
if (isset($_POST["validarCorreo"])) {
  $validarCorreo = new UsuariosAjax();
  $validarCorreo->validarCorreo = $_POST["validarCorreo"];
  $validarCorreo->ajaxValidarCorreo();
}

//  Eliminar un usuario
if (isset($_POST["codUsuarioEliminar"])) {
  $eliminarUsuario = new UsuariosAjax();
  $eliminarUsuario->eliminarUsuario = $_POST["codUsuarioEliminar"];
  $eliminarUsuario->ajaxEliminarUsuario();
}

if (isset($_POST["tieneAcceso"])) {
  $tieneAcceso = new UsuariosAjax();
  $tieneAcceso->ajaxTieneAcceso();
}
