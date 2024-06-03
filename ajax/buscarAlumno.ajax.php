<?php

require_once "../controller/buscarAlumno.controller.php";
require_once "../model/buscarAlumno.model.php";
require_once "../functions/buscarAlumno.functions.php";

class BuscarAlumnoAjax
{
  //mostar todos los Apoderados DataTable
  public function ajaxMostrartodasLasBusquedas()
  {
    $todasLasBusquedas = ControllerBuscarAlumno::ctrGetAllBusquedaAlumno();
    foreach ($todasLasBusquedas as &$dataBsucar) {
      $dataBsucar['estadoAdmisionAlumno'] = FunctionBuscarAlumno::getEstadoAlumnoBuscar($dataBsucar["estadoAdmisionAlumno"]);
      $dataBsucar['estadoSiagie'] = FunctionBuscarAlumno::getEstadosBuscarSiagiue($dataBsucar["estadoSiagie"]);
    }
    echo json_encode($todasLasBusquedas);
  }
}
//mostar todos los Apoderados DataTable
if (isset($_POST["buscarAlumnos"])) {
  $mostrartodasLasBusquedas = new BuscarAlumnoAjax();
  $mostrartodasLasBusquedas->ajaxMostrartodasLasBusquedas();
}
