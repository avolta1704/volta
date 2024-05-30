<?php

require_once "../controller/docentes.controller.php";
require_once "../model/docentes.model.php";
require_once "../functions/docentes.functions.php";
require_once "../controller/nivelGrado.controller.php";
require_once "../model/nivelGrado.model.php";
require_once "../controller/cursos.controller.php";
require_once "../model/cursos.model.php";
require_once "../controller/anioescolar.controller.php";
require_once "../model/anioescolar.model.php";
require_once "../controller/anioCursoGrado.controller.php";
require_once "../model/anioCursoGrado.model.php";

class DocentesAjax
{
  //mostar todos los usuarios DataTable
  public function ajaxMostrarTodosLosDocentes()
  {
    $todosLosDocentes = ControllerDocentes::ctrGetAllDocentes();
    foreach ($todosLosDocentes as &$docente) {
      $docente['state'] = FunctionDocente::getEstadoocentes($docente["estadoUsuario"]);
      $getGrado = ControllerDocentes::ctrGetGrado($docente['idPersonal']);
      $docente['buttons'] = FunctionDocente::getBtnUsuarios($docente["idPersonal"], $docente["estadoUsuario"], $docente["idTipoPersonal"], $docente["idUsuario"]);
      $docente["grado"] = FunctionDocente::getGrado($getGrado);

    }
    echo json_encode($todosLosDocentes);


  }

  //mostar todos los usuarios DataTable
  public function ajaxMostrarGradosPorTipoDocente()
  {
    $tipoDocente = $_POST["tipoDocente"];
    if ($tipoDocente == 4) {
      $listaGrados = ControllerNivelGrado::ctrGetAllGrados();
    } else {
      $listaGrados = ControllerNivelGrado::ctrGetGradosByNivel($tipoDocente);
    }
    echo json_encode($listaGrados);
  }
  public function ajaxMostrarCursosporNivel()
  {
    $todosLosCursos = ControllerDocentes::ctrGetCurso();
    echo json_encode($todosLosCursos);
  }

  //  Obtener Id Curso Grado
  public $gradoSeleccionado;
  public $cursoSeleccionado;
  public $idPersonal;
  public function ajaxobtenerIdCursogrado()
  {
    $gradoSeleccionado = $this->gradoSeleccionado;
    $cursoSeleccionado = $this->cursoSeleccionado;
    $idPersonaldeCursos = ControllerDocentes::ctroObteneridPersonal($gradoSeleccionado, $cursoSeleccionado);
    $idPersonal = $this->idPersonal;
    if ($idPersonaldeCursos != null) {
      foreach ($idPersonaldeCursos as $todosid) {
        $idPersonalRepetido = $idPersonaldeCursos['idPersonal'];
        $idcursogradoRepetido = $idPersonaldeCursos['idCursoGrado'];
        $response1 = ControllerDocentes::ctroCambiarIdPersonal($idPersonalRepetido, $idPersonal, $idcursogradoRepetido);

      }
      echo json_encode($response1);
    } else {
      if ($cursoSeleccionado == null) {
        $TodoslosidCursos = ControllerDocentes::ctroObteneridCursos($gradoSeleccionado);
        $idPersonal = $this->idPersonal;
        foreach ($TodoslosidCursos as $todosid) {
          $idcursoGrado = $todosid['idCursoGrado'];
          $response1 = ControllerDocentes::ctroAsignarCurso($idPersonal, $idcursoGrado);

        }
        echo json_encode($response1);

      } else {
        $idPersonal = $this->idPersonal;
        $response = ControllerDocentes::ctrobtenerIdCursogrado($gradoSeleccionado, $cursoSeleccionado);
        foreach ($response as &$cursoGrado) {
          $idcursoGrado = $cursoGrado;
        }
        $response1 = ControllerDocentes::ctroAsignarCurso($idPersonal, $idcursoGrado);
        echo json_encode($response1);
      }
    }
  }

  //  Cambiar estado del docente
  public $cambiarEstadoDocente;
  public $idUsuarioEstado;
  public function ajaxCambiarEstadoDocente()
  {
    $cambiarEstadoDocente = $this->cambiarEstadoDocente;
    $idUsuarioEstado = $this->idUsuarioEstado;
    $response = ControllerDocentes::ctrCambiarEstadoDocente($idUsuarioEstado, $cambiarEstadoDocente);
    echo json_encode($response);
  }
}

//mostar todos los usuarios DataTable
if (isset($_POST["todosLosDocentes"])) {
  $mostrarTodosLosDocentes = new DocentesAjax();
  $mostrarTodosLosDocentes->ajaxMostrarTodosLosDocentes();
}

//  Obtener grados por tipo de docente
if (isset($_POST["tipoDocente"])) {
  $obtenerGrados = new DocentesAjax();
  $obtenerGrados->ajaxMostrarGradosPorTipoDocente();
}

//  Obtener grados por tipo de docente
if (isset($_POST["todosloscursos"])) {
  $obtenerGrados = new DocentesAjax();
  $obtenerGrados->ajaxMostrarCursosporNivel();
}

//  Obtener el idCursoGrado
if (isset($_POST["gradoSeleccionado"]) && isset($_POST["cursoSeleccionado"]) && isset($_POST["idPersonal"])) {
  $obtenerIdCursogrado = new DocentesAjax();
  $obtenerIdCursogrado->gradoSeleccionado = $_POST["gradoSeleccionado"];
  $obtenerIdCursogrado->cursoSeleccionado = $_POST["cursoSeleccionado"];
  $obtenerIdCursogrado->idPersonal = $_POST["idPersonal"];
  $obtenerIdCursogrado->ajaxobtenerIdCursogrado();

}

//  Cambiar estado del docente
if (isset($_POST["idUsuarioEstado"]) && isset($_POST["docenteEstado"])) {
  $cambiarEstadoDocente = new DocentesAjax();
  $cambiarEstadoDocente->idUsuarioEstado = $_POST["idUsuarioEstado"];
  $cambiarEstadoDocente->cambiarEstadoDocente = $_POST["docenteEstado"];
  $cambiarEstadoDocente->ajaxCambiarEstadoDocente();

}

