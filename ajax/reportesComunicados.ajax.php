<?php
//controller
require_once "../controller/reportesComunicados.controller.php";

//model
require_once "../model/reportesComunicados.model.php";

// functions
require_once "../functions/reportesComunicados.functions.php";


class ReportesComunicados
{
  /**
   * Función para mostrar todos los comunicados.
   *
   */
  public function ajaxMostrarTodosLosComunicados()
  {
    $todosLosComunicados = ControllerReportesComunicados::ctrGetAllAlumnosConComunicados();

    foreach ($todosLosComunicados as &$dataPensiones) {
      $dataPensiones['nombreAlumno'] = $dataPensiones["nombresAlumno"] . " " . $dataPensiones["apellidosAlumno"];
      $dataPensiones['dniAlumno'] = $dataPensiones["dniAlumno"];
      $dataPensiones['gradoAlumno'] = $dataPensiones["descripcionGrado"];
      $dataPensiones['nivelAlumno'] = $dataPensiones["descripcionNivel"];
      $dataPensiones['acciones'] = FunctionReportesComunicados::getBotonesOpciones($dataPensiones["idAdmisionAlumno"], $dataPensiones["idAlumno"]);
    }

    // Eliminar datos duplicados basados en idalumno
    $todosLosComunicados = FunctionReportesComunicados::eliminarDuplicadosPorIdAlumno($todosLosComunicados);

    echo json_encode(array_values($todosLosComunicados));
  }

  /**
   * Función para mostrar los comunicados por alumnos.
   */
  public function ajaxMostrarComunicadosPorAlumnos()
  {
    $comunicadosPorAlumno = ControllerReportesComunicados::ctrGetComunicadosPorAlumnos();
    echo json_encode(array_values($comunicadosPorAlumno));
  }
}

if (isset($_POST["todosLosComunicados"])) {
  $mostrarTodosLosComunicados = new ReportesComunicados();
  $mostrarTodosLosComunicados->ajaxMostrarTodosLosComunicados();
}

if (isset($_POST["comunicadosPorAlumno"])) {
  $mostrarComunicadosPorAlumno = new ReportesComunicados();
  $mostrarComunicadosPorAlumno->ajaxMostrarComunicadosPorAlumnos();
}
