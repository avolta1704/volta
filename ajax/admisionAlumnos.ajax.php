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
    foreach ($registrosAdmisionAlumnos as &$dataAdmision) {
      $dataAdmision['tipoAdmision'] = FunctionAdmisionAlumnos::getEstadoTipoAdmision($dataAdmision["tipoAdmision"]);
      $dataAdmision['estadoAdmisionAlumn'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($dataAdmision["estadoAdmisionAlumno"]);

         $dataAdmision['buttonsAdmisionAlumno'] = FunctionAdmisionAlumnos::getBotonesAdmisionAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAdmisionAlumno"]);
    }
    echo json_encode($registrosAdmisionAlumnos);
  }
}
//mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registrosAdmisionAlumnos"])) {
  $mostrarRegistrosAdmisionAlumnos = new AdmisionAlumnosAjax();
  $mostrarRegistrosAdmisionAlumnos->ajaxMostrarRegistrosAdmisionAlumnos();
}
