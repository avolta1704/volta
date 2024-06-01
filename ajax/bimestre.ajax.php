<?php

require_once "../controller/bimestre.controller.php";
require_once "../model/bimestre.model.php";

class BimestreAjax
{
  // Obtener todos los bimestres
  public $idCurso;
  public $idGrado;
  public function ajaxObtenerTodosLosBimestres()
  {
    $idCurso = $this->idCurso;
    $idGrado = $this->idGrado;
    $response = ControllerBimestre::ctrObtenerTodosLosBimestres($idCurso, $idGrado);
    echo json_encode($response);
  }

}
// Editar estado de admision alumno
if (isset($_POST["todoslosBimestres"]) && isset($_POST["idCurso"]) && isset($_POST["idGrado"])) {
  $todoslosbimestres = new BimestreAjax();
  $todoslosbimestres->idCurso = $_POST["idCurso"];
  $todoslosbimestres->idGrado = $_POST["idGrado"];
  $todoslosbimestres->ajaxObtenerTodosLosBimestres();
}
