<?php

require_once "../controller/postulantes.controller.php";
require_once "../model/postulantes.model.php";
require_once "../functions/postulantes.functions.php";

class PostulantesAjax
{
  //mostar todos los Postulantes DataTablePostulantesAdmin
  public function ajaxMostrarTodosLosPostulantesAdmin()
  {
    $todosLosPostulantesAdmin = ControllerPostulantes::ctrGetAllPostulantes();
    foreach ($todosLosPostulantesAdmin as &$postulantes) {
      $postulantes['statePostulante'] = FunctionPostulantes::getEstadoPostulantes($postulantes["estadoPostulante"]);
      $postulantes['buttonsPostulante'] = FunctionPostulantes::getBotonesPostulante($postulantes["idPostulante"], $postulantes["estadoPostulante"]);
    }
    echo json_encode($todosLosPostulantesAdmin);
  }
  //  Actualizar estado postulante
  public $codPostulante;
  public function ajaxActualizarEstado()
  {
    $codPostulante = $this->codPostulante;
    $response = ControllerPostulantes::ctrActualizarEstadoPostulante($codPostulante);
    echo json_encode($response);
  }
}
//mostar todos los Postulantes DataTableAdmin
if (isset($_POST["todosLosPostulantesAdmin"])) {
  $mostrarTodosLosPostulantesAdmin = new PostulantesAjax();
  $mostrarTodosLosPostulantesAdmin->ajaxMostrarTodosLosPostulantesAdmin();
}
//  Actualizar estado postulante
if (isset($_POST["codPostulanteActualizar"])) {
  $actualizarEstado = new PostulantesAjax();
  $actualizarEstado->codPostulante = $_POST["codPostulanteActualizar"];
  $actualizarEstado->ajaxActualizarEstado();
}
