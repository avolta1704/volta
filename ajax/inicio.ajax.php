<?php

require_once "../controller/inicio.controller.php";
require_once "../model/inicio.model.php";
require_once "../functions/usuarios.functions.php";

class InicioAjax
{
  public function ajaxObtenertodoslosAlumnosporGrandos()
  {
    $response = ControllerInicio::ctrObtenertodoslosAlumnosporGrandos();
    echo json_encode($response);
  }
  public function ajaxObtenertodaslasPensionesPendientes()
  {
    $response = ControllerInicio::ctrObtenertodaslasPensionesPendientes();
    echo json_encode($response);
  }
  public function ajaxObtenerTodoslosAlumnosporAnio()
  {
    $response = ControllerInicio::ctrObtenerTodoslosAlumnosporAnio();
    echo json_encode($response);
  }
  public function ajaxObtenerMontoRecaudadoporMeses()
  {
    $response = ControllerInicio::ctrObtenerMontoRecaudadoporMeses();
    echo json_encode($response);
  }
  public function ajaxObtenertodostodosPersonalInicio()
  {
    $response = ControllerInicio::ctrObtenerPersonalInicio();
    foreach ($response as &$personalInicio) {
      $personalInicio['state'] = FunctionUsuario::getEstadoUsuarios($personalInicio["estadoUsuario"]);
    }
    echo json_encode($response);
  }
}
// Obtener todos los Alumnos por Grado
if (isset($_POST["AlumnosporGrandos"])) {
  $todosAlumnosporGrandos = new InicioAjax();
  $todosAlumnosporGrandos->ajaxObtenertodoslosAlumnosporGrandos();
}
// Obtener todas las pensiones pendientes
if (isset($_POST["PensionesPendientes"])) {
  $todasPensionesPendientes = new InicioAjax();
  $todasPensionesPendientes->ajaxObtenertodaslasPensionesPendientes();
}
// Obtener todos los Alumnos por anio
if (isset($_POST["AlumnosporAnio"])) {
  $todosAlumnosporAnio = new InicioAjax();
  $todosAlumnosporAnio->ajaxObtenerTodoslosAlumnosporAnio();
}
// Obtener todo el monto recaudado por meses
if (isset($_POST["MontoRecaudadoporMeses"])) {
  $todosMontoRecaudadoporMeses = new InicioAjax();
  $todosMontoRecaudadoporMeses->ajaxObtenerMontoRecaudadoporMeses();
}
if(isset($_POST["personalInicio"])){
  $todosPersonalInicio = new InicioAjax();
  $todosPersonalInicio->ajaxObtenertodostodosPersonalInicio();
}

