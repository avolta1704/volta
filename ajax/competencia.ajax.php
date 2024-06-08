<?php

require_once "../controller/competencia.controller.php";
require_once "../model/competencia.model.php";
require_once "../functions/competencia.functions.php";
require_once "../model/alumnoAnioEscolar.model.php";

class CompetenciaAjax
{
  // Obtener todas las competencias
  public $idUnidad;
  public function ajaxObtenerCompetencia()
  {
    $idUnidad = $this->idUnidad;
    $response = ControllerCompetencia::ctrObtenerCompetencia($idUnidad);
    foreach ($response as &$data) {
      $data['buttons'] = FunctionCompetencia::getButtons($data['idCompetencia'], $data['descripcionCompetencia'], $data['maxNotaCompetencia']);
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
    $response = ControllerCompetencia::ctrCrearCompetencia($idUnidadCrear, $descripcionCompetenciaCrear);
    echo json_encode($response);
  }

  // Modificar competencia
  public $idCompetencia;
  public $notaTextModificada;
  public function ajaxModificarCompetencia()
  {
    $idCompetencia = $this->idCompetencia;
    $notaTextModificada = $this->notaTextModificada;
    $response = ControllerCompetencia::ctrModificarCompetencia($idCompetencia, $notaTextModificada);
    echo json_encode($response);
  }
  // Duplicar Competencia
  public $idCursoDuplicar;
  public $idGradoDuplicar;
  public $idPersonalDuplicar;
  public function ajaxDuplicarCompetencia()
  {
    $idCursoDuplicar = $this->idCursoDuplicar;
    $idGradoDuplicar = $this->idGradoDuplicar;
    $idPersonalDuplicar = $this->idPersonalDuplicar;
    $response = ControllerCompetencia::ctrDuplicarCompetencia($idCursoDuplicar, $idGradoDuplicar, $idPersonalDuplicar);
    echo json_encode($response);
  }
  // Crear competencias DUPLICADA
  public $idUnidadDuplicado;
  public $checkboxValues;
  public function ajaxInsertarDuplicadosCompetencia()
  {
    $idUnidadDuplicado = $this->idUnidadDuplicado;
    $checkboxValues = $this->checkboxValues;
    $response = ControllerCompetencia::ctrInsertarDuplicadosCompetencia($idUnidadDuplicado, $checkboxValues);
    echo json_encode($response);
  }
  // Eliminar competencia
  public $idCompetenciaEliminar;
  public function ajaxEliminarCompetencia()
  {
    $idCompetenciaEliminar = $this->idCompetenciaEliminar;
    $response = ControllerCompetencia::ctrEliminarCompetencia($idCompetenciaEliminar);
    echo json_encode($response);
  }

  // Validar Notas Competencias
  public $idUnidadValidacion;
  public $idCursoValidar;
  public $idGradoValidar;
  public function ajaxValidarNotasCompetencias(){
    $idUnidadValidacion = $this->idUnidadValidacion;
    $idCursoValidar = $this->idCursoValidar;
    $idGradoValidar = $this->idGradoValidar;
    $response = ControllerCompetencia::ctrValidarNotasCompetencias($idUnidadValidacion,$idCursoValidar, $idGradoValidar);
    echo json_encode($response);
  }
}

//Obtener competencias
if (isset($_POST["idUnidad"])) {
  $obtenerCompetencias = new CompetenciaAjax();
  $obtenerCompetencias->idUnidad = $_POST["idUnidad"];
  $obtenerCompetencias->ajaxObtenerCompetencia();
}

//Insertar Competencias
if (isset($_POST["idUnidadCrear"]) && isset($_POST["descripcionCompetenciaCrear"])) {
  $insertarCompetencias = new CompetenciaAjax();
  $insertarCompetencias->idUnidadCrear = $_POST["idUnidadCrear"];
  $insertarCompetencias->descripcionCompetenciaCrear = $_POST["descripcionCompetenciaCrear"];
  $insertarCompetencias->ajaxCrearCompetencia();
}

// Modificar competencia
if (isset($_POST["idCompetencia"]) && isset($_POST["notaTextModificada"])) {
  $modficarCompetencias = new CompetenciaAjax();
  $modficarCompetencias->idCompetencia = $_POST["idCompetencia"];
  $modficarCompetencias->notaTextModificada = $_POST["notaTextModificada"];
  $modficarCompetencias->ajaxModificarCompetencia();
}

// Duplicar Competencia
if (isset($_POST["competenciasDuplicar"]) && isset($_POST["idCurso"]) && isset($_POST["idGrado"]) && isset($_POST["idPersonal"])) {
  $duplicarCompetencia = new CompetenciaAjax();
  $duplicarCompetencia->idCursoDuplicar = $_POST["idCurso"];
  $duplicarCompetencia->idGradoDuplicar = $_POST["idGrado"];
  $duplicarCompetencia->idPersonalDuplicar = $_POST["idPersonal"];
  $duplicarCompetencia->ajaxDuplicarCompetencia();
}

// Insertar Duplicados competencia
if (isset($_POST["checkboxValues"]) && isset($_POST["idUnidadModificado"])) {
  $checkboxValues = json_decode($_POST["checkboxValues"]);
  $idUnidad = $_POST["idUnidadModificado"];
  $insertarDuplicadosCompetencia = new CompetenciaAjax();
  $insertarDuplicadosCompetencia->checkboxValues = $checkboxValues;
  $insertarDuplicadosCompetencia->idUnidadDuplicado = $idUnidad;
  $insertarDuplicadosCompetencia->ajaxInsertarDuplicadosCompetencia();
}
//Eliminar Competencia
if (isset($_POST["idCompetenciaEliminar"])) {
  $eliminarCompetencia = new CompetenciaAjax();
  $eliminarCompetencia->idCompetenciaEliminar = $_POST["idCompetenciaEliminar"];
  $eliminarCompetencia->ajaxEliminarCompetencia();
}

//Validar notas Competencias y Alumnos
if (isset($_POST["idUnidadValidacion"]) && isset($_POST["idCursoValidar"]) && isset($_POST["idGradoValidar"])) {
  $validarNotasCompetencias = new CompetenciaAjax();
  $validarNotasCompetencias-> idUnidadValidacion = $_POST["idUnidadValidacion"];
  $validarNotasCompetencias -> idCursoValidar = $_POST["idCursoValidar"];
  $validarNotasCompetencias -> idGradoValidar =$_POST["idGradoValidar"];
  $validarNotasCompetencias->ajaxValidarNotasCompetencias();
}