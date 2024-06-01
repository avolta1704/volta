<?php

require_once "../controller/unidad.controller.php";
require_once "../model/unidad.model.php";

class UnidadAjax
{
  // Obtener todas las unidades
  public $descripcionBimestre;
  public function ajaxObtenerTodasLasUnidades()
  {
    $descripcionBimestre = $this->descripcionBimestre;
    $response = ControllerUnidad::ctrObtenerTodasLasUnidades($descripcionBimestre);
    echo json_encode($response);
  }

}


// Editar estado de admision alumno
if (isset($_POST["descripcionBimestre"])) {
  $todaslasUnidades = new UnidadAjax();
  $todaslasUnidades->descripcionBimestre = $_POST["descripcionBimestre"];
  $todaslasUnidades->ajaxObtenerTodasLasUnidades();
}
