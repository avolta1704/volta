<?php

require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";

class AlumnosCursosDocente
{
  public function ajaxMostrarAlumnoById($idAlumno)
  {
    $response = ControllerAlumnos::ctrGetAlumnoById($idAlumno);
    echo json_encode($response);
  }
}

if (isset($_POST["idAlumno"])) {
  $mostrarAlumnoById = new AlumnosCursosDocente();
  $mostrarAlumnoById->ajaxMostrarAlumnoById($_POST["idAlumno"]);
}
