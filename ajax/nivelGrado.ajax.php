<?php

require_once "../controller/nivelGrado.controller.php";
require_once "../model/nivelGrado.model.php";

class NivelGradoAjax
{
  public $codNivelBuscar;
  public function ajaxObtenerGrados()
  {
    $codNivelBuscar = $this->codNivelBuscar;
    $response = ControllerNivelGrado::ctrGetGradosByNivel($codNivelBuscar);
    echo json_encode($response);
  }
}

//  Mostrar data para editar
if(isset($_POST["codNivelBuscar"])){
	$editarUsuario = new NivelGradoAjax();
	$editarUsuario -> codNivelBuscar = $_POST["codNivelBuscar"];
	$editarUsuario -> ajaxObtenerGrados();
}

