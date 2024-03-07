<?php
//controller
require_once "../functions/postulantes.functions.php";
require_once "../controller/postulantes.controller.php";
require_once "../controller/admisionAlumno.controller.php";
require_once "../controller/admision.controller.php";
require_once "../controller/anioescolar.controller.php";
//Modelo
require_once "../model/postulantes.model.php";
require_once "../model/admisionAlumno.model.php";
require_once "../model/admision.model.php";
require_once "../model/anioescolar.model.php";

class PostulantesAjax
{
  //mostar todos los Postulantes DataTablePostulantesAdmin
  public function ajaxMostrarTodosLosPostulantesAdmin()
  {
    $todosLosPostulantesAdmin = ControllerPostulantes::ctrGetAllPostulantes();
    foreach ($todosLosPostulantesAdmin as &$postulantes) {
      $postulantes['statePostulante'] = FunctionPostulantes::getestadoPostulantes($postulantes["estadoPostulante"]);
      $postulantes['buttonsPostulante'] = FunctionPostulantes::getBotonesPostulante($postulantes["idPostulante"], $postulantes["estadoPostulante"]);
    }
    echo json_encode($todosLosPostulantesAdmin);
  }
  // Actualizar estado postulante
  public $codPostulanteEdit;
  public $estadoPostulanteEdit;
  public function ajaxActualizarEstado()
  {
    $codPostulanteEdit = $this->codPostulanteEdit;
    $estadoPostulanteEdit = $this->estadoPostulanteEdit;
    $response = ControllerPostulantes::ctrActualizarestadoPostulante($codPostulanteEdit, $estadoPostulanteEdit);
    echo json_encode($response);
  }
}
//mostar todos los Postulantes DataTableAdmin
if (isset($_POST["todosLosPostulantesAdmin"])) {
  $mostrarTodosLosPostulantesAdmin = new PostulantesAjax();
  $mostrarTodosLosPostulantesAdmin->ajaxMostrarTodosLosPostulantesAdmin();
}
// Actualizar estado postulante
if (isset($_POST["codPostulanteEdit"]) && isset($_POST["estadoPostulanteEdit"])) {
  $actualizarEstado = new PostulantesAjax();
  $actualizarEstado->codPostulanteEdit = $_POST["codPostulanteEdit"];
  $actualizarEstado->estadoPostulanteEdit = $_POST["estadoPostulanteEdit"];
  $actualizarEstado->ajaxActualizarEstado();
}
