<?php

require_once "../controller/cursos.controller.php";
require_once "../model/cursos.model.php";
require_once "../functions/cursos.functions.php";


class CursosAjax
{
  /**
   * Método para mostrar todos los cursos mediante una petición AJAX.
   *
   */
  public static function ajaxMostrarTodosLosCursos()
  {
    $todosLosCursos = ControllerCursos::ctrGetCursos();

    foreach ($todosLosCursos as &$dataPago) {
      $dataPago['areaCurso'] = strval($dataPago['descripcionArea']);
      $dataPago['nombreCurso'] = strval($dataPago['descripcionCurso']);
      $dataPago['gradoCurso'] = strval($dataPago['descripcionGrado']);
      $dataPago['estadoCurso'] = FunctionCursos::getEstadoCurso($dataPago['estadoCurso']);
      $dataPago['buttonsCurso'] = FunctionCursos::getBotonesCursos($dataPago["idCurso"]);
    }

    echo json_encode($todosLosCursos);
  }
}

if (isset($_POST["todosLosCursosAdmin"])) {
  $mostrarTodosLosCursos = new CursosAjax();
  $mostrarTodosLosCursos->ajaxMostrarTodosLosCursos();
}
