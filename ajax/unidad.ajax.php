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
  // Obtener todas las competencias
  public $idUnidad;
  public function ajaxObtenerCompetencia()
  {
    $idUnidad = $this->idUnidad;
    $response = ControllerUnidad::ctrObtenerCompetencia($idUnidad);
    foreach ($response as &$data) {
      $data['buttons'] = FunctionUnidad::getButtons($data['idCompetencia'], $data['descripcionCompetencia']);
    }
    echo json_encode($response);
  }
  // Crear competencias
  public $idUnidadCrear;
  public $descripcionCompetenciaCrear;
  public function ajaxCrearCompetencia()
  {
    $idUnidadCrear = $this->idUnidadCrear;
    $descripcionCompetenciaCrear = $this->descripcionCompetenciaCrear;
    $response = ControllerUnidad::ctrCrearCompetencia($idUnidadCrear, $descripcionCompetenciaCrear);
    echo json_encode($response);
  }

  // Modificar competencia
  public $idCompetencia;
  public $notaTextModificada;
  public function ajaxModificarCompetencia()
  {
    $idCompetencia = $this->idCompetencia;
    $notaTextModificada = $this->notaTextModificada;
    $response = ControllerUnidad::ctrModificarCompetencia($idCompetencia, $notaTextModificada);
    echo json_encode($response);
  }

}
// Editar estado de admision alumno
if (isset($_POST["idBimestre"])) {
  $todaslasUnidades = new UnidadAjax();
  $todaslasUnidades->idBimestre = $_POST["idBimestre"];
  $todaslasUnidades->ajaxObtenerTodasLasUnidades();
}

//Obtener competencias
if (isset($_POST["idUnidad"])) {
  $obtenerCompetencias = new UnidadAjax();
  $obtenerCompetencias->idUnidad = $_POST["idUnidad"];
  $obtenerCompetencias->ajaxObtenerCompetencia();
}

//Insertar Competencias
if (isset($_POST["idUnidadCrear"]) && isset($_POST["descripcionCompetenciaCrear"])) {
  $insertarCompetencias = new UnidadAjax();
  $insertarCompetencias->idUnidadCrear = $_POST["idUnidadCrear"];
  $insertarCompetencias->descripcionCompetenciaCrear = $_POST["descripcionCompetenciaCrear"];
  $insertarCompetencias->ajaxCrearCompetencia();
}

// Modificar competencia
if (isset($_POST["idCompetencia"]) && isset($_POST["notaTextModificada"])) {
  $insertarCompetencias = new UnidadAjax();
  $insertarCompetencias->idCompetencia = $_POST["idCompetencia"];
  $insertarCompetencias->notaTextModificada = $_POST["notaTextModificada"];
  $insertarCompetencias->ajaxModificarCompetencia();
}
