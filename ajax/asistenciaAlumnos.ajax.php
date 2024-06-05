<?php

require_once "../controller/asistenciaAlumnos.controller.php";
require_once "../model/asistenciaAlumnos.model.php";

class AsistenciaAlumnosAjax
{
  /**
   * Mostrar la asistencia de los alumnos del dia actual
   * 
   */
  public function ajaxMostrarAsistenciaAlumnos($data)
  {

    $data = json_decode($data, true);
    $idCurso = $data["idCurso"];
    $idGrado = $data["idGrado"];
    $idPersonal = $data["idPersonal"];

    $respuesta = ControllerAsistenciaAlumnos::ctrMostrarAsistenciaAlumnos($idCurso, $idGrado, $idPersonal);
    echo json_encode($respuesta);
  }
}

if (isset($_POST["todosLosAlumnosAsistenciaCurso"])) {
  $mostrarAsistenciaAlumnos = new AsistenciaAlumnosAjax();
  $mostrarAsistenciaAlumnos->ajaxMostrarAsistenciaAlumnos($_POST["todosLosAlumnosAsistenciaCurso"]);
}
