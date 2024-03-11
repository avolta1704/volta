<?php

require_once "../controller/admisionAlumno.controller.php";
require_once "../model/admisionAlumno.model.php";
require_once "../functions/admisionAlumno.functions.php";

class AdmisionAlumnosAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosAdmisionAlumnos()
  {
    $registrosAdmisionAlumnos = ControllerAdmisionAlumno::ctrGetAdmisionAlumnos();
    foreach ($registrosAdmisionAlumnos as &$admisionAlumno) {
      $admisionAlumno['stateAlumno'] = FunctionAdmisionAlumnos::getEstadosAlumnos($admisionAlumno["estadoAlumno"]);
      $admisionAlumno['buttonsAlumno'] = FunctionAdmisionAlumnos::getBotonesAlumnos($admisionAlumno["idAlumno"], $admisionAlumno["estadoAlumno"]);
    }
    echo json_encode($registrosAdmisionAlumnos);
  }
}
//mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registrosAdmisionAlumnos"])) {
  $mostrarRegistrosAdmisionAlumnos = new AdmisionAlumnosAjax();
  $mostrarRegistrosAdmisionAlumnos->ajaxMostrarRegistrosAdmisionAlumnos();
}
