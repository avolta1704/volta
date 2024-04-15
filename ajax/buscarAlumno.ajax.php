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
    echo json_encode($todasLasBusquedas);
  }
}
//mostar todos los Apoderados DataTable
if (isset($_POST["buscarAlumnos"])) {
  $mostrartodasLasBusquedas = new BuscarAlumnoAjax();
  $mostrartodasLasBusquedas->ajaxMostrartodasLasBusquedas();
}
