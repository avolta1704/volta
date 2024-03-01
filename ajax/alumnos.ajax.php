<?php

require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../functions/alumnos.functions.php";

class AlumnosAjax
{
  //mostar todos los Alumno DataTableAlumnosAdmin
  public function ajaxMostrarTodosLosAlumnosAdmin()
  {
    $todosLosAlumnosAdmin = ControllerAlumnos::ctrGetAlumnos();
    foreach ($todosLosAlumnosAdmin as &$alumno) {
      $alumno['stateAlumno'] = FunctionAlumnos::getEstadosAlumnos($alumno["estadoAlumno"]);
      $alumno['buttonsAlumno'] = FunctionAlumnos::getBotonesAlumnos($alumno["idAlumno"],$alumno["estadoAlumno"]);
    }
    echo json_encode($todosLosAlumnosAdmin);
  }

}
//mostar todos los Alumnos DataTableAdmin
if (isset($_POST["todosLosAlumnosAdmin"])) {
  $mostrarTodosLosAlumnosAdmin = new AlumnosAjax();
  $mostrarTodosLosAlumnosAdmin->ajaxMostrarTodosLosAlumnosAdmin();
}
