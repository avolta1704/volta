<?php

require_once "../controller/unidad.controller.php";
require_once "../model/unidad.model.php";
require_once "../functions/unidad.functions.php";

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
  // Cerrar Unidad
  public $idUnidadCerrar;
  public $idBimestreCerrar;
  public function ajaxCerrarUnidad()
  {
    $idUnidadCerrar = $this->idUnidadCerrar;
    $idBimestreCerrar = $this->idBimestreCerrar;
    $response = ControllerUnidad::ctrCerrarUnidad($idUnidadCerrar, $idBimestreCerrar);
    echo json_encode($response);
  }
}
// Obtener todas las unidades
if (isset($_POST["idBimestre"])) {
  $todaslasUnidades = new UnidadAjax();
  $todaslasUnidades->idBimestre = $_POST["idBimestre"];
  $todaslasUnidades->ajaxObtenerTodasLasUnidades();
}
// Cerrar Unidad
  if (isset($_POST["idUnidadCerrar"]) && isset($_POST["idBimestreCerrar"])) {
  $unidadCerrar = new UnidadAjax();
  $unidadCerrar -> idUnidadCerrar = $_POST["idUnidadCerrar"];
  $unidadCerrar -> idBimestreCerrar =$_POST["idBimestreCerrar"];
  $unidadCerrar ->ajaxCerrarUnidad();
}
