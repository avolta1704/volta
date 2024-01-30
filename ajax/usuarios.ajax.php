<?php

require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";

class UsuariosAjax
{
  public $codUsuario;
  public function ajaxEditarUsuario()
  {
    $codUsuario = $this->codUsuario;
    $response = ControllerUsuarios::ctrGetUsuarioEdit($codUsuario);
    echo json_encode($response);
  }
}

//  Mostrar data para editar
if(isset($_POST["codUsuario"])){
	$editarUsuario = new UsuariosAjax();
	$editarUsuario -> codUsuario = $_POST["codUsuario"];
	$editarUsuario -> ajaxEditarUsuario();
}