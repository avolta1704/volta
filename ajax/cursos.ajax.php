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
      $dataPago['estadoCurso'] = FunctionCursos::getEstadoCurso($dataPago['estadoCurso']);
      $dataPago['buttonsCurso'] = FunctionCursos::getBotonesCursos($dataPago["idCurso"]);
    }

    echo json_encode($todosLosCursos);
  }

  /**
   * Método para registrar un curso mediante una petición AJAX.
   *
   */
  public static function ajaxRegistrarCurso($dataRegistrarCursoModal)
  {
    $dataRegistrarCursoModal = json_decode($dataRegistrarCursoModal, true);
    $respuesta = ControllerCursos::ctrRegistrarCurso($dataRegistrarCursoModal);
    echo json_encode($respuesta);
  }

  /**
   * Método para eliminar un curso mediante una petición AJAX.
   *
   */
  public static function ajaxEliminarCurso($idCurso)
  {
    $respuesta = ControllerCursos::ctrEliminarCurso($idCurso);
    echo json_encode($respuesta);
  }

  /**
   * Método para obtener un curso mediante una petición AJAX.
   *
   */
  public static function ajaxObtenerCurso($idCurso)
  {
    $respuesta = ControllerCursos::ctrGetCurso($idCurso);
    echo json_encode($respuesta);
  }

  /**
   * Método para editar un curso mediante una petición AJAX.
   *
   */
  public static function ajaxEditarCurso($dataEditarCursoModal)
  {
    $dataEditarCursoModal = json_decode($dataEditarCursoModal, true);
    $respuesta = ControllerCursos::ctrEditarCurso($dataEditarCursoModal);
    echo json_encode($respuesta);
  }
  public $idCursoAsistenciaDescripcion;
  public $idGradoAsistenciaDescripcion;
  public function ajaxDescripcionGradoCursoAsistencia()
  {
    $idCursoAsistenciaDescripcion = $this->idCursoAsistenciaDescripcion;
    $idGradoAsistenciaDescripcion = $this->idGradoAsistenciaDescripcion;
    $respuesta = ControllerCursos::ctrObtenerDescripcionCursoGradoAsistencia($idCursoAsistenciaDescripcion, $idGradoAsistenciaDescripcion);
    echo json_encode($respuesta);
  }
}

if (isset($_POST["todosLosCursosAdmin"])) {
  $mostrarTodosLosCursos = new CursosAjax();
  $mostrarTodosLosCursos->ajaxMostrarTodosLosCursos();
}

if (isset($_POST["dataRegistrarCursoModal"])) {
  $registrarCurso = new CursosAjax();
  $registrarCurso->ajaxRegistrarCurso($_POST["dataRegistrarCursoModal"]);
}

if (isset($_POST["idCurso"])) {
  $eliminarCurso = new CursosAjax();
  $eliminarCurso->ajaxEliminarCurso($_POST["idCurso"]);
}

if (isset($_POST["idCursoEditar"])) {
  $obtenerCurso = new CursosAjax();
  $obtenerCurso->ajaxObtenerCurso($_POST["idCursoEditar"]);
}

if (isset($_POST["dataEditarCursoModal"])) {
  $eliminarCurso = new CursosAjax();
  $eliminarCurso->ajaxEditarCurso($_POST["dataEditarCursoModal"]);
}
if(isset($_POST["idCursoAsistenciaDescripcion"]) && isset($_POST["idGradoAsistenciaDescripcion"])){
  $descripcionGradoCursoAsistencia = new CursosAjax();
  $descripcionGradoCursoAsistencia->idCursoAsistenciaDescripcion = $_POST["idCursoAsistenciaDescripcion"];
  $descripcionGradoCursoAsistencia->idGradoAsistenciaDescripcion = $_POST["idGradoAsistenciaDescripcion"];
  $descripcionGradoCursoAsistencia->ajaxDescripcionGradoCursoAsistencia();
}
