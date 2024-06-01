<?php

require_once "../controller/bimestre.controller.php";
require_once "../model/bimestre.model.php";

class BimestreAjax
{
  // Obtener todos los bimestres
  public function ajaxObtenerTodosLosBimestres()
  {
    $response = ControllerBimestre::ctrObtenerTodosLosBimestres();
    echo json_encode($response);
  }

}
// Editar estado de admision alumno
if (isset($_POST["todoslosBimestres"]) && isset($_POST["idCurso"]) && isset($_POST["idGrado"])) {
  $todoslosbimestres = new BimestreAjax();
  $todoslosbimestres->ajaxObtenerTodosLosBimestres();
}
