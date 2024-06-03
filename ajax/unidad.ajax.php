<?php

require_once "../controller/unidad.controller.php";
require_once "../model/unidad.model.php";

class UnidadAjax
{
  // Obtener todas las unidades
  public $idBimestre;
  public function ajaxObtenerTodasLasUnidades()
  {
    $idBimestre = $this->idBimestre;
    $response = ControllerUnidad::ctrObtenerTodasLasUnidades($idBimestre);
    echo json_encode($response);
  }

}


// Editar estado de admision alumno
if (isset($_POST["idBimestre"])) {
  $todaslasUnidades = new UnidadAjax();
  $todaslasUnidades->idBimestre = $_POST["idBimestre"];
  $todaslasUnidades->ajaxObtenerTodasLasUnidades();
}
