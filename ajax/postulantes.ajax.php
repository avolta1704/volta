<?php

require_once "../controller/postulantes.controller.php";
require_once "../model/postulantes.model.php";

class PostulantesAjax
{
  public $codPostulante;
  public function ajaxActualizarEstado()
  {
    $codPostulante = $this->codPostulante;
    $response = ControllerPostulantes::ctrActualizarEstadoPostulante($codPostulante);
    echo json_encode($response);
  }
}

//  Actualizar el estado del postulante
if (isset($_POST["codPostulanteActualizar"])) {
  $actualizarEstado = new PostulantesAjax();
  $actualizarEstado->codPostulante = $_POST["codPostulanteActualizar"];
  $actualizarEstado->ajaxActualizarEstado();
}
